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

$(document).ready(function(){
    $(".archive-button").on('click', function(){
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