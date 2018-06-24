import jQuery from "jquery";

(function ($) {

    $('.permission-checkbox').click(function () {

        let loadingIcon =  $(this).parent().parent().find('.permissions__loading');
        let successIcon =  $(this).parent().parent().find('.permissions__success');

        loadingIcon.fadeIn(200);

        $.ajax({
            url: '/admin/permissions/',
            data: {
              permission: $(this).val(),
                checked: $(this).is(':checked'),
                role_id: $('#role_id').val()
            },
            headers: {
                'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
            },
            type: 'POST',
            success: function (data) {
                loadingIcon.hide();
                successIcon.fadeIn(200);
                setTimeout(function () {
                    successIcon.fadeOut(200);
                }, 1000);


            },
            error: function (data) {

                if (data.responseJSON === 'refresh') {
                    window.location.href  = '/admin/permissions'
                }

            }
        });

    });

})(jQuery);