<?php

namespace App\Modules\Mithila\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ResultHistory;

class ResultHistoryController extends Controller
{
    public function index()
    {
        $teacherId = session('teacher_id');
        
        $histories = ResultHistory::whereHas('result.enrollment.course', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->with(['result.enrollment.student', 'result.enrollment.course'])->latest()->get();

        return view('mithila.histories.index', ['histories' => $histories]);
    }
}
