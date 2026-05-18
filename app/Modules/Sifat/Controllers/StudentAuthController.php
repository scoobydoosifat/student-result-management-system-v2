<?php

namespace App\Modules\Sifat\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StudentLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('sifat.student-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $login = StudentLogin::with('student')
            ->where('username', $credentials['username'])
            ->first();

        if (!$login || !Hash::check($credentials['password'], $login->password)) {
            return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
        }

        session([
            'student_id' => $login->student_id,
            'student_name' => $login->student?->full_name,
        ]);

        return redirect()->route('student.dashboard');
    }

    public function logout()
    {
        session()->forget(['student_id', 'student_name']);

        return redirect()->route('student.login');
    }
}
