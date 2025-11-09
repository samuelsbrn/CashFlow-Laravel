<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Redirect root (cek login)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Kalau sudah login → ke dashboard, kalau belum → ke login
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (hanya untuk guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // FORM LOGIN
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    // PROSES LOGIN
    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    })->name('login.attempt');

    // FORM REGISTER
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    // PROSES REGISTER
    Route::post('/register', function (Request $request) {
        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'confirmed', 'min:6'],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    })->name('register.attempt');
});

/*
|--------------------------------------------------------------------------
| LOGOUT (hanya untuk user login)
|--------------------------------------------------------------------------
*/
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| APP ROUTES (hanya untuk user login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('transactions', TransactionController::class);
    Route::resource('categories',   CategoryController::class);

    // Profile routes
    Route::view('/profile', 'profile.edit')->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});
