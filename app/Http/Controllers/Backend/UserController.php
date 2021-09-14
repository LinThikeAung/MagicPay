<?php

namespace App\Http\Controllers\Backend;

use Yajra\Datatables\Datatables;
use Jenssegers\Agent\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\StoreUser;
use Carbon\Carbon;
use App\User;

class UserController extends Controller
{
    public function index(){

        return view('backend.user.index');
    }


    //for datatable rendering
    public function ssd(){
        $users = User::query();
        return Datatables::of($users)
                ->editColumn('created_at',function($user){
                    return Carbon::parse($user->created_at)->format("Y-m-d H:m:s");//laravel carbon default package
                })
                ->editColumn('updated_at',function($user){
                    return Carbon::parse($user->created_at)->format("Y-m-d H:m:s");
                })
                ->editColumn('user_agent',function($user){
                    if($user->user_agent){
                        $agent = new Agent();//app.php mar provider and alias kaw defined lote pp
                        $agent->setUserAgent($user->user_agent);
                        $device = $agent->device();
                        $platform = $agent->platform();
                        $browser = $agent->browser();

                        return "<table class=' table table-bordered'>
                                <tbody>
                                <tr><td>Platform</td><td>".$platform."</td></tr>
                                <tr><td>Device</td><td>".$device."</td</tr>
                                <tr><td>Browser</td><td>".$browser."</td</tr>
                                </tbody>
                                </table>";
                    }
                    return '-';
                })
                ->addColumn('action',function($user){
                $edit_col = '<a href="'.route('admin.user.edit',$user->id).'" class="text-warning mr-3"><i class="fas fa-edit"></i></a>';
                $delete_col = '<a href="" class="text-danger delete" data-id="'.$user->id.'"><i class="fas fa-trash-alt"></i></a>';
                return $edit_col.$delete_col;
                })
                ->rawColumns(['user_agent','action']) // html code par de column dway ko rawColumns htae pay ya dl
                ->make(true);
    }

    public function create(){
        return view('backend.user.create');
    }

    public function store(StoreUser $request){
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =Hash::make($request->password);
        $user->phone = $request->phone;
        $user->save();
        return redirect()->route('admin.user.index')->with("created","Created Successfully");
    }

    public function edit($id){
        $user = User::findOrFail($id);
        return view('backend.user.edit',compact('user'));

    }

    public function update(UpdateUser $request,$id){

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->phone = $request->phone;
        $user->update();

        return redirect()->route('admin.user.index')->with("edited","Edited Successfully");
    }

    public function destroy($id){
        $admin_user = User::findOrFail($id);
        $admin_user->delete();

        return "success";
    }
}
