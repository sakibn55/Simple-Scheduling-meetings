<?php

namespace App\Http\Controllers;

use PDOException;
use App\Models\User;
use App\Models\Reminder;
use App\Notifications\Appointments;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;
use Illuminate\Contracts\Support\ValidatedData;

class ReminderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function validateData(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'description' => 'required|max:255',
            'location_title' => 'required|max:255',
            'lattitude' => 'max:20',
            'longitude' => 'max:20',
            'start' => 'required|date|max:255',
            'end' => 'required|date|max:255',
            'advisor_email' => 'required|email',
        ]);
    }

    protected function validateUpdateData(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'description' => 'required|max:255',
            'location_title' => 'required|max:255',
            'lattitude' => 'max:20',
            'longitude' => 'max:20',
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $advisors = User::whereHas('role', function ($query) {
            $query->where('title', 'advisor');
        })->get();

        $data = [];

        if ($request->isMethod('GET')) {
            if (isset($request->advisor_email) && $request->advisor_email != null) {
                $advisor_email = $request->advisor_email;
                $advisor = User::where('email', $advisor_email)->first();
                if ($advisor == null) {
                    return redirect()->route('dashboard')->with('errors', 'No Advisor Found!');
                }
                $advisor_avaibility = $advisor->advisor()->get();

                $data = $advisor_avaibility->map(function ($d) {

                    $d['className'] = 'bg-success text-white';
                    $d['rendering'] = 'background';
                    return $d;
                });


                //get other students
                $students = User::where('id', '!=', auth()->user()->id)->whereHas('role', function ($query) {
                    $query->where('title', 'student');
                })->with('studentReminder', function ($q) use ($advisor) {
                    $q->where('advisor_id', $advisor->id)->where('start', '>=', now());
                })->get();

                //get other students reminders and store

                if (count($students) > 0) {
                    foreach ($students as $std) {
                        if (count($std->studentReminder) > 0) {
                            foreach ($std->studentReminder as $item) {
                                $item->className = 'bg-danger red text-white';
                                $item->rendering = 'background';
                                $data[] = $item;
                            }
                        }
                    }
                }


                $authUser_reminder = auth()->user()->studentReminder()->where('advisor_id', $advisor->id)->where('start', '>=', now())->get();

                if (count($authUser_reminder) > 0) {

                    foreach ($authUser_reminder as $item) {

                        if ($item->status) {
                            $item['className'] = 'bg-primary text-white';

                        } else {
                            $item['className'] = 'bg-warning text-white';
                        }

                        $item['id'] = (string) Str::uuid();
                        $data[] = $item;
                    }
                }
            }
        }

        $data = json_encode($data);



        return view('reminder.reminder_view', compact('data', 'advisors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validateData($request);

        try {
            $advisor = User::where('email', $request->advisor_email)->first();
            $reminder = new Reminder();
            $reminder->title = $request->title;
            $reminder->description = $request->description;
            $reminder->location_title = $request->location_title;
            $reminder->lattitude = $request->lattitude;
            $reminder->longitude = $request->longitude;
            $reminder->start = $request->start;
            $reminder->end = $request->end;
            $reminder->student_id = auth()->user()->id;
            $reminder->advisor_id = $advisor->id;
            $reminder->save();

            //send notification
            $notification['message'] = 'New Appointment Placed';
            $notification['appointment_id'] = $reminder->slug;
            $advisor->notify(new Appointments($notification));

            return redirect()->back()->with('success', 'Successfully Saved your appointment');
        } catch (PDOException $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $reminder = Reminder::where('slug', $slug)->first();
        if (!empty($reminder)) {
            return response()->json($reminder, 200);
        }
        return response()->json(null, 400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function edit(Reminder $reminder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        if ($request->ajax() && $request->type == "update") {

            $reminder = Reminder::where('slug', $slug)->first();
            try {
                $reminder->start = $request->start;
                $reminder->end = $request->end;
                $reminder->update();
                //send notification
                $notification['message'] = 'Appointment Updated';
                $notification['appointment_id'] = $reminder->slug;
                $reminder->advisor->notify(new Appointments($notification));
                return response()->json($reminder, 200);
            } catch (\Throwable $th) {
                return response()->json($th, 404);
            } catch (PDOException $e) {
                return response()->json($e, 500);
            }
        }

        $this->validateUpdateData($request);

        try {
            $reminder = Reminder::where('slug', $slug)->first();
            $reminder->title = $request->title;
            $reminder->description = $request->description;
            $reminder->location_title = $request->location_title;
            $reminder->lattitude = $request->lattitude;
            $reminder->longitude = $request->longitude;
            $reminder->update();
            //send notification
            $notification['message'] = 'Appointment Updated';
            $notification['appointment_id'] = $reminder->slug;
            $reminder->advisor->notify(new Appointments($notification));
            return redirect()->back()->with('success', 'Sucessfully Updated Appointment');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        } catch (PDOException $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reminder  $reminder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reminder $reminder)
    {
        $reminder = Reminder::where('slug', $reminder->slug)->first();
        try {
            $reminder->delete();
            return redirect()->route('dashboard')->with('success', 'Suceesfully Delete!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        } catch (PDOException $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        }

        return redirect()->back()->with('info', 'Something went wrong! please try again.');
    }
}
