class Curve extends Tool {
    constructor(){
        super(...arguments);

        this.history = [];
        this.support = [];
        this.lineTemp = null;
        this.s_main = null;
        this.s_sub = null;
    }


    mousedown(e){
        if(e.which !== 1) return;
        if(!this.s_main && !this.canvas.contains(e)) return;

        const {x, y} = this.canvas.toCxy(e);
        

        this.support.push({x: x, y: y});

        if(this.s_main){
            this.s_sub = {
                sx1: this.s_main.mx,
                sy1: this.s_main.my,
                sx2: this.s_main.sx2,
                sy2: this.s_main.sy2,
            };
        }

        this.s_main = {
            mx: x,
            my: y,
            sx1: x, 
            sy1: y, 
            sx2: x, 
            sy2: y,
        };
    }

    mousemove(e){
        if(!this.lineTemp && !this.s_main) return;

        const {x, y} = this.canvas.toCxy(e);

        if(this.s_main && e.which === 1){
            this.s_main.sx1 = 2 * this.s_main.mx - x;
            this.s_main.sy1 = 2 * this.s_main.my - y;
            this.s_main.sx2 = x;
            this.s_main.sy2 = y;

            if(this.lineTemp){
                this.lineTemp.sx2 = 2 * this.s_main.mx - x;
                this.lineTemp.sy2 = 2 * this.s_main.my - y;
            }
        }
        else if(e.which === 0 && this.lineTemp){
            this.lineTemp.toX = x;
            this.lineTemp.toY = y;
            this.lineTemp.sx2 =  x;
            this.lineTemp.sy2 = y;
        }
    }

    mouseup(e){
        if(e.which !== 1) return;

        const {x, y} = this.canvas.toCxy(e);

        if(this.lineTemp){
            this.history.push(this.lineTemp);
        }

        this.lineTemp = {
            sx1: this.s_main.sx2,
            sy1: this.s_main.sy2,
            sx2: x,
            sy2: y,
            fromX: this.s_main.mx,
            fromY: this.s_main.my,
            toX: x,
            toY: y,
        }
    }

    keydown(e){
        if(e.keyCode === 13){
            this.lineTemp = null;
            this.s_main = null;
            this.s_sub = null;
            this.support = [];
            this.app.unset();
        }
    }


    redraw(){
        this.history.forEach(item => {
            this.ctx.strokeStyle = this.strokeStyle;
            this.ctx.lineWidth = this.lineWidth;
            this.ctx.beginPath();
            this.ctx.moveTo(item.fromX, item.fromY);
            this.ctx.bezierCurveTo(item.sx1, item.sy1, item.sx2, item.sy2, item.toX, item.toY);
            this.ctx.stroke();
        });


        if(this.lineTemp){
            const LT = this.lineTemp;
            
            this.ctx.strokeStyle = App.subColor;
            this.ctx.lineWidth = 1;
            this.ctx.beginPath();
            this.ctx.moveTo(LT.fromX, LT.fromY);
            this.ctx.bezierCurveTo(LT.sx1, LT.sy1, LT.sx2, LT.sy2, LT.toX, LT.toY);
            this.ctx.stroke();
        }

        if(this.s_main){
            this.ctx.lineWidth = 1;
            this.ctx.strokeStyle = App.subColor;

            this.ctx.beginPath();
            this.ctx.moveTo(this.s_main.sx1, this.s_main.sy1);
            this.ctx.lineTo(this.s_main.sx2, this.s_main.sy2);
            this.ctx.stroke();

            this.ctx.fillStyle = "#fff";
            
            this.ctx.beginPath();
            this.ctx.arc(this.s_main.sx1, this.s_main.sy1, 3, 0, 2 * Math.PI);
            this.ctx.fill();
            this.ctx.stroke();

            this.ctx.beginPath();
            this.ctx.arc(this.s_main.sx2, this.s_main.sy2, 3, 0, 2 * Math.PI);
            this.ctx.fill();
            this.ctx.stroke();
        }

        if(this.s_sub){
            this.ctx.lineWidth = 1;
            this.ctx.strokeStyle = App.subColor;
            this.ctx.beginPath();
            this.ctx.moveTo(this.s_sub.sx1, this.s_sub.sy1);
            this.ctx.lineTo(this.s_sub.sx2, this.s_sub.sy2);
            this.ctx.stroke();

            this.ctx.arc(this.s_sub.sx2, this.s_sub.sy2, 3, 0, 2 * Math.PI);
            this.ctx.stroke();
        }

        this.support.forEach(item => {
            this.ctx.fillStyle = App.subColor;
            this.ctx.beginPath();
            this.ctx.arc(item.x, item.y, 3, 0, 2 * Math.PI);
            this.ctx.fill();
        });
    }
}