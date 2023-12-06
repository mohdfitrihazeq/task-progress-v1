function checkAll() {
    if(document.getElementById("checkall").checked==true){
        var checklist = document.getElementById("data-table");
        for(i=0;i<checklist.rows.length-1;i++){
            document.getElementsByName("assigntaskid["+i+"]")[0].checked = true;
        }
    }
    else{
        var checklist = document.getElementById("data-table");
        for(i=0;i<checklist.rows.length-1;i++){
            document.getElementsByName("assigntaskid["+i+"]")[0].checked = false;
        }
    }
}