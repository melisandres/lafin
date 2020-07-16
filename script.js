const infos = require('./info.json');

let titles =[];
var i;
for (i = 0; i < infos.length; i++) {
  titles.push(infos[i].title);
} 

console.log(titles);

//Does this go here? this makes Join-us resizable
//$(".join-us").resizable({
//   resizeWidth: false,
//   handles: 'n',
// });

var m_pos;
function resize(e){
    var parent = resize_el.parentNode;
    var dx = m_pos - e.y;
    m_pos = e.y;
    parent.style.height = (parseInt(getComputedStyle(parent, '').height) + dx) + "px";
}

var resize_el = document.getElementById("resizer");
resize_el.addEventListener("mousedown", function(e){
    m_pos = e.y;
    document.addEventListener("mousemove", resize, false);
}, false);
document.addEventListener("mouseup", function(){
    document.removeEventListener("mousemove", resize, false);
}, false);


//a function that gets called on click (for project and period icons)
//this function... 

//instead of placing the click function in each
//individual links, as they populate the assides...
//I can have this bit of script pin itself to
//everything with the class "archive-button" 

//$(".archive-button").on('click', function(){
//  var myId = $(this).data().internalid;
//  window.alert(myId+" BABABABABABA!!!!!!");
//});




