<?php

namespace App\Http\Controllers;

use PDOException;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = auth()->user();

        return view('profile', compact('data'));
    }

    public function update(Request $request)
    {

        try {
            $user = User::find(auth()->user()->id);
            $image = new Image();

            //get old image and delete
            if ($request->file('image') != null) {
                if (auth()->user()->image != null) {
                    Storage::delete('public/' . auth()->user()->image->url);
                    auth()->user()->image->delete();
                }
                $image['url'] = $request->file('image')->store('profile', 'public');
                $user->image()->save($image);
            }
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->update();
            return redirect()->back()->with("success", "Successfully Uploaded");
        } catch (PDOException $e) {
            return redirect()->back()->with('errors', $e->getMessage());
        } catch (\Throwable $th) {
            return redirect()->back()->with('errors', $th->getMessage());
        }
    }

    public function password()
    {
        return view('changePassword');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        return redirect()->route('profile')->with('success', 'Password Updated Successfully');
    }
    public function view($email)
    {
        $data = User::where('email', $email)->first();
        if ($data == null) {
            return redirect()->back()->with('errors', 'Not Found');
        }
        return view('profile_view', compact('data'));
    }

    public function notification_read(Request $request)
    {
        if ($request->ajax()) {
            try {
                $notifcation = auth()->user()->notifications()->where('id', $request->id);
                $notifcation->update(['read_at' => now()]);
                return response()->json(null, 200);
            } catch (\Throwable $th) {
                return response()->json($th, 404);
            } catch (PDOException $e) {
                return response()->json($e, 500);
            }
        }
    }

    public function notification_count(Request $request){
        if ($request->ajax()) {
            try {
                $notifcation = auth()->user()->unreadNotifications()->count();
                return response()->json($notifcation, 200);
            } catch (\Throwable $th) {
                return response()->json($th, 404);
            } catch (PDOException $e) {
                return response()->json($e, 500);
            }
        }
    }
    public function destroy(Request $request){
        $user = User::findOrfail(auth()->user()->id);
        $request->validate([
            'password' => ['required', new MatchOldPassword],
        ]);
        Auth::logout();
        try{
            $user->advisor()->delete(); //delete all associated data
            $user->studentReminder()->delete(); //delete all associated data
            $user->advisorReminder()->delete(); //delete all associated data
            $user->image()->delete(); //delete all associated data
            $user->notifications()->delete();
            $user->delete();
            return redirect()->route('login')->with('success', 'Successfully Deleted Your Account');
        } catch (\Throwable $th) {
            return  redirect()->route('login')->with('danger', $th);
        } catch (PDOException $e) {
            return redirect()->route('login')->with('danger', $e);
        }
    }
}
