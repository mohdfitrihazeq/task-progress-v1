<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\ProjectTaskProgress;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
 
class ProjectTaskProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function createnewprojecttaskname()
    {
        $projecttaskprogress = ProjectTaskProgress::join('projects','project_task_progress.project_id','=','projects.id')->join('users','project_task_progress.user_login_name','=','users.id')->where('task_progress_percentage',100)->orderBy('project_task_progress.id', 'DESC')->get();
        $project =  Project::orderBy('id','ASC')->get();
        $user =  User::orderBy('id','ASC')->get();
        return view('createnewprojecttaskname', compact('projecttaskprogress','project','user'));
    }

    public function createupdateprojecttask()
    {
        $projecttaskprogress = ProjectTaskProgress::join('projects','project_task_progress.project_id','=','projects.id')->where('task_progress_percentage',100)->orderBy('project_task_progress.id', 'DESC')->get();
        $project =  Project::orderBy('id','ASC')->get();
        return view('createupdateprojecttask', compact('projecttaskprogress','project'));
    }

    public function completedprojecttask()
    {
        $projecttaskprogress = ProjectTaskProgress::join('projects','project_task_progress.project_id','=','projects.id')->where('task_progress_percentage',100)->orderBy('project_task_progress.id', 'DESC')->get();
        $project =  Project::orderBy('id','ASC')->get();
        return view('completedprojecttask', compact('projecttaskprogress','project'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projecttaskprogress.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

         // Validate the request data
         $validator = Validator::make($request->all(), [
            'project_task_id' => 'unique:project_task_progress,project_id,NULL,id,task_sequence_no_wbs,' . $request->input('task_sequence_no_wbs'),
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ProjectTaskProgress::create($request->all());
 
        return redirect()->route('projecttaskprogress')->with('success', 'project task progress added successfully');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $projecttaskprogress = ProjectTaskProgress::findOrFail($id);
  
        return view('projecttaskprogress.show', compact('projecttaskprogress'));
    }
  
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $projecttaskprogress = ProjectTaskProgress::where('id', $id)->firstOrFail();
  
        return view('projecttaskprogress.edit', compact('projecttaskprogress'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $projecttaskprogress = ProjectTaskProgress::findOrFail($id);
  
        $projecttaskprogress->update($request->all());
  
        return redirect()->route('projecttaskprogress')->with('success', 'project task progress updated successfully');
    }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $projecttaskprogress = ProjectTaskProgress::findOrFail($id);
  
        $projecttaskprogress->delete();
  
        return redirect()->route('projecttaskprogress')->with('success', 'project task progress deleted successfully');
    }
}
