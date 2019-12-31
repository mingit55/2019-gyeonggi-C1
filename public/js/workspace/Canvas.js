class Canvas {
    constructor(app){
        this.app = app;
        this.root = document.createElement("canvas");
        this.root.width = app.width;
        this.root.height = app.height;
        this.ctx = this.root.getContext('2d');
        this.ctx.lineCap = "round";
        app.canvas_wrap.append(this.root);

        this.lineWidth = 1;
        this.strokeStyle = "rgba(0, 0, 0, 1)";
        this.fillStyle = "rgba(0, 0, 0, 1)";
        this.corner = 3;

        this.drawList = [];

        requestAnimationFrame(() => {
            this.frame();
        });
    }

    toCxy(e){
        let x = e.clientX - this.root.offsetLeft;
        let y = e.clientY - this.root.offsetTop;
        x = x < 0 ? 0 : x > this.root.width ? this.root.width : x;
        y = y < 0 ? 0 : y > this.root.height ? this.root.height : y;
        return {x: x, y: y};
    }

    contains(e, exactly = false){
        let result = e.clientX >= this.root.offsetLeft 
                        && e.clientX <= this.root.offsetLeft + this.root.offsetWidth 
                        && e.clientY >= this.root.offsetTop
                        && e.clientY <= this.root.offsetTop + this.root.offsetHeight;
        return exactly ? e.target === this.root : result;
    }

    frame(){
        this.render();
        requestAnimationFrame(() => {
            this.frame();
        });
    }

    render(){
        this.ctx.fillStyle = "#fff";
        this.ctx.fillRect(0, 0, this.root.width, this.root.height);
        this.drawList.forEach( item => {
            item.redraw();
        });
    }

    option(key, value){
        if(key === "color") {
            this.fillStyle = value;
            this.strokeStyle = value;
        }
        else this[key] = value;
    }
}