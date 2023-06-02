const search = document.getElementById("search");

search.addEventListener("click", function() {
    const query = 'input[name="type"]:checked';
    const date1 = document.getElementById("date1").value;
    const date2 = document.getElementById("date2").value;
    var arr = [];
    const selectedEls = document.querySelectorAll(query);
    for (var i = 0; i < selectedEls.length; i++) {
        if (selectedEls[i].value == "전체") {
            arr[0] = "전체";
            break;
        } else {
            arr[i] = selectedEls[i].value;
        }
    }
    $.ajax({      
        type:"POST",  
        url:"rentcarsearchtable.php",      
        data: {
            date1: date1,
            date2: date2,
            arr: arr
        },      
        success:function(args){   
            console.log(args);
            $("#searchtable").html(args);      
        },   

    });  
    console.log(date1, date2);
    console.log(arr);
});