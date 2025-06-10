<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

     // Redirect user to the page based on the account type after registration
    public static function checkUser(User $user)
    {
        // All users are now partners (account_type = 1) since we removed the business/advertiser distinction
        $redirect = '/advertiser';
        return redirect($redirect);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'title' => ['required', 'string'],
            'other_title' => ['nullable', 'string', 'max:255'],
            'company_website' => ['required', 'string', 'max:255'],
            'terms_agreement' => ['required', 'accepted'],
            'understand_checkbox' => ['required', 'accepted'],
            'payment_policy' => ['required', 'accepted'],
            'understand_policy' => ['required', 'accepted'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Handle the "Other" title option
        $title = $request->title;
        if ($title === 'Other' && $request->other_title) {
            $title = $request->other_title;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'title' => $title,
            'other_title' => $request->title === 'Other' ? $request->other_title : null,
            'company_website' => $request->company_website,
            'account_type' => 1, // All users are partners now
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // For AJAX requests, return success response
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'redirect' => '/advertiser']);
        }

        // Set session flag for success modal
        session(['registration_success' => true]);

        return Self::checkUser($user);
    }
}