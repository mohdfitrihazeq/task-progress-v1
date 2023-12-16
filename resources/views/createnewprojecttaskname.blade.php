@extends('layouts.app')
<script src="{{asset('admin_assets/js/createnewprojecttaskname.js')}}"></script>
@section('contents')
@if($unassigned->count()>0)
    @foreach($unassigned as $rs)
    <div class="modal" id="dataModal_{{$rs->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Alert Message</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Please assign Task owner to your Project Task Names For the Project “{{$rs->project_name}}”
                </div>
                <div class="modal-footer">
                    <button name="dataDismiss" class="btn btn-secondary" type="button" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endif
    <div class="d-flex align-items-center justify-content-between pb-5">
        <h3 class="mb-0"><b>Task Planning</b></h3>
        @if(in_array(auth()->user()->role_name,['Master Super Admin - MSA','Super Super Admin - SSA','Project Manager - PM','Project Director - PD']))
            <a href="{{ route('projecttaskprogress.createnewprojecttaskname') }}" class="btn btn-primary">Create New Project Task Name</a>
        @endif
        <a href="{{ route('projecttaskprogress.createupdateprojecttask') }}" class="btn btn-secondary">Update Project Task</a>
        <a href="{{ route('projecttaskprogress.completedprojecttask') }}" class="btn btn-secondary">Completed Project Task</a>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Task planning for the project: </h1>
        <select id="projectFilter" name="projectFilter" class="form-control" aria-label="Project Filter">
            <option value="">Select Project</option>
            @foreach($project as $rs)
                <option value="{{ $rs->id }}" 
                @if($rs->id==session('previousProject'))
                    selected="selected"
                @endif
                >{{ $rs->project_name }}</option>
            @endforeach
        </select>
    </div>
    <hr>
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
        <div class="row mb-3">
            <div class="col">
                <b>OPTION 1 : Add New Project Tasks one by one</b>
            </div>
        </div>
    <form class="pb-5" onsubmit="return validateInput(project_id.value)" action="{{ route('projecttaskprogress.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="project_id" id="project_id" class="form-control"
            @if(Session::has('previousProject'))
                value="{{session('previousProject')}}"
            @endif
        hidden>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Project Sequence No. <b>(WBS)</b>: </label>
                <input type="text" id="task_sequence_no_wbs" name="task_sequence_no_wbs" class="form-control" placeholder="Task Sequence No." required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Project Task Name: </label>
                <input type="text" id="task_name" name="task_name" class="form-control" placeholder="Task Name" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Task Owner: </label>
                <Select id="task_owner" name="task_owner" class="form-control" required>
                    <option value="">Select Task Owner</option>
                @foreach($user->groupBy('id') as $rs=>$rs2)
                    <option data-project="" value="{{$rs2->first()->id}}">{{$rs2->first()->user_name}} - {{$rs2->first()->name}}</option>
                @endforeach
                @foreach($user as $rs)
                    <option data-project="{{$rs->project_id}}" value="{{$rs->id}}">{{$rs->user_name}} - {{$rs->name}}</option>
                @endforeach
                </Select>
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <a href="{{ route('projecttaskprogress.createnewprojecttaskname') }}" class="btn btn-secondary">Clear</a>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
    <hr class="my-4 dotted border-5">
        <div class="row mb-3">
            <div class="col">
                <b>OPTION 2 : Add a Batch of New Project Tasks via the Excel Import</b>
            </div>
        </div>
    <form class="pb-5" onsubmit="return validateInput(importfromexcelprojectid.value)" action="{{ route('projecttaskprogress.importfromexcel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input
            @if(Session::has('previousProject'))
                value="{{session('previousProject')}}"
            @endif
        hidden id="importfromexcelprojectid" name="importfromexcelprojectid">
        <input hidden name="user" value="{{auth()->user()->id}}">
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Project Name: </label>
            </div>
            <div class="col" id="importfromexcelprojectname" name="importfromexcelprojectname">
                @if(Session::has('previousProject'))
                    @foreach($project as $rs)
                        @if($rs->id==session('previousProject'))
                            {{$rs->project_name}}
                        @endif
                    @endforeach
                @endif
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
    <form action="{{ route('projecttaskprogress.assigntaskowner') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input
            @if(Session::has('previousProject'))
                value="{{session('previousProject')}}"
            @endif
        hidden id="assignproject" name="assignproject">
        <table class="table table-hover" id="data-table">
            <thead class="table-primary">
                <tr>
                    <th></th>
                    <th>Task Sequence No. (WBS)</th>
                    <th>Project Task Name</th>
                    <th>Task Owner</th>
                </tr>
            </thead>
            <tbody>
                @if($projecttaskprogress->count() > 0)
                    @foreach($projecttaskprogress as $rs)
                        <tr data-project="{{$rs->project_id}}">
                            <td class="align-middle">
                                <input type="checkbox" name="assigntaskid[{{ $loop->iteration-1 }}]" class="form-control" value="{{ $rs->id; }}">
                                </input>
                            </td>
                            <td class="align-middle">
                                {{ $rs->task_sequence_no_wbs; }}
                            </td> 
                            <td class="align-middle">
                                <input type="text" name="assigntaskname[{{ $loop->iteration-1 }}]" class="form-control" value="{{ $rs->task_name; }}">
                                </input>
                            </td>
                            <td class="align-middle">
                                @if($rs->task_actual_start_date==null)
                                    <Select name="assigntaskowner[{{ $loop->iteration-1 }}]" class="form-control">
                                    @if($rs->user_login_name==null)
                                        <option value="">
                                            Select Task Owner
                                        </option>
                                    @else
                                        <option value="{{$rs->user_login_name}}">
                                            {{$rs->user_name}} - {{$rs->name}}
                                        </option>
                                    @endif
                                    @foreach($user as $rsuser)
                                        @if($rsuser->project_id==$rs->project_id)
                                            <option value="{{ $rsuser->id }}"
                                                @if ($rsuser->id == $rs->user_login_name)
                                                    selected="selected"
                                                @endif
                                            >{{ $rsuser->user_name }} - {{ $rsuser->name }}</option>
                                        @endif
                                    @endforeach
                                    </Select>
                                @else
                                    @foreach($user as $rsuser)
                                        @if($rsuser->id==$rs->user_login_name&&$rsuser->project_id==$rs->project_id)
                                            {{$rsuser->user_name}} - {{$rsuser->name}}
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">Project Task Progress not found</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <table class="table table-hover">
            <tr>
                <td class="align-middle">
                    <input type="checkbox" class="form-control" id="checkall" onclick="checkAll()">
                </td>
                <td width="95%" class="align-middle">
                    Check All
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="d-grid">
                <button type="submit" name="update" value="update" class="btn btn-primary">Update Selected</button>
                <button type="submit" name="delete" onclick="return confirm('Are you sure to Delete the selected record(s) !')" value="delete" class="btn btn-danger">Delete Selected</button>
            </div>
        </div>
    </form>
