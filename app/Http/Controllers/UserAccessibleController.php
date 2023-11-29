<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectCompany;
use App\Models\User;
use App\Models\Role;
use App\Models\UserAccessible;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Auth;


class UserAccessibleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $projects = collect();
        // Check if the user has a company
        // dd($user->company);
        if ($user->company) {
            // If the user is MSA, get all projects associated with the company
            if ($user->role_name == 'Master Super Admin - MSA' || $user->role_name == 'Super Super Admin - SSA') {
                // $projects = $user->company->projects;
                $projects = Project::all(); //showing all project
            } else {
                // If the user is not MSA, get projects associated with the user's company_id
                $companyProjects = Project::whereHas('companies', function ($query) use ($user) {
                    $query->where('companies.company_id', $user->company_id);
                })->get();

                $projects = $companyProjects;
                // dd($projects);

            }
        }

        return view('access.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $projects = collect();
        // Check if the user has a company
        // dd($user);
        if ($user->company) {
            // If the user is MSA, get all projects associated with the company
            // if ($user->role_name == 'Master Super Admin - MSA') {
            //     // $projects = $user->company->projects;
            //     $projects = Project::all(); //showing all project
            // } else {
                // If the user is not MSA, get projects associated with the user's company_id
                $companyProjects = Project::join('project_company', 'projects.id', '=', 'project_company.project_id')
                ->where('project_company.company_id', $user->company_id)
                ->orderBy('project_company.company_id','DESC')
                ->get();

                $projects = $companyProjects;
                $projectIds = $projects->pluck('project_id')->toArray();
                // dd($projects);

            // }
        }
        $profile = User::findOrFail($id);
        // dd($profile);
        // $user_accessible = UserAccessible::all();
         // Retrieve UserAccessible records based on user_name
        $user_accessible = UserAccessible::where('user_name', $profile->user_name)->get();

        // dd($projects);
        // $roles = Role::all();  // Retrieve all roles or adjust as needed
        // $companies = Company::all();  // Retrieve all roles or adjust as needed

        return view('access.edit', compact('profile','projects','user','user_accessible','projectIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'project_id' => [
                function ($attribute, $value, $fail) use ($request, $id) {
                    // Check if the combination of project_id and user_name already exists
                    $existingRecord = UserAccessible::where('project_id', $request->project_id)
                        ->where('user_name', $request->user_name)
                        ->first();

                    if ($existingRecord && $existingRecord->user_name === $request->user_name) {
                        // The combination already exists with the same user_name
                        $fail("The combination of project name and user already exists.");
                    }

                    // Check if the user already has 10 projects
                    $userProjectsCount = UserAccessible::where('user_name', $request->user_name)->count();

                    if ($userProjectsCount >= 10) {
                        $fail("The user has already hit the Max 10 projects in the user's project accessible list");
                    }
                },
            ],
        ]);


        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create or update the user_accessible record
        $user_accessible = new UserAccessible([
            'user_name' => $request->user_name,
            'project_id' => $request->project_id,
        ]);

        $user_accessible->save();

        $profile = User::findOrFail($id);

        return redirect()->route('access.edit', ['id' => $profile->id])->with('success', 'Profile updated successfully');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user_accessible = UserAccessible::findOrFail($id);
        $user_name = $user_accessible->user_name;
    
        // Delete the user_accessible record
        $user_accessible->delete();
    
        // Get the user's profile ID from the user table
        $user = User::where('user_name', $user_name)->first();
        $user_id = $user->id;
    
        // Redirect to access.edit with the user's profile ID
        return redirect()->route('access.edit', ['id' => $user_id])->with('success', 'User accessible deleted successfully');
    }
    

}
