<?php

namespace App\Http\Controllers;

use PDOException;
use App\Models\Reminder;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isNull;
use Illuminate\Contracts\Support\ValidatedData;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->ajax())
    	{
    		$data = Reminder::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['slug', 'title', 'start', 'end','status']);

            $data= $data->map(function($d)
            {
                $d['overlap'] = false;
                if(!$d['status']){
                    $d['className'] = 'bg-danger text-white';
                }else{
                    $d['className'] = 'bg-success text-white';
                }
                return $d;
            });

            return response()->json($data);
    	}
    	return view('reminder.reminder_view');
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

            $reminder = new Reminder();
            $reminder->title = $request->title;
            $reminder->description = $request->description;
            $reminder->location_title = $request->location_title;
            $reminder->lattitude = $request->lattitude;
            $reminder->longitude = $request->longitude;
            $reminder->range = $request->range;
            $reminder->start = $request->start;
            $reminder->end = $request->end;

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
        ]);
    }
}
