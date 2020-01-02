<!-- Unique -->
<link rel="stylesheet" href="css/mypage.css">
<link rel="styleshet" href="css/gallery-info.css">

<div id="add-artwork" class="section">
    <div class="inline">
        <h3 class="font-weight-bold">새로운 작품 추가</h3>
        <form class="mt-5" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">작품 이미지</label>
                <small class="text-muted ml-2">10MB 이내의 jpg, jpeg, png 파일만 업로드할 수 있습니다.</small>
                <div class="custom-file">
                    <input type="file" id="image" name="image" class="custom-file-input" required>
                    <label for="image" class="custom-file-label">작품 이미지를 선택하세요!</label>
                </div>
            </div>
            <div class="form-group">
                <label for="title">작품명</label>
                <input type="text" id="title" name="title" class="form-control" placeholder="작품의 이름을 입력하세요!" required>
            </div>
            <div class="form-group">
                <label for="description">소개</label>
                <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="작품을 소개할 수 있는 간단한 소개글을 적어보세요!" required></textarea>
            </div>
            <div class="form-group mb-5">
                <label for="size-x">사이즈</label>
                <small class="text-muted ml-2">인치 단위로 작성해 주시기 바랍니다.</small>
                <div class="d-flex align-items-center">
                    <input type="number" id="size-x" class="size-input form-control" name="size_x" style="width: 100px;" min="1" required>
                    <span class="mx-3">&times;</span>
                    <input type="number" id="size-y" class="size-input form-control" name="size_y" style="width: 100px;" min="1" requried>
                </div>
            </div>
            <button type="submit" id="submit-btn" class="border-btn" style="width: 200px;">추가하기</button>
        </form>
    </div>
</div>

<script>
    window.addEventListener("load", () => {
        let submit = false;
        const submitBtn = document.querySelector("#submit-btn");

        function disable(message){
            alert(message);
            submit = false;
            submitBtn.disabled = true;
            return false;
        }

        const image = document.querySelector("#image");

        function imageCheck(){
            let file = image.files[0];
            let possible_ext = ["jpg", "jpeg", "png"];

            if(!file) return disable("작품 이미지를 선택해 주세요!");
            if(!possible_ext.includes(file.name.substr(-3).toLowerCase())) return disable(possible_ext.join(", ") + " 확장자 파일만 업로드 할 수 있습니다.");
            if(file.size > 1024 * 1024 * 10) return disable("10MB 이내의 파일만 업로드할 수 있습니다.");
            submit = true;
            submitBtn.disabled = false;
            
            image.nextElementSibling.innerText = file.name;
        };  

        image.addEventListener("change", imageCheck);

        function sizeCheck(size){
            if(size < 1) return disable("사이즈는 1인치 이상이여야 합니다.");
            submit = true;
            submitBtn.disabled = false;
        }

        let x_timer;
        let size_x = document.querySelector("#size-x");
        size_x.addEventListener("keydown", e => {
            if(x_timer) clearTimeout(x_timer);
            x_timer = setTimeout(() => sizeCheck(e.target.value), 500);
        });

        let y_timer;
        let size_y = document.querySelector("#size-y");
        size_y.addEventListener("keydown", e => {
            if(y_timer) clearTimeout(y_timer);
            y_timer = setTimeout(() => sizeCheck(e.target.value), 500);
        });
        
        const form = document.querySelector("form");
        form.addEventListener("submit", e => {
            imageCheck()
            && sizeCheck(size_x.value)
            && sizeCheck(size_y.value);

            if(!submit) e.preventDefault();
        });

        
    });
</script>