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
function validateEndDate(str) {
    if(document.getElementsByName("end["+str+"]")[0].value<document.getElementsByName("start["+str+"]")[0].value){
        alert("The Actual End Date has to be greater than or equal to the Actual Start Date !");
        document.getElementsByName("update["+str+"]")[0].disabled=true;
    }
    else{
        document.getElementsByName("update["+str+"]")[0].disabled=false;
    }
}