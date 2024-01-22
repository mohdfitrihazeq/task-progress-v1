<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\ProjectTaskProgress;
use App\Models\Project;
use App\Models\User;
use App\Models\UserAccessible;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
 
class ProjectTaskProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $projects = collect();
        $projects = UserAccessible::select('projects.id','projects.project_name')
        ->join('projects','user_accessibles.project_id','=','projects.id')
        ->where('user_accessibles.user_name','=',$user->user_name);
        $currentProject = Project::select('projects.id','projects.project_name')
        ->where('id','=',$request->route('id2'))
        ->get()
        ->first();
        $currentProjectId = $request->route('id2');
        if($request->route()->getName()!='projecttaskprogress.index' && sizeof($projects->get())>0){
            $currentProject = $currentProject->project_name;
        }
        elseif($request->route()->getName()!='projecttaskprogress.index' && sizeof($projects->get())==0){
            $currentProject = "No Project Available";
        }
        else{
            $currentProject = "Select Project";
        }
        $projects = $projects->orderBy('project_name','desc')->get();
        $users = collect();
        $users =  User::join('user_accessibles','users.user_name','=','user_accessibles.user_name')
        ->whereIn('user_accessibles.project_id',UserAccessible::select('project_id')
        ->where('user_name',auth()->user()->user_name)
        ->get())
        ->select('users.id','users.user_name','users.name','user_accessibles.project_id')
        ->groupBy('users.id','users.name','users.user_name','user_accessibles.project_id')
        ->where('project_id','=',($request->route('id2')))
        ->orderBy('users.id','ASC')
        ->get();
        $projecttaskprogress = collect();
        $projecttaskprogress = ProjectTaskProgress::select('project_task_progress.id'
        ,'project_task_progress.task_sequence_no_wbs'
        ,'project_task_progress.task_name'
        ,'project_task_progress.task_actual_start_date'
        ,'project_task_progress.task_actual_end_date'
        ,'project_task_progress.last_update_bywhom'
        ,'project_task_progress.task_progress_percentage'
        ,'project_task_progress.project_id'
        ,'project_task_progress.user_login_name'
        ,'projects.project_name'
        ,'projects.backdated_date_days'
        ,'users.user_name')
        ->join('user_accessibles','project_task_progress.project_id','=','user_accessibles.project_id')
        ->join('projects','project_task_progress.project_id','=','projects.id')
        ->leftJoin('users','project_task_progress.user_login_name','=','users.id')
        ->where('project_task_progress.project_id','=',$request->route('id2'))
        ->where('user_accessibles.user_name','=',$user->user_name);

        switch($request->route('id')){
            case 'create': 
                $projecttaskprogress = $projecttaskprogress->whereNull('task_actual_end_date');
                break;
            case 'update':
                $projecttaskprogress = $projecttaskprogress->whereNull('task_actual_end_date')
                ->where('user_login_name','=',$user->id);
                break;
            case 'completed':
                $projecttaskprogress = $projecttaskprogress->whereNotNull('task_actual_end_date');
                break;
            default:
                break;
        }
        $projecttaskprogress = $projecttaskprogress->get();
        $total = ceil($projecttaskprogress->count()/100)+1;
        $projecttaskprogress = $projecttaskprogress->skip((($request->route('id3')-1)*100))
        ->take(100);
        $currentModule = $request->route('id');
        $currentPage = $request->route('id3');
        $projectarr=[];
        foreach($projecttaskprogress as $progress){
            array_push($projectarr,$progress);
            $progress['wbsarr']=explode('.',$progress['task_sequence_no_wbs']);
        }
        usort($projectarr, function ($a, $b) {
            if($a['project_id']!=$b['project_id']){
                return $a['project_id'] - $b['project_id'];
            }
            else{
                if(sizeof($a['wbsarr'])==sizeof($b['wbsarr'])){
                    for($i=0;$i<sizeof($a['wbsarr']);$i++){
                        if($a['wbsarr'][$i]!=$b['wbsarr'][$i]){
                            return $a['wbsarr'][$i] - $b['wbsarr'][$i];
                        }
                    }
                }
                else{
                    for($i=0;$i<min(sizeof($a['wbsarr']),sizeof($b['wbsarr']));$i++){
                        if($a['wbsarr'][$i]!=$b['wbsarr'][$i]){
                            return $a['wbsarr'][$i] - $b['wbsarr'][$i];
                        }
                    }
                    for($i=min(sizeof($a['wbsarr']),sizeof($b['wbsarr']));$i<max(sizeof($a['wbsarr']),sizeof($b['wbsarr']));$i++){
                        return sizeof($a['wbsarr']) - sizeof($b['wbsarr']);
                    }
                }
            }
        });
        foreach($projectarr as $progress){
            unset($progress['wbsarr']);
        }
        $projecttaskprogress=$projectarr;
        return view('projecttaskprogress.index', compact('projecttaskprogress','projects','users','total','currentModule','currentProjectId','currentProject','currentPage'));
    }

    public function store(Request $request)
    {
        if($request->file('file')!=null){
            $file = $request->file('file');
            $fileContents = file($file->getPathname());
            $project = $request->input('project_id');
            $user = Auth::user();
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
                        'last_update_bywhom' => \Carbon\Carbon::now()->format('d-m-Y H:i:s').' - '.$user->name,
                        // Add more fields as needed
                    ]);
                }
            } 
        }
        else{
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
        }
        return redirect()->route('projecttaskprogress',['id'=>'create','id2'=>$request->input('project_id'),'id3'=>1])->with('success', 'Project Task Created Successfully');
    }

    public function update(Request $request)
    {   
        if(isset($request->all()['updatetask'])){
            foreach($request->all()['updatetask'] as $key => $value){
                $projecttaskprogress = ProjectTaskProgress::findOrFail($request->all()['updatetask'][$key]);
                if($request->input("destroy")!=null){
                    $projecttaskprogress->delete();
                }
                if($request->input("update")!=null){
                    if($request->all()['task_name'][$key]!=null){
                        $projecttaskprogress->update(['task_name'=>$request->all()['task_name'][$key],]);
                    }
                    if($request->all()['task_owner'][$key]!=null){
                        $projecttaskprogress->update(['user_login_name'=>$request->all()['task_owner'][$key],]);
                    }
                    $projecttaskprogress->update(['last_update_bywhom' => \Carbon\Carbon::now()->format('d-m-Y H:i:s').' - '.auth()->user()->name,]);
                }
                if(isset($request->all()['start'][$key])){
                    $start=substr($request->all()['start'][$key],6,4)."-".substr($request->all()['start'][$key],3,2)."-".substr($request->all()['start'][$key],0,2);
                    $projecttaskprogress->update([
                        'task_actual_start_date'=>$start,
                    ]);
                }
                if(isset($request->all()['end'][$key])){
                    $end=substr($request->all()['end'][$key],6,4)."-".substr($request->all()['end'][$key],3,2)."-".substr($request->all()['end'][$key],0,2);
                    $projecttaskprogress->update([
                        'task_actual_end_date'=>$end,
                    ]);
                }
                if(isset($request->all()['progress'][$key])){
                    $projecttaskprogress->update([
                        'task_progress_percentage'=>$request->all()['progress'][$key],
                    ]);
                }
            }
        }
        return redirect()->route('projecttaskprogress',['id'=>$request->input('current_module'),'id2'=>$request->input('project_id'),'id3'=>$request->input('current_page')])->with('success', 'project task progress updated successfully')->with('previousProject',$request->input('assignproject'));
    }
    
    
}
