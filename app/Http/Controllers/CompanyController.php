<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->isAbleTo('create company')) {
            $allCompanies = User::where('type', 'company')->where('created_by', creatorId())->get();
            return view('admin.company.index', compact('allCompanies'));
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }
    public function createCompany()
    {
        if (Auth::user()->isAbleTo('create company')) {
            return view('admin.company.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function storeCompany(Request $request)
    {
        if (Auth::user()->isAbleTo('create company')) {
            $rules = [
                'company_name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                $message = $validation->getMessageBag();
                return redirect()->back()->with('error', $message->first());
            }

            $company = new User();
            $company->name = $request->company_name;
            $company->email = $request->email;
            $company->password = Hash::make($request->password);
            $company->type = 'company';
            $company->created_by = creatorId();
            $company->save();

            $companyRole = Role::where('name', 'company')->where('created_by', 1)->first();
            if ($companyRole) {
                $company->update(['type' => $companyRole->name]);
                $company->roles()->attach($companyRole);
            }

            if (Auth::user()->hasRole('super admin')) {
                $data = $company->makeRoles();
            }

            return redirect()->back()->with('success', 'Company Registered Successfully.');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function editCompany(Request $request, $companyId)
    {
        if (Auth::user()->isAbleTo('edit company')) {
            $company = User::where('id', $companyId)->first();
            if ($company) {
                return view('admin.company.edit', compact('company'));
            } else {
                return response()->json(['error' => __('Company Not Found !!')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function updateCompany(Request $request, $companyId)
    {
        if (Auth::user()->isAbleTo('edit company')) {

            $rules = [
                'company_name' => 'required',
                'email' => 'required',
            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
                $validationError = $validation->getMessageBag();
                return redirect()->back()->with('error',  __($validationError->first()));
            }
            $company = User::where('id', $companyId)->first();
            if ($company) {
                $company->name = $request->company_name;
                $company->email = $request->email;
                $company->save();
                return redirect()->back()->with('success', 'Comapny Data Update Successfully.');
            } else {
                return response()->json(['error' => __('Company Not Found !!')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function deleteCompany(Request $request, $companyId)
    {
        if (Auth::user()->isAbleTo('delete company')) {
            $company = User::where('id', $companyId)->first();
            if ($company) {
                if ($company->id == 2) {
                    return redirect()->back()->with('error', 'You Can Not Delete Default Company.');
                } else {

                    // delete current company roles 
                    $roles = Role::where('created_by', $companyId)->get();
                    foreach ($roles as $role) {
                        $role->delete();
                    }

                    //delete users of that company
                    $companyUsers = User::where('created_by', $companyId)->get();
                    foreach ($companyUsers as $companyUser) {
                        $companyUser->delete();
                    }
                    
                    $company->delete();
                    return redirect()->back()->with('success', 'Company Deleted Successfully.');
                }
            } else {
                return redirect()->back()->with('error', 'Company Not Found !!');
            }
        } else {
            return redirect()->back()->with('error', 'Permission Denied !');
        }
    }
}
