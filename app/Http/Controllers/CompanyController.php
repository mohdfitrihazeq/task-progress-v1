<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
 
class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $company = Company::orderBy('created_at', 'DESC')->get();
  
        return view('company.index', compact('company'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('company.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'company_name' => ['required', Rule::unique('companies', 'company_name')],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new company
        Company::create($request->all());

        // Redirect to the company index page with success message
        return redirect()->route('company')->with('success', 'Company added successfully');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $company_id)
    {
        $company = Company::where('company_id',$company_id)->firstOrFail();
  
        return view('company.show', compact('company'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $company_id)
    {
        $company = Company::where('company_id',$company_id)->firstOrFail();
        return view('company.edit', compact('company'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $company_id)
    {
        $company = Company::findOrFail($company_id);

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'company_name' => [
                'required',
                Rule::unique('companies', 'company_name')->ignore($company->company_id, 'company_id'),
            ],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $company->update($request->all());

        return redirect()->route('company')->with('success', 'Company updated successfully');
    }

  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $company_id)
    {
        $company = Company::findOrFail($company_id);
  
        $company->delete();
  
        return redirect()->route('company')->with('success', 'company deleted successfully');
    }
}

