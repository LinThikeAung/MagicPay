<?php

namespace App\Http\Controllers\Frontend;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\Transfer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePassword;
use Laravel\Ui\Presets\React;

class PageController extends Controller
{
    public function home(){
        $user = Auth::guard('web')->user();
        return view('frontend.home',compact('user'));
    }
    public function profile(){
        //select Authenticated user
        $user = Auth::guard('web')->user();//auth.php mar default user gaurd ka web par
        return view('frontend.profile',compact('user'));
    }
    public function updatePassword(){
        return view('frontend.update-password');
    }
    public function storeUpdatePassword(UpdatePassword $request){
        $old_password = $request->oldpassword;
        $new_password = $request->newpassword;
        $user = Auth::guard('web')->user();
        if (Hash::check($old_password,$user->password)) {
            $user->password = Hash::make($new_password);
            $user->update();
            return redirect()->route('profile')->with('updated','Password Updated Successfully');
        }
        return back()->withErrors(['Your old password was not correct.']);
    }

    public function showWallet(){

        $user = Auth::guard('web')->user();
        return view('frontend.wallet',compact('user'));
    }

    public function showTransfer(){
        $user = Auth::guard('web')->user();
        return view('frontend.transfer',compact('user'));
    }

    public function transferConfirm(Transfer $request){

        if($request->amount < 1000){
            return back()->withErrors(['amount'=>'At least 1000MMK is required.'])->withInput();
        }

        $user = Auth::guard('web')->user();
        if($user->phone == $request->tophone){
            return back()->withErrors(['tophone'=>'Invalid Account'])->withInput();
        }

        $to_account = User::where('phone',$request->tophone)->first();//select first row

        if(!$to_account){
            return back()->withErrors(['tophone'=>'Account does not exist.'])->withInput();
        }

        $from_account = $user;
        $amount = $request->amount;
        $description = $request->description;
        return view('frontend.transfer_confirm',compact('from_account','to_account','amount','description'));
    }

    public function transferComplete(Request $request){

        $user = Auth::guard('web')->user();

        if($request->amount < 1000){
            return back()->withErrors(['amount'=>'At least 1000MMK is required.'])->withInput();
        }

        if($user->phone == $request->tophone){
            return back()->withErrors(['tophone'=>'Invalid Account'])->withInput();
        }

        $to_account = User::where('phone',$request->tophone)->first();//select first row

        if(!$to_account){
            return back()->withErrors(['tophone'=>'Account does not exist.'])->withInput();
        }

        $from_account = $user;
        $amount = $request->amount;
        $description = $request->description;

        //from account is loggined user_erro
        //to account is selecting from User table
        //therefore both are users
        //user joined wallet using eloquent
        if(!$from_account->wallet || !$to_account->wallet){ //wallet account ma shi yin
            return back()->withErrors(['tophone'=>'Account does not exist.'])->withInput();
        }

        $from_account_wallet = $from_account->wallet;//sender
        $from_account_wallet->decrement('amount',$amount);//from_account ka wallet amount ko Request ka lar de amount reduce mal
        $from_account_wallet->update();//reduce p yin update lote

        $to_account_wallet = $to_account->wallet;//receiver
        $to_account_wallet->increment('amount',$amount);
        $to_account_wallet->update();

        return redirect('/')->with('transfered','Transfered Successfully');
    }

    public function accountVerify(Request $request){
        $phone = $request->phone;

        $Authuser = Auth::guard('web')->user();

        if($Authuser->phone != $request->phone){

            $user = User::where('phone',$request->phone)->first();
            if($user){
                return response()
                    ->json(['status' => 'success','data' => $user,'message' => "success"]);
            }
        }
        return response()->json(['status' => 'fail', 'message' => "Invalid Data"]);
    }

    public function checkPassword(Request $request){

        if(!$request->password){
            return response()->json(['status' => 'fail', 'message' => "Password is incorrect"]);
        }

        $Authuser = Auth::guard('web')->user();

        if (Hash::check($request->password, $Authuser->password)) {
            return response()->json(['status' => 'success', 'message' => "Password is correct"]);
        }else{
            return response()->json(['status' => 'fail', 'message' => "Password is incorrect"]);
        }
    }
}
