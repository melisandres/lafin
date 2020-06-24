<script>
//this deals with the extra bits of info that 
//are "collapsible" in the center text... or 
//I suppose in other areas too...

//since I need to call this as a function, every
//time I populate the center-text box... I need to 
//define it here, as a function. and then call it
//from the php file function displayText() in c-text.php

function SetUpArchiveText(){
        var coll = document.getElementsByClassName("collapsible");
        var i;
        
        for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                        for(i = 0; i < coll.length; i++){
                                if ($(coll[i]).hasClass("archive-info-active")){
                                        coll[i].classList.toggle("archive-info-active");
                                        coll[i].nextElementSibling.style.maxHeight = null;
                                }
                        }

                        this.classList.toggle("archive-info-active");
                        var content = this.nextElementSibling;

                        if (content.style.maxHeight){
                                content.style.maxHeight = null;
                                } else {
                                content.style.maxHeight = content.scrollHeight + "px";                                
                                } 



                 //       if (content.style.display === "block") {
                 //               content.style.display = "none";
                 //       } 
                 //       else {
                 //               content.style.display = "block";
                 //       }
                });
        }
} 
</script>

<?php 
function displayText($onD){
        echo "<h1>".$onD[title]."</h1>";
        echo "<h4>".$onD[lead]."</h4>";

        if ($onD[index] == "27") {
                include '../infos/'.$onD[index].'.php'; 
                echo '<script>SetUpArchiveText();</script>';
        }
        else { 
                echo "<p>".$onD[blurb]."</p>";
        }
}

displayText($onDisplay);
?>