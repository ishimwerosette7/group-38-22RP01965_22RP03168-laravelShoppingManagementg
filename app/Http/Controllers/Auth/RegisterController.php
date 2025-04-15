<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'account_type' => ['required', 'in:buyer,seller'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string'],
            'business_name' => ['required_if:account_type,seller', 'nullable', 'string', 'max:255'],
            'business_type' => ['required_if:account_type,seller', 'nullable', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::min(4)],
        ]);
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'account_type' => $request->account_type,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'business_name' => $request->business_name,
            'business_type' => $request->business_type,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('login')
            ->with('success', 'Registration successful! Please login with your credentials.');
    }
} 
