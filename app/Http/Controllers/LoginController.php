<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:4'],
        ]);

        $user = DB::table('users')->where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Email atau password salah.');
        }

        // set session login
        $request->session()->regenerate();
        $request->session()->put('logged_in', true);
        $request->session()->put('user_id',   $user->id);
        $request->session()->put('user_name', $user->name);
        if (isset($user->role)) {
            $request->session()->put('role', $user->role); // opsional
        }

        return redirect()->route('home')->with('success', 'Selamat datang, '.$user->name.'!');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'Anda telah logout.');
    }
}
