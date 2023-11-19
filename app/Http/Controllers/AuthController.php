<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
  
class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }
  
    public function registerSave(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed'
        ])->validate();
  
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 'Admin'
        ]);
  
        return redirect()->route('login');
    }
  
    public function login()
    {
        return view('auth/login');
    }
  
    public function loginAction(Request $request)
    {
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();
  
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('auth.failed')
            ]);
        }
  
        $request->session()->regenerate();
  
        return redirect()->route('dashboard');
    }
  
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
  
        $request->session()->invalidate();
  
        return redirect('/login');
    }
 
    // public function profile()
    // {
    //     return view('profile');
    // }

    // public function store(Request $request)
    // {
    //     User::create($request->all());
 
    //     return redirect()->route('profile')->with('success', 'Profile updated successfully');
    // }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profile = User::orderBy('created_at', 'DESC')->get();
  
        return view('profile.index', compact('profile'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('profile.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create($request->all());
 
        return redirect()->route('profile')->with('success', 'User added successfully');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = User::findOrFail($id);
  
        return view('profile.show', compact('profile'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $profile = User::findOrFail($id);
  
        return view('profile.edit', compact('profile'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $profile = User::findOrFail($id);
  
        $profile->update($request->all());
  
        return redirect()->route('profile')->with('success', 'profile updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $profile = User::findOrFail($id);
  
        $profile->delete();
  
        return redirect()->route('profile')->with('success', 'profile deleted successfully');
    }
}