<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserProfileController;
 
Route::get('/', function () {
    return redirect()->route('login'); // Redirect to the login route
});
 
Route::controller(AuthController::class)->group(function () {

    Route::get('firstlogin', 'showLoginForm');
    Route::get('firstlogin/{user}', 'showFirstLoginForm')->name('firstlogin');
    Route::post('firstlogin/changepassword', 'changePassword')->name('changepassword');
    
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');
  
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');
  
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
    // Route::post('store', 'store')->name('profile.store');

});
  
Route::middleware('auth')->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
 
    Route::controller(RoleController::class)->prefix('roles')->group(function () {
        Route::get('', 'index')->name('roles');
        Route::get('create', 'create')->name('roles.create');
        Route::post('store', 'store')->name('roles.store');
        Route::get('show/{id}', 'show')->name('roles.show');
        Route::get('edit/{id}', 'edit')->name('roles.edit');
        Route::put('edit/{id}', 'update')->name('roles.update');
        Route::delete('destroy/{id}', 'destroy')->name('roles.destroy');
    });

    Route::controller(ProjectController::class)->prefix('project')->group(function () {
        Route::get('', 'index')->name('project');
        Route::get('create', 'create')->name('project.create');
        Route::post('store', 'store')->name('project.store');
        Route::get('show/{id}', 'show')->name('project.show');
        Route::get('edit/{id}', 'edit')->name('project.edit');
        Route::put('edit/{id}', 'update')->name('project.update');
        Route::delete('destroy/{id}', 'destroy')->name('project.destroy');
    });

    Route::controller(CompanyController::class)->prefix('company')->group(function () {
        Route::get('', 'index')->name('company');
        Route::get('create', 'create')->name('company.create');
        Route::post('store', 'store')->name('company.store');
        Route::get('show/{id}', 'show')->name('company.show');
        Route::get('edit/{id}', 'edit')->name('company.edit');
        Route::put('edit/{id}', 'update')->name('company.update');
        Route::delete('destroy/{id}', 'destroy')->name('company.destroy');
    });

    // Route::controller(AuthController::class)->prefix('profile')->group(function () {
    //     Route::get('', 'index')->name('profile');
    //     Route::get('create', 'create')->name('profile.create');
    //     Route::post('store', 'store')->name('profile.store');
    //     Route::get('show/{id}', 'show')->name('profile.show');
    //     Route::get('edit/{id}', 'edit')->name('profile.edit');
    //     Route::put('edit/{id}', 'update')->name('profile.update');
    //     Route::delete('destroy/{id}', 'destroy')->name('profile.destroy');
    // });
 
    Route::middleware('auth')->prefix('profile')->group(function () {
        Route::get('', [UserProfileController::class, 'index'])->name('profile');
        Route::get('create', [UserProfileController::class, 'create'])->name('profile.create');
        Route::post('store', [UserProfileController::class, 'store'])->name('profile.store');
        Route::get('show/{id}', [UserProfileController::class, 'show'])->name('profile.show');
        Route::get('edit/{id}', [UserProfileController::class, 'edit'])->name('profile.edit');
        Route::put('edit/{id}', [UserProfileController::class, 'update'])->name('profile.update');
        Route::get('editpassword/{user}', [UserProfileController::class, 'editPassword'])->name('profile.editpassword');
        Route::put('edit/{id}', [UserProfileController::class, 'updatePassword'])->name('profile.updatepassword');
        Route::delete('destroy/{id}', [UserProfileController::class, 'destroy'])->name('profile.destroy');
    });
    // Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');

});