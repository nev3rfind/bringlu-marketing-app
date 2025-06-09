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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string'],
            'other_title' => ['nullable', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_website' => ['required', 'url', 'max:255'],
            'paypal_email' => ['required', 'email', 'max:255'],
            'commission_structure' => ['required', 'array', 'min:1'],
            'commission_structure.*' => ['string', 'in:megamog,minimog'],
            'company_type_id' => ['required', 'integer', 'in:1,2'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Handle the "Other" title option
        $title = $request->title;
        if ($title === 'Other' && $request->other_title) {
            $title = $request->other_title;
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'title' => $title,
            'other_title' => $request->title === 'Other' ? $request->other_title : null,
            'company_name' => $request->company_name,
            'company_website' => $request->company_website,
            'paypal_email' => $request->paypal_email,
            'commission_structure' => json_encode($request->commission_structure),
            'company_type_id' => $request->company_type_id,
            'account_type' => 1, // All users are partners now
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

       return Self::checkUser($user);
    }
}