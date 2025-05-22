const canvas = document.getElementById("rainForest");
        const ctx = canvas.getContext("2d");
        canvas.width = 400;
        canvas.height = 400;

        class  Drop {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.length = Math.random() * 40 + 20;
                this.speed = 4;
            }
            fall() {
                this.y += this.speed;
                if(this.y > canvas.height){
                    this.y = 0;
                    this.x = Math.random() * canvas.width;
                }
            }
            draw() {
                ctx.beginPath();
                ctx.moveTo(this.x, this.y);
                ctx.lineTo(this.x, this.y + this.length);
                ctx.strokeStyle = "black";
                ctx.lineWidth = 3;
                ctx.stroke();
            }
        }

        let drops = [];
        for(let i = 0; i < 20; i++){
            drops.push(new Drop());
        }

        function animate(){
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            drops.forEach(drop => {
                drop.fall();
                drop.draw();
            });
            requestAnimationFrame(animate);
        }

        animate();