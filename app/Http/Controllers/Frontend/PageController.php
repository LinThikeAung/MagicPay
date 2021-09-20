<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
}


