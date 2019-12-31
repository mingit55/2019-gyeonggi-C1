<?php

function dump(){
    foreach(func_get_args() as $arg) {
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(){
    call_user_func_array("dump", func_get_args());
    exit;
}

function guest(){
    return !isset($_SESSION['user']);
}

function user(){
    return isset($_SESSION['user']) ? $_SESSION['user'] : false;
}

function president($owner_id){
    return user() && user()->id === $owner_id;
}

function go($url, $message = ""){
    echo "<script>";
    if($message !== "") echo "alert('$message');";
    echo "location.assign('$url');";
    echo "</script>";
}

function back($message = ""){
    echo "<script>";
    if($message !== "") echo "alert('$message');";
    echo "history.back()";
    echo "</script>";   
}

function view($page, $data = []){
    extract($data);
    
    require VIEWS."/template/header.php";
    require VIEWS."/$page.php";
    require VIEWS."/template/footer.php";
}

function json_response($data){
    header("Content-type: application/json");
    echo json_encode($data);

    return true;
}

function isEmpty($exception = []){
    foreach($_POST as $data){
        if(!in_array($data, $exception) && trim($data) === "") return true;
    }
    return false;
}

function rand_str($length){
    $result = "";
    $str = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
    for($i = 0; $i < $length; $i++){
        $result .= $str[rand(0, strlen($str) - 1)];
    }
    return $result;
}

function noOverlapFilename($extention, $path){
    do {
        $filename = rand_str(20) . $extention;
    } while(is_file("$path/$filename"));
    return $filename;
}

function prevLoginData(){
    return isset($_SESSION['prevLogin']) ? $_SESSION['prevLogin'] : false;
}