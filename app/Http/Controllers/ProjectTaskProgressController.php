<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\ProjectTaskProgress;
use App\Models\Project;
use App\Models\User;
use App\Models\UserAccessible;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
 
class ProjectTaskProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function createnewprojecttaskname()
    {
        $projecttaskprogress = ProjectTaskProgress::select(
            'project_task_progress.id',
            'project_task_progress.project_id',
            'project_task_progress.task_sequence_no_wbs',
            'project_task_progress.task_name',
            'project_task_progress.user_login_name',
            // Include other selected columns here
            'projects.project_name',
            'users.user_name',
            'users.name'
        )
        ->join('projects', 'project_task_progress.project_id', '=', 'projects.id')
        ->leftJoin('users', 'project_task_progress.user_login_name', '=', 'users.id')
        ->join('user_accessibles', 'user_accessibles.project_id', '=', 'project_task_progress.project_id')
        ->where('user_accessibles.user_name', '=', auth()->user()->user_name)
        ->where('task_progress_percentage', '=', 0)
        ->groupBy(
            'project_task_progress.id',
            'project_task_progress.project_id',
            'project_task_progress.task_sequence_no_wbs',
            'project_task_progress.task_name',
            'project_task_progress.user_login_name',
            // Include other selected columns here
            'projects.project_name',
            'users.user_name',
            'users.name'
        )
        ->orderBy('project_task_progress.project_id','ASC')
        ->orderBy('project_task_progress.task_sequence_no_wbs','ASC')
        ->get();
        $unassigned = ProjectTaskProgress::join('projects','project_task_progress.project_id','=','projects.id')->where('user_login_name',null)->selectRaw('projects.id,projects.project_name,count(*) AS unassigned_count')->groupBy('projects.id','projects.project_name')->get();
        $project =  Project::join('user_accessibles','user_accessibles.project_id','=','projects.id')->where('user_accessibles.user_name',auth()->user()->user_name)->select('projects.*')->orderBy('project_name','ASC')->get();
        $user =  User::join('user_accessibles','users.user_name','=','user_accessibles.user_name')->whereIn('user_accessibles.project_id',UserAccessible::select('project_id')->where('user_name',auth()->user()->user_name)->get())->select('users.id','users.user_name','users.name','user_accessibles.project_id')->groupBy('users.id','users.name','users.user_name','user_accessibles.project_id')->orderBy('users.id','ASC')->get();
        return view('createnewprojecttaskname', compact('projecttaskprogress','project','user','unassigned'));
    }

    public function createupdateprojecttask()
    {
        $projecttaskprogress = ProjectTaskProgress::select(
            'project_task_progress.id',
            'project_task_progress.project_id',
            'project_task_progress.task_sequence_no_wbs',
            'project_task_progress.task_name',
            'project_task_progress.last_update_bywhom',
            'project_task_progress.task_actual_start_date',
            'project_task_progress.task_actual_end_date',
            'project_task_progress.task_progress_percentage',
            // Include other selected columns here
            'projects.project_name',
            'users.user_name',
            'users.name'
        )
        ->join('projects', 'project_task_progress.project_id', '=', 'projects.id')
        ->leftJoin('users', 'project_task_progress.user_login_name', '=', 'users.id')
        ->join('user_accessibles', 'user_accessibles.project_id', '=', 'project_task_progress.project_id')
        ->where('user_accessibles.user_name', '=', auth()->user()->user_name)
        ->where('project_task_progress.user_login_name', '=', auth()->user()->id)
        ->where('task_progress_percentage','<',100)
        ->groupBy(
            'project_task_progress.id',
            'project_task_progress.project_id',
            'project_task_progress.task_sequence_no_wbs',
            'project_task_progress.task_name',
            'project_task_progress.last_update_bywhom',
            'project_task_progress.task_actual_start_date',
            'project_task_progress.task_actual_end_date',
            'project_task_progress.task_progress_percentage',
            // Include other selected columns here
            'projects.project_name',
            'users.user_name',
            'users.name'
        )
        ->orderBy('project_task_progress.project_id','ASC')
        ->orderBy('project_task_progress.task_sequence_no_wbs','ASC')
        ->get();
        $project =  Project::join('user_accessibles','user_accessibles.project_id','=','projects.id')->where('user_accessibles.user_name',auth()->user()->user_name)->select('projects.*')->orderBy('project_name','ASC')->get();
        return view('createupdateprojecttask', compact('projecttaskprogress','project'));
    }

    public function completedprojecttask()
    {
        $projecttaskprogress = ProjectTaskProgress::select(
            'project_task_progress.id',
            'project_task_progress.project_id',
            'project_task_progress.task_sequence_no_wbs',
            'project_task_progress.task_name',
            'project_task_progress.task_actual_start_date',
            'project_task_progress.task_actual_end_date',
            'project_task_progress.task_progress_percentage',
            // Include other selected columns here
            'projects.project_name',
            'users.user_name',
            'users.name'
        )
        ->join('projects', 'project_task_progress.project_id', '=', 'projects.id')
        ->join('users', 'project_task_progress.user_login_name', '=', 'users.id')
        ->join('user_accessibles', 'user_accessibles.project_id', '=', 'project_task_progress.project_id')
        ->where('user_accessibles.user_name', '=', auth()->user()->user_name)
        ->where('task_progress_percentage',100)
        ->groupBy(
            'project_task_progress.id',
            'project_task_progress.project_id',
            'project_task_progress.task_sequence_no_wbs',
            'project_task_progress.task_name',
            'project_task_progress.task_actual_start_date',
            'project_task_progress.task_actual_end_date',
            'project_task_progress.task_progress_percentage',
            // Include other selected columns here
            'projects.project_name',
            'users.user_name',
            'users.name'
        )
        ->orderBy('project_task_progress.project_id','ASC')
        ->orderBy('project_task_progress.task_sequence_no_wbs','ASC')
        ->get();
        $project =  Project::join('user_accessibles','user_accessibles.project_id','=','projects.id')->where('user_accessibles.user_name',auth()->user()->user_name)->select('projects.*')->orderBy('project_name','ASC')->get();
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
            'last_update_bywhom' => \Carbon\Carbon::now()->format('d-m-Y H:i:s').' - '.auth()->user()->name,
            // Add more fields as needed
        ]);
 
        return redirect()->route('projecttaskprogress.createnewprojecttaskname')->with('success', 'project task progress added successfully')->with('previousProject',$request->input('project_id'));
    }

    public function importfromexcel(Request $request)
    {
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        $project = $request->input('importfromexcelprojectid');
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
                    'last_update_bywhom' => \Carbon\Carbon::now()->format('d-m-Y H:i:s').' - '.auth()->user()->name,
                    // Add more fields as needed
                ]);
            }
        } 
        return redirect()->route('projecttaskprogress.createnewprojecttaskname')->with('success', 'project task progress added successfully')->with('previousProject',$request->input('importfromexcelprojectid'));
    }
  
    public function assigntaskowner(Request $request)
    {
        if(isset($request->all()['assigntaskid'])){
            foreach($request->all()['assigntaskid'] as $key => $value){
                $projecttaskprogress = ProjectTaskProgress::findOrFail($request->all()['assigntaskid'][$key]);
                if($request->input("delete")!=null){
                    $projecttaskprogress->delete();
                }
                if($request->input("update")!=null){
                    $projecttaskprogress->update(['task_name'=>$request->all()['assigntaskname'][$key],'user_login_name'=>$request->all()['assigntaskowner'][$key],'last_update_bywhom' => \Carbon\Carbon::now()->format('d-m-Y H:i:s').' - '.auth()->user()->name,]);
                }
            }
        }
        return redirect()->route('projecttaskprogress.createnewprojecttaskname')->with('success', 'project task progress assigned successfully')->with('previousProject',$request->input('assignproject'));
    }

    public function updateprojecttask(Request $request)
    {
        foreach($request->all()['update'] as $key => $value){
            if(isset($request->all()['start'][$key])){
                $start=substr($request->all()['start'][$key],6,4)."-".substr($request->all()['start'][$key],3,2)."-".substr($request->all()['start'][$key],0,2);
            }
                if(isset($request->all()['end'][$key])){
                $end=substr($request->all()['end'][$key],6,4)."-".substr($request->all()['end'][$key],3,2)."-".substr($request->all()['end'][$key],0,2);
            }
                $projecttaskprogress = ProjectTaskProgress::findOrFail($value);
            if(isset($request->all()['start'][$key])){
                $projecttaskprogress->update([
                    'task_actual_start_date'=>$start,
                ]);
            }
            if(isset($request->all()['end'][$key])){
                $projecttaskprogress->update([
                    'task_actual_end_date'=>$end,
                ]);
            }
            if(isset($request->all()['progress'][$key])){
                $projecttaskprogress->update([
                    'task_progress_percentage'=>$request->all()['progress'][$key],
                ]);
            }
            $projecttaskprogress->update([
                'last_update_bywhom' => \Carbon\Carbon::now()->format('d-m-Y H:i:s').' - '.auth()->user()->name,
            ]);
        }
        return redirect()->route('projecttaskprogress.createupdateprojecttask')->with('success', 'project task progress updated successfully')->with('previousProject', $request->all()['project_id']);
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
