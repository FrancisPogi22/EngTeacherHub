<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validation->fails()) return back()->withInput()->with('warning', implode('<br>', $validation->errors()->all()));

        if (auth()->attempt($request->only('email', 'password'))) return $this->checkUserAccount();

        return back()->withInput()->with('warning', 'Incorrect User Credentials.');
    }

    public function register(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'Cpassword' => 'required|same:password'
        ]);

        if ($validation->fails()) return back()->withInput()->with('warning', implode('<br>', $validation->errors()->all()));

        $profileImage = $request->file('profile');
        $profileImagePath = $profileImage;

        if ($profileImage) {
            $profileImagePath = $profileImage->store();
            $profileImage->move(public_path('profiles/'), $profileImagePath);
        }

        $user = User::create([
            'type' => $request->type,
            'profile' => $profileImagePath,
            'category' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'email' => $request->email,
            'rate' => $request->rate,
            'password' => Hash::make($request->password),
        ]);

        if ($request->type == 2) {
            Year::create([
                'user_id' => $user->id,
                'year' => $request->year,
            ]);
        }

        return back()->with('success', 'Successfully registered.');
    }

    public function logout()
    {
        auth()->logout();
        session()->flush();
        return redirect('/')->with('success', 'Successfully Logged out.');
    }

    private function checkUserAccount()
    {
        if (!auth()->check()) return back();

        $userAuthenticated = auth()->user();

        if (auth()->user()->type == 2) {
            return redirect("/teacher/homepage")->with('success', "Welcome $userAuthenticated->name.");
        } else {
            return redirect("/homepage")->with('success', "Welcome $userAuthenticated->name.");
        }
    }
}
