class Ruler extends Tool {
    constructor(){
        super(...arguments);

        this.select = null;
        this.line = null;
        this.history = [];
    }

    mousedown(e){
        if(e.which !== 1) return;
        
        const {x, y} = this.canvas.toCxy(e);


        if(!this.select) {
            this.select = {
                cx: x,
                cy: y,
                fromX: 0,
                fromY: 0,
                toX: 0,
                toY: 0,
                angle: 0,
            };
        }

        else if(!this.line){
            this.line = {
                fromX: x,
                fromY: y,
                toX: x,
                toY: y,
            }
            this.history.push(this.line);
        }
    }   
    
    mousemove(e){
        const {x, y} = this.canvas.toCxy(e);

        if(e.which === 0 && this.select){
            let angle = Math.atan2(this.select.cy - y, this.select.cx - x);
            if(angle < 0) angle += Math.PI * 2;

            this.select.fromX = this.select.cx + Math.cos(angle) * this.app.width;
            this.select.fromY = this.select.cy + Math.sin(angle) * this.app.width;

            this.select.toX = this.select.cx - Math.cos(angle) * this.app.width;
            this.select.toY = this.select.cy - Math.sin(angle) * this.app.width;

            this.select.angle = angle;
        }

        else if(e.which === 1 && this.line){
            let angle = this.select.angle;
            

            // 보조선의 중앙보다 마우스의 X값이 작으면 방향이 역전됨
            // 이는 Tan 함수가 2,3 사분면에서 음수가 되기 때문
            if(this.select.cx > x){
                angle *= -1;
            }


            // 어디를 선택하든 X값과 보조선 내의 Y값에 선을 그어야 함
            // ∴ 보조선의 각도를 미리 저장해 두고 각도에 맞추어서 삼각함수를 통해 위치를 계산
            // tan = y / x
            // y = tan * x

            if(x < this.line.fromX) {
                this.line.fromX = x;
                this.line.fromY = this.select.cy + Math.tan(angle) * Math.abs(x - this.select.cx);
            }
            if(x > this.line.toX ){
                this.line.toX = x;
                this.line.toY = this.select.cy + Math.tan(angle) * Math.abs(x - this.select.cx);
            }
        }
    }

    mouseup(e){
        if(e.which !== 1) return;

        if(this.line) this.line = null;
    }

    keydown(e) {
        if(e.keyCode === 13) {
            this.select = null;
            this.line = null;
            this.app.unset();
        }
    }

    redraw(){ 
        this.history.forEach(x => {
            this.ctx.strokeStyle = this.strokeStyle;
            this.ctx.lineWidth = this.lineWidth;

            this.ctx.beginPath();
            this.ctx.moveTo(x.fromX, x.fromY);
            this.ctx.lineTo(x.toX, x.toY);
            this.ctx.closePath();

            this.ctx.stroke();
        });

        if(this.select){
            this.ctx.fillStyle = App.subColor;
            this.ctx.strokeStyle = App.subColor;
            this.ctx.lineWidth = 1;

            this.ctx.beginPath();
            this.ctx.arc(this.select.cx, this.select.cy, 3, 0, Math.PI * 2);
            this.ctx.fill();

            this.ctx.beginPath();
            this.ctx.moveTo(this.select.fromX, this.select.fromY);
            this.ctx.lineTo(this.select.toX, this.select.toY);
            this.ctx.closePath();
            this.ctx.stroke();
        }
    }
}
