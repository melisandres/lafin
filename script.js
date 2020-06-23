const infos = require('./info.json');

let titles =[];
var i;
for (i = 0; i < infos.length; i++) {
  titles.push(infos[i].title);
} 

console.log(titles);

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




