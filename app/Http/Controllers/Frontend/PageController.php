<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\AccountGenerator;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\Transfer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePassword;
use App\Transaction;
use Illuminate\Support\Facades\DB;

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

        $hashString = $request->tophone.$request->amount.$request->description;
        $hashValue = hash_hmac('sha256',$hashString,'magicPay123!@#');

        $hashValue = $hashValue;

        if($request->hashVal !== $hashValue){
            //return back()->withErrors(['hash'=>'The given data is invalid.'])->withInput();
        }

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
        return view('frontend.transfer_confirm',compact('from_account','to_account','amount','description','hashValue'));
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

        DB::beginTransaction();
        try{
            $from_account_wallet = $from_account->wallet;//sender
            $from_account_wallet->decrement('amount',$amount);//from_account ka wallet amount ko Request ka lar de amount reduce mal
            $from_account_wallet->update();//reduce p yin update lote

            $to_account_wallet = $to_account->wallet;//receiver
            $to_account_wallet->increment('amount',$amount);
            $to_account_wallet->update();


            $refNumber = AccountGenerator::refNumber();

            $from_account_transaction = new Transaction();
            $from_account_transaction->ref_no= $refNumber;
            $from_account_transaction->trx_id= AccountGenerator::trxId();
            $from_account_transaction->user_id= $from_account->id;
            $from_account_transaction->type= 2;
            $from_account_transaction->amount= $amount;
            $from_account_transaction->source_id= $to_account->id;
            $from_account_transaction->description= $description;
            $from_account_transaction->save();

            $to_account_transaction = new Transaction();
            $to_account_transaction->ref_no= $refNumber;
            $to_account_transaction->trx_id= AccountGenerator::trxId();
            $to_account_transaction->user_id= $to_account->id;
            $to_account_transaction->type= 1;
            $to_account_transaction->amount= $amount;
            $to_account_transaction->source_id= $from_account->id;
            $to_account_transaction->description= $description;
            $to_account_transaction->save();


            DB::commit();
            return redirect('/transaction/detail/'.$from_account_transaction->trx_id)->with('transfered','Transfered Successfully');
        }catch(\Exception $e){
            DB::rollback();
            return back()->withErrors(['failed'=>'Something was wrong'.$e->getMessage()])->withInput();
        }
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


    public function transaction(Request $request){

        $Authuser = Auth::guard('web')->user();

        //elga funtion with()=>  user and source ka transaction model mar connect thr dl
        $transactions = Transaction::with('user','source')->OrderBy('created_at','desc')->where('user_id',$Authuser->id);//get and paginage ma thone htr dot data ma par thay buu //query bal yay htr dr
        if($request->type){
            $transactions = $transactions->where('type',$request->type);
        }

        if($request->date){
            $transactions = $transactions->whereDate('created_at',$request->date);//testing date
        }
        $transactions = $transactions->paginate(3);
        return view('frontend.transaction',compact('transactions'));
    }

    public function transactionDetail($trx_id){

        $Authuser = Auth::guard('web')->user();
        $transactions = Transaction::with('user','source')->where('user_id',$Authuser->id)->where('trx_id',$trx_id)->first();
        return view('frontend.transactionDetail',compact('transactions'));
    }

    public function hashTransfer(Request $request){

        $hashString = $request->tophone.$request->amount.$request->description;
        $hashValue = hash_hmac('sha256',$hashString,'magicPay123!@#');

        return response()->json([
            'status' => 'success',
            'data' => $hashValue
        ]);
    }
}
