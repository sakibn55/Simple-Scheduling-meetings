<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function myReminders(){
        $reminders = auth()->user()->studentReminder()->with('advisor')->get();
        return view('student.student_reminders',compact('reminders'));
    }
}
