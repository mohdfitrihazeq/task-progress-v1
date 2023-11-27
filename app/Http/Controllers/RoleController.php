<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
 
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::orderBy('created_at', 'DESC')->get();
  
        return view('role.index', compact('role'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         // Validate the request data
        $validator = Validator::make($request->all(), [
            'role_name' => ['required', Rule::unique('roles', 'role_name')],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Role::create($request->all());
 
        return redirect()->route('roles')->with('success', 'role added successfully');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $role = Role::findOrFail($id);
  
        return view('role.show', compact('role'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
        $role = Role::findOrFail($id);
  
        return view('role.edit', compact('role'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findOrFail($id);

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'role_name' => [
                'required',
                Rule::unique('roles', 'role_name')->ignore($role->id),
            ],
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the role with the new data
        $role->update($request->all());

        // Redirect to the roles index with a success message
        return redirect()->route('roles')->with('success', 'Role updated successfully');
    }

  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
  
        $role->delete();
  
        return redirect()->route('roles')->with('success', 'role deleted successfully');
    }
}
