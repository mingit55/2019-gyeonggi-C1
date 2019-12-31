class Tool {
    constructor(app){
        this.app = app;
        this.canvas = app.canvas;
        this.ctx = app.canvas.ctx;

        this.strokeStyle = this.canvas.strokeStyle;
        this.fillStyle = this.canvas.fillStyle;
        this.lineWidth = this.canvas.lineWidth;
    }
}