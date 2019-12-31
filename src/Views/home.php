<!-- Unique -->
<link rel="stylesheet" href="/css/index.css">
<link rel="stylesheet" href="/css/gallery-list.css">

<!-- 슬라이드 영역 -->
<input type="radio" id="slide1" name="slider" hidden="hidden" checked>
<input type="radio" id="slide2" name="slider" hidden="hidden">
<input type="radio" id="slide3" name="slider" hidden="hidden">
<div id="slider" class="section">
    <div class="text">
        <h5>색채의 물결, 미술의 바다</h5>
        <h1><span>BIAF</span> 2019</h1>
    </div>
    <div class="images">
        <div class="item" data-idx="1"></div>
        <div class="item" data-idx="2"></div>
        <div class="item" data-idx="3"></div>
    </div>
    <div class="process">
        <label for="slide1" data-idx="1" class="btn"></label>
        <label for="slide2" data-idx="2" class="btn"></label>
        <label for="slide3" data-idx="3" class="btn"></label>
    </div>
</div>
<!-- 인기 갤러리 -->
<div id="gallery" class="section">

    <div class="inline">
        <div class="section-title">
            <h5>인기 갤러리</h5>
            <h1>Popular Gallery</h1>
        </div>
        <div class="contents mt-3">
            
        </div>
    </div>
</div>

<script src="/js/sort.js"></script>
<script type="text/javascript">
    window.onload = () => {
        let sno = 0;
        let slide = () => {
            Array.from(document.querySelectorAll("#slider .process .btn"))[sno].click();
            setTimeout(() => {
                sno = sno + 1 >= 3 ? 0 : sno + 1;
                slide();
            }, 5000);
        };
        slide(0);

        document.querySelectorAll("#slider .process .btn").forEach((x, i) => {
            x.addEventListener("click", () => sno = i);
        });

        function galleryTemplate(data){
            let html =  `<div class="item">
                            <span class="name font-weight-bold mr-2">${data.name}</span>
                            <span class="country text-muted">${data.country}</span>
                            <p class="description mt-3">${data.description}</p>
                            <a href="/gallery/info?id=${data.id}" class="btn mt-2">자세히 보기</a>
                        </div>`;
            let parent = document.createElement("div");
            parent.innerHTML = html;
            return parent.firstChild;
        }
        
        const contents = document.querySelector("#gallery .contents");

        // AJAX
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/gallery/popular-list");
        xhr.send();
        xhr.onload = () => {
            let response = JSON.parse(xhr.responseText);
            
            // 목표 정렬 순서 :: 한글 - 영문 (대소문자 구분 X) - 숫자 - 그 외
            response.customSort("name").forEach((data, i) => {
                let row = galleryTemplate(data);
                row.style.opacity = "0";
                row.style.transition = "opacity 0.5s linear";
                contents.append(row);

                setTimeout(() => {
                    row.style.opacity = "1";
                }, 250 * i);
            });
        };
    };
</script>

