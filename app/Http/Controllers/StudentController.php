<?php

namespace App\Http\Controllers;

use App\Models\Advisor;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $data = User::whereHas('role', function ($query) {
            $query->where('title', 'advisor');
        })->get();

        return view('student.student_dashboard', compact('data'));
    }
    public function myReminders()
    {
        $reminders = auth()->user()->studentReminder()->with('advisor')->get();
        return view('student.student_reminders', compact('reminders'));
    }

    public function advisorAvaibility(Request $request, $advisor_email)
    {

        if ($request->ajax()) {
            $datas = User::where('email', $advisor_email)->with(['advisorReminder', 'advisor'])->first();
            return response()->json($datas);
        }
    }
}
