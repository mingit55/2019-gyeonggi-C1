class Fill extends Tool {
    constructor(){
        super(...arguments);

        this.startColor = null;
        // width: 배열의 너비, height: 배열의 높이
        // data: 한 픽셀당 4개의 인덱스로 이뤄진 배열 (r, g, b, a)
        this.imageData = this.ctx.getImageData(0, 0, this.app.width, this.app.height);

        this.changeColor = splitRGBA(this.canvas.fillStyle);
    }

    mousedown(e){
        const {x, y} = this.canvas.toCxy(e);
        this.startColor = Array.from(this.ctx.getImageData(x, y, 1, 1).data);
        if(e.which !== 1) return;
        this.fillOut(x, y);
    }

    mouseup(){
        this.app.unset();
    }

    // 채우기
    fillOut(x, y){
        // 채우기를 실행할 좌표
        let stack = [[x, y]];

        // 채우기를 실행할 좌표들이 남지 않을 때까지 반복
        while(stack.length > 0){    
            // 현재 실행중인 위치 (current_position)
            let now_pos = stack.pop();
            let x = now_pos[0];
            let y = now_pos[1];
            
            // 실제 배열에서의 현 좌표
            let p = (y * this.app.width + x) * 4;

            // 현재 좌표에서 Y축 감소 (위로 상승)
            while( y-- > 0 && this.matchStart(p)){
                p -= this.app.width * 4; // (rgba) 값이 있는 만큼 감소해야 하는 값도 4배
            }
            y++;
            p += this.app.width * 4;

            // 좌우 채우기 가능 여부
            let left = false;
            let right = false;
            
            while(y++ < this.app.height - 1 && this.matchStart(p)){
                this.fillPixel(p);

                // 왼쪽
                if(x > 0){
                    // 바로 왼쪽의 색상이 처음 색상과 일치하면서
                    if(this.matchStart(p - 4)){ 
                        // 왼쪽에서 배열에 추가한 적이 없다면
                        if(!left){ 
                            // 새롭게 추가 (최외곽 while문에서 반응)
                            stack.push([x - 1, y]); 
                            left = true;
                        }
                    }
                    else if(left === true){
                        left = false;
                    }
                }
                
                // 오른쪽 (왼쪽과 동일, 방향과 x값만 다름)
                if(x < this.app.width - 1){
                    if(this.matchStart(p + 4)){
                        if(!right){
                            stack.push([x + 1, y]);
                            right = true;
                        }
                    }
                    else if(right === true){
                        right = false;
                    }
                }

                p += this.app.width * 4;
            }
            
        }
    }

    // 해당 위치의 색상을 변경할 색으로 바꿈
    fillPixel(pos){
        this.imageData.data[pos] = this.changeColor[0];      // R
        this.imageData.data[pos + 1] = this.changeColor[1];  // G
        this.imageData.data[pos + 2] = this.changeColor[2];  // B
        this.imageData.data[pos + 3] = this.changeColor[3];  // A
    }

    // 해당 좌표가 처음 클릭했을 때 색상과 일치하는 지 확인
    matchStart(pos){
        return this.imageData.data[pos] === this.startColor[0]
                && this.imageData.data[pos + 1] === this.startColor[1]
                && this.imageData.data[pos + 2] === this.startColor[2]
                && this.imageData.data[pos + 3] === this.startColor[3]
    }

    redraw(){
        this.ctx.putImageData(this.imageData, 0, 0);    
    }
}   