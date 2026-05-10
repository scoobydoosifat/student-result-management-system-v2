<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('teacher_id') || $request->session()->get('teacher_role') !== 'teacher') {
            return redirect()->route('teacher.login');
        }

        return $next($request);
    }
}
