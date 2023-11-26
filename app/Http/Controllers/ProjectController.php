<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Project;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Company;
use App\Models\ProjectCompany;
 
class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $project = Project::with('companies')->orderBy('created_at', 'DESC')->get();
        $companies = Company::orderBy('created_at', 'DESC')->get();
        $project_company = ProjectCompany::orderBy('created_at', 'DESC')->get();

        return view('project.index', compact('project', 'companies', 'project_company'));
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
            'project_name' => ['required', Rule::unique('projects', 'project_name')],
            // 'company_id' => ['required', Rule::exists('companies', 'id')],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the project
        $project = Project::create([
            'project_name' => $request->input('project_name'),
        ]);

        $company = Company::create([
            'company_name' => $request->input('company_name'),
        ]);
        // $company = Company::findOrFail($request->company_id);

        // Attach the project to the specified company
        $project->companies()->attach($company);

        return redirect()->route('project')->with('success', 'Project added successfully');
    }


  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
  
        return view('project.show', compact('project'));
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

        return view('project.edit', compact('project', 'companies', 'associatedCompanies'));
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
            'company_ids' => 'array', // Assuming 'company_ids' is an array in the form
            'company_ids.*' => 'exists:companies,company_id', // Validate each company_id in the array
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the project's general information
        $project->update([
            'project_name' => $request->input('project_name'),
        ]);

        // Sync the associated companies in the pivot table
        $project->companies()->sync($request->input('company_ids'));

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