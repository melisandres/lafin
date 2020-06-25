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
                                        var lastContent = coll[i];
                                        if (lastContent === this){
                                                console.log("detecting an ACTIVE button was clicked again");
                                        }
                                        else{
                                                lastContent.classList.toggle("archive-info-active");
                                                //coll[i].nextElementSibling.style.maxHeight = null;
                                                //window.alert("animating out");
                                                console.log("animating lastContent out");
                                                $(lastContent.nextElementSibling).animate({left: '-90%'}, 'slow');
                                                //lastContent.nextElementSibling.style.display = "none";
                                        }
                                }
                                else{
                                        //coll[i].nextElementSibling.style.display = "none";  
                                }
                        }
         //       });
                        this.classList.toggle("archive-info-active");
                        var newContent = this.nextElementSibling;

                        //if (newContent.style.display === "none") {
                        //        newContent.style.display = "block";
                                newContent.style.left= "-80%";
                                console.log("animatingg in");
                                $(newContent.nextElementSibling).animate({left: '5%'}, 'slow')
                                newContent.style.left= "20px";
                        //} 
                        //else {
                        //        window.alert("falling into the else 'block'");
                        //        content.style.display = "block";
                        //}
                 //       if (content.style.maxHeight){
                 //               content.style.maxHeight = null;
                 //               } else {
                 //               content.style.maxHeight = content.scrollHeight + "px";                                
                 //               } 
                 
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