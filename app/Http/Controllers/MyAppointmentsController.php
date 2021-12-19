<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;

class MyAppointmentsController extends Controller
{

    public function index(){
        $reminders = Reminder::all();
        return view('reminder.appointments', compact('reminders'));
    }
}
