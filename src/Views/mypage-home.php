<!-- Unique -->
<link rel="stylesheet" href="/css/mypage.css">
<link rel="stylesheet" href="/css/gallery-info.css">

<div id="mypage" class="section">
    <div class="inline">
        <div class="section-title">
            <h5>마이페이지</h5>
            <h1>MY PAGE</h1>
        </div>
        <div class="user-info">
            <span class="title font-weight-bold ml-3">사용자 정보</span>
            <div class="d-flex mt-3">
                <div class="image p-3">
                    <img src="/images/users/profile.png" alt="Profile Image" height="130">
                </div>
                <div class="text p-3">
                    <span class="name font-weight-bold mr-2"><?=$userdata->user_name?></span>
                    <p class="intro mt-2"><?=$userdata->comment?></p>
                </div>
            </div>
        </div>
        <hr>
        <div class="gallery py-4 px-2">
            <div class="mb-4 px-4 d-flex justify-content-between">
                <div class="title">내 작품 정보</div>
                <a href="/mypage/add-artwork" class="border-btn">작품 추가하기</a>
            </div>
            <div class="list stack">
                <?php foreach($myArtworks as $artwork):?>
                    <a href="/artwork/info?id=<?=$artwork->id?>" class="item">
                        <div class="image">
                            <img src="/images/articles/<?=$artwork->image?>" alt="<?=$artwork->title?>" height="150">  
                        </div>
                        <div class="description ml-4">
                            <h5 class="font-weight-bold mb-2"><?=$artwork->title?></h5>
                            <span class="year text-muted mr-4">연도: <?=$artwork->register_date?></span>
                            <span class="size text-muted">크기: 200 x 195</span>
                            <p class="mt-2">본래 작가가 표현하는 평면적인 면에서 인간미가 느껴지기 마련이다. 작품에서 쉬이 발견 할 수 있다. 각자 다른곳을 바라보고 있고 서로 멀지않은 거리에 있음에도 전혀 다른 음료와 서양식 음식을 파는 집이 있다.부산국제아트페어에 작품을 내어 많은 사람들에게 한국 미술을 알리고 싶다.</p>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <hr>
        <div class="gallery py-4 px-2">
            <div class="title mb-4 pl-4">구매 작품 정보</div>
            <div class="list stack no-hover">
                <?php foreach($buyHistory as $item): ?>
                    <a href="/artwork.html" class="item">
                        <div class="image"><img src="/images/articles/<?=$item->a_image?>" alt="<?=$item->a_title?>" height="150"></div>
                        <div class="description ml-4">
                            <h5 class="font-weight-bold mb-2"><?=$item->a_title?></h5>
                            <p class="mt-2"><?=$item->description?></p>
                        </div>
                        <a href="gallery_info.html" class="sub-item ml-5 pl-5 mt-4 py-3 pr-3">
                            <div class="font-weight-bold">아티스트 정보</div>
                            <div class="u-info d-flex mt-3">
                                <img src="/images/users/<?=$item->u_image?>" alt="Profile-image" height="100">
                                <div class="info ml-4">
                                    <span class="font-weight-bold"><?=$item->username?></span>
                                    <p class="intro mt-2"><?=$item->u_comment?></p>
                                </div>
                            </div>
                        </a>
                    </a>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>

