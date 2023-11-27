@extends('layouts.app')
  
<!-- @section('title', 'Project Task Progress') -->
  
@section('contents')
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
                <Select type="text" name="task_owner" class="form-control" required>
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
                <input type="file" name="file">
            </div>
        </div>
        <div class="row">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Import From Excel</button>
            </div>
        </div>
    </form>
    <form action="{{ route('projecttaskprogress.store') }}" method="POST" enctype="multipart/form-data">
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
                @if(Session::has('data'))
                    @foreach(Session::get('data') as $rs)
                        <tr>
                            <td class="align-middle"></td>
                            <td class="align-middle">{{ $rs }}</td>
                            <td class="align-middle">{{ $rs }}</td>
                            <td class="align-middle">{{ $rs }}</td>
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
                <button type="submit" class="btn btn-primary">Update Selected</button>
                <button type="submit" class="btn btn-primary">Delete Selected</button>
            </div>
        </div>
    </form>
<script>    
    $(document).ready(function () {
        $('#projectFilter').on('change', function() {
            var selectedProject = $(this).val();
            var selectElement = document.getElementById('projectFilter');
            var selectedValue = selectElement.options[selectElement.selectedIndex].innerHTML;
            document.getElementById("importfromexcelprojectid").value=selectedProject;
            document.getElementById("importfromexcelprojectname").innerHTML=selectedValue;
        });
        $('#data-table').DataTable({
            dom: 'Bfrtip', // Add the export buttons to the DOM
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0,1] // Include only the first column in the export
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0,1] // Include only the first column in the export
                    }
                }
            ]
        });
    });
</script>
@endsection