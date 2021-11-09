<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Auth::routes(['register' => false,]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home/assets', [App\Http\Controllers\HomeController::class, 'assets'])->name('home.assets');
Route::get('/home/assets/create', [App\Http\Controllers\HomeController::class, 'createAssets'])->name('home.assets.create');
Route::post('/home/assets/save', [App\Http\Controllers\HomeController::class, 'saveAssets'])->name('home.assets.save');
Route::get('/home/allocations', [App\Http\Controllers\HomeController::class, 'allocations'])->name('home.allocations');
Route::get('/home/allocations/create', [App\Http\Controllers\HomeController::class, 'createAllocations'])->name('home.allocations.create');

Route::get('/home/account', [App\Http\Controllers\HomeController::class, 'settings'])->name('home.settings');
Route::post('/home/account/password-change', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('home.password.change');


Route::get('/legal', [App\Http\Controllers\LegalHomeController::class, 'index'])->name('legal');
Route::get('/legal/contracts/reports', [App\Http\Controllers\LegalHomeController::class, 'reports'])->name('legal.reports');
Route::get('/legal/contracts/reports/pdf', [App\Http\Controllers\LegalHomeController::class, 'reportsPDF'])->name('legal.reports.pdf');
Route::get('/legal/contracts/{contract}/open', [App\Http\Controllers\ContractsController::class, 'openContract'])->name('contracts.open');
Route::get('/legal/contracts/{contract}/download', [App\Http\Controllers\ContractsController::class, 'downloadContract'])->name('contracts.download');
Route::get('/legal/contracts/{contract}/cancel', [App\Http\Controllers\ContractsController::class, 'cancelContract'])->name('contracts.cancel');
Route::get('/legal/contracts/expired', [App\Http\Controllers\LegalHomeController::class, 'expiredContracts'])->name('contracts.expired');

Route::get('/legal/account', [App\Http\Controllers\LegalHomeController::class, 'settings'])->name('legal.settings');
Route::post('/legal/account/password-change', [App\Http\Controllers\LegalHomeController::class, 'changePassword'])->name('legal.password.change');

Route::get('/gfc',[\App\Http\Controllers\GFCHomeController::class,'index'])->name('gfc');
Route::get('/gfc/contracts',[\App\Http\Controllers\GFCHomeController::class,'contracts'])->name('gfc.contracts');
Route::get('/gfc/contracts/{contract}/open',[\App\Http\Controllers\GFCHomeController::class,'openContract'])->name('gfc.contracts.open');

Route::get('/gfc/account', [App\Http\Controllers\GFCHomeController::class, 'settings'])->name('gfc.settings');
Route::post('/gfc/account/password-change', [App\Http\Controllers\GFCHomeController::class, 'changePassword'])->name('gfc.password.change');

Route::get('/manager',[\App\Http\Controllers\ManagerHomeController::class,'index'])->name('manager');
Route::get('/manager/contracts',[\App\Http\Controllers\ManagerHomeController::class,'contracts'])->name('manager.contracts');
Route::get('/manager/contracts/{contract}/open',[\App\Http\Controllers\ManagerHomeController::class,'openContract'])->name('manager.contracts.open');
Route::get('/manager/contracts/reports', [App\Http\Controllers\managerHomeController::class, 'reports'])->name('manager.reports');


Route::get('/manager/account', [App\Http\Controllers\ManagerHomeController::class, 'settings'])->name('manager.settings');
Route::post('/manager/account/password-change', [App\Http\Controllers\ManagerHomeController::class, 'changePassword'])->name('manager.password.change');


Route::get('/admin', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin');
Route::get('/admin/contracts', [\App\Http\Controllers\AdminController::class, 'contracts'])->name('admin.contracts');

Route::POST('/admin/register/user', [\App\Http\Controllers\AdminController::class, 'registerUser'])->name('admin.user.register');
Route::get('/admin/register/user/{user}/password/expire', [\App\Http\Controllers\AdminController::class, 'expirePassword'])->name('admin.user.expire');


Route::get('/admin/registration/sheet', [\App\Http\Controllers\UsersController::class, 'registrationSheet'])->name('reg.sheet');
Route::post('/admin/registration/sheet/upload', [\App\Http\Controllers\UsersController::class, 'uploadSheet'])->name('upload.sheet');

Route::get('/admin/assets-sheet', [\App\Http\Controllers\AssetsController::class, 'registrationSheet'])->name('assets.sheet');
Route::post('/admin/asset-sheet/upload', [\App\Http\Controllers\AssetsController::class, 'uploadSheet'])->name('upload.assets.sheet');

Route::get('/admin/disable-user/{user}', [\App\Http\Controllers\UsersController::class, 'manage'])->name('users.manage');

Route::get('/admin/account', [App\Http\Controllers\AdminController::class, 'settings'])->name('admin.settings');
Route::post('/admin/account/password-change', [App\Http\Controllers\AdminController::class, 'changePassword'])->name('admin.password.change');


/**
 * Resource routes
 */

Route::resource('/legal/contracts', \App\Http\Controllers\ContractsController::class);

Route::resource('/admin/users', \App\Http\Controllers\UsersController::class);
Route::resource('/admin/assets', \App\Http\Controllers\AssetsController::class);
Route::resource('/admin/allocations', \App\Http\Controllers\AllocationsController::class);
