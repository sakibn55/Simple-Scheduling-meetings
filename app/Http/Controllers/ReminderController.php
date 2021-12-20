<?php

namespace App\Http\Controllers;

use PDOException;
use App\Models\User;
use App\Models\Reminder;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use function PHPUnit\Framework\isNull;
use Illuminate\Contracts\Support\ValidatedData;

class ReminderController extends Controller
{

    protected function validateData(Request $request){
        $request->validate([
            'title' => 'required|max:50',
            'description' => 'required|max:255',
            'location_title' => 'required|max:255',
            'lattitude' => 'max:20',
            'longitude' => 'max:20',
            'range' => 'required|integer',
            'start' => 'required|date|max:255',
            'end' => 'required|date|max:255',
            'advisor_email' =>'required|email',
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // if($request->ajax())
    	// {
    	// 	$data = Reminder::whereDate('start', '>=', $request->start)
        //                ->whereDate('end',   '<=', $request->end)
        //                ->get(['slug', 'title', 'start', 'end','status']);

        //     $data= $data->map(function($d)
        //     {
        //         $d['overlap'] = false;
        //         if(!$d['status']){
        //             $d['className'] = 'bg-danger text-white';
        //         }else{
        //             $d['className'] = 'bg-success text-white';
        //         }
        //         return $d;
        //     });

        //     return response()->json($data);
    	// }


        $advisors = User::whereHas('role', function($query){
            $query->where('title','advisor');
        } )->get();

        $data = [];

        if($request->isMethod('GET')){
            if(isset($request->advisor_email) && $request->advisor_email != null){
                $advisor_email = $request->advisor_email;
                $advisor = User::where('email', $advisor_email)->first();
                $advisor_avaibility = $advisor->advisor()->get();

                $data= $advisor_avaibility->map(function($d)
                {
                    $d['className'] = 'bg-success text-white';
                    //$d['selectable'] = true;
                    $d['rendering'] = 'background';
                    return $d;
                });
            }else{
                $data = Reminder::all();
                $data= $data->map(function($d)
                {
                    $d['selectable'] = true;
                    if(!$d['status']){
                        $d['className'] = 'bg-danger text-white';
                    }else{
                        $d['className'] = 'bg-success text-white';
                    }
                    return $d;
                });
            }

        }

        $data = json_encode($data);
    	return view('reminder.reminder_view',compact('data','advisors'));
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

        try{
            $advisor = User::where('email',$request->advisor_email)->first()->id;
            $reminder = new Reminder();
            $reminder->title = $request->title;
            $reminder->description = $request->description;
            $reminder->location_title = $request->location_title;
            $reminder->lattitude = $request->lattitude;
            $reminder->longitude = $request->longitude;
            $reminder->range = $request->range;
            $reminder->start = $request->start;
            $reminder->end = $request->end;
            $reminder->student_id = auth()->user()->id;
            $reminder->advisor_id = $advisor;
            $reminder->save();
            return redirect()->back()->with('success','Successfully Saved your appointment');

        }catch(PDOException $e){
            return redirect()->back()->with('error',$e->getMessage());
        }catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
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
        if(!empty($reminder)){
            return response()->json($reminder,200);
        }
        return response()->json(null,400);

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
        if($request->ajax() && $request->type=="update"){

            $reminder = Reminder::where('slug',$slug)->first();
            try {
                $reminder->start = $request->start;
                $reminder->end = $request->end;
                $reminder->update();
                return response()->json($reminder,200);
            } catch (\Throwable $th) {
                return response()->json($th, 404);
            }
            catch(PDOException $e){
                return response()->json($e, 500);
            }
        }

        $this->validateData($request);

        $reminder = Reminder::where('slug',$slug)->first();

        try {
            $reminder->title = $request->title;
            $reminder->description = $request->description;
            $reminder->location_title = $request->location_title;
            $reminder->lattitude = $request->lattitude;
            $reminder->longitude = $request->longitude;
            $reminder->range = $request->range;
            $reminder->start = $request->start;
            $reminder->end = $request->end;
            $reminder->update();
            return redirect()->back()->with('success','Sucessfully updated reminder');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }
        catch(PDOException $e){
            return redirect()->back()->with('error',$e->getMessage());
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
        $reminder = Reminder::where('slug',$reminder->slug)->first();
        try{
            $reminder->delete();
            return redirect()->back()->with('success','Suceesfully Canceled Your Appointment');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }
        catch(PDOException $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

        return redirect()->back()->with('info','Something went wrong! please try again.');
    }


}
