<?php

namespace App\Http\Controllers;

use PDOException;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function getCounselors(){

        $counselors = User::whereHas('role', function($query){
            $query->where('title','counselor');
        } )->get();

        return view('admin.list_of_counselors',compact('counselors'));
    }

    public function createCounselor(){
        return view ('admin.add_counselors');
    }
    public function addCounselors(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role_id = Role::where('title', 'counselor')->first()->id;
            $user->save();

            return redirect()->route('admin.counselors')->with('success','Suceesfully Added New Counselor');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }
        catch(PDOException $e){
            return redirect()->back()->with('error',$e->getMessage());
        }

    }

    public function getStudents(){

        $students = User::whereHas('role', function($query){
            $query->where('title','student');
        } )->get();

        return view('admin.list_of_students',compact('students'));
    }

    public function destroyUser(Request $request){

        $user = User::where('email', $request->email)->first();
        try{
            $user->delete();
            return redirect()->back()->with('success','Suceesfully Deleted User');
        }
        catch (\Throwable $th) {
            return redirect()->back()->with('error',$th->getMessage());
        }
        catch(PDOException $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
