<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
  
class AuthController extends Controller
{
    public function showFirstLoginForm(Request $request){
		if (!$request->route('user')) {
            // ID parameter is missing; redirect to another URL
            return redirect('login');
        }
		else{
			$user = $request->route('user'); // Retrieve the 'user' parameter from the route
			$exists = User::where('user_name', $user)->whereNull('password_changed_at')->exists(); 
			if ($exists) {
				// Record exists
				return view('auth.firstlogin', ['user' => $user]);
			} else {
				// Record does not exist
				return redirect()->route('login');
			}
		}
	}

    public function showResetPasswordForm(Request $request){
		if (!$request->route('user')) {
            // ID parameter is missing; redirect to another URL
            return redirect('login');
        }
		else{
			$user = $request->route('user'); // Retrieve the 'user' parameter from the route
            return view('auth.firstlogin', ['user' => $user]);
		}
	}
	
	public function changePassword(Request $request){
		$user = $request->input('user_name'); // Retrieve the 'user' parameter from the route
        // Access form input
        $validator = Validator::make($request->all(), [
            'user_name' => ['required'
            ],
            'password' => [
                'required',
                'confirmed',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
            ],
        ]);
        if ($validator->fails()) {
            return redirect($request->input('context').'/'.$request->input('user_name'))
                        ->withErrors($validator)
                        ->withInput();
        }
        $input = [
            'password' => bcrypt($request->input('password')),
            'password_changed_at' => \Carbon\Carbon::now(),
        ];

        User::where('user_name', $user)->update($input);
        
        if (!Auth::attempt($request->only('user_name', 'password'))) {
            throw ValidationException::withMessages([
                'user_name' => trans('auth.failed')
            ]);
        }
  
        $request->session()->regenerate();
        return redirect()->route('dashboard');
	}
    
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
        if($request->input('forgotPassword')!=null && $request->input('forgotPassword')=="forgotPassword"){
            if(User::where('user_name', '=', $request->input('user_name'))
            ->whereNotNull('password_changed_at')
            ->whereNotNull('email')
            ->exists()){
                $user = User::where('user_name', '=', $request->input('user_name'))->first();
                $userEmail = $user->email;
                $emailData = [
                    'user_name' => $user->user_name,
                    'name' => $user->name,
                ];
                Mail::to($userEmail, $user->name)->send(new ResetPasswordMail($emailData));
                return redirect()->back()->withErrors("Your password reset link has been sent to your registered email account -> ".substr($userEmail,0,4)."********".substr($userEmail,-3)." !");
            }
        }
        Validator::make($request->all(), [
            'user_name' => 'required',
        ])->validate();

        if(User::where('user_name', '=', $request->input('user_name'))->whereNull('password_changed_at')->exists()){
            return redirect()->route('firstlogin',['user'=>$request->input('user_name')]);
        }
        else{
            if (!Auth::attempt($request->only('user_name', 'password'))) {
                throw ValidationException::withMessages([
                    'user_name' => trans('auth.failed')
                ]);
            }

            $request->session()->regenerate();
      
            return redirect()->route('dashboard');
        }
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