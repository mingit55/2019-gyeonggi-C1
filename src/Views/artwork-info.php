<!-- Unique -->
<link rel="stylesheet" href="/css/artwork.css">

<div id="artwork" class="section">
    <div class="inline">
        <div class="head-line">
            <h1 class="title mb-3"><?=$artwork->title?></h1>
            <span class="text-muted mr-4">연도: <?=date("Y년", strtotime($artwork->register_date))?></span>
            <span class="text-muted mr-4">크기: <?=$artwork->width?> x <?=$artwork->height?></span>
            <span class="text-muted">가격: \ <?=number_format($artwork->price)?></span>
            <p class="description mt-2"><?=$artwork->description?></p>
            <?php if(!$isBought && user() && $artwork->uid !== user()->id):?>
                <form action="/artworks/buy" method="post">
                    <input type="hidden" name="aid" value="<?=$artwork->id?>">
                    <button class="btn mt-2">구매하기</button>
                </form>
            <?php endif;?>
        </div>
        <hr>
        <div class="m-image py-4">
            <img src="/images/articles/<?=$artwork->image?>" alt="artwork">
        </div>
        <hr>
        <a href="gallery_info.html" class="foot-line d-block">
            <h5 class="title mb-3 font-weight-bold">아티스트 정보</h5>
            <div class="a-info d-flex ml-2">
                <div class="image">
                    <img src="/images/users/<?=$artist->image?>" alt="Profile Image" height="100">
                </div>
                <div class="info ml-4">
                    <span class="name font-weight-bold"><?=$artist->user_name?></span>
                    <p class="description mt-2"><?=$artist->comment?></p>
                </div>
            </div>
        </a>
    </div>
</div>