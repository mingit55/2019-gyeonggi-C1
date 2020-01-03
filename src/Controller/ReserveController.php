<?php
namespace Controller;

use App\DB;

class ReserveController {
    // View
    function reserveBooth(){
        $checkPerm = DB::fetch("SELECT * FROM gallery WHERE owner_id = ?", [user()->id]);
        if(!$checkPerm) return back("갤러리 대표만 접근할 수 있습니다.");
        

        view("reserve-booth", [], true);
    }

    function reserveList(){
        view("reserve-list", [], true);
    }

    // Execute
    function reserveBoothExecute(){
        $myGallery = DB::fetch("SELECT * FROM gallery WHERE owner_id = ?", [user()->id]);
        if(!$myGallery) return back("갤러리 대표만 접근할 수 있습니다.");

        if(isEmpty()) return back("내용을 모두 입력하세요.");
        extract($_POST);

        $data = [$myGallery->id, $booth_id, $reserve_start, $reserve_end];
        DB::query("INSERT INTO reservation(gallery_id, booth_id, start_date, end_date) VALUES (?, ?, ?, ?)", $data);

        return go("/reservation/list", "예약이 완료되었습니다.");
    }


    // Process
    function takeBoothList(){
        $json_data = json_decode(file_get_contents(ROOT."/public/datas/booth.json"))->booth;
        foreach($json_data as $item) {
            $split = explode("x", $item->size);
            $item->size = (int)$split[0] * (int)$split[1];
        }
        return json_response($json_data);
    }

    function takeReservedList(){
        $reserveList = DB::fetchAll("SELECT * FROM reservation");
        
        foreach($reserveList as $item){
            $item->gallery = DB::fetch("SELECT G.*, U.user_name owner_name FROM gallery G, users U WHERE G.id = ? AND G.owner_id = U.id", [$item->gallery_id]);
        }

        return json_response(["reservation" => $reserveList]);
    }
}