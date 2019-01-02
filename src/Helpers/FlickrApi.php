<?php
/***************************************************************************************************
 
USAGE
<?php
include 'flickrapi.php';
$apiKey = 'XXXXXXXXXXXXXXXXXXXXXXXX';
$userId = 'XXXXXX@XXX';
$flickr = new FlickrAPI($apiKey, $userId);
?>	
<?php $collectionId = "XXXXXX" ?>
<?php $photosets = $flickr->getCollection($collectionId)->set ?>
<?php $previousPhotos = array() ?>
<?php foreach ($photosets as $photoset): ?>
<?php $photos = $flickr->getPhotosetPhotos($photoset->id) ?>
	<?php for ($i = 0; $i < count($photos); $i++): ?>
    	<?php $photoUrl = $flickr->getPhotoURL($photos[$i]) ?>
        <?php if (!in_array($photoUrl, $previousPhotos)): $previousPhotos[] = $photoUrl; endif ?>
    <?php endfor ?>
	<div class="gal">
        <a href="/photoset/<?php echo $photoset->id ?>">
            <img src="<?php echo $photoUrl ?>" alt="<?php echo $photoset->title ?>" />
            <h3><?php echo $photoset->title ?></h3>
        </a>
    </div>
<?php endforeach ?>
***************************************************************************************************/

namespace sgerli\flick\Helpers;

class FlickrAPI {
    const URL = 'https://api.flickr.com/services/rest/';
    
    public function getCollections() {
        $response = $this->request('flickr.collections.getTree');
        return $response->collections->collection;
    }
    
    public function getCollection($collectionId) {
        $response = $this->request(
            'flickr.collections.getTree',
            array('collection_id' => $collectionId)
        );
        return $response->collections->collection[0];
    }
    
    public function getPhotosetPhotos($photosetId) {
        $response = $this->request(
            'flickr.photosets.getPhotos',
            array('photoset_id' => $photosetId, 'extras' => 'url_k')
        );
        return $response->photoset->photo;
    }
    
    public function getPhotosetInfo($photosetId) {
        $response = $this->request(
            'flickr.photosets.getInfo',
            array('photoset_id' => $photosetId)
        );
        return (object) array(
            'title' => $response->photoset->title->_content
        );
    }
    
    public function getPhotoURL($photo, $size = null) {
        return sprintf(
            'https://farm%s.staticflickr.com/%s/%s_%s%s.jpg',
            $photo->farm,
            $photo->server,
            $photo->id,
            $photo->secret,
            $size ? '_' . $size : ''
        );
    }

    public function getPhotoFlickrURL($photo) {
        return sprintf(
            'https://www.flickr.com/photos/%s/%s/',
            $this->_userId,
            $photo->id
        );
    }
    
    public function request($method, array $params = array()) {
        $defaultParams = array(
            'method' => $method,
            'api_key' => $this->_key,
            'user_id' => $this->_userId,
            'format' => 'json',
            'nojsoncallback' => 1
        );
        $params = array_merge($defaultParams, $params);
        $response = $this->_req(static::URL, $params);
        $r = json_decode($response);
        if ($r->stat === 'fail') {
            trigger_error('Code ' . $r->code . ': ' . $r->message, E_USER_WARNING);
        }
        return $r;
    }
    
    public function __construct($apiKey, $userId) {
        $this->_key = $apiKey;
        $this->_userId = $userId;
    }
    
    protected function _req($url, $params = null, $verb = 'POST') {
        $cparams = array('http' => array('method' => $verb, 'ignore_errors' => true));
        if ($params !== null) {
            $params = http_build_query($params);
            if ($verb == 'POST') {
                $cparams['http']['content'] = $params;
            } else {
                $url .= '?' . $params;
            }
        }
        $context = stream_context_create($cparams);
        @$fp = fopen($url, 'rb', false, $context);
        if (!$fp) {
            $res = false;
        } else {
            $meta = stream_get_meta_data($fp);
            $res = stream_get_contents($fp);
        }
        if ($res === false) {
            throw new Exception("$verb $url failed: $php_errormsg");
        }
        return $res;
    }
}
