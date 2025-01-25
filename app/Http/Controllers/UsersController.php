<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(UserDataTable $DataTable ){
        $header = 'Users';
        $users = User::where('role_id',1)->get();
        return $DataTable->render('users.list',compact('header','users'));
    }

    public function verify(Request $request){
       
        User::where('id', decrypt($request->id))->update(['status' => '1']);
        toastr('User verified successfully !');
        return redirect()->route('users');
    }
}
