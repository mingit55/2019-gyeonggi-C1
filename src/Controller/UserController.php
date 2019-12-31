<?php
namespace Controller;

use App\DB;

class UserController {
    function login(){
        view("login");
    }

    function join(){
        view("join");
    }

    function logout(){
        $_SESSION['prevLogin'] = $_SESSION['user'];
        unset($_SESSION['user']);
        go("/", "로그아웃 되었습니다.");
    }

    /*** Execute ***/

    function loginExecute(){
        if(isEmpty()) return back("로그인 정보를 입력해 주십시오.");
        extract($_POST);

        $find = DB::fetch("SELECT * FROM users WHERE user_id = ?", [$user_id]);
        if(!$find) return back("아이디와 일치하는 회원이 없습니다.");
        if($find->password !== hash("sha256", $password)) return back("비밀번호가 일치하지 않습니다.");

        $_SESSION['user'] = $find;
        return go("/", "로그인 되었습니다.");
    }

    function loginPrevExecute(){
        if(isEmpty()) return back("로그인 정보를 입력해 주십시오.");
        extract($_POST);

        if(prevLoginData()->password !== hash("sha256", $password)) return back("비밀번호가 일치하지 않습니다.");
        
        $_SESSION['user'] = prevLoginData();

        return go("/", "로그인 되었습니다.");
    }

    function joinExecute(){
        if(isEmpty()) return back("모든 정보를 입력해 주십시오.");
        extract($_POST);

        $image = $_FILES['image'];
        if(!$image) return back("프로필 사진을 업로드 해 주십시오.");

        $ext = mb_substr($image['name'], -4);
        $filename = noOverlapFilename($ext, PUBLIC_IMAGE."/users");
        move_uploaded_file($image['tmp_name'], PUBLIC_IMAGE."/users/$filename");

        $input = [
            $user_id,
            $user_name,
            hash("sha256", $password),
            $filename,
            $comment
        ];

        DB::query("INSERT INTO users(user_id, user_name, password, image, comment) VALUES (?, ?, ?, ?, ?)", $input);
        go("/users/login", "회원가입 되었습니다.");
    }


    /*** Process ***/
    
    function isExist(){
        $result = ["exist" => false];

        if(!isset($_GET['id'])) return json_response($result);
        $user_id = $_GET['id'];
        
        $find = DB::fetch("SELECT * FROM users WHERE user_id = ?", [$user_id]);
        $result['exist'] = $find != false;
        
        return json_response($result);
    }
    
}