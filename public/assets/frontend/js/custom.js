/**
 * Created by Mr.Hung on 3/7/2017.
 */
$(document).ready(function () {
    $('.nav ul li').hover(function () {
        $(this).find('.sub-menu:first').show();
    },function () {
        $(this).find('.sub-menu').hide();
    })
})
function on_load_ajax(item) {
    var id = $(item).attr('data-id');
    var view = $(item).attr('data-views');
    var url = $(item).attr('data-url');
    var number = $(item).attr('data-number');
    var post_it = $(item).attr('data-post');
    var type = $(item).attr('data-type');
    var page = $(item).attr('data-page');
    // var img='<div class="overlay"></div><img src="'+ baseUrl+'skin/admin/images/loading.gif" class="loading_gif" />';
    // $('body').append(img);
    $.ajax({
        type: "POST",
        url: url,
        data: {id:id,number:number,page:page,view:view,type:type},
        success: function (data, status) {
            if(data.length > 0){
                $('#'+view).append(data);
                $(item).attr('data-number',parseInt(number)+ parseInt(post_it));
            }else{
                $(item).hide();
            }

        }
    })
}