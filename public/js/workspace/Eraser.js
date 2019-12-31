class Eraser extends Tool {
    constructor(){
        super(...arguments);
        this.history = [];
    }

    mousedown(e){
        if(e.which !== 1) return;
        const { x, y } = this.canvas.toCxy(e);
        this.history.push({x: x, y: y});
        console.log("mousedown");
    }

    mousemove(e){
        if(e.which !== 1) return;
        const { x, y } = this.canvas.toCxy(e);
        this.history.push({x: x, y: y});
        console.log("mousemove");
    }

    mouseup(e){
        if(e.which !== 1) return;
        this.app.unset();
        console.log("mouseup");
    }

    redraw(){
        if(this.history.length > 0){
            this.ctx.lineWidth = this.lineWidth;
            this.ctx.strokeStyle = "#fff";
            this.ctx.beginPath();
            this.ctx.moveTo(this.history[0].x, this.history[0].y);
            this.history.forEach( item => {
                this.ctx.lineTo(item.x, item.y);
            });
            this.ctx.stroke();
        }
    }
}