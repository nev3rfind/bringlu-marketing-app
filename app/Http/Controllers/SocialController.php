<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Cookie;
use Illuminate\Http\Response;

class SocialController extends Controller
{
    public function showAccountSelection() {
        return view('github-auth');
    }

    // Setting session to store account type
    public function setAccountTypeSession($account_type) {
        return session(['account_type' => $account_type]);
    }

    // Getting account type from the form
    public function getAccountType(Request $request) {
      Self::setAccountTypeSession($request->account_type);
        return redirect()->route('login.github');
    }

    // Redirect to drive
    public function githubRedirect(){
        return Socialite::driver('github')->redirect();
    }

    // Github callback function
    public function githubCallback()
    {
        $user = Socialite::driver('github')->user();
        $this->_registerOrLoginGitHubUser($user);
        // Return home after login
        return redirect()->route('home');
    }

    // Register user if there is no record in the 'users' table, otherwise - login
    protected function _registerOrLoginGitHubUser($incomingUser)
    {
        $user = User::where('github_id', $incomingUser->id)->first();
        // If user does not have account then register
        if(!$user) {
            $user = new User();
            // Seperate GitHub User 'name' column into different columns
            // for first and last name
            $name = explode(" ", $incomingUser->name);
            $user->first_name = $name[0];
            $user->last_name = $name[1];
            $user->phone = "N/A";
            $user->email = $incomingUser->email;
            $user->password = encrypt('password');
            // Get account type from the session
            $user->account_type = session('account_type');
            $user->github_id = $incomingUser->id;
            $user->save();
        }
        Auth::login($user);
    }
}
