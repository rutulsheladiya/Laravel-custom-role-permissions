<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginForm()
    {
        return view('welcome');
    }
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->isAbleTo('view dashboard')) {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function dashboard(Request $request)
    {
        if (Auth::user()->isAbleTo('view dashboard')) {
            if(Auth::user()->type == 'superadmin'){
                $companies = User::where('created_by',1)->count();
                return view('admin.dashboard',compact('companies'));
            }else{
                $company = Auth::user();
                $totalCompanyUsers = User::where('created_by',creatorId())->count();
                $totalRoles = Role::where('created_by',creatorId())->count();
                return view('admin.company.dashboard',compact('totalCompanyUsers','totalRoles'));
            }
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logout Successfully.');
    }
}
