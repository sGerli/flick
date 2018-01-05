<?php $view->script('flick', 'flick:js/admin/flick.js', 'vue') ?>

<div id="flick-settings" class="uk-form">

    <button class="uk-button uk-button-primary uk-align-right" @click="save">{{ 'Save' | trans }}</button>

    <h2>Settings</h2>

    <p class="uk-form-controls uk-form-horizontal">
        <label class="uk-form-label">{{ 'Flickr api key' | trans }}</label>
        <input type="text" placeholder="0000000000000" class="uk-form-width-large" v-model="config.apiKey">
    </p>
    <p class="uk-form-controls uk-form-horizontal">
        <label class="uk-form-label">{{ 'Flickr user id' | trans }}</label>
        <input type="text" placeholder="000000@000" class="uk-form-width-large" v-model="config.uId">
    </p>
    <p class="uk-form-controls uk-form-horizontal">
        <label class="uk-form-label">{{ 'Collection id' | trans }}</label>
        <input type="text" placeholder="000000" class="uk-form-width-large" v-model="config.cId">
    </p>

</div>