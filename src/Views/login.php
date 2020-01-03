<!-- Unique -->
<link rel="stylesheet" href="/css/login.css">

<div id="login" class="section">
    <div class="inline">
        <div class="section-title text-center">
            <h5>로그인</h5>
            <h1>Sign In</h1>
        </div>
        <form class="my-5" method="post">
            <div class="form-group">
                <label for="user_id" class="font-weight-bold">아이디</label>
                <input type="text" id="user_id" class="form-control" name="user_id" placeholder="아이디를 입력하세요.">
            </div>
            <div class="form-group">
                <label for="password" class="font-weight-bold">비밀번호</label>
                <input type="password" id="password" class="form-control" name="password" placeholder="비밀번호를 입력하세요.">
            </div>
            <button type="submit" class="btn mt-2" disabled>입력 완료</button>
        </form>
        <?php if(prevLoginData()):?>
            <div class="short-login">
                <span class="font-weight-bold">이전에 로그인한 계정으로 재로그인</span>
                <form action="/users/login/prev" method="post" class="d-flex align-items-center mt-4">
                    <div class="image">
                        <img src="/images/users/<?=prevLoginData()->image?>" alt="Profile-image" height="100" width="100">
                    </div>
                    <div class="info ml-4 d-flex flex-column justify-content-center">
                        <div class="form-group">
                            <input type="text" class="form-control" name="user_id" value="<?=prevLoginData()->user_id?>" readonly>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="비밀번호를 입력하세요.">
                        </div>
                    </div>
                    <button type="submit" class="ml-3 btn" disabled>로그인</button>
                </form>
            </div>
        <?php endif;?>
    </div>
</div>

<script>
    window.onload = () => {
        const inputs = document.querySelectorAll("input");
        inputs.forEach(x => {
            x.addEventListener("keyup", e => {
                let parent = e.target.parentElement;
                while(parent.nodeName !== 'FORM' && parent.nodeName !== "BODY") {
                    parent = parent.parentElement;
                } 
                let btn = parent.querySelector("button");
                let result = Array.from(parent.querySelectorAll("input")).reduce((p, c) => p && c.value.trim() !== "", true);
                if(result) btn.disabled = false;
                else btn.disabled = true;
            });
        });
    }
</script>