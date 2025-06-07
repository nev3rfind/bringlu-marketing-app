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
        $redirect = '/business';
        if ($user->account_type === 1)
        {
            $redirect = '/advertiser';
        }

        return redirect($redirect);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if($request->account_type == 2)
        {
            $company_type_id = 1;
        } else if($request->account_type == 3) {
            $company_type_id = 2;
        } else {
            $company_type_id = null;
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'account_type' => $request->account_type,
            'password' => Hash::make($request->password),
            'company_type_id' => $company_type_id
        ]);

        event(new Registered($user));

        Auth::login($user);

       return Self::checkUser($user);
    }
}
