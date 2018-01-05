$(function(){

    var vm = new Vue({

        el: '#flick-settings',

        data: {
            config: window.$data.config,
        },

        methods: {
            save: function() {

                this.$http.post('admin/flick/save', { config: this.config }, function() {
                    UIkit.notify(vm.$trans('Settings saved.'), '');
                }).error(function(data) {
                    UIkit.notify(data, 'danger');
                });
            }

        }

    });

});