class Compass extends Tool {
    constructor(){
        super(...arguments);

        this.history = [];

        this.s_angle = 0;
        this.select = null;
        this.draw = null;
    }

    getAngle(y, x){
        let angle = Math.atan2(y, x) + Math.PI;

        return angle;
    }

    mousedown(e){
        if(e.which !== 1 ) return;
        if( !this.select && !this.canvas.contains(e) ) return;
        
        const {x, y} = this.canvas.toCxy(e);

        if(! this.select){
            this.select = {
                cx: x,
                cy: y,
                r: 0,
            };
        }
        else if(! this.draw) {
            this.s_angle = this.getAngle(this.select.cy - y, this.select.cx - x);
            this.draw = {
                cx: this.select.cx,
                cy: this.select.cy,
                radius: this.select.r,
                startAngle: this.getAngle(this.select.cy - y, this.select.cx - x),
                endAngle: this.getAngle(this.select.cy - y, this.select.cx - x)
            };
            this.history.push(this.draw);
        }
    }

    mousemove(e){
        if(!this.select) return;

        const {x, y} = this.canvas.toCxy(e);
        
        if( e.which === 0)
            this.select.r = Math.sqrt(Math.pow(this.select.cx - x, 2) + Math.pow(this.select.cy - y, 2));
        else if( e.which === 1 && this.draw) {
            let angle = this.getAngle(this.select.cy - y, this.select.cx - x)
            console.log(Math.parse360(angle));

            if(this.draw.startAngle > angle) this.draw.startAngle = angle;
            if(this.draw.endAngle < angle) this.draw.endAngle = angle;
        }
    }

    mouseup(e){
        const {x, y} = this.canvas.toCxy(e);

        if(this.draw){
            this.draw = null;
        }
    }

    keydown(e) {
        if(e.keyCode === 13) {
            this.select = null;
            this.draw = null;
            this.app.unset();
        }
    }

    redraw(){
        this.history.forEach(x => {
            this.ctx.strokeStyle = this.strokeStyle;
            this.ctx.lineWidth = this.lineWidth;

            this.ctx.beginPath();
            this.ctx.arc(x.cx, x.cy, x.radius, x.startAngle, x.endAngle);
            this.ctx.stroke();
        });

        if(this.select) {
            this.ctx.fillStyle = App.subColor;
            this.ctx.strokeStyle = App.subColor;
            this.ctx.lineWidth = 1;
            
            this.ctx.beginPath();
            this.ctx.arc(this.select.cx, this.select.cy, 3, 0, Math.PI * 2);
            this.ctx.closePath();
            this.ctx.fill();

            this.ctx.beginPath();
            this.ctx.arc(this.select.cx, this.select.cy, this.select.r, 0, Math.PI * 2);
            this.ctx.closePath();
            this.ctx.stroke();
        }
    }
}