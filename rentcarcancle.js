const cancel = document.getElementById("cancel");
const previous = document.getElementById("previous");

// cancel 버튼 누르면 rentcarreservation.php에서 쿼리를 실행해서
// 받아온 response를 테이블에 뿌린다
cancel.addEventListener("click", function() {
    $.ajax({      
        type:"POST",  
        url:"rentcarreservation.php",      
        data: {
            date:'a'
        },      
        success:function(args){   
            console.log(args);
            $("#seartable").html(args);      
        },   
    });  
});

// previous 버튼 누르면 rentcarprevioustable.php에서 쿼리를 실행해서
// 받아온 response를 테이블에 뿌린다
previous.addEventListener("click", function() {
    $.ajax({      
        type:"POST",  
        url:"rentcarprevioustable.php",      
        data: {
            date:'a'
        },      
        success:function(args){   
            console.log(args);
            $("#seartable").html(args);      
        },   
    });  
});