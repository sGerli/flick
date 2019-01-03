<?php
/**
 * @var $view
 * @var Pagekit\Module\Module $flick
 * @var array $config
 */
$view->style('flick', 'sgerli/flick:external/fancybox/jquery.fancybox.min.css');
$view->script('flick', 'sgerli/flick:js/flick.js', ['uikit-grid', 'fancybox']);

use sgerli\flick\Helpers\FlickrApi;

// include 'flickrapi.php';
$apiKey = $config['apiKey'];
$userId = $config['uId'];
$collectionId = $config['cId'];

if ($apiKey && $userId && $collectionId) {
$flickr = new FlickrAPI($apiKey, $userId);

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
            <li class="uk-active" data-uk-filter=""><a href="#"><?= __('All') ?></a></li>
            <?php foreach ($photosets as $photoset) : ?>
                <li data-uk-filter="<?= $photoset->title ?>"><a href="#"><?= __($photoset->title) ?></a></li>
            <?php endforeach; ?>

        </ul>
    </div>

    <div class="uk-grid uk-grid-width-small-1-1 uk-grid-width-medium-1-3" data-uk-grid="{controls: '#flick-filter', gutter: 20}">
        <?php foreach ($photosets as $photoset): ?>
        <?php $photos = $flickr->getPhotosetPhotos($photoset->id); ?>
            <?php foreach ($photos as $photo ): ?>
                <div data-uk-filter="<?= $photoset->title ?>">
                <a href="<?php echo $photo->url_k ?>" data-caption="<h2><?php echo $photo->title ?></h2> <small><a class='linkback' href='<?php echo $flickr->getPhotoFlickrURL($photo) ?>'>View on Flickr</a></small>" data-fancybox>
                    <div class="uk-panel uk-panel-box">
                        <div class="uk-panel-teaser">
                            <img src="<?php echo $flickr->getPhotoURL($photo, 'z') ?>">
                        </div>
                        
                    </div>
                    </a>
                </div>
            <?php endforeach ?>
        <?php endforeach ?>
    </div>
</div>

<?php } else {
        echo 'Please configure in the admin section.';
} ?>