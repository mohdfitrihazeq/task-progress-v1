function toggleEndDate() {
    var EndDateList = document.getElementById("data-table");
    for(i=0;i<EndDateList.rows.length-1;i++){
        if(document.getElementsByName("progress["+i+"]")[0].value==100){
            document.getElementsByName("end["+i+"]")[0].disabled=false;
        }
        else{
            document.getElementsByName("end["+i+"]")[0].disabled=true;
        }
    }
}