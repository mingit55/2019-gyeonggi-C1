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
                    <a href="/artworks/info?id=<?=$artwork->id?>" class="item">
                        <div class="image">
                            <img src="/images/articles/<?=$artwork->image?>" alt="<?=$artwork->title?>" height="150">  
                        </div>
                        <div class="description ml-4">
                            <h5 class="font-weight-bold mb-2"><?=$artwork->title?></h5>
                            <span class="year text-muted mr-4">연도: <?=$artwork->register_date?></span>
                            <span class="size text-muted">크기: 200 x 195</span>
                            <p class="mt-2"><?=$artwork->description?></p>
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
                    <a href="/artworks/info?id=<?=$item->aid?>" class="item">
                        <div class="image">
                            <img src="/images/articles/<?=$item->a_image?>" alt="<?=$item->a_title?>" height="150">
                        </div>
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

