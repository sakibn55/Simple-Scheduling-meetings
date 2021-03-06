<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Advisor;
use App\Models\Reminder;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = User::whereHas('role', function ($query) {
            $query->where('title', 'advisor');
        })->get();

        return view('student.student_dashboard', compact('data'));
    }
    public function myReminders()
    {
        $reminders = auth()->user()->studentReminder()->with('advisor')->orderByDesc('start')->get();
        return view('student.student_reminders', compact('reminders'));
    }

    public function advisorAvaibility(Request $request, $advisor_email)
    {

        if ($request->ajax()) {
            $datas = User::where('email', $advisor_email)->with(['advisorReminder', 'advisor'])->first();
            return response()->json($datas);
        }
    }

    public function viewAppointment($slug)
    {
        $data = Reminder::where('slug', $slug)->first();
        return view(
            'student.reminder_view',
            compact('data')
        );
    }
}
