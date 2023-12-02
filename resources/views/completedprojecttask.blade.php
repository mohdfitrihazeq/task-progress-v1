@extends('layouts.app')
  
@section('contents')
    <div class="d-flex align-items-center justify-content-between pb-5">
        <h3 class="mb-0"><b>Task Planning</b></h3>
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
                <tr id="data-table-header" class="data-table-header">
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
        var table = document.getElementById('data-table');
        var rows = table.getElementsByTagName('tr');
        // Loop through each <tr> element and log its content
        for (var i = 1; i < rows.length; i++) {
            rows[i].style.display='none';
        }
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
        var table = $('#data-table').DataTable({
            dom: 'Bfrtip', // Add the export buttons to the DOM
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: 'wo header',
                    header: false,
                    exportOptions: {
                        columns: ':visible',
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'w header',
                    exportOptions: {
                        columns: ':visible',
                        rows: ":not('.data-table-header')",
                    }
                },
                {
                    text: 'USA Date Format',
                    action: function ( e, dt, node, config ) {
                        table.rows().every(function(){
                            if(this.data()[2][4]=="-"){
                                let date = new Date(this.data()[2]);
                                let day = date.getDate().toString().padStart(2,"0");
                                let month = date.getMonth()+1;
                                let year = date.getFullYear();
                                this.data()[2]=month+"/"+day+"/"+year;
                                date = new Date(this.data()[3]);
                                day = date.getDate().toString().padStart(2,"0");
                                month = date.getMonth()+1;
                                year = date.getFullYear();
                                this.data()[2]=month+"/"+day+"/"+year;
                            }
                            else{
                                let date = new Date(this.data()[2]);
                                let day = date.getDate().toString().padStart(2,"0");
                                let month = date.getMonth()+1;
                                let year = date.getFullYear();
                                this.data()[2]=year+"-"+month+"-"+day;
                                date = new Date(this.data()[3]);
                                day = date.getDate().toString().padStart(2,"0");
                                month = date.getMonth()+1;
                                year = date.getFullYear();
                                this.data()[3]=year+"-"+month+"-"+day;
                            }
                        });
                        var htmltable = document.getElementById('data-table');
                        var htmlrows = htmltable.getElementsByTagName('tr');

                        // Loop through each <tr> element and log its content
                        for (var i = 1; i < htmlrows.length; i++) {
                            if(htmlrows[i].getElementsByTagName("td")[2].innerHTML[4]=="-"){
                                let htmldate = new Date(htmlrows[i].getElementsByTagName("td")[2].innerHTML);
                                let htmlday = htmldate.getDate().toString().padStart(2,"0");
                                let htmlmonth = htmldate.getMonth()+1;
                                let htmlyear = htmldate.getFullYear();
                                htmlrows[i].getElementsByTagName("td")[2].innerHTML=htmlmonth+"/"+htmlday+"/"+htmlyear;
                                htmldate = new Date(htmlrows[i].getElementsByTagName("td")[2].innerHTML);
                                htmlday = htmldate.getDate().toString().padStart(2,"0");
                                htmlmonth = htmldate.getMonth()+1;
                                htmlyear = htmldate.getFullYear();
                                htmlrows[i].getElementsByTagName("td")[3].innerHTML=htmlmonth+"/"+htmlday+"/"+htmlyear;
                            }
                            else{
                                let htmldate = new Date(htmlrows[i].getElementsByTagName("td")[2].innerHTML);
                                let htmlday = htmldate.getDate().toString().padStart(2,"0");
                                let htmlmonth = htmldate.getMonth()+1;
                                let htmlyear = htmldate.getFullYear();
                                htmlrows[i].getElementsByTagName("td")[2].innerHTML=htmlyear+"-"+htmlmonth+"-"+htmlday;
                                htmldate = new Date(htmlrows[i].getElementsByTagName("td")[2].innerHTML);
                                htmlday = htmldate.getDate().toString().padStart(2,"0");
                                htmlmonth = htmldate.getMonth()+1;
                                htmlyear = htmldate.getFullYear();
                                htmlrows[i].getElementsByTagName("td")[3].innerHTML=htmlyear+"-"+htmlmonth+"-"+htmlday;
                            }
                        }
                    }
                },
                {
                    text: 'Project column included in Excel',
                    action: function ( e, dt, node, config ) {
                        if(table.columns( [5] ).visible()[0]==true){
                            table.columns( [5] ).visible( false );
                        }
                        else{
                            table.columns( [5] ).visible( true );
                        }
                    }
                },
            ],
        });
    });
</script>
@endsection
