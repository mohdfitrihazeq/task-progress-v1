function toggleEndDate(str) {
    if(document.getElementsByName("progress["+str+"]")[0].value>=20){
        document.getElementsByName("end["+str+"]")[0].disabled=false;
    }
    else{
        document.getElementsByName("end["+str+"]")[0].disabled=true;
    }
}

function validateEndDate(str) {
    var enddate = document.getElementsByName("end["+str+"]")[0].value.substring(6,10) + "-" + document.getElementsByName("end["+str+"]")[0].value.substring(3,5) + "-" + document.getElementsByName("end["+str+"]")[0].value.substring(0,2);
    var startdate = document.getElementsByName("start["+str+"]")[0].value.substring(6,10) + "-" + document.getElementsByName("start["+str+"]")[0].value.substring(3,5) + "-" + document.getElementsByName("start["+str+"]")[0].value.substring(0,2);
    if(enddate<startdate){
        alert("The Actual End Date has to be greater than or equal to the Actual Start Date !");
        document.getElementsByName("updatetask["+str+"]")[0].disabled=true;
    }
    else{
        document.getElementsByName("updatetask["+str+"]")[0].disabled=false;
    }
}

function usaDateFormat() {
    var usadateformat=$("#usadateformat")[0].innerHTML;
    var x= document.querySelectorAll('[name="data"]');
    if(usadateformat=='<path d=\"M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z\"></path>'){
        $("#usadateformat")[0].innerHTML='<path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/></path>';
        for(var i=0;i<x.length;i++){
            x[i].getElementsByTagName('div')[2].innerHTML=x[i].getElementsByTagName('div')[2].innerHTML.trim().substring(3,5)+"/"+x[i].getElementsByTagName('div')[2].innerHTML.trim().substring(0,2)+"/"+x[i].getElementsByTagName('div')[2].innerHTML.trim().substring(6,10);
            x[i].getElementsByTagName('div')[3].innerHTML=x[i].getElementsByTagName('div')[3].innerHTML.trim().substring(3,5)+"/"+x[i].getElementsByTagName('div')[3].innerHTML.trim().substring(0,2)+"/"+x[i].getElementsByTagName('div')[3].innerHTML.trim().substring(6,10);
        }
    }
    if(usadateformat=='<path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"></path>'){
        $("#usadateformat")[0].innerHTML='<path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"></path>';
        for(var i=0;i<x.length;i++){
            x[i].getElementsByTagName('div')[2].innerHTML=x[i].getElementsByTagName('div')[2].innerHTML.trim().substring(3,5)+"/"+x[i].getElementsByTagName('div')[2].innerHTML.trim().substring(0,2)+"/"+x[i].getElementsByTagName('div')[2].innerHTML.trim().substring(6,10);
            x[i].getElementsByTagName('div')[3].innerHTML=x[i].getElementsByTagName('div')[3].innerHTML.trim().substring(3,5)+"/"+x[i].getElementsByTagName('div')[3].innerHTML.trim().substring(0,2)+"/"+x[i].getElementsByTagName('div')[3].innerHTML.trim().substring(6,10);
        }
    }
}

