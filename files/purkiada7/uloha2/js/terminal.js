var firstShow=true;var inputNumber=0;var restoreText="";var number=Math.floor(Math.random()*1E4+1);var connected=false;var files=[];var current="/";function showTerminal(){$(".terminal-wrapper").show();if(firstShow){firstShow=false;print("Na\u010d\u00edt\u00e1n\u00ed termin\u00e1lu v2.1.7 ...");setTimeout(function(){println(" dokon\u010deno!");println("Seznam příkazů můžete zobrazit pomocí příkazu 'help'");$(".terminal-input").show()},2E3)}$("#command").focus()}function hideTerminal(){$(".terminal-wrapper").hide()}
function setInputVisible(visible){if(visible){$(".terminal-input").show();$("#command").focus()}else{$("#command").val("");$(".terminal-input").hide()}}function setCurrent(dir){current=dir;if(current=="/")$("#commandText").html("agent010@AgentPC:~$&nbsp;");else $("#commandText").html("agent010@AgentPC:~"+current+"$&nbsp;")}function println(text){$(".terminal-input").before(text+"<br>");$(".terminal").scrollTop($(".terminal").height())}
function print(text){$(".terminal-input").before(text);$(".terminal").scrollTop($(".terminal").height())}function input(text){restoreText=$("#commandText").text();$("#commandText").html(text);inputNumber=1}function input2(text){restoreText=$("#commandText").text();$("#commandText").html(text);inputNumber=2}
function customInput(text){setInputVisible(false);text=text.trim();println($("#commandText").text()+text);var wait=false;if(text=="admin@codesec.xyz"){println("P\u0159ipojov\u00e1n\u00ed k emailu ...");wait=true;setTimeout(function(){println("Z\u00edsk\u00e1v\u00e1n\u00ed p\u0159\u00edstupu ...");setTimeout(function(){println("K z\u00edsk\u00e1n\u00ed p\u0159\u00edstupu je pot\u0159eba zadat de\u0161ifrovac\u00ed k\u00f3d");println("Zkuste toto \u010d\u00edslo uhodnout (napi\u0161te libovoln\u00e9 \u010d\u00edslo 1-10000 a zjist\u00edte jestli je v\u011bt\u0161\u00ed nebo men\u0161\u00ed dokud ho neuhodnete)");
input2("Zadejte de\u0161ifrovac\u00ed k\u00f3d:&nbsp;");setInputVisible(true)},2E3)},2E3)}else println("Tento email nebyl nalezen");$("#commandText").html(restoreText);inputNumber=0;if(!wait)setInputVisible(true)}
function customInput2(text){setInputVisible(false);text=text.trim();println($("#commandText").text()+text);if(text==number){println("Email byl \u00fasp\u011bsn\u011b de\u0161ifrov\u00e1n, heslo k \u00fa\u010dtu admin je: "+(![]+[])[+!+[]]+([][[]]+[])[!+[]+!+[]]+((+[])[([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+
[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+([][[]]+[])[+!+[]]+(![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[+!+[]]+([][[]]+[])[+[]]+([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+(!![]+[])[+!+[]]]+[])[+!+[]+[+!+[]]]+([![]]+[][[]])[+!+[]+
[+[]]]+([][[]]+[])[+!+[]]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]][([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+([][[]]+[])[+!+[]]+(![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+(!![]+
[])[+!+[]]+([][[]]+[])[+[]]+([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+(!![]+[])[+!+[]]]((!![]+[])[+!+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+([][[]]+[])[+[]]+(!![]+[])[+!+[]]+([][[]]+[])[+!+[]]+(+[![]]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+
[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+!+[]]]+(!![]+[])[!+[]+!+[]+!+[]]+(![]+[])[!+[]+!+[]+!+[]]+([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(![]+[])[+!+[]]+(+(!+[]+!+[]+[+!+[]]+[+!+[]]))[(!![]+[])[+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+
(+![]+([]+[])[([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+([][[]]+[])[+!+[]]+(![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[+!+[]]+([][[]]+[])[+[]]+([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+
(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+(!![]+[])[+[]]+(!![]+[])[+!+[]]+([![]]+[][[]])[+!+[]+[+[]]]+([][[]]+[])[+!+[]]+(+![]+[![]]+([]+[])[([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(!![]+[][(![]+[])[+[]]+([![]]+
[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+([][[]]+[])[+!+[]]+(![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[+!+[]]+([][[]]+[])[+[]]+([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+
[+[]]]+(!![]+[])[+!+[]]])[!+[]+!+[]+[+[]]]](!+[]+!+[]+!+[]+[+!+[]])[+!+[]]+(!![]+[])[!+[]+!+[]+!+[]])()(([]+[])[([![]]+[][[]])[+!+[]+[+[]]]+(!![]+[])[+[]]+(![]+[])[+!+[]]+(![]+[])[!+[]+!+[]]+([![]]+[][[]])[+!+[]+[+[]]]+([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(![]+[])[!+[]+!+[]+!+[]]]()[+[]])[!+[]+!+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+
[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+([][[]]+[])[!+[]+!+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(+![]+([]+[])[([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+([][[]]+[])[+!+[]]+(![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[+!+[]]+([][[]]+[])[+[]]+([][(![]+
[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+(!![]+[])[+!+[]]])[+!+[]+[+[]]]+(!![]+[])[!+[]+!+[]+!+[]]+([][(![]+[])[+[]]+([![]]+[][[]])[+!+[]+[+[]]]+(![]+[])[!+[]+!+[]]+(!![]+[])[+[]]+(!![]+[])[!+[]+!+[]+!+[]]+(!![]+[])[+!+[]]]+[])[!+[]+!+[]+!+[]]+[!+[]+
!+[]]+[!+[]+!+[]+!+[]+!+[]+!+[]]+[!+[]+!+[]+!+[]+!+[]+!+[]+!+[]+!+[]+!+[]]);$("#commandText").html(restoreText);inputNumber=0}else if(text<number)println("De\u0161ifrovac\u00ed k\u00f3d je v\u011bt\u0161\u00ed \u010d\u00edslo ne\u017e jste napsali");else if(text>number)println("De\u0161ifrovac\u00ed k\u00f3d je men\u0161\u00ed \u010d\u00edslo ne\u017e jste napsali");else println("Vstupn\u00ed hodnotou m\u016f\u017ee b\u00fdt pouze \u010d\u00edslo");setInputVisible(true)}
function command(text){setInputVisible(false);text=text.trim();println($("#commandText").text()+text);var cmd=text.split(" ");var wait=false;try{switch(cmd[0]){case "help":println("Seznam p\u0159\u00edkaz\u016f:");println("help - zobraz\u00ed seznam p\u0159\u00edkaz\u016f");println("dir - vyp\u00ed\u0161e obsah slo\u017eky");println("cd [složka] - otev\u0159e slo\u017eku");println("cd .. - n\u00e1vrat do slo\u017eky '/'");println("download [soubor] - st\u00e1hne soubor ze serveru");println("connect [adresa] - p\u0159ipojen\u00ed k serveru");
println("disconnect - odpojen\u00ed ze serveru");println("run [program] - spust\u00ed program");println("exit - ukon\u010d\u00ed termin\u00e1l");break;case "dir":if(connected){println("Soubory v adres\u00e1\u0159i '/server/':");println("emailhack.exe")}else{println("Soubory v adres\u00e1\u0159i '"+current+"':");if(current=="/")println("Downloads");else if(current=="/Downloads/")println(files.toString())}break;case "cd":if(connected)println("P\u0159\u00edstup zam\u00edtnut");else if(cmd[1]=="Downloads")setCurrent("/Downloads/");
else if(cmd[1]=="..")setCurrent("/");else println("Tato slo\u017eka nebyla nalezena");break;case "connect":if(cmd[1]=="128.0.0.1"){connected=true;println("P\u0159ipojeno k 128.0.0.1")}else println("Nepoda\u0159ilo se p\u0159ipojit k serveru");break;case "disconnect":if(connected){println("Odpojeno od severu 128.0.0.1");connected=false}else println("Nejsi p\u0159ipojen\u00fd k serveru");break;case "download":if(connected)if(cmd[1]=="emailhack.exe"){if(files.indexOf("emailhack.exe")!=-1){println("Tento soubor u\u017e existuje!");
break}wait=true;println("Stahov\u00e1n\u00ed souboru emailhack.exe ...");setTimeout(function(){files.push("emailhack.exe");println("Stahov\u00e1n\u00ed bylo dokon\u010deno.");setInputVisible(true)},1E3)}else println("Tento soubor neexistuje");else println("Nejste p\u0159ipojen\u00fd k serveru");break;case "run":if(connected){println("Pokud chcete spustit program, tak se odpojte od serveru");break}if(current=="/Downloads/"&&cmd[1]=="emailhack.exe"){println("Spou\u0161t\u011bn\u00ed programu emailhack.exe ...");
println("----------------");println("Emailhack v1.1.3");println("----------------");input("Zadejte email do kter\u00e9ho chcete z\u00edskat p\u0159\u00edstup:&nbsp;(admin@codesec.xyz)&nbsp;")}else println("Tento program nebyl nalezen");break;case "exit":hideTerminal();break;default:println("Nezn\u00e1m\u00fd p\u0159\u00edkaz, napi\u0161te 'help' pro seznam p\u0159\u00edkaz\u016f")}}catch(err){println("\u0160patn\u00fd syntax p\u0159\u00edkazu")}if(!wait)setInputVisible(true)}
$(document).ready(function(){setInputVisible(false);$("#command").keydown(function(e){if(e.keyCode==13)if(inputNumber==1)customInput($("#command").val());else if(inputNumber==2)customInput2($("#command").val());else command($("#command").val())});$("#command").focusout(function(){setTimeout(function(){$("#command").focus()},10)})});
