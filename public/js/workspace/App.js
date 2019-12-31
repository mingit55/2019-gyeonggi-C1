Math.distance = function(a, b){
    return Math.sqrt(a * a + b * b);
};

Math.parse360 = function(radian){
    return radian * 180 / Math.PI;
}


function hex2dec(hex){
    hex = hex.toLowerCase();
    if(hex < 10) return hex;
    else if(hex === "a") return 10;
    else if(hex === "b") return 11;
    else if(hex === "c") return 12;
    else if(hex === "d") return 13;
    else if(hex === "e") return 14;
    else if(hex === "f") return 15;
    else return "";
}

function prettyRGB(r, g, b, a = null){
    let arr = [r, g, b];

    a !== null ? arr.push(a) : arr.push(1);
    
    let result = "rgba";
    result += `(${arr.join(", ")})`;
    return result;
}

function splitRGBA(rgba){
    let regexp = /^rgba\(([0-9]{1,3}),\s([0-9]{1,3}),\s([0-9]{1,3}),\s([0-9]{1,3})\)$/g;
    let arr = Array.from(regexp.exec(rgba));
    arr.shift();
    arr = arr.map(x => parseInt(x));
    return arr;
}

function hex2rgb(hex){
    hex = hex.replace("#", "");
    if(hex.length < 6){
        let split = hex.split("");
        hex = split[0] + split[0] + split[1] + split[1] + split[2] + split[2];
    }

    let split = hex.split("");
    let rgb = [];
    rgb[0] = parseInt(hex2dec(split[0]) * 16 + hex2dec(split[1]));
    rgb[1] = parseInt(hex2dec(split[2]) * 16 + hex2dec(split[3]));
    rgb[2] = parseInt(hex2dec(split[4]) * 16 + hex2dec(split[5]));
    rgb[3] = 1;

    return rgb;
}

class App {
    static subColor = "#61C4EC";

    constructor(aside, canvas_wrap){
        this.type = "pen";
        this.aside = document.querySelector(aside);
        this.canvas_wrap = document.querySelector(canvas_wrap);
        this.width = this.canvas_wrap.offsetWidth;
        this.height = this.canvas_wrap.offsetHeight;

        this.canvas = new Canvas(this);

        /* Tools */
        this.pen = () => new Pen(this);
        this.curve = () => new Curve(this);
        this.figure = () => new Figure(this);
        this.compass = () => new Compass(this);
        this.ruler = () => new Ruler(this);
        this.fill = () => new Fill(this);
        this.eraser = () => new Eraser(this);

        /* Option */
        this.o_wrap = document.querySelector("#options .list");
        this.o_color = document.createElem(`<div class="form-group">
                                                <label for="color">색상</label>
                                                <div class="picker-open form-control">
                                                    <label for="color" id="color-label"></label>
                                                    <input type="text" hidden name="color" id="color">
                                                </div>
                                            </div>`);
        this.o_width = document.createElem(`<div class="form-group">
                                                <label for="line-width">굵기</label>
                                                <select id="line-width" class="form-control" name="lineWidth">
                                                    <option value="1">1px</option>
                                                    <option value="2">2px</option>
                                                    <option value="4">4px</option>
                                                    <option value="8">8px</option>
                                                    <option value="12">12px</option>
                                                    <option value="16">16px</option>
                                                    <option value="32">32px</option>
                                                </select>
                                            </div>`);
        this.o_corner = document.createElem(`<div class="form-group">
                                                <label for="corner">각의 개수</label>
                                                <select id="corner" class="form-control" name="corner">
                                                    <option value="3">3개</option>
                                                    <option value="4">4개</option>
                                                    <option value="5">5개</option>
                                                    <option value="6">6개</option>
                                                    <option value="7">7개</option>
                                                    <option value="8">8개</option>
                                                    <option value="9">9개</option>
                                                    <option value="10">10개</option>
                                                    <option value="11">11개</option>
                                                    <option value="12">12개</option>
                                                    <option value="13">13개</option>
                                                    <option value="14">14개</option>
                                                    <option value="15">15개</option>
                                                    <option value="16">16개</option>
                                                    <option value="17">17개</option>
                                                    <option value="18">18개</option>
                                                    <option value="19">19개</option>
                                                    <option value="20">20개</option>
                                                </select>
                                            </div>`);

        this.o_wrap.append(this.o_width);
        this.o_wrap.append(this.o_color);
        this.action = null;

        this.colorPicker = new ColorPicker("#color", "#color-label");
        
        this.eventTrigger();
    }

    eventTrigger(){
        // 툴 선택
        this.aside.querySelectorAll("#tools .tool").forEach((x, i) => {
            x.addEventListener("dblclick", e => {
                if(this.action) return false;
                this.type = e.target.dataset.key;
                document.querySelector("#tools .tool.active").classList.remove("active");
                x.classList.add("active");

                this.o_wrap.innerHTML = "";
                switch(this.type){
                    case "figure": 
                        this.o_wrap.append(this.o_corner);
                        this.o_wrap.append(this.o_width);
                        this.o_wrap.append(this.o_color);
                        break;
                    case "fill":
                        this.o_wrap.append(this.o_color);
                        break;
                    case "eraser":
                        this.o_wrap.append(this.o_width);
                        break;
                    default:
                        this.o_wrap.append(this.o_width);
                        this.o_wrap.append(this.o_color);
                    
                }
            });
        });

        // 옵션 선택
        const o_event = e => this.canvas.option(e.target.name, e.target.value);
        this.colorPicker.input.addEventListener("changecolor", o_event);
        this.o_width.addEventListener("change", o_event);
        this.o_corner.addEventListener("change", o_event);
        


        window.addEventListener("mousedown", e => {
            if(this.action === null && this.canvas.contains(e, true)) {
                this.action = this[this.type]();
                this.canvas.drawList.push(this.action);
            }
            if(this.action && this.action.mousedown) this.action.mousedown(e);
        });

        window.addEventListener("mousemove", e => {
            if(this.action === null) return;
            if(this.action && this.action.mousemove) this.action.mousemove(e);
        });

        window.addEventListener("mouseup", e => {
            if(this.action === null) return;
            if(this.action && this.action.mouseup) this.action.mouseup(e);
        });

        window.addEventListener("keydown", e => {
            if(this.action === null) return;
            if(this.action && this.action.keydown) this.action.keydown(e);
        });


        // 다운로드
        document.querySelector("#download").addEventListener("click", e => {
            let a_tag = document.createElement("a");
            a_tag.download = "artwork.jpg";
            a_tag.href = this.canvas.root.toDataURL("image/jpeg");
            document.body.append(a_tag);
            a_tag.click();
            a_tag.remove();
        });
    }

    unset(){
        this.action = null;
    }
};


window.addEventListener("load", () => {
    const workspace = new App("aside", "#main-canvas");
});