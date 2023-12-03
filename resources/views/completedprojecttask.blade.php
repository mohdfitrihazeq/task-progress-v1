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
    @if($projecttaskprogress->count() > 0)
        @foreach($projecttaskprogress as $rs)
            <input hidden name="exportrow" data-project="{{ $rs->project_id }}" value="{{ '<tr><td>'.$rs->task_sequence_no_wbs.'</td></tr>' }}">
        @endforeach
    @endif
    <form>
        <table class="table table-hover" id="data-table">
            <thead class="table-primary">
                <tr id="data-table-header" class="data-table-header">
                    <th>Task Sequence No. (WBS)</th>
                    <th>Task Name</th>
                    <th>Actual Start Date</th>
                    <th>Actual End Date</th>
                    <th hidden>Project</th>
                    <th hidden>Project ID</th>
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
                            <td class="align-middle" hidden>{{ $rs->project_name }}</td>
                            <td class="align-middle" hidden>{{ $rs->project_id }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">Project Task Progress not found</td>
                    </tr>
                @endif
            </tbody>
        </table>
        <input hidden id="includeheader" value="disabled">
        <input hidden id="includeproject" value="disabled">
        <input hidden id="dateformat" value="uk">
    </form>
    <button id="btnExport" onclick="fnExcelReport();"> EXPORT </button>
    <iframe id="txtArea1" style="display:none"></iframe>
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
function fnExcelReport() {
    var tab_text = "<table border='2px'><tr>";
    var j = 0;
    var tab = document.getElementById('data-table'); // id of table
    var projectFilter = document.getElementById('projectFilter').value; 
    var includeHeader = document.getElementById('includeheader').value;
    var includeProject = document.getElementById('includeproject').value;
    var dateFormat = document.getElementById('dateformat').value;

    if(includeHeader=="enabled"){
        var header = tab.rows[0].getElementsByTagName("th");
        for (l = 0; l < 4; l++) {
            tab_text = tab_text + header[l].outerHTML;
        }
        if(includeProject=="enabled"){
            tab_text = tab_text + header[4].outerHTML;
        }
        tab_text = tab_text + "</tr><tr>";
    }
    for (j = 1; j < tab.rows.length; j++) {
        var data = tab.rows[j].getElementsByTagName("td");
        for (k = 0; k < 2; k++) {
            if(data[5].innerHTML==projectFilter||projectFilter==""){
                tab_text = tab_text + data[k].outerHTML;
            }
        }
        for (k = 2; k < 4; k++) {
            if(data[5].innerHTML==projectFilter||projectFilter==""){
                if(dateFormat=="uk"){
                    tab_text = tab_text + "<td style='mso-number-format:" + "yyyy-mm-dd" + "'>" + data[k].innerHTML + "</td>";
                }
                else{
                    tab_text = tab_text + "<td style='mso-number-format:" + "mm/dd/yyyy" + "'>" + data[k].innerHTML + "</td>";
                }
            }
        }
        if((data[5].innerHTML==projectFilter||projectFilter=="")&&includeProject=="enabled"){
            tab_text = tab_text + data[4].outerHTML;
        }
        tab_text = tab_text + "</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text = tab_text + "</table>";
    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
    tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var msie = window.navigator.userAgent.indexOf("MSIE ");

    // If Internet Explorer
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        txtArea1.document.open("txt/html", "replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus();

        sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
    } else {
        // other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
    }

    return sa;
}
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
    });
</script>
@endsection
