function focusConsole(){
  $("#input").focus();
}

$(document).keypress(function(e) {
    if(e.which == 13) {
        if($("#input").is(":focus")){
          ajaxRequest();
        }
    }
});

function ajaxRequest(){
  var command = document.getElementById("input").value;
  var request = new XMLHttpRequest();
  request.onreadystatechange = function() {
    if (request.readyState == 4 && request.status == 200) {
      removeOldInput();
      document.getElementById("console-wrapper").innerHTML += request.responseText;
    }
    $("#input").focus();
  }
  request.open("GET", "commands.php?input=" + command, true);
  request.send();
}

function removeOldInput(){
  var id = document.getElementById("input");  
  id.remove("#input"); 
}