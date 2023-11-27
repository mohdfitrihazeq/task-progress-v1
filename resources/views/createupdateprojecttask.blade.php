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
    <hr />
    @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    <form>
        <table class="table table-hover" id="data-table">
            <thead class="table-primary">
                <tr>
                    <th>Task Sequence No. (WBS)</th>
                    <th>Task Name</th>
                    <th>Actual Start Date</th>
                    <th>Actual Start Date</th>
                    <th>Task progress %</th>
                    <th>Last update & by whom</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if($projecttaskprogress->count() > 0)
                    @foreach($projecttaskprogress as $rs)
                        <tr>
                            <td class="align-middle">{{ $rs->task_sequence_no_wbs }}</td>
                            <td class="align-middle">{{ $rs->task_name }}</td>
                            <td class="align-middle">{{ $rs->task_actual_start_date }}</td>
                            <td class="align-middle">{{ $rs->task_actual_end_date }}</td>
                            <td class="align-middle">{{ $rs->task_progress_percentage }}</td>
                            <td class="align-middle">{{ $rs->last_update_bywhom }}</td>
                            <td class="align-middle">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('projecttaskprogress.edit', $rs->id)}}" type="button" class="btn btn-warning">Update</a>
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
        $("#select_all").on('click', function() {
            var nodesObj = $('#dataTables').DataTable().columns( [ 0, 6 ] ).nodes().to$();
            var nodesArray = nodesObj[0].concat( nodesObj[1] );
            $(nodesArray).find('input[type="checkbox"]:enabled:visible').prop('checked', 'true');
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