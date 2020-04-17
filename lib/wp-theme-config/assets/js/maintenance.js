(function ($) {
    "use strict";

    $(document).ready(function () {
        'use strict';

        //CountDown settings
        $(function () {
            var d = $('#countdown').data('date');
            var date;
            if(d){
                var str = d.split("/");
                var year = str[0];
                var month = str[1];
                var day = str[2];
                date = month + '/' + day + '/' + year;
            }else{
                d = new Date();
                d.setDate(d.getDate() + 15);
                var year = d.getFullYear();
                var month = d.getMonth() + 1;
                var day = d.getDate();
                date = month + '/' + day + '/' + year;
            }
            console.log(date);
            $('#countdown').countdown({
                date: date + ' 23:59:59' //Here you can change countdown time
            }, function () {
                alert('Here we go!');
            });
        });

    });

})(jQuery);