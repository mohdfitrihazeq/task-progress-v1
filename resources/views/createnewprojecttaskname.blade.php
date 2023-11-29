@extends('layouts.app')
  
<!-- @section('title', 'Project Task Progress') -->
@section('contents')
@if($unassigned->count()>0)
    @foreach($unassigned as $rs)
    <div class="modal" id="dataModal_{{$rs->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
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
        <h1 class="mb-0">Task Progress</h1>
        <a href="{{ route('projecttaskprogress.createnewprojecttaskname') }}" class="btn btn-primary">Create New Project Task Name</a>
        <a href="{{ route('projecttaskprogress.createupdateprojecttask') }}" class="btn btn-primary">Update Project Task</a>
        <a href="{{ route('projecttaskprogress.completedprojecttask') }}" class="btn btn-primary">Completed Project Task</a>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Task planning for the project: </h1>
        <select id="projectFilter" name="projectFilter" class="form-control" aria-label="Project Filter">
            @foreach($project as $rs)
                    <option value="{{ $rs->id }}">{{ $rs->project_name }}</option>
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
    <form class="pb-5" action="{{ route('projecttaskprogress.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input value="{{$project['0']['id']}}" type="text" name="project_id" id="project_id" class="form-control" hidden>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Project Sequence No. <b>(WBS)</b>: </label>
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
                <Select name="task_owner" class="form-control" required>
                @foreach($user as $rs)
                    <option value="{{ $rs->id }}">{{ $rs->name }}</option>
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
                Add a Batch of New Project Tasks via the Excel Import
            </div>
        </div>
    <form class="pb-5" action="{{ route('projecttaskprogress.importfromexcel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input value="{{$project['0']['id']}}" hidden id="importfromexcelprojectid" name="importfromexcelprojectid">
        <input hidden name="user" value="{{auth()->user()->id}}">
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Project Name: </label>
            </div>
            <div class="col" id="importfromexcelprojectname" name="importfromexcelprojectname">
                {{$project['0']['project_name']}}
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
                                <Select name="assigntaskowner[{{ $loop->iteration-1 }}]" class="form-control">
                                <option value=""></option>
                                @foreach($user as $rsuser)
                                    <option value="{{ $rsuser->id }}"
                                    @if ($rsuser->id == $rs->user_login_name)
                                    selected="selected"
                                    @endif
                                    >{{ $rsuser->user_name }} - {{ $rsuser->name }}</option>
                                @endforeach
                                </Select>
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
        <div class="row">
            <div class="d-grid">
                <button type="submit" name="update" value="update" class="btn btn-primary">Update Selected</button>
                <button type="submit" name="delete" value="delete" class="btn btn-danger">Delete Selected</button>
            </div>
        </div>
    </form>
<script>    
    $(document).ready(function () {
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

            var table = document.getElementById('data-table');
            var rows = table.getElementsByTagName('tr');

            // Loop through each <tr> element and log its content
            for (var i = 1; i < rows.length; i++) {
                if(rows[i].getAttribute('data-project')!=selectedProject){
                    rows[i].style.display='none';
                }
                else{
                    rows[i].style.display='table-row';
                }
            }
        });
    });
</script>
@endsection