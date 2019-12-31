<!-- Unique -->
<link rel="stylesheet" href="/css/join.css">


<div id="join" class="section">
    <div class="inline">
        <div class="section-title text-center">
            <h5>회원가입</h5>
            <h1>Sign Up</h1>
        </div>
        <form class="my-5" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="user_id" class="font-weight-bold">아이디</label>
                <input type="text" id="user_id" class="form-control" name="user_id" placeholder="[영어/한글/숫자] 10자 이하, 숫자로만 이뤄질 수 없음">
            </div>
            <div class="form-group">
                <label for="user_name" class="font-weight-bold">이름</label>
                <input type="text" id="user_name" class="form-control" name="user_name" placeholder="[한글] 10자 이하">
            </div>
            <div class="form-group">
                <label for="password" class="font-weight-bold">비밀번호</label>
                <input type="password" id="password" class="form-control" name="password" placeholder="[영어/숫자/특수문자] 모두 포함, 10자 이하, 4~10자">
            </div>
            <div class="form-group">
                <label for="image" class="font-weight-bold">프로필 사진</label>
                <small class="text-muted">10MB까지 업로드 할 수 있습니다.</small>
                <div class="custom-file">
                    <input type="file" id="image" class="custom-file-input" name="image" accept="image/*">
                    <label for="image" class="custom-file-label">이미지를 선택하세요….</label>
                </div>
            </div>
            <div class="form-group">
                <label for="comment" class="font-weight-bold">상태 메세지</label>
                <textarea name="comment" id="comment" cols="30" rows="10" class="form-control" placeholder="255자까지 입력하실 수 있습니다…." maxlength="255"></textarea>
            </div>
            <button type="submit" class="btn mt-2" disabled>확인</button>
        </form>
    </div>
</div>

<script>
    let inputList = [
        document.querySelector("#user_id"),
        document.querySelector("#user_name"),
        document.querySelector("#password"),
        document.querySelector("#image"),
        document.querySelector("#comment"),
    ]

    let rules = {
        user_name: [
            name => ({result: /^[ㄱ-ㅎㅏ-ㅣ가-힣]{1,10}$/.test(name), message: "이름은 [한글]로 10자까지만 입력 가능합니다."}),
        ],
        password: [
            pass => ({result: /^(?=.*[a-zA-Z]+)(?=.*[0-9]+)(?=.*[!@#$%^&*]+)([a-zA-Z0-9!@#$%^&*]{4,10})$/.test(pass), message: "암호는 [영문/숫자/특수문자] 조합 4~10자로만 입력 가능합니다."})
        ],
        comment: [
            comment => ({result: comment.length <= 255 && comment.length > 0, message: "메세지는 255자까지만 입력 가능합니다."})
        ]
    };

    let p_submit = false;
    let s_btn = document.querySelector("form button");

    document.createElem = innerHTML => {
        let parent = document.createElement('div');
        parent.innerHTML = innerHTML;
        return parent.firstElementChild;
    };

    function check(target){
        let validator = {result: true, message: ""};
        for(let rule of rules[target.id]){
            let exec = rule(target.value);
            if(!exec.result){
                validator = exec;
                break;
            }
        }
        
        error(target, validator.result, validator.message);

        return validator.result;
    }
    function error(target, result, message = "올바른 양식에 맞추어 입력하세요."){
        let exist = target.nextElementSibling;
        let error_form = document.createElem(`<div class="error-message text-danger mt-2">${message}</div>`);

        if(result){
            if(exist) exist.remove();
            if(true === inputList.reduce((p, c) => p && c.value.trim() !== "", true)){
                p_submit = true;
                s_btn.disabled = "";
            }
        }
        else {
            if(!exist)
                target.parentElement.append(error_form);
            p_submit = false;
            s_btn.disabled = "disabled";
        }
        return result;
    }

    const user_id = document.querySelector("#user_id");
    let id_timer;
    user_id.addEventListener("keydown", function(){
        if(id_timer){
            clearTimeout(id_timer);
        }
        id_timer = setTimeout(() => {
            idCheck(this);
        }, 500);
    });
    function idCheck(target){
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/users/exist?id="+target.value);
        xhr.send();
        
        xhr.onload = () => {
            let response = JSON.parse(xhr.responseText);
            error(target, /^[a-zA-Z0-9ㄱ-ㅎㅏ-ㅣ가-힣]{1,10}$/.test(target.value), "아아디는 [영문/숫자/한글]로 10자까지만 입력 가능합니다.")
            && error(target, !/^[0-9]+$/.test(target.value), "아이디는 숫자로만 이뤄질 수 없습니다.")
            && error(target, response.exist === false, "중복된 아이디 입니다.");
        };
    }

    const user_name = document.querySelector("#user_name");
    let name_timer;
    user_name.addEventListener("keydown", function(){
        if(name_timer){
            clearTimeout(name_timer);
        }
        name_timer = setTimeout(() => {
            check(this);
        }, 500);
    });

    const password = document.querySelector("#password");
    let pass_timer;
    password.addEventListener("keydown", function(){
        if(pass_timer){
            clearTimeout(pass_timer);
        }
        pass_timer = setTimeout(() => {
            check(this);
        }, 500);
    });

    const comment = document.querySelector("#comment");
    let comment_timer;
    comment.addEventListener("keydown", function(){
        if(comment_timer){
            clearTimeout(comment_timer);
        }
        comment_timer = setTimeout(() => {
            check(this);
        }, 500);
    });


    const image = document.querySelector("#image");
    const imageCheck = target => {
        let file = target.files[0];

        error(target.parentElement, file != undefined, "이미지를 선택해 주십시오.")
        && error(target.parentElement, file.type.substr(0, 5) === "image", "이미지 파일만 업로드 할 수 있습니다.")
        && error(target.parentElement, file.size <= 1024 * 1024 * 10, "10MB까지만 업로드 할 수 있습니다.");

        if(file) target.nextElementSibling.innerText = file.name;
    };
    image.addEventListener("change", function(){
        imageCheck(this);
    });

    document.querySelector("form").addEventListener("submit", function(e){
        idCheck(user_id);
        check(user_name);
        check(password);
        check(comment);
        imageCheck(image);
    
        if(!p_submit){
            e.preventDefault();
            return false;
        }
    });
</script>