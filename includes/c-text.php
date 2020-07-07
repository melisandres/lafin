<script>
//this deals with the extra bits of info that 
//are "collapsible" in the center text... or 
//I suppose in other areas too...

//since I need to call this as a function, every
//time I populate the center-text box... I need to 
//define it here, as a function. and then call it
//from the php file function displayText() in c-text.php

//what this does is:
// -it gets all the elements with class "collapsible" (buttons)
// -it places an event listener on each
// -the event listener, listens for click. 
// -when a click occurs, the script cycles through "collapsibles"
// -for each, it determines if that button is currently active.
// -if the button is active and just clicked, it exits the function
// -otherwise, is deactivates the button and slides it's content out.
// -NOW, it can look at itself, the button clicked
// -set that button to active, and slide it's content onscreen

function SetUpArchiveText(){
        var coll = document.getElementsByClassName("collapsible");
        var i;
        //add script here that loads, and makes active, the ABOUT section (or the FIRST section)
        var firstContent = coll[0].nextElementSibling;
        coll[0].classList.toggle("archive-info-active");
        firstContent.style.left = "20px";


        for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                        for(i = 0; i < coll.length; i++){
                                if ($(coll[i]).hasClass("archive-info-active")){
                                        var lastContent = coll[i];
                                        if (lastContent === this){
                                                return;
                                        }
                                        else{
                                                lastContent.classList.toggle("archive-info-active");
                                                $(lastContent.nextElementSibling).animate({left: '100%'}, 450, "swing");
                                        }
                                }
                        }
                        this.classList.toggle("archive-info-active");
                        var newContent = this.nextElementSibling;
                        newContent.style.left = "-100%";
                        $(newContent).animate({left: '20px'}, 700);
                });
        }
} 
</script>

<?php 
function displayText($onD){
        echo "<h1>".$onD[title]."</h1>";
        echo "<h4>".$onD[lead]."</h4>";
        if (file_exists('../infos/'.$onD[infos].'.php')) {
                include '../infos/'.$onD[infos].'.php';
                echo '<script>SetUpArchiveText();</script>';
        };
        if (file_exists('infos/'.$onD[infos].'.php')){
                include 'infos/'.$onD[infos].'.php';
                echo '<script>SetUpArchiveText();</script>';
        };
}

displayText($onDisplay);
?>