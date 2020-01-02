<?php
namespace Controller;

use App\DB;

class MypageController {
    // View
    function __construct(){
        $history_match_artist = "SELECT B.*, A.uid artist, A.title a_title, A.image a_image, A.description FROM buy_history B, artworks A WHERE B.aid = A.id";

        $this->default = [
            "userdata" => DB::find("users", user()->id),
            "myArtworks" => DB::fetchAll("SELECT * FROM artworks WHERE uid = ?", [user()->id]),
            "buyHistory" => DB::fetchAll("SELECT B.*, U.user_name username, U.comment u_comment, U.image u_image
                                          FROM ($history_match_artist) B, users U
                                          WHERE B.artist = U.id AND B.owner = ?", [user()->id]),
        ]; 
    }

    function mypageHome(){
        view("mypage-home", $this->default);
    }

    function addArtwork(){
        view("mypage-add-artwork");
    }

    function workspace(){
        view("mypage-workspace", [], true);
    }
    
    // Execute

    function addArtworkExecute(){
        isEmpty();
        extract($_POST);
        
        if(!isset($_FILES['image'])) return back("이미지를 업로드해 주세요!");
        $image = $_FILES['image'];
        $path = PUBLIC_IMAGE . "/articles";
        $ext = mb_substr($image['name'], -4);
        $filename = noOverlapFilename($ext, $path);
        move_uploaded_file($image['tmp_name'], "$path/$filename");

        $data = [
            $filename,
            $title,
            $description,
            $size_x,
            $size_y,
            user()->id,
        ];
        DB::query("INSERT INTO artworks(image, title, description, width, height, uid) VALUES (?, ?, ?, ?, ?, ?)", $data);

        go("/mypage", "작품이 추가되었습니다.");
    }
}