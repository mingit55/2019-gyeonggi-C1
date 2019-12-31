class Figure extends Tool {
    constructor(){
        super(...arguments);
        
        this.angle = 0;
        this.length = 0;
        this.cx = 0;
        this.cy = 0;
        
        this.corner = this.canvas.corner;
    }

    mousedown(e){
        if(e.which !== 1) return;
        const {x, y} = this.canvas.toCxy(e);
        this.cx = x;
        this.cy = y;       
        const unit = 2 * Math.PI / this.corner;
    }

    mousemove(e){
        if(e.which !== 1) return;
        const {x, y} = this.canvas.toCxy(e);       
        
        let width = (this.cx - x);
        let height = (this.cy - y);
        
        this.length = Math.sqrt(Math.pow(width, 2) + Math.pow(height, 2));
        this.angle = Math.atan2(height, width);

        
        this.angle += Math.PI;
    }

    mouseup(e){
        if(e.which !== 1) return;
        this.app.unset();

    }

    redraw(){
        const unit = Math.PI / this.corner;

        let x, y;
        x = this.cx + Math.cos(this.angle) * this.length;
        y = this.cy + Math.sin(this.angle) * this.length;

        this.ctx.beginPath();
        this.ctx.moveTo(x, y);

        this.ctx.strokeStyle = this.strokeStyle;
        this.ctx.lineWidth = this.lineWidth;

        for(let i = 1; i <= this.corner; i++){
            let angle = this.angle + unit * i;
            x = this.cx + Math.cos(angle + unit * i) * this.length;
            y = this.cy + Math.sin(angle + unit * i) * this.length;
            this.ctx.lineTo(x, y);
        }

        x = this.cx + Math.cos(this.angle) * this.length;
        y = this.cy + Math.sin(this.angle) * this.length;
        this.ctx.lineTo(x, y);
        this.ctx.closePath();

        this.ctx.stroke();

        // console.log(this.fillStyle, this.strokeStyle);
        this.ctx.fillStyle = this.fillStyle;
        this.ctx.fill();
    }
}