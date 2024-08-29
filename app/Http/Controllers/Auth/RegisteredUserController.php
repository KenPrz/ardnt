<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): RedirectResponse
    {

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'handle' => $request->handle,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Handle expired verification for a user.
     *
     * This method checks if the user's email has been verified. If the email is already verified,
     * it returns false indicating that there is no need to delete the user. If the email is not
     * verified and the user's creation time is more than 5 minutes ago, it deletes the user and
     * returns true indicating that the user was deleted. Otherwise, it returns false indicating
     * that the user was not deleted and is still unverified.
     *
     * @param  User  $user  The user object.
     * @return bool True if the user was deleted, false otherwise.
     */
    private function handleExpiredVerification($user): bool
    {
        if ($user->email_verified_at) {
            return false; // User is already verified, no need to delete.
        }

        if ($user->created_at->diffInMinutes() > 1) {
            $user->delete();

            return true; // Indicate that the user was deleted.
        }

        return false; // User was not deleted and is still unverified.
    }
}
