@extends('layouts.app2')
<script src="{{asset('admin_assets/js/projecttaskprogress.js')}}"></script>
@section('contents')
<div class="container">
    <div class="mb-5 row text-justify">
        <div class="col-md-3 text-left">
            <h3><b>Task Planning</b></h3>
        </div>
        @if(in_array(auth()->user()->role_name,['Master Super Admin - MSA','Super Super Admin - SSA','Project Manager - PM','Project Director - PD']))
        <div class="col text-left">
            @if($currentProjectId!=null)
            <a href="{{route('projecttaskprogress',['id'=>'create','id2'=>$currentProjectId,'id3'=>($currentModule=='create')*($currentPage)+($currentModule!='create')])}}">
            @else
            <a href="{{route('projecttaskprogress.index',['id'=>'create'])}}">
            @endif
                <div class="btn col-md-12 @if($currentModule=='create') {{'btn-primary'}} @else {{'btn-secondary'}} @endif">Create
                </div>
            </a>
        </div>
        @endif
        <div class="col text-center">
            @if($currentProjectId!=null)
            <a href="{{route('projecttaskprogress',['id'=>'update','id2'=>$currentProjectId,'id3'=>($currentModule=='update')*($currentPage)+($currentModule!='update')])}}">
            @else
            <a href="{{route('projecttaskprogress.index',['id'=>'update'])}}">
            @endif
            <div class="btn col-md-12 @if($currentModule=='update') {{'btn-primary'}} @else {{'btn-secondary'}} @endif">Update
                </div>
            </a>
        </div>
        <div class="col text-right">
            @if($currentProjectId!=null)
            <a href="{{route('projecttaskprogress',['id'=>'completed','id2'=>$currentProjectId,'id3'=>($currentModule=='completed')*($currentPage)+($currentModule!='completed')])}}">
            @else
            <a href="{{route('projecttaskprogress.index',['id'=>'completed'])}}">
            @endif
            <div class="btn col-md-12 @if($currentModule=='completed') {{'btn-primary'}} @else {{'btn-secondary'}} @endif">Completed
                </div>
            </a>
        </div>
    </div>
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="mb-5 row align-items-center">
        <div class="col-md-3">
            <h6>Task planning for the project:</h6>
        </div>
        <div class="dropdown show col-9 text-center">
            <a class="btn btn-primary dropdown-toggle col-md-12" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{$currentProject}}
            </a>
            <div class="dropdown-menu col-md-12">
                @if(sizeof($projects)>0)
                    @foreach($projects as $project) 
                        @if($project['id']==$currentProjectId)
                            <a href="{{route('projecttaskprogress',['id'=>$currentModule,'id2'=>$project['id'],'id3'=>$currentPage])}}" class="dropdown-item">
                                {{$project['project_name']}}
                            </a>
                        @else
                            <a href="{{route('projecttaskprogress',['id'=>$currentModule,'id2'=>$project['id'],'id3'=>1])}}" class="dropdown-item">
                                {{$project['project_name']}}
                            </a>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <hr class="border-primary border-5"></hr>
    @switch($currentModule)
        @case('create')
                <div class="row mb-3">
                    <div class="col">
                        <b>OPTION 1 : Add New Project Tasks one by one</b>
                    </div>
                </div>
            <form class="pb-5" action="{{ route('projecttaskprogress.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input name="project_id" value="{{$currentProjectId}}" hidden></input>
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Task Sequence No. <b>(WBS)</b>: </label>
                        <input type="text" name="task_sequence_no_wbs" class="form-control" placeholder="Task Sequence No." required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Project Task Name: </label>
                        <input type="text" name="task_name" class="form-control" placeholder="Task Name" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Task Owner: </label>
                        <Select id="task_owner" name="task_owner" class="form-control" required>
                            <option value="">Select Task Owner</option>
                        @foreach($users->groupBy('id') as $rs)
                            <option value="{{$rs->first()->id}}">{{$rs->first()->user_name}} - {{$rs->first()->name}}</option>
                        @endforeach
                        </Select>
                    </div>
                </div>
                <div class="row">
                    <div class="d-grid">
                        @if($currentPage==null)
                            <a href="{{route('projecttaskprogress.index',['id'=>$currentModule,'id2'=>$currentProjectId])}}" class="btn btn-secondary">Clear</a>
                        @else
                            <a href="{{route('projecttaskprogress',['id'=>$currentModule,'id2'=>$currentProjectId,'id3'=>$currentPage])}}" class="btn btn-secondary">Clear</a>
                        @endif
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
            <hr class="border-primary border-5"></hr>
                <div class="row mb-3">
                    <div class="col">
                        <b>OPTION 2 : Add a Batch of New Project Tasks via the Excel Import</b>
                    </div>
                </div>
            <form class="pb-5" action="{{ route('projecttaskprogress.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <div class="col">
                        <label class="form-label">Project Name: </label>
                    </div>
                    <div class="col">
                        <input name="project_id"  value="{{$currentProjectId}}" hidden></input>
                        {{$currentProject}}
                    </div>
                    <div class="col">
                        <input type="file" name="file" required>
                    </div>
                </div>
                <div class="row">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Import From Excel</button>
                    </div>
                </div>
            </form>
            <hr class="border-primary border-5"></hr>
                <div class="row bg-primary text-white align-items-center">
                    <div class="col-md-1">
                    </div>
                    <div class="col-md-2">
                        <b>Task Sequence No. (WBS)</b>
                    </div>
                    <div class="col-md-3">
                        <b>Project Task Name</b>
                    </div>
                    <div class="col-md-4 text-center">
                        <b>Task Owner</b>
                    </div>
                    <div class="col-md-2">
                        <b>Actual Start Date</b>
                    </div>
                </div>
            <form action="{{ route('projecttaskprogress.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input name="current_module" value={{$currentModule}} hidden></input>
                <input name="project_id" value="{{$currentProjectId}}" hidden></input>
                <input name="current_page" value="{{$currentPage}}" hidden></input>
                @for($i=0;$i<sizeof($projecttaskprogress);$i++)
                    <div class="row py-2 align-items-center">
                        <div class="col-md-1">
                            <input name="updatetask[{{$i}}]" type="checkbox" class="form-control" value="{{$projecttaskprogress[$i]['id']}}"></input>
                        </div>
                        <div class="col-md-2" class="form-control">
                            {{$projecttaskprogress[$i]['task_sequence_no_wbs']}}
                        </div>
                        <div class="col-md-3" class="form-control">
                            <input class="form-control" name="task_name[{{$i}}]" value="{{$projecttaskprogress[$i]['task_name']}}">
                            </input>
                        </div>
                        <div class="col-md-4" class="form-control">
                            <Select name="task_owner[{{$i}}]" class="form-control">
                                <option value="">Select Task Owner</option>
                                @foreach($users->groupBy('id') as $rs)
                                    <option value="{{$rs->first()->id}}" 
                                    @if($rs->first()->id==$projecttaskprogress[$i]['user_login_name'])
                                        selected
                                    @endif
                                    >{{$rs->first()->user_name}} - {{$rs->first()->name}}</option>
                                @endforeach
                            </Select>
                        </div>
                        <div class="col-md-2">
                            {{$projecttaskprogress[$i]['task_actual_start_date']}}
                        </div>
                    </div>
                    <hr class="py-0 my-0"></hr>
                @endfor
                <div class="row bg-grey-50 py-2">
                    <div class="col-md-1">
                        <input type="checkbox" name="select_all" class="form-control" onclick="selectAll(this.checked)"></input>
                    </div>
                    <div class="col-md-2 align-self-center">
                        Check All
                    </div>
                    <div class="col-md-9">
                        <input type="submit" name="update" class="form-control col-md-3 btn btn-primary" value="Update Selected"></input>
                        <input type="submit" name="destroy" class="form-control col-md-3 btn btn-danger" value="Delete Selected"></input>
                    </div>
                </div>
            </form>
        @break
        @case('update')
        <form action="{{ route('projecttaskprogress.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input name="current_module" value="{{$currentModule}}" hidden></input>
        <input name="project_id" value="{{$currentProjectId}}" hidden></input>
        <input name="current_page" value="{{$currentPage}}" hidden></input>
            <div class="row bg-primary text-white align-items-center">
                <div class="col-md-1">
                    <b>Task Sequence No. (WBS)</b>
                </div>
                <div class="col-md-2">
                    <b>Task Name</b>
                </div>
                <div class="col-md-2">
                    <b>Actual Start Date</b>
                </div>
                <div class="col-md-2">
                    <b>Actual End Date</b>
                </div>
                <div class="col-md-1">
                    <b>Task progress %</b>
                </div>
                <div class="col-md-2">
                    <b>Last update & by whom</b>
                </div>
                <div class="col-md-2">
                    <b>Action</b>
                </div>
            </div>
            @foreach($projecttaskprogress as $rs)
                <div class="row align-items-center">
                    <div class="col-md-1">
                        {{$rs->task_sequence_no_wbs}}
                    </div>
                    <div class="col-md-2">
                        {{$rs->task_name}}
                    </div>
                    <div class="col-md-2">
                        @if($rs->task_actual_start_date==NULL)
                            <input class="form-control form-control-sm datepicker" type="text" onkeydown="return false" onchange="validateEndDate('{{$loop->iteration-1}}')" name="start[{{$loop->iteration-1}}]" data-date="{{$rs->task_actual_start_date}}" data-backdate="-{{$rs->backdated_date_days}}d"></input>
                        @else
                            <input class="form-control form-control-sm datepicker" type="text" onkeydown="return false" class="datepicker" name="start[{{$loop->iteration-1}}]" data-date="{{ $rs->task_actual_start_date }}" hidden></input>
                            {{date_format(date_create($rs->task_actual_start_date),"d-m-Y")}}
                        @endif
                    </div>
                    <div class="col-md-2">
                        <input class="form-control form-control-sm datepicker" type="text" onkeydown="return false" onchange="validateEndDate('{{$loop->iteration-1}}')" name="end[{{$loop->iteration-1}}]" data-date="{{ $rs->task_actual_end_date }}" data-backdate="-{{$rs->backdated_date_days}}d" disabled></input>
                    </div>
                    <div class="col-md-1">
                        <input class="form-control form-control-sm" type="number" min="{{$rs->task_progress_percentage}}" onchange="toggleEndDate('{{$loop->iteration-1}}')" max=100 step=20 name="progress[{{$loop->iteration-1}}]" value="{{ $rs->task_progress_percentage }}"></input>
                    </div>
                    <div class="col-md-2">
                        {{$rs->last_update_bywhom}}
                    </div>
                    <div class="col-md-2">
                        <button class="form-control btn btn-warning" type="submit" name="updatetask[{{$loop->iteration-1}}]" value="{{$rs->id}}">Update</button>
                    </div>
                </div>
                <hr class="py-0 my-0"></hr>
            @endforeach
            </form>
            <script>
                $(".datepicker").datepicker({
                    dateFormat: "dd-mm-yy",
                    minDate: "-2d",
                    maxDate: "+0d",
                });
                $(document).ready(function() {
                    $(".datepicker").each(function(){$(this).datepicker( "option", "minDate", $(this).attr("data-backdate"));});
                    var picker = document.getElementsByClassName("datepicker");
                    for ( i = 0 ; i < picker.length ; i++ ){
                        if(picker[i].getAttribute("data-date")!=""){
                            var date = new Date(picker[i].getAttribute("data-date"));
                            picker[i].value = date.getDate().toString().padStart(2,"0")+"-"+(date.getMonth()+1).toString().padStart(2,"0")+"-"+date.getFullYear();
                            
                        }
                        else{
                            var date = new Date();
                            picker[i].value = date.getDate().toString().padStart(2,"0")+"-"+(date.getMonth()+1).toString().padStart(2,"0")+"-"+date.getFullYear();
                            
                        }
                    }
                });
            </script>
        @break
        @case('completed')
            <div class="container mx-0 px-0" name="data-table">
                <div class="row bg-primary text-white" name="header">
                    <div class="col-md-2 d-block">
                        <b>Task Sequence No. (WBS)</b>
                    </div>
                    <div class="col-md-3 d-block">
                        <b>Task Name</b>
                    </div>
                    <div class="col-md-3 d-block">
                        <b>Actual Start Date</b>
                    </div>
                    <div class="col-md-3 d-block">
                        <b>Actual End Date</b>
                    </div>
                    <div class="col-md-1 d-block">
                        <b>Project</b>
                    </div>
                </div>
                @foreach($projecttaskprogress as $rs)
                    <div name="data" class="row">
                        <div class="col-md-2 d-block">
                            {{$rs->task_sequence_no_wbs}}
                        </div>
                        <div class="col-md-3 d-block">
                            {{$rs->task_name}}
                        </div>
                        <div class="col-md-3 d-block">
                            {{date_format(date_create($rs->task_actual_start_date),"d/m/Y")}}
                        </div>
                        <div class="col-md-3 d-block">
                            {{date_format(date_create($rs->task_actual_end_date),"d/m/Y")}}
                        </div>
                        <div class="col-md-1 d-block">
                            {{$rs->project_name}}
                        </div>
                    </div>
                    <hr class="py-0 my-0"></hr>
                @endforeach
                <div class="row align-items-center justify-content-between bg-secondary p-2 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file" viewBox="0 0 16 16" id="usadateformat" name="usadateformat" onclick="usaDateFormat() "><path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/></svg>
                    USA Date Format
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file" viewBox="0 0 16 16" id="headersincludedinexcel" name="headersincludedinexcel" onclick="headersIncludedInExcel() "><path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/></svg>
                    Headers included in Excel
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file" viewBox="0 0 16 16" id="projectcolumnincludedinexcel" name="projectcolumnincludedinexcel" onclick="projectColumnIncludedInExcel() "><path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/></svg>
                    Project column included in Excel
                </div>
                <div class="row align-items-center justify-content-between bg-primary p-2 text-white">
                    <div class="col-md-12">
                        <button class="btn btn-success" id="btnExport" onclick="fnExcelReport();">Export Excel</button>
                        <iframe id="txtArea1" style="display:none"></iframe>
                    </div>
                </div>
            </div>
        @break
        @default
            <span>Something went wrong, please try again</span>
    @endswitch
    <hr class="border-primary border-5">
    <div class="my-5 row justify-content-center">
        @if($total>0)
            @for($i=max(min($currentPage-5,$total-11),1);$i<min(max($currentPage+6,12),$total);$i++) 
                    <div class="col-md-1">
                        @if($i==$currentPage)
                            <a href="{{route('projecttaskprogress',['id'=>$currentModule,'id2'=>$currentProjectId,'id3'=>$i])}}"><div class="btn btn-primary">{{$i}}
                            </div></a>
                        @else
                            <a href="{{route('projecttaskprogress',['id'=>$currentModule,'id2'=>$currentProjectId,'id3'=>$i])}}"><div class="btn btn-secondary">{{$i}}
                            </div></a>
                        @endif
                    </div>
            @endfor
        @endif
    </div>
</div>
@endsection