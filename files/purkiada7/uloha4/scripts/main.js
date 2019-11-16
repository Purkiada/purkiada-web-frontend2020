/*
	Jednoduchý loading
*/
$(document).ready(function(){
	$("#loading").fadeOut();
})
/*
	Blokace refreshnutí stránky přes klávesu F5
*/
$(document).bind('keypress keydown keyup', function(e) {
	var ztrataDat = "Prosím, nerefreshujte stránku, mohlo by dojít ke ztrátě dat !";
    if(e.which === 116) {
       console.log('blocked');
	   alert(ztrataDat);
       return false;
    }
    if(e.which === 82 && e.ctrlKey) {
       console.log('blocked');
	   alert(ztrataDat);
       return false;
    }
});
/*
	Znemožnění zobrazení zdrojového kódu
*/
	$(function () {
      $(document).bind('contextmenu', function (e) {
        e.preventDefault();
        alert("Je zakázáno zobrazovat v této úloze zdrojový kód");
      });
    $('.Container').bind('contextmenu',function(e){
      e.preventDefault();
      alert("Je zakázáno zobrazovat v této úloze zdrojový kód");
      });
    });
	document.onkeydown = function (cc) {
	if(cc.which == 85){
		return false;
	}
	}
/*
	Znemožnění vracení stránku zpět
*/
history.pushState(null, null, location.href);
window.onpopstate = function(event) {
    history.go(1);
};