<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
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

        // Create a new user
        $user = new User([
            'user_name' => $request->name,
            'name' => $request->name,
            'email' => $request->email,
            'role_name' => $request->role_name,
            'password' => Hash::make($request->password),
        ]);

        $company = Company::findOrFail($request->company_id);
        $role = Role::findOrFail($request->role_name);
        $user->company()->associate($company);
        $user->role()->associate($role);

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
        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request, string $id)
    {
        $profile = User::findOrFail($id);
        $profile->update($request->all());
        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function destroy(string $id)
    {
        $profile = User::findOrFail($id);
        $profile->delete();
        return redirect()->route('profile')->with('success', 'Profile deleted successfully');
    }
}
