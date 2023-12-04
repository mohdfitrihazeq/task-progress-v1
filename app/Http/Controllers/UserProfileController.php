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
use Auth;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = collect();
        $company = Company::all();

        // Check if the user has a company
        if ($user->company) {
            // If the user is MSA, get all profiles
            if ($user->role_name == 'Master Super Admin - MSA') {
                $profile = User::with('company')->orderBy('created_at', 'DESC')->get();
            } else {
                // If the user is not MSA, get profiles associated with the user's company_id
                $companyProfiles = User::where('company_id', $user->company_id)->with('company')->orderBy('created_at', 'DESC')->get();
                $profile = $companyProfiles;
                // dd($profiles);
            }
        }
        // dd($profile);
        return view('profile.index', compact('profile', 'company'));
    }


    public function create()
    {
        $user = Auth::user();
        $companies = [];
    
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
            // Rule::unique('users'), // Check uniqueness in the 'users' table
            function ($attribute, $value, $fail) {
                // Check if the email contains '@' and '.'
                if (strpos($value, '@') === false || strpos($value, '.') === false) {
                    $fail('Error '.$attribute.'. Please ensure it has "@" or "." !');
                }
            },
        ],
        'password' => 'required',
    ]);

        // Add custom error message for duplicate email
        // $validator->sometimes('email', 'unique:users', function ($input) {
        //     return !User::where('email', $input['email'])->exists();
        // });

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
            'user_name' => $request->user_name,
            'name' => $request->name,
        ];
        Mail::to($userEmail, $userName)->send(new FirstLoginMail($emailData));
        // Create a new user
        if (\Auth::user()->role_name == 'Master Super Admin - MSA') {
            $user = new User([
                'user_name' => $request->user_name,
                'name' => $request->name,
                'email' => $request->email,
                'role_name' => $request->role_name,
                'company_id' => $request->company_id,
                'password' => Hash::make($request->password),
            ]);
            $company = Company::where('company_id', $request->company_id)->firstOrFail();
            $role = Role::where('role_name', $request->role_name)->first();
            //$user->company()->associate($company);
            // $user->role()->associate($role);
            $user->save();
        }else{
            $user = new User([
                'user_name' => $request->user_name,
                'name' => $request->name,
                'email' => $request->email,
                'role_name' => $request->role_name,
                'password' => Hash::make($request->password),
                'company_id' => \Auth::user()->company_id,
            ]);
            $role = Role::where('role_name', $request->role_name)->first();
            //$user->company()->associate($company);
            // $user->role()->associate($role);
            $user->save();
        }


        return redirect()->route('profile')->with('success', 'User added successfully');
    }

    public function show(string $id)
    {
        $profile = User::findOrFail($id);
        $company = Company::all();
        $roles = Role::all();
        return view('profile.show', compact('profile','company','roles'));
    }

    public function edit(string $id)
    {
        $profile = User::findOrFail($id);
        $roles = Role::all();  // Retrieve all roles or adjust as needed
        $companies = Company::all();  // Retrieve all roles or adjust as needed

        return view('profile.edit', compact('profile', 'roles','companies'));
    }

    public function update(Request $request, string $id)
    {
        $profile = User::findOrFail($id);
    
        // Access form input
        $validator = Validator::make($request->all(), [
            'new_password' => [
                'nullable',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
            ],
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    // Check if the email contains '@' and '.'
                    if (strpos($value, '@') === false || strpos($value, '.') === false) {
                        $fail('Error '.$attribute.'. Please ensure it has "@" or "." !');
                    }
                },
            ],
        ]);
        
        $validator->messages()->add('new_password.regex', 'The password should at least be a mix of a lower case character (e.g., a, d), an upper case character (e.g., B, F), a number (e.g., 2, 3), and a symbol (e.g., &, @). For example, tpS@12345.');
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Check if new password is provided
        if ($request->filled('new_password')) {
            $input = array_merge(
                $request->except('new_password', '_token', '_method'),
                [
                    'password' => bcrypt($request->input('new_password')),
                    'password_changed_at' => now(),
                ]
            );
        } else {
            // If new password is not provided, retain the old password
            $input = array_merge(
                $request->except('new_password', '_token', '_method'),
                ['password_changed_at' => now()]
            );
        }
    
        $profile->update($input);
    
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
            return redirect('profile/editpassword/'.$user)
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
