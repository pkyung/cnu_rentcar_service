const search = document.getElementById("search");
// search 버튼을 누르면 날짜 정보와 렌터가 정보를 가져오는데
// rentcar가 전체라 하나라도 들어있으면 
// arr에 전체 값만 넣고 rentcarsearchtable.php에 정보를 보낸다
// 응답 처리를 잘 하면 searchtable에 정보를 뿌린다
search.addEventListener("click", function() {
    const query = 'input[name="type"]:checked';
    var date1 = document.getElementById("date1").value;
    var date2 = document.getElementById("date2").value;
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
            console.log("왜 안해?");
        },   

    });  
    console.log(date1, date2);
    console.log(arr);
});
