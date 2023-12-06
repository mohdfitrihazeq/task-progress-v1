<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Company;
use App\Models\ProjectCompany;
use App\Models\AuthController;
use Auth;
use App\Rules\UniqueProjectForCompany;
 
class ProjectController extends Controller
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
            if ($user->role_name == 'Master Super Admin - MSA') {
                // $projects = $user->company->projects;
                $projects = Project::orderBy('project_name','ASC')->get();
            } else {
                // If the user is not MSA, get projects associated with the user's company_id
                $companyProjects = Project::whereHas('companies', function ($query) use ($user) {
                    $query->where('companies.company_id', $user->company_id);
                })->orderBy('project_name','ASC')->get();

                $projects = $companyProjects;
                // dd($projects);

            }
        }

        return view('project.index', compact('projects'));
    }



  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('project.create', compact('companies'));
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_name' => [
                'required',
                new UniqueProjectForCompany($request->input('company_id')),
            ],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the project
        $project = Project::create([
            'project_name' => $request->input('project_name'),
        ]);

        // Check if the user is Master Super Admin - MSA
        if (\Auth::user()->role_name == 'Master Super Admin - MSA') {
            // Validate and create the company only if MSA
            if ($request->has('company_id')) {
                $company = Company::find($request->input('company_id'));

                // Attach the project to the specified company
                $project->companies()->attach($company->company_id);
            }
        } else {
            // Use \Auth::user()->company_id for company_id
            $company = Company::find(\Auth::user()->company_id);

            // Attach the project to the specified company
            $project->companies()->attach($company->company_id);
        }

        return redirect()->route('project')->with('success', 'Project added successfully');
    }




  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
         // Get the companies associated with the project
         $associatedCompanies = $project->companies;

         // Get all companies
         $companies = Company::all(); 
  
        return view('project.show', compact('project','companies', 'associatedCompanies'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);

        // Get the companies associated with the project
        $associatedCompanies = $project->companies;

        // Get all companies
        $companies = Company::all(); 

        // Get all projects
        $projects = Project::all();

        return view('project.edit', compact('project', 'companies', 'associatedCompanies', 'projects'));
    }


  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'project_name' => ['required', Rule::unique('projects', 'project_name')->ignore($project->id)],
            'company_id' => 'exists:companies,company_id', // Validate the selected company_id
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the project's general information
        $project->update([
            'project_name' => $request->input('project_name'),
        ]);

        // Check if the user is Master Super Admin - MSA
        if (\Auth::user()->role_name == 'Master Super Admin - MSA') {
            // Validate and update the company only if MSA
            if ($request->has('company_id')) {
                $company = Company::find($request->input('company_id'));

                // Sync the associated company in the pivot table
                $project->companies()->sync([$company->company_id]);
            }
        }

        return redirect()->route('project')->with('success', 'Project updated successfully');
    }



  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
  
        $project->delete();
  
        return redirect()->route('project')->with('success', 'project deleted successfully');
    }
}