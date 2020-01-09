<?php 
$type = "project";
fillAsides($pageProjects, $type, $onDisplay);
?>

<script>
//instead of placing the click function in each
//individual links, as they populate the assides...
//I can have this bit of script pin itself to
//everything with the class "archive-button" 

//$(document).ready(function(){
//    $(".archive-button").on('click', function(){
//        var myId = $(this).data().internalid;
//        $.get("includes/archive-refresh.php", {"newIndex": myId}, function(data, status){
//          $("#c-text").html(data);
//            alert(status);
//        })
//   });
//});

//this script is triggerd when a link with the class 
//'archive-button' is clicked. It removes the p-active class
//from the last active button, and adds it to the button just clicked.
//it then sends two post requests. 1 to c-text, another to c-image.
$(document).ready(function(){
    $(".archive-button").on('click', function(){
        var actives = document.querySelectorAll(".archive-button");
        console.log(actives);
        for (var i = 0, len = actives.length; i < len; i++) {
            if (actives[i].classList.contains("p-active")) {
                actives[i].classList.remove("p-active");
                console.log(actives[i]);
                }
        }
        this.classList.add("p-active");
        var myId = $(this).data().internalid;
        $.ajax({
            type: "POST",
            url: "includes/archive-refresh.php",
            data: {
                "newIndex": myId,
                "refresh": "text"
            },
            success: function(data, status) { 
                $("#c-text").html(data);
            }
        });
        $.ajax({
            type: "POST",
            url: "includes/archive-refresh.php",
            data: {
                "newIndex": myId,
                "refresh": "image"
            },
            success: function(data, status) { 
                $("#c-image").html(data);
            }
        });
    });   
});

</script>