<script src="{!! asset('assets/backend/plugins/ckeditor/ckeditor.js') !!}" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('textarea.ckeditor').each(function(){
            CKEDITOR.replace( $(this).attr('id'), {
                extraPlugins: 'oembed,image2,justify,widget,markdown',
                //config.image2_alignClasses = [ 'align-left', 'align-center', 'align-right' ];
                image2_captionedClass: 'image-captioned',
                on: {
                    dialogShow: function ( evt ) {
                        var dialog = evt.data;
                        if (  dialog.getName() == 'image2') {
                            dialog.setValueOf( 'info', 'align', 'center' );
                            dialog.setValueOf( 'info', 'width', '600' );
                            dialog.setValueOf( 'info', 'hasCaption', 'checked' );
                        }
                    }
                },
                filebrowserBrowseUrl: '/admin/elfinder/ckeditor',
            } );

            CKEDITOR.config.allowedContent = true;
        });
    });
</script>