<script>    
    function validateInput(str){
        if(str==""){
            alert("no project selected");
            return false;
        }
        else{
            return true;
        }
    }
    $(document).ready(function () {
        var table = document.getElementById('data-table');
        var rows = table.getElementsByTagName('tr');
        // Loop through each <tr> element and log its content
        for (var i = 1; i < rows.length; i++) {
            if(rows[i].getAttribute('data-project')!="{{session('previousProject')}}"){
                rows[i].style.display='none';
            }
        }
        var elements = document.getElementsByName('dataDismiss');
        for (var i = 0; i < elements.length; i++) {
            elements[i].addEventListener('click', function() {
                // Handle click event for each element
                var modals = document.getElementsByClassName('modal');
                for (var j = 0; j < modals.length; j++) {
                    modals[j].style.display='none';
                }
            });
        }
        var select = document.getElementById('task_owner');
        var options = select.getElementsByTagName('option');
        // Loop through each <tr> element and log its content
        for (var i = 1; i < options.length; i++) {
            if(("{{Session::has('previousProject')}}"==""&&options[i].getAttribute('data-project')!='')||("{{Session::has('previousProject')}}"=="1"&&options[i].getAttribute('data-project')!="{{session('previousProject')}}")){
                options[i].style.display='none';
            }
        }
        $('#projectFilter').on('change', function() {
            var selectedProject = $(this).val();
            if(document.getElementById("dataModal_"+selectedProject)!=null){
            document.getElementById("dataModal_"+selectedProject).style.display="block";
            }
            var selectElement = document.getElementById('projectFilter');
            var selectedValue = selectElement.options[selectElement.selectedIndex].innerHTML;
            document.getElementById("project_id").value=selectedProject;
            document.getElementById("importfromexcelprojectid").value=selectedProject;
            document.getElementById("importfromexcelprojectname").innerHTML=selectedValue;
            document.getElementById("assignproject").value=selectedProject;

            var table = document.getElementById('data-table');
            var rows = table.getElementsByTagName('tr');
            // Loop through each <tr> element and log its content
            for (var i = 1; i < rows.length; i++) {
                if(rows[i].getAttribute('data-project')!=selectedProject&&selectedProject!=''){
                    rows[i].style.display='none';
                }
                else{
                    rows[i].style.display='table-row';
                }
            }
            var select = document.getElementById('task_owner');
            var options = select.getElementsByTagName('option');
            // Loop through each <tr> element and log its content
            for (var i = 1; i < options.length; i++) {
                if(options[i].getAttribute('data-project')!=selectedProject&&selectedProject!=''){
                    options[i].style.display='none';
                }
                else{
                    options[i].style.display='inline';
                }
            }
        });
    });
</script>
@endsection