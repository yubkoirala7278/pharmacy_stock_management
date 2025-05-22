<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// ==========Authentication============
Route::get('/', [LoginController::class, 'showLoginForm']);
Auth::routes([
    'register' => false,      // Disable registration
    'verify'   => false,      // Disable email verification
    'reset'    => false,      // ✅ Disable password reset
]);
// =======End of Authentication=========


// ==========Admin==============
Route::middleware(['auth.admin'])->group(function () {
    require __DIR__ . '/admin.php';
});
// =======End of Admin===========
