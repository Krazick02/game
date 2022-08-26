<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>canvas</title>
</head>
<style>
    canvas {
        background-color: orange   ;   
    }
</style>
<body>
    <canvas id="mycanvas" width="1000" height="800"></canvas>   




    <script type ="text/javascript">
        var cv  =null;
        var ctx  = null;
        var superX=240,superY=240;
        var player=null;
        var player2=null;
        var obs1=null;
        var obs2=null;
        var obs3=null;
        var obs4=null;
        var obs5=null;
        var score=0;
        var direction='left';
        var pause=false;
        var speed=3;               
        var life=5;               
        var bone= new Image();
        var dog= new Image();
        var wall= new Image();
        var crack= new Audio();
        var choque= new Audio();

        
        function start(){
             cv  =document.getElementById('mycanvas');
             ctx  = cv.getContext('2d');
             ctx.strokeRect(0,0,1000,1000);
            player =new Cuadraro(superX,superY,40,40,'blue');
            player2 =new Cuadraro(generateRandomInteger(960),generateRandomInteger(760),40,40,'red');
            obs1 =new Cuadraro(150,100,200,20,'black');
            obs2 =new Cuadraro(150,350,200,20,'black');
            obs3 =new Cuadraro(150,600,200,20,'black');
            obs4 =new Cuadraro(750,160,20,440,'black');
            obs5 =new Cuadraro(600,160,20,440,'black');
            dog.src='dog.png';
            bone.src='bone.png';
            wall.src='wall.png';
            crack.src='hueso_3.mp3';
            choque.src='choque.mp3';
            paint();
        }
        function paint(){
            window.requestAnimationFrame(paint);
            ctx.fillStyle ='ORANGE';
            ctx.fillRect(0,0,1000,800);
            ctx.font="30px arial";
            ctx.fillStyle="black";                
            ctx.fillText("SCORE : "+score+ " - SPEED : "+speed+" HEARTS :"+life,30,60);
            
            //player.dibujar(ctx);
            
            //player2.dibujar(ctx);

            obs1.dibujar(ctx);           
            obs2.dibujar(ctx);           
            obs3.dibujar(ctx);           
            obs4.dibujar(ctx);
            obs5.dibujar(ctx);

            ctx.drawImage(dog,player.x,player.y,40,40);
            ctx.drawImage(bone,player2.x,player2.y,40,40);

            ctx.drawImage(wall,obs1.x,obs1.y,200,20);
            ctx.drawImage(wall,obs2.x,obs2.y,200,20);
            ctx.drawImage(wall,obs3.x,obs3.y,200,20);
            ctx.drawImage(wall,obs4.x,obs4.y,20,440);
            ctx.drawImage(wall,obs5.x,obs5.y,20,440);

            if(pause){
                ctx.fillStyle="rgba(0,0,0,0.5)";                
                ctx.fillRect(0,0,1000,800);
                ctx.fillStyle="WHITE";
                ctx.font="50px arial";             
                ctx.fillText("P A U S E",400,380);
            }else{
                update();
            }
        }
        function update(){
            if(direction=='rigth'){
                player.x +=speed;
                if(player.x >= 980){
                    player.x = 0;
                }
            }
            if(direction=='down'){
                player.y +=speed;
                if(player.y >= 780){
                    player.y = 0;
                }
            }
            if(direction=='up'){
                player.y -=speed;
                if(player.y <= 0){
                    player.y = 780;
                }
            }
            if(direction=='left'){
                player.x -=speed;
                if(player.x <= 0){
                    player.x = 980;
                }
            }
            if(player.se_tocan(player2)){
                player2.x=generateRandomInteger(960);
                player2.y=generateRandomInteger(760);
                score+=5;
                speed+=3;
                crack.play();
                
            }
            if(player.se_tocan(obs1) || player.se_tocan(obs2) || player.se_tocan(obs3) || player.se_tocan(obs4) || player.se_tocan(obs5)){
                ctx.fillStyle="rgba(0,0,0,0.5)";                
                ctx.fillRect(0,0,1000,800);
                ctx.fillStyle="red";
                ctx.font="50px arial";             
                ctx.fillText("G A M E  O V E R ",300,360);
                ctx.fillStyle="blue";
                ctx.font="30px arial"; 
                ctx.fillText("S C O R E : "+score,415,410);
                ctx.fillText(" Press R to restart ",385,450);
                speed=0;
            }

            // if(life>0){
            //         lifes-=1;
            //         choque.play();
            //         superX=240;
            //         superY=240;
            //     }else{
            //         ctx.fillStyle="rgba(0,0,0,0.5)";                
            //         ctx.fillRect(0,0,1000,800);
            //         ctx.fillStyle="red";
            //         ctx.font="50px arial";             
            //         ctx.fillText("G A M E  O V E R ",300,360);
            //         ctx.fillStyle="blue";
            //         ctx.font="30px arial"; 
            //         ctx.fillText("S C O R E : "+score,415,410);
            //         ctx.fillText(" Press R to restart ",385,450);
            //         speed=0;
            //     }
        }
        function Cuadraro(x,y,w,h,c){
            this.x = x;
            this.y = y;
            this.w = w;
            this.h = h;
            this.c = c;
            this.se_tocan = function (target) { 
                if(this.x < target.x + target.w &&
                this.x + this.w > target.x && 
                this.y < target.y + target.h && 
                this.y + this.h > target.y){
                    return true; 
                }  
            };
            this.dibujar = function(ctx){
                ctx.fillStyle=this.c;
                ctx.fillRect(this.x,this.y,this.w,this.h);
                ctx.strokeRect(this.x,this.y,this.w,this.h);
            }
        }
        document.addEventListener('keydown',function(e){
        if(e.keyCode == 87 || e.keyCode == 38){
            direction='up';
        }
        //ritgh
        if(e.keyCode == 83 || e.keyCode == 40){
            direction='down';
        }
        //left
        if(e.keyCode == 65 || e.keyCode == 37){
            direction='left';
        }
        //down
        if(e.keyCode == 68 || e.keyCode == 39){
            direction='rigth';
        }
        //down
        if(e.keyCode == 32){
            pause=(pause)?false:true;
        }
        //RESTART
        if(e.keyCode == 114 || e.keyCode == 82 ){
            location.reload();
        }
        })
        function generateRandomInteger(max) {
            return Math.floor(Math.random() * max) + 1;
        }
        window.addEventListener('load',start)
        window.requestAnimationFrame = (function () {
            return window.requestAnimationFrame ||
                window.webkitRequestAnimationFrame ||
                window.mozRequestAnimationFrame ||
                function (callback) {
                    window.setTimeout(callback, 17);
                };
        }());
        function rbgaRand() {
            var o = Math.round, r = Math.random, s = 255;
            return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
        }
        
    </script>
</body> 
</html>