<script src="{!! asset('assets/backend/plugins/tinymce/tinymce.min.js') !!}" type="text/javascript"></script>
<script>
    !function ($) {
        $(function(){
            function elFinderBrowser (field_name, url, type, win) {
                tinymce.activeEditor.windowManager.open({
                file: '{!! route('elfinder.tinymce4') !!}',
                //file: '../../cms/elfinder',// use an absolute path!
                title: 'elFinder 2.0',
                width: 900,
                height: 450,
                resizable: 'yes'
            }, {
                setUrl: function (url) {
                    win.document.getElementById(field_name).value = url;
                }
            });
                return false;
            }

            tinymce.init({
                selector:'textarea.tinymce',
                menubar:false,
                plugins: "link image code table textcolor",
                //fullscreen_new_window : true,
                // fullscreen_settings : {
                //     theme_advanced_path_location : "top"
                // },
                convert_urls: false,
                relative_urls: false,
                toolbar: "table | forecolor | backcolor| undo | redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | code | image",
                file_browser_callback : elFinderBrowser,
                forced_root_block : "",
                force_br_newlines : true,
                force_p_newlines : false
            });
        });
}(window.jQuery);
</script>
