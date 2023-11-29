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
        $projecttaskprogress = ProjectTaskProgress::join('projects','project_task_progress.project_id','=','projects.id')->where('task_progress_percentage','<',100)->orderBy('project_task_progress.id', 'DESC')->get();
        $project =  Project::orderBy('id','ASC')->get();
        $user =  User::orderBy('id','ASC')->get();
        return view('createnewprojecttaskname', compact('projecttaskprogress','project','user'));
    }

    public function createupdateprojecttask()
    {
        $projecttaskprogress = ProjectTaskProgress::join('projects','project_task_progress.project_id','=','projects.id')->where('task_progress_percentage','<',100)->select('project_task_progress.*','projects.project_name')->orderBy('project_task_progress.id', 'DESC')->get();
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
            'task_sequence_no_wbs' => 'unique:project_task_progress,task_sequence_no_wbs,NULL,id,project_id,' . $request->input('project_id'),
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ProjectTaskProgress::create([
            'project_id' => $request->input('project_id'),
            'task_sequence_no_wbs' => $request->input('task_sequence_no_wbs'),
            'task_name' => $request->input('task_name'),
            'task_progress_percentage' => '0',
            'user_login_name' => $request->input('task_owner'),
            'last_update_bywhom' => \Carbon\Carbon::now().' - '.auth()->user()->name,
            // Add more fields as needed
        ]);
 
        return redirect()->route('projecttaskprogress.createnewprojecttaskname')->with('success', 'project task progress added successfully');
    }

    public function importfromexcel(Request $request)
    {
        $projecttaskprogressarray = [];
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        $project = $request->input('importfromexcelprojectid');
        $projectname = Project::where('id',$project)->get()['0']['project_name'];
        $user = $request->input('user');
        foreach ($fileContents as $line) {
            $data['task_sequence_no_wbs'] = str_getcsv($line)['0'];
            $data['task_name'] = str_getcsv($line)['1'];
            
            if($data['task_sequence_no_wbs']!=''&&$data['task_name']!=''){
                $validator = Validator::make($data, [
                   'task_sequence_no_wbs' => 'unique:project_task_progress,task_sequence_no_wbs,NULL,id,project_id,' . $project,
               ]);
       
               // Check if validation fails
               if ($validator->fails()) {
                   return redirect()->back()->withErrors($validator)->withInput();
               }
                $projecttaskprogress = ProjectTaskProgress::create([
                    'project_id' => $project,
                    'task_sequence_no_wbs' => $data['task_sequence_no_wbs'],
                    'task_name' => $data['task_name'],
                    'task_progress_percentage' => '0',
                    'last_update_bywhom' => \Carbon\Carbon::now().' - '.auth()->user()->name,
                    // Add more fields as needed
                ]);
                array_push($projecttaskprogressarray,['id'=>$projecttaskprogress->id,'task_sequence_no_wbs'=>$projecttaskprogress->task_sequence_no_wbs,'task_name'=>$projecttaskprogress->task_name,'project_name'=>$projectname]);
            }
        } 
        return redirect()->route('projecttaskprogress.createnewprojecttaskname')->with('success', 'project task progress added successfully')->with('data',$projecttaskprogressarray);
    }
  
    public function assigntaskowner(Request $request)
    {
        foreach($request->all()['assigntaskid'] as $key => $value){
            $projecttaskprogress = ProjectTaskProgress::findOrFail($request->all()['assigntaskid'][$key]);
            if($request->input("delete")!=null){
                $projecttaskprogress->delete();
            }
            if($request->input("update")!=null){
                $projecttaskprogress->update(['task_name'=>$request->all()['assigntaskname'][$key],'user_login_name'=>$request->all()['assigntaskowner'][$key],'last_update_bywhom' => \Carbon\Carbon::now().' - '.auth()->user()->name,]);
            }
        }
        return redirect()->route('projecttaskprogress.createnewprojecttaskname')->with('success', 'project task progress assigned successfully');
    }

    public function updateprojecttask(Request $request)
    {
        foreach($request->all()['update'] as $key => $value){
            $projecttaskprogress = ProjectTaskProgress::findOrFail($value);
            $projecttaskprogress->update(['task_actual_start_date'=>$request->all()['start'][$key],'task_actual_end_date'=>$request->all()['end'][$key],'task_progress_percentage'=>$request->all()['progress'][$key],'last_update_bywhom'=>$request->all()['progress'][$key],'last_update_bywhom' => \Carbon\Carbon::now().' - '.auth()->user()->name,]);
        }
        return redirect()->route('projecttaskprogress.createupdateprojecttask')->with('success', 'project task progress updated successfully');
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
