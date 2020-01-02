<?php
namespace Controller;

use App\DB;

class MainController {
    function home(){
        view("home");
    }

    function init(){
        // JSON 보기용
        // header("application/json");
        // readfile(ROOT."/public/datas/datas.json");
        // exit;



        $read = file_get_contents(ROOT."/public/datas/datas.json");
        $json = json_decode($read);

        //Users
        DB::query("DELETE FROM users");
        foreach($json->users as $user) {
            $sql = "INSERT INTO users(id, user_id, user_name, password, image, comment) VALUES (?, ?, ?, ?, ?, ?);";
            $data = [$user->id, $user->user_id, $user->user_name, hash("sha256", $user->user_pw), $user->user_profile_img, $user->user_about];
            DB::query($sql, $data);
        }

        //Gallery
        DB::query("DELETE FROM gallery");        
        DB::query("DELETE FROM gallery_users");
        DB::query("DELETE FROM gallery_artworks");

        foreach($json->gallery as $gallery){
            $sql = "INSERT INTO gallery(id, name, description, country, owner_id, sitelink, address, phone, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $data =[$gallery->id, $gallery->gallery_name, $gallery->description, $gallery->nation, $gallery->owner, $gallery->website_link, $gallery->address, $gallery->phone_number, $gallery->email];
            DB::query($sql, $data);

            DB::query("INSERT INTO gallery_users(uid, gid) VALUES (?, ?)", [$gallery->owner, $gallery->id]);
            foreach($gallery->artist as $user_id){
                DB::query("INSERT INTO gallery_users(uid, gid) VALUES (?, ?)", [$user_id, $gallery->id]);
            }

            foreach($gallery->item as $artwork_id){
                DB::query("INSERT INTO gallery_artworks(aid, gid) VALUES (?, ?)", [$artwork_id, $gallery->id]);
            }
        }


        //Artworks
        DB::query("DELETE FROM artworks");
        foreach($json->artworks as $artwork){
            $sql = "INSERT INTO artworks(id, image, title, description, width, height, uid, register_date, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $split = explode("x", $artwork->size);
            $width = trim($split[0]);
            $height = trim($split[1]);
            $data = [$artwork->id, $artwork->img, $artwork->title, $artwork->description, $width, $height, $artwork->artist_id, $artwork->register_date, $artwork->price];
            DB::query($sql, $data);
        }

        //BuyHistory
        DB::query("DELETE FROM buy_history");
        foreach($json->buy_history as $history){
            $sql = "INSERT INTO buy_history(id, buy_date, aid, owner) VALUES (?, ?, ?, ?)";
            $data = [$history->id, $history->buy_date, $history->artwork_id, $history->owner];
            DB::query($sql, $data);
        }
        
        // Reservation
        DB::query("DELETE FROM reservation");
        DB::query("DELETE FROM reservation_booth");
        foreach($json->reservation as $res){
            $sql = "INSERT INTO reservation(id, gid, start_date, end_date) VALUES (?, ?, ?, ?)";
            $data = [$res->id, $res->gallery_id, $res->start_date, $res->end_date];

            DB::query($sql, $data);

            // 해당 예약에서 빌린 부스 저장
            foreach($res->booth as $booth_id){
                if($booth_id) DB::query("INSERT INTO reservation_booth(bid, rid) VALUES (?, ?)", [$booth_id, $res->id]);
            }
        }

        echo "데이터 베이스에 성공적으로 초기작업을 완료했습니다.";
    }

}