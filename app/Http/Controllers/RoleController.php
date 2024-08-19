<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function getRoles()
    {
        if (Auth::user()->isAbleTo('manage role')) {
            $roles = Role::where('created_by', creatorId())
                ->withCount('permissions')
                ->get();
            return view('admin.roles.index', compact('roles'));
        } else {
            return redirect()->back()->with('error', 'Permission Denied !!!');
        }
    }

    public function createRole()
    {
        if (Auth::user()->isAbleTo('create role')) {
            return view('admin.roles.create');
        } else {
            return response()->json(['error' => 'Permission Denied'], 401);
        }
    }

    public function storeRole(Request $request)
    {
        if (Auth::user()->isAbleTo('create role')) {
            $rules = [
                'role_name' => 'required'
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                $message = $validation->getMessageBag();
                return redirect()->back()->with('error', $message->first());
            }

            $checkRole = Role::where('name', $request->role_name)->where('created_by', creatorId())->first();
            if (empty($checkRole)) {
                $role = new Role();
                $role->name = $request->role_name;
                $role->created_by = creatorId();
                $role->save();
                return redirect()->route('get.roles')->with('success', 'Role Created Successfully..');
            } else {
                return redirect()->back()->with('error', 'This Role is Already Exist !!!');
            }
        } else {
            return redirect()->back()->with('error', 'Permission Denied !!!');
        }
    }

    public function editRole(Request $request, $role_id)
    {
        if (Auth::user()->isAbleTo('edit role')) {
            $role = Role::where('id', $role_id)->first();
            if ($role) {
                $permissions = Permission::all()->groupBy('scope');
                $assignedPermissions = $role->permissions->pluck('id')->toArray();
                return view('admin.roles.edit', compact('role', 'permissions', 'assignedPermissions'));
            } else {
                return response()->json(['error' => 'Role Not Found !!'], 401);
            }
        } else {
            return redirect()->back()->with('error', 'Permission Denied !!');
        }
    }

    public function updateRole(Request $request, $role_id)
    {
        if (Auth::user()->isAbleTo('edit role')) {
            $role = Role::where('id', $role_id)->first();
            if ($role) {
                $role->syncPermissions($request->permissions);
                return redirect()->route('get.roles')->with('Success', 'Permission Assign Successfully.');
            } else {
                return redirect()->route('get.roles')->with('error', 'Role Not Found !!');
            }
        } else {
            return redirect()->back()->with('error', 'Permission Denied !!');
        }
    }

    public function deleteRole(Request $request, $role_id)
    {
        if (Auth::user()->isAbleTo('edit role')) {
            $role = Role::where('id', $role_id)->first();
            if ($role) {
                $role->delete();
                return redirect()->back()->with('error', 'Role Deleted Successfully.');
            } else {
                return redirect()->back()->with('error', 'Permission Denied !!');
            }
        } else {
            return redirect()->back()->with('error', 'Permission Denied !!');
        }
    }
}
