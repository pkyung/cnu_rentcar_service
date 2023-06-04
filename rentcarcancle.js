const cancel = document.getElementById("cancel");
const previous = document.getElementById("previous");


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