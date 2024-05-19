<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Categories;
use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    private $users;

    public function __construct()
    {
        $this->users = new User;
    }

    public function homepage()
    {
        if (auth()->user()->type == 2) {
            $year = Year::where('user_id', auth()->user()->id)->first();
            $categories = Categories::all();

            return view('userpages.teacher.homepage', compact('year', 'categories'));
        } else {
            $categories = Categories::all();

            return view('userpages.homepage', compact('categories'));
        }
    }

    public function editClientProfile(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'profile'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validation->fails()) return back()->withInput()->with('warning', implode('<br>', $validation->errors()->all()));

        $profile = $request->file('profile');
        $user = $this->users->where('id', auth()->user()->id)->first();
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($profile) {
            $profile = $profile->store();
            $userImageOld  = $user->profile;
            $userData['profile'] = $profile;
            $request->profile->move(public_path('profiles/'), $profile);

            if ($userImageOld) {
                $userImageOldPath = public_path('profiles/' . $userImageOld);

                if (file_exists($userImageOldPath)) unlink($userImageOldPath);
            }
        }

        User::where('id', auth()->user()->id)->update($userData);

        return back()->with('success', 'Successfully Updated.');
    }

    public function filterTeachers(Request $request)
    {
        $filterValue = $request->filter;
        $query = User::where('type', 2);

        if ($filterValue == '1-3') {
            $query->join('years', 'users.id', '=', 'years.user_id')
                ->where('years.year', '>=', 1)
                ->where('years.year', '<=', 3);
        } elseif ($filterValue == '3-5') {
            $query->join('years', 'users.id', '=', 'years.user_id')
                ->where('years.year', '>=', 3)
                ->where('years.year', '<=', 5);
        } elseif ($filterValue == '5-10') {
            $query->join('years', 'users.id', '=', 'years.user_id')
                ->where('years.year', '>=', 5)
                ->where('years.year', '<=', 10);
        } elseif ($filterValue == '10-50') {
            $query->join('years', 'users.id', '=', 'years.user_id')
                ->where('years.year', '>=', 10);
        }

        $teachers = $query->get();

        return response(['teachers' => $teachers]);
    }

    public function getCategoryTeacher(Request $request)
    {
        $teachers = User::where('category', $request->category)->get();

        return response(["teachers" => $teachers]);
    }

    public function getTeacher()
    {
        $teachers = User::join('years', 'users.id', '=', 'years.user_id')
            ->select('users.*', 'years.year')
            ->where('users.type', 2)
            ->get();

        return response(["teachers" => $teachers]);
    }

    public function editProfile(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'year' => 'required',
            'type' => 'required',
            'profile'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validation->fails()) return back()->withInput()->with('warning', implode('<br>', $validation->errors()->all()));

        $profile = $request->file('profile');
        $user = $this->users->where('id', auth()->user()->id)->first();
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
        ];

        if ($profile) {
            $profile = $profile->store();
            $userImageOld  = $user->profile;
            $userData['profile'] = $profile;
            $request->profile->move(public_path('profiles/'), $profile);

            if ($userImageOld) {
                $userImageOldPath = public_path('profiles/' . $userImageOld);

                if (file_exists($userImageOldPath)) unlink($userImageOldPath);
            }
        }

        User::where('id', auth()->user()->id)->update($userData);
        Year::where('user_id', auth()->user()->id)->update([
            'year' => $request->year
        ]);

        return back()->with('success', 'Successfully Updated.');
    }

    public function inquiries()
    {
        $bookings = Booking::join('users as teachers', 'bookings.teacher_id', '=', 'teachers.id')
            ->where('bookings.user_id', auth()->user()->id)
            ->where('bookings.end_date', '>=', now())
            ->select('bookings.*', 'teachers.name as teacher_name', 'teachers.email as teacher_email', 'teachers.profile as teacher_profile', 'teachers.description as teacher_description')
            ->get();

        return view('userpages.inquiries', compact('bookings'));
    }

    public function clients()
    {
        $clients = Booking::join('users as client', 'bookings.user_id', '=', 'client.id')
            ->where('bookings.teacher_id', auth()->user()->id)
            ->where('bookings.end_date', '>=', now())
            ->where('bookings.status', "Pending")
            ->select('bookings.*', 'client.name as client_name', 'client.email as client_email', 'client.profile as client_profile')
            ->get();

        return view('userpages.teacher.client', compact('clients'));
    }

    public function doneClient(Request $request)
    {
        $booking = Booking::find($request->id);

        if (!$booking) {
            return response(['status' => 'warning', 'message' => 'Booking not found.']);
        }

        $booking->status = 'Done';
        $booking->save();

        return response(['status' => 'success', 'message' => 'Booking status updated to done.']);
    }

    public function removeClients(Request $request)
    {
        $user = Booking::where('user_id', $request->id)->first();

        if (!$user) {
            return response(['status' => 'warning', 'message' => 'User not found.']);
        }

        $deleted = $user->delete();

        if (!$deleted) {
            return response(['status' => 'warning', 'message' => 'Remove was not successful.']);
        }

        return response([]);
    }

    public function bookTeacher(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'teacherID' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:date',
        ]);

        if ($validation->fails()) return back()->withInput()->with('warning', implode('<br>', $validation->errors()->all()));

        $teacher = User::where('id', $request->teacherID)->first();

        Booking::create([
            'user_id' => auth()->user()->id,
            'teacher_id' => $request->teacherID,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => "Pending",
            'price' => $teacher->rate,
        ]);

        return back()->with('success', 'Successfully Booked.');
    }
}
