(function($) {

    tinymce.create('tinymce.plugins.hellotheme_clearboth', {
        init: function(ed, url) {

            //spacer
            ed.addButton('hellotheme_clearboth', {
                title: 'Add Clear Floats Break',
                image: url + '/../img/tinymce/spacer.png',
                onclick: function() {
                    ed.selection.setContent('<hr class="clear-both">');
                }
            });
        },
        createControl: function(n, cm) {
            return null;
        },
    });

    tinymce.PluginManager.add('hello_tinymce_script', tinymce.plugins.hellotheme_clearboth);
})(jQuery);
