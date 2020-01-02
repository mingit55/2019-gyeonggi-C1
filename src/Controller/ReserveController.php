<?php
namespace Controller;

use App\DB;

class ReserveController {
    // View
    function reserveBooth(){
        $size = isset($_GET['size']) ?  $_GET['size'] : false;
        $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : false;
        $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : false;

        $checkPerm = DB::fetch("SELECT * FROM gallery WHERE owner_id = ?", [user()->id]);
        if(!$checkPerm) return back("갤러리 대표만 접근할 수 있습니다.");
        

        view("reserve-booth", [], true);
    }

    function reserveList(){
        view("reserve-list");
    }

    // Process
    function takeReservedList(){
        $res_data = [];
        
        // 변동되지 않는 데이터 :: Booth 테이블
        // 변동 가능한 데이터 :: Rerservation 테이블
        
    }
}