<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function getLogin(){
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if(auth()->guard('users')->attempt(['username' => $request->input('username'),  'password' => $request->input('password')])){
            $user = auth()->guard('users')->user();
            //if($user->is_admin == 1){
                return redirect()->route('get_loan_details')->with('success','You are Logged in sucessfully.');
            //}
        }else {
            return back()->with('error','Whoops! invalid username and password.');
        }
    }

    public function adminLogout(Request $request)
    {
        auth()->guard('users')->logout();
        Session::flush();
        Session::put('success', 'You are logout sucessfully');
        return redirect(route('adminLogin'));
    }
}