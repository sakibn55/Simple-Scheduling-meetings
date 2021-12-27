<?php

namespace App\Http\Controllers;

use Exception;
use PDOException;
use App\Models\Role;
use App\Models\User;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Database\Eloquent\Builder;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }
    public function index()
    {
        $reminders = Reminder::orderByDesc('start')->get();
        return view('admin.appointments', compact('reminders'));
    }
    public function getAdvisor()
    {

        $advisor = User::whereHas('role', function ($query) {
            $query->where('title', 'advisor');
        })->get();

        return view('admin.list_of_advisor', compact('advisor'));
    }

    public function createAdvisor()
    {
        return view('admin.add_advisor');
    }
    public function addAdvisor(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:12'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
            $user->role_id = Role::where('title', 'advisor')->first()->id;
            $user->save();

            return redirect()->route('admin.advisors')->with('success', 'Suceesfully Added New Advisor');
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        } catch (PDOException $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        }
    }

    public function getStudents()
    {

        $students = User::whereHas('role', function ($query) {
            $query->where('title', 'student');
        })->get();

        return view('admin.list_of_students', compact('students'));
    }

    public function destroyUser(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        try {
            $user->advisor()->delete(); //delete all associated data
            $user->studentReminder()->delete(); //delete all associated data
            $user->advisorReminder()->delete(); //delete all associated data
            $user->image()->delete(); //delete all associated data
            $user->delete(); //delete user
            return redirect()->back()->with('success', 'Suceesfully Deleted User');
        } catch (\Throwable $th) {
            return redirect()->back()->with('danger', $th->getMessage());
        } catch (PDOException $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        } catch (Exception $e) {
            return redirect()->back()->with('danger', $e->getMessage());
        }
    }

    public function viewAppointment($slug)
    {
        $data = Reminder::where('slug', $slug)->first();
        return view(
            'admin.reminder_view',
            compact('data')
        );
    }
}
