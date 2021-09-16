<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Wallet;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class WalletController extends Controller
{
    public function index(){
        return view('backend.wallet.index');
    }
    public function ssd()
    {
        $wallets =  Wallet::with('users');
        //wallet nae users table ko eloquent thone htr loz waller and users ko with nae htoke dr
        return Datatables::of($wallets)
                ->editColumn('created_at',function($wallet){
                    return Carbon::parse($wallet->created_at)->format("Y-m-d H:m:s");//laravel carbon default package
                })
                ->editColumn('updated_at',function($wallet){
                    return Carbon::parse($wallet->created_at)->format("Y-m-d H:m:s");
                })
                ->editColumn('amount',function($wallet){
                    return number_format($wallet->amount,2);
                })
                ->addColumn('account_person', function($wallet){
                   $user = $wallet->user;
                   if($user)
                   {
                        return "<p>Name : $user->name</p><p>Email : $user->email</p><p>Phone : $user->phone</p>";
                   }
                })
                ->rawColumns(['account_person'])
                ->make(true);
    }
}
