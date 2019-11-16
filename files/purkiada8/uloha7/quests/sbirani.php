<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Sbírání</title>
        <link rel="stylesheet" type="text/css" href="../css/template.css">
        <script src="../content/jquery.js" type="text/javascript"></script>
    </head>
    <body>
         <section style='float:left;background-color:white;padding:10px;'>
             <a href="#" onclick="window.open('sbirani.html', 'newwindow', 'width=500, height=500'); return false;"><button>Otevřít zadání</button></a>
        </section>
        <canvas id="ctx" width="800" height="600" style="border:1px solid #000000;background-image:url('../imgs/space.jpg')">
            Tento prohlížeč bohužel nepodporuje canvas
        </canvas>
        <script>  
            /* Základní popisky*/
            var ctx = document.getElementById("ctx").getContext("2d");
            
            var body = 0;
            var hp = 3;
            
            $.ajax({ url: '../content/stats.php',
                data: {action: 'SBIRANI=USRSTART=Uzivatel spustil hru | ' + "" + body + "" + hp},
                type: 'post'
            });
            
            var stones = [];
            
            for(i = 0;i<50;i++){
                stones.push(
                    [
                        Math.ceil((Math.random() * 800) + 20),
                        Math.ceil((Math.random() * 600) + 20)
                    ]);
            }
            
            var points = [];
            for(i = 0;i<5;i++){
                points.push(
                    [
                        Math.ceil((Math.random() * 700) + 50),
                        Math.ceil((Math.random() * 500) + 50)
                    ]);
            }
           
            var stone = new Image();
            stone.src = '../imgs/asteroid.png';
            
            var player = new Image();
            player.src = '../imgs/falcon.png';   
           
            var point = new Image();
            point.src= '../imgs/point.png';
           
            var falcon = {
                x : 0,
                y : 0,
                spdX : 10,
                spdY : 10
            };
            document.onkeydown = function(event){
                if (event.keyCode === 68 && falcon.x < 750 ) { //d
                    falcon.x += falcon.spdX;
                } 
                if (event.keyCode === 83 && falcon.y < 560){ //s
                    falcon.y += falcon.spdY;
                }
                if (event.keyCode === 65 && falcon.x > 0) { //a
                    falcon.x -= falcon.spdX;
                }
                if (event.keyCode === 87 && falcon.y > 0) { //w
                    falcon.y -= falcon.spdY;
                }
                if (event.keyCode === 80) { //p
                    setInterval(update,10);
                    setInterval(updateStone, 20);  
                }
            };
            var updateStone = function (){
                var randNumb = Math.round(Math.random());
                var anotherRandNumb = Math.floor((Math.random() * 32) + 1);
                if(randNumb === 0) {
                    if(anotherRandNumb > 16){
                        stones[Math.floor((Math.random() * stones.length) + 0)][randNumb] += Math.floor((Math.random() * 32) + 1);
                    } else {
                        stones[Math.floor((Math.random() * stones.length) + 0)][randNumb] -= Math.floor((Math.random() * 32) + 1);
                    }
                } else {
                    if(anotherRandNumb > 16){
                        stones[Math.floor((Math.random() * stones.length) + 0)][randNumb] += Math.floor((Math.random() * 32) + 1);
                    } else {
                        stones[Math.floor((Math.random() * stones.length) + 0)][randNumb] -= Math.floor((Math.random() * 32) + 1);
                    }
                }
            };
          
          var getDistance = function(entity1x, entity1y, entity2x, entity2y){
              var vx = entity1x - entity2x;
              var vy = entity1y - entity2y;
              return Math.sqrt(vx*vx+vy*vy);
          };
          var testCollision = function (entity1x, entity1y, entity2x, entity2y){
              var distance = getDistance(entity1x, entity1y, entity2x, entity2y);
              return distance < 30;
          };
            function update(){
                ctx.clearRect(0,0,800,600);         
                ctx.drawImage(player,falcon.x,falcon.y);
                
                for(i = 0; i < stones.length; i++) {
                    ctx.drawImage(stone, stones[i][0], stones[i][1]);
                    var is_colliding = testCollision(falcon.x, falcon.y, stones[i][0], stones[i][1]);
                    if (is_colliding) {
                        hp-=1;
                        if (hp === -43 ){
                            alert('Zničil tě asteroid, zkus to znovu! ');
                            $.ajax({ url: '../content/stats.php',
                                data: {action: 'SBIRANI=USRDESTROYED=Uzivatel byl znicen | '},
                                type: 'post'
                            });
                            window.location.replace("../content/stats.php");

                    }
                }}
                for(i = 0; i < points.length; i++) {
                    ctx.drawImage(point, points[i][0], points[i][1]);
                    var is_colliding = testCollision(falcon.x, falcon.y, points[i][0], points[i][1]);
                    if (is_colliding) {
                        console.log('kolize s bodem');
                        body +=1;
                        points.splice(i,1);
                    }
                }
                if(points.length === 0 ){
                    $.ajax({ url: '../content/stats.php',
                    data: {action: 'SBIRANI=USRPOINTS=Mel bodu' + body.toString()},
                    type: 'post'
                });          
                window.location.replace("../content/stats.php");
                }
            };           
        </script> 
    </body>
</html>
