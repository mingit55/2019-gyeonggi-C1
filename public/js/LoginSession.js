document.createElem = html => {
    let parent = document.createElement("div");
    parent.innerHTML = html;
    return parent.firstChild;
}
document.createTableElem = html => {
    let parent = document.createElement("table");
    parent.innerHTML = html;
    return parent.firstChild.firstChild;
}

class LoginSession {
    constructor(userList){
        this.user = null;
        this.prevData = null;
        this.userList = userList;

        this.in_nav = document.querySelector("header .login-action");

        this.init();
    }

    init(){
        let ls_id = localStorage.getItem("login_id");
        let prev_id = localStorage.getItem("prev_id");
        
        let prevData = !prev_id ? null : this.userList.find(x => x.user_id === prev_id);

        if(ls_id) {
            this.user = this.userList.find(x => x.user_id === ls_id);
            this.loginAction();
        }
        else {
            this.user = null;
            this.logoutAction();
        }
    }

    loginAction(){
        this.in_nav.innerHTML = `<li>
                                    <a href="/users/logout">로그아웃</a>
                                </li>`;
    }

    logoutAction(){
        this.in_nav.innerHTML = `<li>
                                    <a href="/users/login">로그인</a>
                                </li>
                                <li>
                                    <a href="/users/join">회원 가입</a>
                                </li>`;
    }   


    login(user_id, password){
        let find = this.userList.find(x => x.user_id === user_id);
        // if(!find)
    }
}

let session = new LoginSession(database.users);