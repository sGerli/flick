<?php
/**
 * @var $view
 * @var Pagekit\Module\Module $flick
 * @var array $config
 */
$view->style('flick', 'sgerli/flick:external/fancybox/jquery.fancybox.min.css');
$view->script('flick', 'sgerli/flick:js/flick.js', ['uikit-grid', 'fancybox']);

use sgerli\flick\Helpers\FlickrApi;


function collectionToCSV($collection) {
    $string = "";
    foreach ($collection as $album) {
        if (!empty($string)) {
            $string .= ", ";
        }
        $string .= $album;
    }
    return $string;
}

// include 'flickrapi.php';
$error = null;

try {
    $apiKey = $config['apiKey'];
    $userId = $config['uId'];
    $collectionId = $config['cId'];
    
    if ($apiKey && $userId && $collectionId) {
    $flickr = new FlickrAPI($apiKey, $userId);
    
    $photosets = $flickr->getCollection($collectionId)->set;
    $photoCollection = [];
    
    foreach ($photosets as $photoset):
        $photos = $flickr->getPhotosetPhotos($photoset->id);
        foreach ($photos as $photo):
            if (!array_key_exists($photo->id, $photoCollection)):
                $photo->collections = [];
                $photoCollection[$photo->id] = $photo;
            endif;
            $photoCollection[$photo->id]->collections[] = $photoset->title;
        endforeach;
    endforeach;
?>

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
        <?php foreach ($photoCollection as $photo ): ?>
            <div data-uk-filter="<?= collectionToCSV($photo->collections) ?>">
            <a href="<?php echo $photo->url_k ?>" data-caption="<h2><?php echo $photo->title ?></h2> <small><a class='linkback' href='<?php echo $flickr->getPhotoFlickrURL($photo) ?>'>View on Flickr</a></small>" data-fancybox>
                <div class="uk-panel uk-panel-box">
                    <div class="uk-panel-teaser">
                        <img src="<?php echo $flickr->getPhotoURL($photo, 'z') ?>">
                    </div>
                    
                </div>
                </a>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?php } else {
        echo 'Please configure in the admin section.';
    }

} catch (Exception $e) {
    echo 'An error ocurred while fetching from the Flickr API: '. $e->getMessage();
}
?>