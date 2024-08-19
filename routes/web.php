<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [AdminController::class, 'loginForm'])->name('login');
Route::post('login-process', [AdminController::class, 'loginProcess'])->name('login.process');
Route::prefix('admin')->middleware('auth')->group(function () {
  Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

  // Company Routes
  Route::get('companies', [CompanyController::class, 'index'])->name('show.all.company');
  Route::get('create-company', [CompanyController::class, 'createCompany'])->name('create.company');
  Route::post('store-company', [CompanyController::class, 'storeCompany'])->name('store.company');
  Route::get('edit-company/{companyId}', [CompanyController::class, 'editCompany'])->name('edit.company');
  Route::post('update-company/{companyId}', [CompanyController::class, 'updateCompany'])->name('update.company');
  Route::delete('delete-company/{companyId}', [CompanyController::class, 'deleteCompany'])->name('delete.company');

  // Logout Route
  Route::post('logout', [AdminController::class, 'logout'])->name('logout');

  // Routes for Role
  Route::get('roles', [RoleController::class, 'getRoles'])->name('get.roles');
  Route::get('create-role', [RoleController::class, 'createRole'])->name('create.role');
  Route::post('store-role', [RoleController::class, 'storeRole'])->name('store.role');
  Route::get('edit-role/{role_id}', [RoleController::class, 'editRole'])->name('edit.role');
  Route::post('update-role/{role_id}', [RoleController::class, 'updateRole'])->name('update.role');
  Route::delete('delete-role/{role_id}', [RoleController::class, 'deleteRole'])->name('delete.role');

  // Route for Create User Company side
  Route::get('users', [UserController::class, 'index'])->name('show.all.users');
  Route::get('create-user', [UserController::class, 'createUser'])->name('create.users');
  Route::post('store-user', [UserController::class, 'storeUser'])->name('store.user');
  Route::get('edit-user/{user_id}', [UserController::class, 'editUser'])->name('edit.user');
  Route::post('update-user/{user_id}', [UserController::class, 'updateUser'])->name('update.user');
  Route::delete('delete-user/{userId}', [UserController::class, 'deletUser'])->name('delete.user');
});
