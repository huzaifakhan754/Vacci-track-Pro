<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:parent,hospital'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        if ($request->role === 'hospital') {
            Hospital::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'address' => 'Please update your address',
                'location' => 'Please update location',
                'phone' => '0000000000',
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect($this->redirectTo($request));
    }

    protected function redirectTo(Request $request): string
    {
        return match ($request->user()?->roles->first()?->name) {
            'admin' => route('admin.dashboard', absolute: false),
            'parent' => route('parent.dashboard', absolute: false),
            'hospital' => route('hospital.dashboard', absolute: false),
            default => route('dashboard', absolute: false),
        };
    }
}
