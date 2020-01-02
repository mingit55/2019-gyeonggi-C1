<link rel="stylesheet" href="/css/gallery-info.css">
<div id="info" class="section">
    <div class="inline">
        <div class="gal-info">
            <span class="name font-weight-bold mr-2"><?=$gallery->name?></span>
            <span class="country text-muted"><?=$gallery->country?></span>
            <p class="description mt-2"><?=$gallery->description?></p>
        </div>
        <div class="own-info">
            <span class="title font-weight-bold ml-3">갤러리 대표</span>
            <div class="d-flex">
                <div class="image p-3">
                    <img src="/images/users/<?=$owner->image?>" alt="Profile Image" height="130">
                </div>
                <div class="text p-3">
                    <span class="name font-weight-bold mr-2"><?=$owner->user_name?></span>
                    <span class="tel text-muted">연락처: <?=$gallery->phone?></span>
                    <p class="intro mt-2"><?=$owner->comment?></p>
                </div>
            </div>
        </div>
        <div class="gallery py-4 px-2">
            <div class="mb-4 d-flex justify-content-between">
                <span class="title">전시 작품</span>
                <?php if(president($gallery->owner_id)):?>
                    <a href="/gallery/add-artwork?id=<?=$gallery->id?>" class="border-btn">작품 추가하기</a>
                <?php endif;?>
            </div>
            <div class="list stack">
                <?php foreach($artworks as $artwork):?>
                    <a href="/artworks/info?id=<?=$artwork->id?>" class="item">
                        <div class="image">
                            <img src="/images/articles/<?=$artwork->image?>" alt="<?=$artwork->title?>" height="150" <?= $artwork->exist ? "style='filter: brightness(50%)'" : ""?>>   
                        </div>
                        <div class="description ml-4">
                            <h5 class="font-weight-bold mb-3"><?=$artwork->title?></h5>
                            <p><?=$artwork->description?></p>
                        </div>
                    </a>
                <?php endforeach;?>
                <?php if(count($artworks) === 0): ?>
                    <h5 class="my-5 w-100 text-center">등록된 전시 작품이 없습니다.</h5>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>