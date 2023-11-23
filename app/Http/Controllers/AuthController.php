<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
  
class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }
  
    public function registerSave(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'user_name' => 'required',
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users'), // Check uniqueness in the 'users' table
            ],
            'password' => 'required|confirmed',
        ]);

        // Add custom error message for duplicate email
        $validator->sometimes('email', 'unique:users', function ($input) {
            return !User::where('email', $input['email'])->exists();
        });

        $validator->sometimes('name', 'unique:users', function ($input) {
            return !User::where('name', $input['name'])->exists();
        });

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        

        // Create a new user
        User::create([
            'user_name' => $request->name,
            'name' => $request->name,
            'role_name' => 'SITE',
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'level' => 'Admin',
        ]);

        // Redirect to the login page
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
    // public function create()
    // {
    //     $companies = Company::all();
    //     $roles = Role::all();
    //     return view('profile.create', compact('companies','roles'));
    //     // return view('profile.create');
    // }
  
    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {

    //     // Validate the request data
    //     $validator = Validator::make($request->all(), [
    //         'user_name' => 'required',
    //         'name' => 'required',
    //         'email' => [
    //             'required',
    //             'email',
    //             Rule::unique('users'), // Check uniqueness in the 'users' table
    //         ],
    //         'password' => 'required',
    //     ]);

    //     // Add custom error message for duplicate email
    //     $validator->sometimes('email', 'unique:users', function ($input) {
    //         return !User::where('email', $input['email'])->exists();
    //     });

    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     // Create a new user
    //     // User::create([
    //     //     'user_name' => $request->name,
    //     //     'name' => $request->name,
    //     //     'email' => $request->email,
    //     //     'role_name' => $request->role_name,
    //     //     'email' => $request->email,
    //     //     'company_id' => $request->company_id,
    //     //     'password' => Hash::make($request->password),
    //     // ]);

    //     // User::create($request->all());

    //     // Create a new user
    //     $user = new User([
    //         'user_name' => $request->name,
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'role_name' => $request->role_name,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     $company = Company::findOrFail($request->company_id);
    //     $role = Role::findOrFail($request->role_name);
    //     $user->company()->associate($company);
    //     $user->role()->associate($role);

    //     $user->save();

 
    //     return redirect()->route('profile')->with('success', 'User added successfully');
    // }
  
    // /**
    //  * Display the specified resource.
    //  */
    // public function show(string $id)
    // {
    //     $profile = User::findOrFail($id);
  
    //     return view('profile.show', compact('profile'));
    // }
  
    // /**
    //  * Show the form for editing the specified resource.
    //  */
    // public function edit(string $id)
    // {
    //     $profile = User::findOrFail($id);
  
    //     return view('profile.edit', compact('profile'));
    // }
  
    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     $profile = User::findOrFail($id);
  
    //     $profile->update($request->all());
  
    //     return redirect()->route('profile')->with('success', 'profile updated successfully');
    // }
  
    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     $profile = User::findOrFail($id);
  
    //     $profile->delete();
  
    //     return redirect()->route('profile')->with('success', 'profile deleted successfully');
    // }
}