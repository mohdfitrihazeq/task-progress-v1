<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Mail\FirstLoginMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function index()
    {
        $profile = User::orderBy('created_at', 'DESC')->get();
        return view('profile.index', compact('profile'));
    }

    public function create()
    {
        $companies = Company::all();
        $roles = Role::all();
        return view('profile.create', compact('companies', 'roles'));
    }

    public function store(Request $request)
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
        'password' => 'required',
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
        // User::create([
        //     'user_name' => $request->name,
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'role_name' => $request->role_name,
        //     'email' => $request->email,
        //     'company_id' => $request->company_id,
        //     'password' => Hash::make($request->password),
        // ]);

        // User::create($request->all());
		$userEmail = $request->email;
        $userName = $request->name;

        $emailData = [
            'name' => $request->name,
        ];
        Mail::to($userEmail, $userName)->send(new FirstLoginMail($emailData));
        // Create a new user
        $user = new User([
            'user_name' => $request->user_name,
            'name' => $request->name,
            'email' => $request->email,
            'role_name' => $request->role_name,
            'company_id' => $request->company_id,
            'password' => Hash::make($request->password),
        ]);
        $company = Company::where('id', $request->company_id)->firstOrFail();
        $role = Role::where('role_name', $request->role_name)->first();
        //$user->company()->associate($company);
        // $user->role()->associate($role);
        $user->save();


        return redirect()->route('profile')->with('success', 'User added successfully');
    }

    public function show(string $id)
    {
        $profile = User::findOrFail($id);
        return view('profile.show', compact('profile'));
    }

    public function edit(string $id)
    {
        $profile = User::findOrFail($id);
        $roles = Role::all();  // Retrieve all roles or adjust as needed

        return view('profile.edit', compact('profile', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $profile = User::findOrFail($id);
        $profile->update($request->all());
        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function editPassword(string $id)
    {
        $profile = User::findOrFail($id);
        $roles = Role::all();  // Retrieve all roles or adjust as needed

        return view('profile.editpassword', compact('profile', 'roles'));
    }

	public function updatePassword(Request $request, string $user){
        $profile = User::findOrFail($user);
        // Access form input
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'confirmed',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
            ],
        ]);
        if ($validator->fails()) {
            return redirect('dashboard/'.$request->input('password'))
                        ->withErrors($validator)
                        ->withInput();
        }
        $input = [
            'password' => bcrypt($request->input('password')),
            'password_changed_at' => \Carbon\Carbon::now()
        ];

        $profile->update($input);
  
        $request->session()->regenerate();
  
        return redirect()->route('dashboard')->with('success', 'Password updated successfully');
	}

    public function destroy(string $id)
    {
        $profile = User::findOrFail($id);
        $profile->delete();
        return redirect()->route('profile')->with('success', 'Profile deleted successfully');
    }
}
