<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        if (Auth::user()->isAbleTo('manage user')) {
            $users = User::where('created_by', creatorId())->get();            
            return view('admin.users.index', compact('users'));
        } else {
            return redirect()->back()->with('error', 'Permission Denied !!!');
        }
    }

    public function createUser()
    {
        if (Auth::user()->isAbleTo('create user')) {
            $roles = Role::where('created_by', creatorId())->get();
            return view('admin.users.create', compact('roles'));
        } else {
            return response()->json(['error' => 'Permission Denied !!!'], 401);
        }
    }

    public function storeUser(Request $request)
    {
        if (Auth::user()->isAbleTo('create user')) {
            $rules = [
                'emp_name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'role' => 'required',
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                $validationError = $validation->getMessageBag();
                return redirect()->back()->with('error', $validationError->first());
            }
            $checkUser = User::where('email', $request->email)->first();
            if (empty($checkUser)) {
                $user = new User();
                $user->name = $request->emp_name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->created_by = creatorId();
                $user->save();

                $role = Role::where('id', $request->role)->first();
                if ($role) {
                    $user->type = $role->name;
                    $user->save();
                    $user->roles()->attach($role);
                }

                return redirect()->back()->with('success', 'User Created Successfully..');
            } else {
                return redirect()->back()->with('error', 'This Email is Already Registered.');
            }
        } else {
            return redirect()->back()->with('error', 'Permission Denied !!!');
        }
    }

    public function editUser(Request $request, $user_id)
    {
        if (Auth::user()->isAbleTo('edit user')) {
            $user = User::where('id', $user_id)->first();
            if ($user) {
                $roles = Role::where('created_by', creatorId())->get();
                return view('admin.users.edit', compact('user', 'roles'));
            } else {
                return response()->json(['error' => 'User Not Found !!!'], 401);
            }
        } else {
            return response()->json(['error' => 'Permission Denied !!!'], 401);
        }
    }

    public function updateUser(Request $request, $user_id)
    {
        if (Auth::user()->isAbleTo('edit user')) {
            $rules = [
                'emp_name' => 'required',
                'email' => 'required',
                'role' => 'required',
            ];

            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                $validationError = $validation->getMessageBag();
                return redirect()->back()->with('error', $validationError->first());
            }

            $user = User::where('id', $user_id)->first();

            if ($user) {
                $user->name = $request->emp_name;
                $user->email = $request->email;
                $user->save();
                $findRole = Role::where('id', $request->role)->first();
                if ($findRole) {
                    $user->roles()->detach();
                    $user->roles()->attach($findRole);
                    $user->type = $findRole->name;
                    $user->save();
                } else {
                    return redirect()->back()->with('error', 'Requested Role Not Found !!!');
                }
                return redirect()->back()->with('success', 'User Details Update Successfully.');
            } else {
                return redirect()->back()->with('error', 'Permission Denied !!!');
            }
        } else {
            return redirect()->back()->with('error', 'Permission Denied !!!');
        }
    }

    public function deletUser(Request $request, $user_id)
    {
        if (Auth::user()->isAbleTo('delete user')) {
            $user = User::where('id', $user_id)->first();
            if ($user) {
                $user->delete();
                return redirect()->back()->with('success', 'User Delete Successfully.');
            } else {
                return redirect()->back()->with('error', 'User Not Found !!!');
            }
        } else {
            return redirect()->back()->with('error', 'Permission Denied !!!');
        }
    }
}
