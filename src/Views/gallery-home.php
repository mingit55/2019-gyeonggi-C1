<!-- Unique -->
<link rel="stylesheet" href="css/gallery-list.css">

<!-- 인기 갤러리 -->
<div id="gallery" class="section">

    <div class="inline">
        <div class="section-title">
            <h5>갤러리 목록</h5>
            <h1>Gallery List</h1>
        </div>
        <div class="contents mt-3">
        </div>
        <!-- <div id="pagination" class="mt-5">
            <button class="prev">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>
            </button>
            <button class="page active">1</button>
            <button class="page">2</button>
            <button class="page">3</button>
            <button class="page">4</button>
            <button class="page">5</button>
            <button class="next">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>
            </button>
        </div> -->
    </div>
</div>

<script src="/js/sort.js"></script>
        <script>
            window.addEventListener("load" , e => {
                function galleryTemplate(data){
                    let parent = document.createElement("div");
                    parent.innerHTML =  `<div class="item">
                                            <span class="name font-weight-bold mr-2">${data.name}</span><span class="country text-muted">${data.country}</span>
                                            <p class="description mt-3">${data.description}</p>
                                            <a href="/gallery/info?id=${data.id}" class="btn mt-2">자세히 보기</a>
                                        </div>`;
                    return parent.firstChild;
                }

                
            
                // 모든 갤러리 리스트 가져오기
                const wrap = document.querySelector("#gallery .contents");
                const html = document.querySelector("html");

                let xhr = new XMLHttpRequest();
                xhr.open("POST", `/gallery/take-list`);
                xhr.send();
                xhr.onload = () => {
                    let response = JSON.parse(xhr.responseText);
                    let galleryList = response.customSort("name");
                    
                    popView();

                    document.addEventListener("scroll", function(e){
                        let max = html.scrollHeight - window.innerHeight;
                        if(max === html.scrollTop){
                            popView();
                        }
                    });
                
                    // galleryList 에서 10개씩 꺼내서 보여주는 함수
                    function popView(){
                        let viewList = galleryList.slice(0, 10);
                        galleryList.splice(0, 10);
                        viewList.forEach((x, i) => {
                            let view = galleryTemplate(x);
                            view.style.opacity = '0';
                            view.style.transition = "opacity 0.4s";
                            wrap.append(view);

                            setTimeout(() => {
                                view.style.opacity = '1';
                            }, i * 250);
                        });
                    }
                };
                
                
                
            }); 
        </script>
