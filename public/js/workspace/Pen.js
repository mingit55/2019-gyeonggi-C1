class Pen extends Tool {
    constructor(){
        super(...arguments);
        this.history = [];
    }

    mousedown(e){
        if(e.which !== 1) return;

        const {x, y} = this.canvas.toCxy(e);
        this.history.push({x: x, y: y});
    }

    mousemove(e){       
        if(e.which !== 1) return;

        const {x, y} = this.canvas.toCxy(e);
        this.history.push({x: x, y: y});
    }

    mouseup(e){
        if(e.which !== 1) return;
        this.app.unset();
    }

    redraw(){
        this.ctx.lineWidth = this.lineWidth;
        this.ctx.strokeStyle = this.strokeStyle;

        this.ctx.beginPath();
        this.ctx.moveTo(this.history[0].x, this.history[0].y);
        let hl = this.history.length;
        for(let i = 0; i < hl; i++){
            let draw = this.history[i];
            this.ctx.lineTo(draw.x, draw.y);
        }
        this.ctx.stroke();
        this.ctx.closePath();
    }
}