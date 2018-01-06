<?php
/**
 * @var $view
 * @var Pagekit\Module\Module $flick
 * @var array $config
 */
$view->script('flick', 'flick:js/flick.js', ['uikit-grid', 'uikit-lightbox']);

include 'flickrapi.php';
$apiKey = $config['apiKey'];
$userId = $config['uId'];
$flickr = new FlickrAPI($apiKey, $userId);
$collectionId = $config['cId'];
$photosets = $flickr->getCollection($collectionId)->set ?>

<article id="flick-gallery">
    <?php if ($config['flick_title']) : ?>
            <h1 class="uk-article-title"><?= $config['flick_title'] ?></h1>
        <?php endif; ?>
        <div class="uk-clearfix">

            <?php if ($flick_text) : ?>
                <?= $flick_text ?>
            <?php endif; ?>

        </div>

    <div class="uk-tab-center uk-margin">
        <ul id="flick-filter" class="uk-tab">
            <li class="uk-active" data-uk-filter=""><a href=""><?= __('All') ?></a></li>
            <?php foreach ($photosets as $photoset) : ?>
                <li data-uk-filter="<?= $photoset->title ?>"><a href=""><?= __($photoset->title) ?></a></li>
            <?php endforeach; ?>

        </ul>
    </div>

    <div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-3" data-uk-grid="{controls: #flick-filter, gutter: 20}">
        <?php foreach ($photosets as $photoset): ?>
        <?php $photos = $flickr->getPhotosetPhotos($photoset->id); ?>
            <?php foreach ($photos as $photo ): ?>
                <?php $photoUrl = $flickr->getPhotoURL($photo) ?>\
                <div data-uk-filter="<?= $photoset->title ?>">
                <a href="<?php echo $photo->url_k ?>" data-uk-lightbox>
                    <div class="uk-panel uk-panel-box">
                        <div class="uk-panel-teaser">
                            <img src="<?php echo $photoUrl ?>">
                        </div>
                        
                    </div>
                    </a>
                </div>
            <?php endforeach ?>
        <?php endforeach ?>
    </div>
</div>