<!-- Unique -->
<link rel="stylesheet" href="/css/gallery-artwork-add.css">

<input type="hidden" id="gallery_id" value="<?=$gallery->id?>">
<div id="add-artwork" class="section">
    <div class="inline">
        <div id="select-art" class="art-list">
            <span class="title">
                선택한 작품
            </span>
            <table class="list mt-4">
                <thead>
                    <tr>
                        <th>작품 이미지</th>
                        <th>제목</th>
                        <th>아티스트</th>
                        <th>가격</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <form method="post">
                <input type="hidden" id="select-list" name="select-list">
                <input type="hidden" name="gid" value="<?=$gallery->id?>">
                <button id="append-btn" class="border-btn mt-4">추가하기</button>
            </form>
        </div>
        <div id="artworks" class="art-list mt-5">
            <span class="title">
                작품 목록
            </span>
            <table class="list mt-4">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="all-checkbox">
                        </th>
                        <th>작품 이미지</th>
                        <th>제목</th>
                        <th>아티스트</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    document.createTableElem = function(innerHTML){
        let parent = document.createElement("table");
        parent.innerHTML = innerHTML;
        return parent.firstChild.firstChild;
    };

    window.addEventListener("load", () => {
        const selectList = document.querySelector("#select-art tbody");
        const commonList = document.querySelector("#artworks tbody");

        const appendBtn = document.querySelector("#append-btn");



        function rollback(message){
            alert(message);
            appendBtn.disabled = true;
        }

        function priceCheck(target, frame){
            let price = parseInt(target.value);
            if(price < 100000) return rollback("최소 가격은 100,000원 입니다.");
            if(price % 100000 !== 0) return rollback("가격은 100,000원 단위로만 입력할 수 있습니다.");
            appendBtn.disabled = false;
            frame.price = price;
        }

        let gallery_id = document.querySelector("#gallery_id").value;

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/gallery/take-empty-artworks?id="+gallery_id);
        xhr.send();
        xhr.onload = () => {
            let response = JSON.parse(xhr.response);
            let artList = response.artworks.map(x => {
                let frame = {
                    price : 100000,
                    select: false,
                    data: x,
                    commonHTML: document.createTableElem(`<tr>
                                    <td class="checkbox">
                                        <input type="checkbox" class="art-checkbox">
                                    </td>
                                    <td class="image">
                                        <img src="/images/articles/${x.image}" alt="artwork" height="100">
                                    </td>
                                    <td>
                                        ${x.title}
                                    </td>
                                    <td>
                                        ${x.user_name}
                                    </td>
                                </tr>`),
                    selectHTML: document.createTableElem(`<tr>
                                    <td class="image">
                                        <img src="/images/articles/${x.image}" alt="artwork" height="100">
                                    </td>
                                    <td>
                                        ${x.title}
                                    </td>
                                    <td>
                                        ${x.user_name}
                                    </td>
                                    <td class="price">
                                        <input type="number" class="price" step="100000" min="100000" value="100000">
                                    </td>
                                </tr>`),
                };

                frame.commonHTML.querySelector(".art-checkbox").addEventListener("change", e => {
                    frame.select = e.target.checked;
                    view();
                });

                let p_input = frame.selectHTML.querySelector("input.price");

                let input_timer;
                p_input.addEventListener("keydown", e => {
                    if(input_timer){
                        clearTimeout(input_timer);
                    }
                    input_timer = setTimeout(() => {
                        priceCheck(e.target, frame);
                    }, 400);
                });

                return frame;
            });
            
            // View
            function view(){
                commonList.innerHTML = "";

                let no_select = artList.filter(x => !x.select);

                no_select.forEach(x => {
                    commonList.append(x.commonHTML);    
                });
                if(no_select.length === 0){
                    commonList.innerHTML = `<tr><td colspan="4">추가할 수 있는 작품이 없습니다.</td></tr>`;    
                }

                let select = artList.filter(x => x.select);

                selectList.innerHTML = "";
                select.forEach(x => {
                    selectList.append(x.selectHTML);
                });
                if(select.length === 0){
                    selectList.innerHTML = `<tr><td colspan="4">선택할 수 있는 작품이 없습니다.</td></tr>`;    
                    appendBtn.disabled = true;
                }
                else appendBtn.disabled = false;
            }
            view();
        
            
            document.querySelector("#all-checkbox").addEventListener("change", e => {
                artList = artList.map(x => {
                    x.select = e.target.checked;
                    return x;
                });
                view();
            });


            appendBtn.addEventListener("click", e => {
                artList.filter(x => x.select).forEach(x => {
                    let target = x.selectHTML.querySelector("input.price");
                    priceCheck(target, x);
                });
            });
        }
    
    });
</script>
