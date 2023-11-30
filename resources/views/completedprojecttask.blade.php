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
    <form>
        <table class="table table-hover" id="data-table">
            <thead class="table-primary">
                <tr>
                    <th>Task Sequence No. (WBS)</th>
                    <th>Task Name</th>
                    <th>Actual Start Date</th>
                    <th>Actual End Date</th>
                    <th>Task Progress %</th>
                    <th>Project</th>
                </tr>
            </thead>
            <tbody>
                @if($projecttaskprogress->count() > 0)
                    @foreach($projecttaskprogress as $rs)
                        <tr data-project="{{ $rs->project_id }}">
                            <td class="align-middle">{{ $rs->task_sequence_no_wbs }}</td>
                            <td class="align-middle">{{ $rs->task_name }}</td>
                            <td class="align-middle">{{ $rs->task_actual_start_date }}</td>
                            <td class="align-middle">{{ $rs->task_actual_end_date }}</td>
                            <td class="align-middle">{{ $rs->task_progress_percentage }}</td>
                            <td class="align-middle">{{ $rs->project_name }}</td>
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

    <script src="{{asset('admin_assets/js/completedprojecttask.js')}}"></script>
    <div class="d-flex align-items-center justify-content-between bg-primary p-2 text-white">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file" viewBox="0 0 16 16" id="usadateformat" name="usadateformat" onclick="usaDateFormat() "><path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/></svg>
        USA Date Format
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file" viewBox="0 0 16 16" id="headersincludedinexcel" name="headersincludedinexcel" onclick="headersIncludedInExcel() "><path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/></svg>
        Headers included in Excel
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-file" viewBox="0 0 16 16" id="projectcolumnincludedinexcel" name="projectcolumnincludedinexcel" onclick="projectColumnIncludedInExcel() "><path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/></svg>
        Project column included in Excel
    </div>
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
        $('#data-table').DataTable({
            dom: 'Bfrtip', // Add the export buttons to the DOM
            buttons: [
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [0,1,2,3,4,5] // Include only the first column in the export
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [0,1,2,3,4,5] // Include only the first column in the export
                    }
                }
            ]
        });
    });
</script>
@endsection
