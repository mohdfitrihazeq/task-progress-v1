<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Company;
 
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
        Company::create($request->all());
 
        return redirect()->route('company')->with('success', 'company added successfully');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
  
        return view('company.show', compact('company'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
  
        return view('company.edit', compact('company'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $company = Company::findOrFail($id);
  
        $company->update($request->all());
  
        return redirect()->route('company')->with('success', 'company updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
  
        $company->delete();
  
        return redirect()->route('company')->with('success', 'company deleted successfully');
    }
}

