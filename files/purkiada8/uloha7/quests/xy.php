<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Souřadnice</title>
        <link rel="stylesheet" type="text/css" href="../css/template.css">
        <script src="../content/jquery.js" type="text/javascript"></script>
    </head>
    <body>
        <section style='float:left;background-color:white;padding:10px;'>
             <a href="#" onclick="window.open('xy.html', 'newwindow', 'width=500, height=500'); return false;"><button>Otevřít zadání</button></a>
        </section>
        <canvas id="ctx" width="800" height="600" style="border:1px solid #000000;background-image:url('../imgs/space.jpg')"></canvas>
        <script type='text/javascript'>  

            /* Základní popisky*/
            var ctx = document.getElementById("ctx").getContext("2d");
            ctx.font = '30px Arial';
            ctx.fillStyle = 'white';

            /* Nastavení*/
            var pocetLodi = 0;
            var body = 0;
            var start = false;
            var allowedFire = true;
            
            $.ajax({ url: '../content/stats.php',
                            data: {action: "XY=DATA="+pocetLodi +""+ body},
                            type: 'post'
                        });
            
            /* Entity */
            var falcon = {
                x : 400,
                y : 100,
                spdX : 10,
                spdY : 10
            };
            
            var stardestroyer = {
                x : Math.round(Math.ceil((Math.random() * 250) + 1)/10)*10,
                y : Math.round(Math.ceil((Math.random() * 460) + 1)/10)*10
            };
 
            var player = new Image();
            player.src = '../imgs/falcon1.png';   
            
            var enemy = new Image();
            enemy.src = '../imgs/enemy.png'; 
            

            
            /* Ovládání */
            document.onkeydown = function(event){
                if (event.keyCode === 68 && falcon.x < 600) { //d
                    falcon.x += falcon.spdX;
                } 
                if (event.keyCode === 83 && falcon.y < 460){ //s
                    falcon.y += falcon.spdY;
                }
                if (event.keyCode === 65 && falcon.x > 0) { //a
                    falcon.x -= falcon.spdX;
                }
                if (event.keyCode === 87 && falcon.y > 0) { //w
                    falcon.y -= falcon.spdY;
                }
                if (event.keyCode === 80) { //p
                    start = true;
                }
            };
            /* Fce */
            var Enemy = {
                drawShip() {
                    ctx.drawImage(enemy, stardestroyer.x, stardestroyer.y);

                },
                updateShip(vt){
                    stardestroyer.x = Math.ceil(vt.v*vt.t) ; 
                        $.ajax({ url: '../content/stats.php',
                            data: {action: "XY=USRDRAWNSHIP="},
                            type: 'post'
                        });
                },
                destroyShip(){
                    stardestroyer.x = -1000;
                    stardestroyer.y = Math.round(Math.ceil((Math.random() * 360) + 1)/10)*10 ;  
                }      
            };
            var shoot = function(){
                if(falcon.y === stardestroyer.y && stardestroyer.x+350 > falcon.x ) {
                    $.ajax({ url: '../content/stats.php',
                            data: {action: "XY=USERSUCCESSHIPDESTROYED="},
                            type: 'post'
                        });
                    return true;
                }
                return false;
            };

            var generateS = function(){
                var s = 700;
                while (s > 400) {
                    var v = Math.ceil((Math.random() * 10) + 1);
                    var t = Math.ceil((Math.random() * 30) + 10);
                    s = v*t;
                }
                return {"v" : v,"t": t};   
            };
            /* Hlavní cyklus */
            setInterval(update,10);  
            function update(){
                ctx.clearRect(0,0,1200,600);
                /* Vykreslení */
                ctx.drawImage(player,falcon.x,falcon.y);
                ctx.fillText("X: "+falcon.x + " Y: "+falcon.y, 600, 590);    
                if (start) {
                    if (pocetLodi !== 10){
                        Enemy.drawShip(); 
                        document.onkeyup = function(event){
                            if(event.keyCode === 32 && allowedFire) {
                                allowedFire = false;
                                if (shoot()){
                                    body+=1;
                                    console.log('Trefil jsi!');
                                } 
                                Enemy.destroyShip();
                                pocetLodi +=1;
                                var vt = generateS(); 
                                console.log("Loď letí rychlostí "+vt.v+" jednotek/vteřinu. \
                                  Loď přiletí za "+vt.t+" sekund. \ Souřadnice nepřátelské lodi Y : " + stardestroyer.y + " X : musíte spočítat !");
                                setTimeout(function() {
                                    allowedFire = true;
                                    Enemy.updateShip(vt);
                                }, vt.t*1000);    
                            }
                    };
                    } else {
                        $.ajax({ url: '../content/stats.php',
                            data: {action: "XY=USRPOINTS="+"Pocet bodu "+body},
                            type: 'post'
                        });
                        window.location.replace("../content/stats.php");
                    }
                }
            }
        </script>
    </body>
</html>
