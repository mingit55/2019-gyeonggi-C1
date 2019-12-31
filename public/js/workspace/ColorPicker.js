class ColorPicker {
    static changecolor = new CustomEvent("changecolor");

    set color(color){
        if(typeof color === "string") color = hex2rgb(color);

        this.input.value = prettyRGB(color[0], color[1], color[2], color[3]);
        this.label.style.backgroundColor = prettyRGB(color[0], color[1], color[2]);
        this.label.style.opacity = color[3];
        
        this.input.dispatchEvent(ColorPicker.changecolor);
    }

    constructor(input, label){
        this.open = false;

        this.input = document.querySelector(input);
        this.input.value = "rgba(0, 0, 0, 1)";

        this.label = document.querySelector(label);
        this.label.style.backgroundColor = "rgba(0, 0, 0, 1)";

        this.root = document.querySelector("#colorPicker");
        this.main_canvas = this.root.querySelector(".main canvas");
        this.mctx = this.main_canvas.getContext("2d");


        this.sub_canvas = this.root.querySelector(".sub canvas");
        this.sctx = this.sub_canvas.getContext("2d");

        this.opac_canvas = this.root.querySelector(".opacity canvas");
        this.octx = this.opac_canvas.getContext("2d");

        this.init();
        this.eventTrigger();
    }

    init(){
        this.setMainColor("#ff0000");
        this.setOpacityColor("#000000");
        this.setSubColor();
    }

    setMainColor(color){
        const {width, height} = this.main_canvas;
        // console.log(color);

        this.mctx.clearRect(0, 0, width, height);
        this.mctx.fillStyle = color;
        this.mctx.fillRect(0, 0, width, height);

        let grd;
        grd = this.mctx.createLinearGradient(0, 0, width, 0);
        grd.addColorStop(0, "rgba(255, 255, 255, 255)");
        grd.addColorStop(1, "rgba(255, 255, 255, 0)");
        this.mctx.fillStyle = grd;
        this.mctx.fillRect(0, 0, width, height);

        grd = this.mctx.createLinearGradient(0, 0, 0, height);
        grd.addColorStop(0, "transparent");
        grd.addColorStop(1, "rgba(0, 0, 0, 255)");
        this.mctx.fillStyle = grd;
        this.mctx.fillRect(0, 0, width, height);
    }

    setOpacityColor(color){
        const {width, height} = this.opac_canvas;

        if(typeof color === "string") color = hex2rgb(color);
        
        
        let grd = this.octx.createLinearGradient(0, 0, 0, height);
        grd.addColorStop(0, `rgba(${color[0]}, ${color[1]}, ${color[2]}, 255)`);
        grd.addColorStop(1, `rgba(${color[0]}, ${color[1]}, ${color[2]}, 0)`);
    
        this.octx.clearRect(0, 0, width, height);
        this.octx.fillStyle = grd;
        this.octx.fillRect(0, 0, width, height);
    }

    setSubColor(){
        const {width, height} = this.sub_canvas;

        let grd;
        grd = this.sctx.createLinearGradient(0, 0, this.sub_canvas.width, this.sub_canvas.height);
        grd.addColorStop(0.0, "#f00");
        grd.addColorStop(0.166, "#ff0");
        grd.addColorStop(0.333, "#0f0");
        grd.addColorStop(0.499, "#0ff");
        grd.addColorStop(0.666, "#00f");
        grd.addColorStop(0.833, "#f0f");
        grd.addColorStop(1.0, "#f00");

        this.sctx.clearRect(0, 0, width, height);
        this.sctx.fillStyle = grd;
        this.sctx.fillRect(0, 0, width, height);
    }

    show(){
        this.root.style.left = this.label.offsetLeft + this.label.offsetWidth + 50 + "px";
        this.root.style.top = this.label.offsetTop + "px";

        this.root.style.display = "flex";

        this.open = true;
    }

    hide(){
        this.root.style.display = "none";
        this.open = false;
    }

    eventTrigger(){
        this.input.addEventListener("click", e => {
            e.preventDefault();
            this.show();
        });

        // 커서 움직이기
        const canvasEvent = e => {
            if(e.which !== 1 || !e.target.classList.contains("picker")) return;
            let ctx = this[e.target.dataset.context];
            let data = Array.from(ctx.getImageData(e.offsetX, e.offsetY, 1, 1).data);
            let name = e.target.dataset.name;

            data[3] = parseFloat((data[3] / 255).toFixed(2));
            
            if(name === "main") {
                this.color = data;
                this.setOpacityColor(data);
            }
            else if(name === "sub") {
                this.setMainColor( prettyRGB.apply(null, data) );
            }
            else if(name === "opacity"){
                this.color = data;
            }
        };

        window.addEventListener("mousedown", e => canvasEvent(e));
        window.addEventListener("mousemove", e => canvasEvent(e));

        window.addEventListener("mousedown", e => {
            if(this.open){
                try {
                    let target = e.target;
                    while( (! target.id || target.id !== "colorPicker") && target.nodeName !== "body") target = target.parentElement;
                    if(target.id !== "colorPicker"){
                        this.hide();
                    }
                }
                catch(e){
                    this.hide();
                }
            }
        });
    }
}