<?php
namespace Controller;

use App\DB;

class GalleryController {
    // View
    function galleryHome(){
        view("gallery-home");
    }

    function galleryInfo(){
        if(!isset($_GET['id'])) return back("해당 페이지는 존재하지 않습니다.");
        
        $gid = $_GET['id'];
        $gallery = DB::find("gallery", $gid);
        if(!$gallery) return back("해당 갤러리는 존재하지 않는 갤러리 입니다.");

        $owner = DB::find("users", $gallery->owner_id);
        $artworks = DB::fetchAll("SELECT A.* 
                                  FROM artworks A, gallery_artworks G
                                  WHERE G.aid = A.id AND G.gid = ?", [$gid]);

        $data = [
            "gallery" => $gallery,
            "owner" => $owner,
            "artworks" => $artworks
        ];

        view("gallery-info", $data);
    }

    function addArtwork(){
        if(!isset($_GET['id'])) return back("해당 페이지는 존재하지 않는 페이지입니다.");

        $gid = $_GET['id'];
        $gallery = DB::find("gallery", $gid);
        if(!$gallery) return back("해당 갤러리는 존재하지 않습니다.");
        

        $data = [
            "gallery" => $gallery,
        ];
        view("gallery-add-artwork", $data);
    }

    // Execute

    function addArtworkExecute(){
        if(isEmpty()) return back("데이터가 존재하지 않습니다.");
        extract($_POST);

        $selectList = json_decode($selectList);

        foreach($selectList as $item){
            DB::query("INSERT INTO gallery_artworks(gid, aid) VALUES (?, ?)", [$gid, $item->data->aid]);
            DB::query("UPDATE artworks SET price = ?", [$item->price]);
        }

        go("/gallery/info?id=$gid", "새롭게 작품이 추가되었습니다.");
    }

    // Process
    function takeList(){
        json_response(DB::fetchAll("SELECT * FROM gallery"));
    }

    function popularList(){
        $buy_count_table = "SELECT B.aid, G.gid, COUNT(*) AS cnt FROM buy_history B, gallery_artworks G WHERE B.aid = G.aid GROUP BY B.aid";
        $popular_list = "SELECT SUM(IFNULL(C.cnt, 0)) total, G.* 
                        FROM gallery AS g
                        LEFT JOIN ($buy_count_table) C
                        ON C.gid = g.id
                        GROUP BY g.id 
                        ORDER BY total DESC
                        LIMIT 0, 5";
        json_response(DB::fetchAll($popular_list));
    }

    function takeEmptyArtworks(){
        // 데이터 정상 여부 확인
        $returned = ["artworks" => []];
        if(!isset($_GET['id'])) return json_response($returned);
        $gid = $_GET['id'];
        $gallery = DB::find("gallery", $gid);
        if(!$gallery) return json_response($returned);

        $art_in_gallery = "SELECT U.uid, A.id AS aid, A.title, A.image, A.description 
        FROM gallery_users U, artworks A 
        WHERE A.uid = U.uid AND U.gid = ?";

        $returned['artworks'] = DB::fetchAll("SELECT A.*, G.gid, U.user_name
                                                FROM users U, ($art_in_gallery) A
                                                LEFT JOIN gallery_artworks G
                                                ON G.aid = A.aid
                                                WHERE U.id = A.uid AND G.gid IS NULL", [$gid]);
        return json_response($returned);
    }
}