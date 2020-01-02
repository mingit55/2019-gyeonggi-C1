<?php

function userPermission(){
    return (object)[
                "result" => user(),
                "destination" => "/users/login",
                "message" => "로그인 후 이용하실 수 있습니다.",
            ];
}

function guestPermission(){
    // dd(guest());
    return (object)[
                "result" => guest(),
                "destination" => "/",
                "message" => "로그인 후엔 이용하실 수 없습니다."
            ];   
}

function presidentPermission(){
    if(!isset($_GET['id'])) return false;
    return (object)[
                "result" => president($_GET['id']),
                "destination" => "/gallery/info?id=".$_GET['id'],
                "message" => "갤러리 대표만 이용 가능한 서비스 입니다.",
            ];   
}