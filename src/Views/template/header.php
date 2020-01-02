<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>부산국제아트페어</title>

    <!-- Common -->
    <link rel="stylesheet" href="/css/common.css">
    <script src="/js/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <script src="/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <!-- 헤더 -->
    <header>
        <div class="inline d-flex justify-content-between align-items-center">
            <a href="/">
                <img class="logo" src="/images/logo.png" alt="BUSAN INTERNATIONAL ART FAIR" height="70">
            </a>
            <ul class="main-nav d-flex">
                <li class="mx-3">
                    <a href="/reservation/booth">축제 참가</a>
                    <ul class="sub-nav">
                        <li>
                            <a href="/reservation/booth">부스 예약</a>
                        </li>
                        <li>
                            <a href="/reservation/list">예약 현황</a>
                        </li>
                    </ul>
                </li>
                <li class="mx-3">
                    <a href="/gallery">갤러리</a>
                </li>
                <li class="mx-3">
                    <a href="/mypage">마이페이지</a>
                    <ul class="sub-nav">
                        <li><a href="/mypage">내 정보</a></li>
                        <li><a href="/mypage/workspace">작업실</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="login-action main-nav d-flex">
                <?php if(user()):?>
                    <li>
                        <a href="/users/logout">로그아웃</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="/users/login">로그인</a>
                    </li>
                    <li>
                        <a href="/users/join">회원 가입</a>
                    </li>
                <?php endif;?>
            </ul>
        </div>
    </header>