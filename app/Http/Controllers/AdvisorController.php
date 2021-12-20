<?php

namespace App\Http\Controllers;

use PDOException;
use App\Models\Advisor;
use App\Models\Reminder;
use Illuminate\Http\Request;

class AdvisorController extends Controller
{
    protected function validateData(Request $request){
        $request->validate([
            'start' => 'required|date|max:255',
            'end' => 'required|date|max:255',
        ]);
    }
    public function myReminders(){
        $reminders = auth()->user()->advisorReminder()->with('student')->get();
        return view('advisor.advisor_reminder',compact('reminders'));
    }

    public function getAvability(Request $request){
        if($request->ajax())
    	{
            $data = auth()->user()->advisor()->whereDate('start', '>=', $request->start)
            ->whereDate('end',   '<=', $request->end)
            ->get(['id', 'start', 'end']);

    		// $data = Advisor::whereDate('start', '>=', $request->start)
            //            ->whereDate('end',   '<=', $request->end)
            //            ->get(['id', 'start', 'end'])->where('user_id', auth()->user()->id);

            $data= $data->map(function($d)
            {
                $d['overlap'] = false;
                return $d;
            });

            return response()->json($data);
    	}
    	return view('advisor.advisor_calender');
    }
    public function avaibilityCalendar(){
        return view('advisor.advisor_calender');
    }
    public function store(Request $request){
        if($request->ajax()){
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

            }
            catch(PDOException $e){
                return response()->json($e->getMessage(), 404);
            }
        }
    }

    public function update(Request $request){
        if($request->ajax()){
            $this->validateData($request);
            try {
                $advisor = Advisor::findOrFail($request->id);
                $advisor->start = $request->start;
                $advisor->end = $request->end;
                $advisor->update();
                return response()->json($advisor, 200);
            } catch (\Throwable $th) {
                return response()->json($th->getMessage(), 500);

            }
            catch(PDOException $e){
                return response()->json($e->getMessage(), 404);
            }
        }
    }

    public function destroy(Request $request){
        if($request->ajax()){
            try {
                $advisor = Advisor::findOrFail($request->id);
                $advisor->delete();
                return response()->json(null, 200);
            } catch (\Throwable $th) {
                return response()->json($th->getMessage(), 500);

            }
            catch(PDOException $e){
                return response()->json($e->getMessage(), 404);
            }
        }
    }

    public function confirmation(Request $reminder){
        try {
            $reminder = Reminder::where('slug',$reminder->slug)->first();
            if($reminder->status){
                $reminder->status = 0;
            }else{
                $reminder->status = 1;
            }
            $reminder->update();
            return redirect()->back()->with('success','Successfully Confirmed');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());

        }
        catch(PDOException $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
