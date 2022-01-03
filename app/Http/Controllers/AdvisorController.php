<?php

namespace App\Http\Controllers;

use PDOException;
use App\Models\Advisor;
use App\Models\Reminder;
use Illuminate\Http\Request;
use App\Notifications\Appointments;

class AdvisorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'advisor']);
    }
    protected function validateData(Request $request)
    {
        $request->validate([
            'start' => 'required|date|max:255',
            'end' => 'required|date|max:255',
        ]);
    }
    public function myReminders()
    {
        $reminders = auth()->user()->advisorReminder()->with('student')->orderByDesc('start')->get();

        return view('advisor.advisor_reminder', compact('reminders'));
    }

    public function getAvaibility(Request $request)
    {
        if ($request->ajax()) {
            $data = auth()->user()->advisor()->whereDate('start', '>=', $request->start)
                ->whereDate('end',   '<=', $request->end)
                ->get(['id', 'start', 'end']);

            $data = $data->map(function ($d) {
                $d['overlap'] = false;
                $d['className'] = 'bg-success text-white';
                return $d;
            });

            return response()->json($data);
        }
        return view('advisor.advisor_calender');
    }
    public function avaibilityCalendar()
    {
        return view('advisor.advisor_calender');
    }
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $this->validateData($request);
            try {
                $advisor = new Advisor();
                $advisor->start = $request->start;
                $advisor->end = $request->end;
                $advisor->user_id = auth()->user()->id;
                $advisor->save();
                return response()->json($advisor, 200);
            } catch (\Throwable $th) {
                return response()->json($th->getMessage(), 500);
            } catch (PDOException $e) {
                return response()->json($e->getMessage(), 404);
            }
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $this->validateData($request);
            try {
                $advisor = Advisor::findOrFail($request->id);
                $advisor->start = $request->start;
                $advisor->end = $request->end;
                $advisor->update();
                return response()->json($advisor, 200);
            } catch (\Throwable $th) {
                return response()->json($th->getMessage(), 500);
            } catch (PDOException $e) {
                return response()->json($e->getMessage(), 404);
            }
        }
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            try {
                $advisor = Advisor::findOrFail($request->id);
                $advisor->delete();
                return response()->json(null, 200);
            } catch (\Throwable $th) {
                return response()->json($th->getMessage(), 500);
            } catch (PDOException $e) {
                return response()->json($e->getMessage(), 404);
            }
        }
    }

    public function confirmation(Request $reminder)
    {
        try {
            $reminderData = Reminder::where('slug', $reminder->slug)->first();
            if ($reminderData->status) {
                $reminderData->status = 0;
                $notification['message'] = 'Your Appointment Denied';
            } else {
                $reminderData->status = 1;
                $notification['message'] = 'Your Appointment Confirmed';
            }
            $reminderData->update();
            //send notification
            $notification['appointment_id'] = $reminderData->slug;
            $reminderData->student->notify(new Appointments($notification));

            return redirect()->back()->with('success', 'Successfully Updated');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        } catch (PDOException $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        }
    }

    public function viewAppointment($slug)
    {
        $data = Reminder::where('slug', $slug)->first();
        return view(
            'advisor.reminder_view',
            compact('data')
        );
    }
}
