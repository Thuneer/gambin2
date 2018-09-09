import $ from "jquery";

$(function () {

    $('.post-preview').click(function (e) {

        e.preventDefault();

        $.ajax({
            url: '/admin/articles/preview/',
            data: $('#form').serializeArray()
            ,
            headers: {
                'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
            },
            type: 'POST',
            success: function (data) {

                console.log(data);
                window.open('/preview/a', 'post-preview');

            },
            error: function (data) {
                console.log(data);

            }
        });

    });

});