function projectColumnIncludedInExcel() {
    var headersincludedinexcel=$("#headersincludedinexcel")[0].innerHTML;
    var projectcolumnincludedinexcel=$("#projectcolumnincludedinexcel")[0].innerHTML;
    var x= document.querySelectorAll('[name="data"],[name="header"]');
    if(projectcolumnincludedinexcel=='<path d=\"M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z\"></path>'){
        $("#projectcolumnincludedinexcel")[0].innerHTML='<path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/></path>';
        for(var i=1;i<x.length;i++){
            x[i].getElementsByTagName('div')[0].classList.replace('col-md-3','col-md-2');
            x[i].getElementsByTagName('div')[4].classList.add('col-md-1');
            x[i].getElementsByTagName('div')[4].classList.replace('d-none','d-block');
        }
        if(headersincludedinexcel=='<path d=\"M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z\"></path>'){
            x[0].getElementsByTagName('div')[0].classList.replace('col-md-2','col-md-3');
            x[0].getElementsByTagName('div')[4].classList.replace('d-block','d-none');
            x[0].getElementsByTagName('div')[4].classList.remove('col-md-1');
        }
        else{
            x[0].getElementsByTagName('div')[0].classList.replace('col-md-3','col-md-2');
            x[0].getElementsByTagName('div')[4].classList.replace('d-none','d-block');
            x[0].getElementsByTagName('div')[4].classList.add('col-md-1');
        }
    }
    if(projectcolumnincludedinexcel=='<path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"></path>'){
        $("#projectcolumnincludedinexcel")[0].innerHTML='<path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"></path>';
        for(var i=1;i<x.length;i++){
            x[i].getElementsByTagName('div')[0].classList.replace('col-md-2','col-md-3');
            x[i].getElementsByTagName('div')[4].classList.remove('col-md-1');
            x[i].getElementsByTagName('div')[4].classList.replace('d-block','d-none');
        }
        if(headersincludedinexcel=='<path d=\"M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z\"></path>'){
            x[0].getElementsByTagName('div')[0].classList.replace('col-md-2','col-md-3');
            x[0].getElementsByTagName('div')[4].classList.replace('d-block','d-none');
            x[0].getElementsByTagName('div')[4].classList.remove('col-md-1');
        }
        else{
            x[0].getElementsByTagName('div')[0].classList.replace('col-md-2','col-md-3');
            x[0].getElementsByTagName('div')[4].classList.replace('d-block','d-none');
            x[0].getElementsByTagName('div')[4].classList.remove('col-md-1');
        }
    }
}

function headersIncludedInExcel() {
    var headersincludedinexcel=$("#headersincludedinexcel")[0].innerHTML;
    var projectcolumnincludedinexcel=$("#projectcolumnincludedinexcel")[0].innerHTML;
    var x= document.querySelectorAll('[name="header"]')[0];
    if(headersincludedinexcel=='<path d=\"M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z\"></path>'){
        $("#headersincludedinexcel")[0].innerHTML='<path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"/></path>';
        var y= x.querySelectorAll('div');
        for(var i=0;i<y.length-1;i++){
            y[i].classList.replace('d-none','d-block');
        } 
        if(projectcolumnincludedinexcel=='<path d=\"M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z\"></path>'){
            y[y.length-1].classList.replace('d-block','d-none');
            y[0].classList.replace('col-md-2','col-md-3');
        }
        else{
            y[y.length-1].classList.replace('d-none','d-block');
            y[0].classList.replace('col-md-3','col-md-2');
        }
    }
    if(headersincludedinexcel=='<path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-1.146 6.854-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708.708z"></path>'){
        $("#headersincludedinexcel")[0].innerHTML='<path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"></path>';
        var y= x.querySelectorAll('div');
        for(var i=0;i<y.length-1;i++){
            y[i].classList.replace('d-block','d-none');
        }
        if(projectcolumnincludedinexcel=='<path d=\"M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z\"></path>'){
            y[0].classList.replace('col-md-2','col-md-3');
        }
        else{
            y[0].classList.replace('col-md-3','col-md-2');
        }
        y[y.length-1].classList.replace('d-block','d-none');
        y[y.length-1].classList.remove('col-md-1');
    }
}

function fnExcelReport() {
    var tab_text = "<table border='2px'><tr>";
    var tab = document.getElementsByName('data-table')[0]; // id of table

    var x = tab.getElementsByClassName("row");
    for(var i = 0;i<x.length-2;i++){
        var y = x[i].getElementsByTagName("div");
        for(var j = 0;j<y.length;j++){
            if(y[j].classList.contains('d-none')==false){
                tab_text = tab_text + '<td style="mso-number-format:' + "'\@'" + '">' + y[j].innerHTML + "</td>";
            }
        }
        tab_text = tab_text + "</tr><tr>";
    }

    tab_text = tab_text + "</tr></table>";
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

        sa = txtArea1.document.execCommand("SaveAs", true, "Completed Task Progress.xls");
    } else {
        // other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
    }

    return sa;
}

function selectAll(str){
    if(str==true){
        document.querySelectorAll('input[type="checkbox"]').forEach(function(e){
            e.checked=true;
        });
    }
    else{
        document.querySelectorAll('input[type="checkbox"]').forEach(function(e){
            e.checked=false;
        });
    }
}