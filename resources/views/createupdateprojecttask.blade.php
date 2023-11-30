@extends('layouts.app')
  
<!-- @section('title', 'Task Planning') -->
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between pb-5">
        <h3 class="mb-0">Task Planning</h3>
        <a href="{{ route('projecttaskprogress.createnewprojecttaskname') }}" class="btn btn-primary">Create New Project Task Name</a>
        <a href="{{ route('projecttaskprogress.createupdateprojecttask') }}" class="btn btn-primary">Update Project Task</a>
        <a href="{{ route('projecttaskprogress.completedprojecttask') }}" class="btn btn-primary">Completed Project Task</a>
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Task planning for the project: </h1>
        <select id="projectFilter" name="projectFilter" class="form-control" aria-label="Project Filter">
                    <option value="">Select Project</option>
            @foreach($project as $rs)
                    <option value="{{ $rs->id }}">{{ $rs->project_name }}</option>
            @endforeach
        </select>
    </div>
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <form action="{{ route('projecttaskprogress.updateprojecttask') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <table class="table table-hover" id="data-table">
            <thead class="table-primary">
                <tr>
                    <th>Task Sequence No. (WBS)</th>
                    <th>Task Name</th>
                    <th>Actual Start Date</th>
                    <th>Actual End Date</th>
                    <th>Task progress %</th>
                    <th>Last update & by whom</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($projecttaskprogress->count() > 0)
                    @foreach($projecttaskprogress as $rs)
                        <tr data-project="{{$rs->project_id}}">
                            <td class="align-middle">
                                {{ $rs->task_sequence_no_wbs }}
                            </td>
                            <td class="align-middle">
                                {{ $rs->task_name }}
                            </td>
                            <td class="align-middle">
                                <input type="date" name="start[{{$loop->iteration-1}}]" value="{{ $rs->task_actual_start_date }}">
                            </td>
                            <td class="align-middle">
                                <input type="date" name="end[{{$loop->iteration-1}}]" value="{{ $rs->task_actual_end_date }}">
                            </td>
                            <td class="align-middle">
                                <input type="number" min="{{$rs->task_progress_percentage}}" max=100 step=20 name="progress[{{$loop->iteration-1}}]" value="{{ $rs->task_progress_percentage }}">
                            </td>
                            <td class="align-middle">
                                {{ $rs->last_update_bywhom }}
                            </td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="submit" name="update[{{$loop->iteration-1}}]" value="{{$rs->id}}" class="btn btn-warning">Update</button>
                                </div>
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
    </form>

<script>    
    $(document).ready(function () {
        
        $('#projectFilter').on('change', function() {
            var selectedProject = $(this).val();

            var table = document.getElementById('data-table');
            var rows = table.getElementsByTagName('tr');

            // Loop through each <tr> element and log its content
            for (var i = 1; i < rows.length; i++) {
                if(rows[i].getAttribute('data-project')!=selectedProject&&selectedProject!=''   ){
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