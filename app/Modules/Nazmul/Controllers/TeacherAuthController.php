<?php

namespace App\Modules\Nazmul\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TeacherLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TeacherAuthController extends Controller
{
    public function showCoordinatorLoginForm()
    {
        return view('nazmul.coordinator-login');
    }

    public function showTeacherLoginForm()
    {
        return view('nazmul.teacher-login');
    }

    public function loginCoordinator(Request $request)
    {
        return $this->attemptLogin($request, 'coordinator', 'coordinator.dashboard');
    }

    public function loginTeacher(Request $request)
    {
        return $this->attemptLogin($request, 'teacher', 'teacher.dashboard');
    }

    public function logout()
    {
        $role = session('teacher_role');
        session()->forget(['teacher_id', 'teacher_name', 'teacher_role']);

        return $role === 'coordinator'
            ? redirect()->route('coordinator.login')
            : redirect()->route('teacher.login');
    }

    private function attemptLogin(Request $request, string $role, string $redirectRoute)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $login = TeacherLogin::with('teacher')
            ->where('username', $credentials['username'])
            ->first();

        if (!$login || !Hash::check($credentials['password'], $login->password)) {
            return back()->withErrors(['username' => 'Invalid credentials'])->withInput();
        }

        if (($login->teacher?->role ?? 'teacher') !== $role) {
            return back()->withErrors(['username' => 'Role not permitted for this login'])->withInput();
        }

        session([
            'teacher_id' => $login->teacher_id,
            'teacher_name' => $login->teacher?->full_name,
            'teacher_role' => $role,
        ]);

        return redirect()->route($redirectRoute);
    }
}
