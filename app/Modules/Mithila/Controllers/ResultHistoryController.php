<?php

namespace App\Modules\Mithila\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ResultHistory;

class ResultHistoryController extends Controller
{
    public function index()
    {
        return view('mithila.histories.index', ['histories' => ResultHistory::with('result')->latest()->get()]);
    }
}
