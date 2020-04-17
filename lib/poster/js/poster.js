//提交到wordpress自带的ajax处理
$(document).on('click touchstart', '.btn-bigger-cover', function (event) {
    event.preventDefault();
    var bigger = $('#bigger-cover');
    var bigger_cover = $('#bigger-cover img');
    if (bigger_cover.hasClass('load_bigger_img')) {
        $.ajax({
            url: "\/wp-admin\/admin-ajax.php",
            type: 'POST',
            dataType: 'json',
            data: bigger_cover.data(),
        }).done(function (data) {
            if (data.s == 200) {
                bigger_cover.attr('src', data.src);
                $('.bigger_share').attr('href', data.share);
                $('.bigger_down').attr('href', data.src);
                bigger_cover.removeClass('load_bigger_img');
                $('.image-loading').remove()
            } else {
                alert( data.m );
            }
        }).fail(function () {
            alert('Error：网络错误，请稍后再试！');
        })  
    }
    bigger.addClass('dialog-open');
});

//关闭窗口
$(document).on('click touchstart','.poster-close',function() {
    $('.dialog-poster').removeClass('dialog-open');
});

$(document).on('click touchstart','.dialog-overlay',function() {
    $('.dialog-poster').removeClass('dialog-open');
});