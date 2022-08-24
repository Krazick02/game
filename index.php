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
        
        background-color: white;
        
    }
</style>
<body>
    <canvas id="mycanvas" width="500" height="500"></canvas>
    <script type ="text/javascript">
        var cv  =null;
        var ctx  = null;
        var superX=240,superY=240;
        var player=null;
        var player2=null;
        var score=0;
        var direction='left';
        var pause=false;

        function start(){
             cv  =document.getElementById('mycanvas');
             ctx  = cv.getContext('2d');
            player =new Cuadraro(superX,superY,40,40,'red');
            player2 =new Cuadraro(generateRandomInteger(500),generateRandomInteger(500),40,40,'red');
             paint();
        }
        function paint(){
            window.requestAnimationFrame(paint);
            ctx.fillStyle ='white';
            ctx.fillRect(0,0,500,500);
            

            ctx.fillStyle="black";                
            ctx.fillText("SCORE :"+score,30,30);

            player.c=rbgaRand();
            player.dibujar(ctx);

            player2.c=rbgaRand();
            player2.dibujar(ctx);

            if(pause){
                ctx.fillStyle="rgba(0,0,0,0.5)";                
                ctx.fillRect(0,0,500,500);
                ctx.fillStyle="black";                
                ctx.fillText("P A U S E",230,230);
            }else{
                update();
            }
        }
        function update(){
            if(direction=='rigth'){
                player.x +=10;
                if(player.x >= 500){
                    player.x = 0;
                }
            }
            if(direction=='down'){
                player.y +=10;
                if(player.y >= 500){
                    player.y = 0;
                }
            }
            if(direction=='up'){
                player.y -=10;
                if(player.y <= 0){
                    player.y = 500;
                }
            }
            if(direction=='left'){
                player.x -=10;
                if(player.x <= 0){
                    player.x = 500;
                }
            }

            if(player.se_tocan(player2)){
                player2.x=generateRandomInteger(500);
                player2.y=generateRandomInteger(500);

                score+=5;

                
            }
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