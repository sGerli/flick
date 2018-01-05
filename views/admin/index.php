<?php $view->script('flick', 'flick:js/admin/flick.js', ['vue', 'editor']) ?>

<div id="flick-settings" class="uk-form">

    <button class="uk-button uk-button-primary uk-align-right" @click="save">{{ 'Save' | trans }}</button>

    <h2>Settings</h2>

    <div class="uk-form-horizontal">
        <div class="uk-form-row">
            <label for="title" class="uk-form-label">{{ 'Flick Gallery title' | trans }}</label>

            <div class="uk-form-controls">
                <input id="title" class="uk-width-1-1" type="text" name="title"
                        v-model="config.flick_title">
            </div>
        </div>
    </div>


    <div class="uk-form-stacked uk-margin">
        <div class="uk-form-row">
            <span class="uk-form-label">{{ 'Flick Gallery text' | trans }}</span>

            <div class="uk-form-controls">
                <v-editor id="form-intro" :value.sync="config.flick_text"
                            :options="{markdown : config.markdown_enabled, height: 250}"></v-editor>
                <p>
                    <label><input type="checkbox" v-model="config.markdown_enabled"> {{ 'Enable Markdown' | trans }}</label>
                </p>
            </div>
        </div>
    </div>

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