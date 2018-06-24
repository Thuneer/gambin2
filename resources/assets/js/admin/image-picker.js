import jQuery from "jquery";
import * as Dropzone from "../dropzone";

(function ($) {

    if (document.querySelector('.image-picker-previewddd') !== null) {

        let path = '';
        let imageAdded = false;
        let id= -1;
        let images = $('.image-picker__images');

        let previewContainer = $('.image-picker-preview');

        let searchIcon = $('.image-picker__search-icon');
        let loadingIcon = $('.image-picker__loading-icon');
        let closeIcon = $('.image-picker__close-icon');

        let searchInput = $(".image-picker__input");
        let activeMessage = $('.image-picker__selected');
        let addIcon = $('.image-picker-preview__add');

        // Add CSRF token to header for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });

        // Set images on page load
        setImages();

        if ($('#image-picker-id').data('path')) {
            path = $('#image-picker-id').data('path');
            id = $('#image-picker-id').data('id');
            setActiveImage();
        }

        // Check if dropzone exists on page
        if (document.querySelector('#imagePickerDropzone') !== null) {

            // Initialize dropzone with image-picker id
            var myDropzone = new Dropzone("#imagePickerDropzone", {
                url: "/admin/media",
                headers: {
                    'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
                },
                parallelUploads: 20,
                maxFilesize: 2,
                acceptedFiles: '.jpg,.png,.mp4',
                success(file, res) {

                    console.log(res);

                    $(file.previewElement).find('.dz-success-mark').css('display', 'block');
                    $(file.previewElement).attr('data-path', res.path_thumbnail);
                    $(file.previewElement).attr('data-id', res.id);

                    console.log(file.previewElement);

                    $('#none-found').hide();
                },
                previewTemplate: '        <div class="dz-preview dz-preview--picker dz-file-preview">\n' +
                '            <div class="dz-image"><img data-dz-thumbnail=""></div>\n' +
                '            <div class="dz-details">\n' +
                '                <div class="dz-filename"><span data-dz-name></span></div>\n' +
                '                <div class="dz-size" data-dz-size></div>\n' +
                '                <img data-dz-thumbnail />\n' +
                '            </div>\n' +
                '            <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>\n' +
                '            <div class="dz-success-mark"><span><i class="fas fa-check"></i></span></div>\n' +
                '            <div class="dz-error-mark"><span><i class="fas fa-times"></i></span></div>\n' +
                '            <div class="dz-error-message"><span data-dz-errormessage></span></div>\n' +
                '        </div>',
                dictDefaultMessage: '<div class="dropzone-message"><i class="dropzone-message__icon fas fa-upload"></i><div>Drop files here</div><div class="dropzone-message__or">or</div><div class="dropzone-message__btn">click to upload</div></div>    '

            });
        }


        $(document).on('click', '.image-picker__item', function () {

            $('.image-picker__item').removeClass('image-picker__item--active');

            $(this).addClass('image-picker__item--active');

            activeMessage.html('<b>' + $(this).data('name') + '</b>' + ' selected.');

            path = $(this).data('path');
            id = $(this).data('id');

            setSelectBtnState('enabled');

        });

        $(document).on('click', '.dz-preview--picker', function () {

            if ($(this).hasClass('dz-complete')) {

                $('.dz-preview--picker').removeClass('dz-preview--active');

                $(this).addClass('dz-preview--active');

                path = $(this).data('path');
                id = $(this).data('id');

                setSelectBtnState('enabled');

            }

        });


        // Making sure hovering over items and background works
        $(document).on('mouseenter','.dz-preview--picker', function (event) {

            $(this).parent().css('background-color', 'white');

        }).on('mouseleave','.dz-preview--picker',  function(){
            $(this).parent().css('background-color', '#dfe9ff');
        });

        $(document).on('mouseenter','.dropzone', function (event) {

            $(this).css('background-color', '#dfe9ff');

        }).on('mouseleave','.dropzone',  function(){
            $(this).css('background-color', 'white');
        });


        $('.image-picker__tab').click(function () {

            let tab = $(this).data('tab');
            changeTab(tab, this);

        });

        // On search-input keyUp event fetches images
        searchInput.keyup(function () {

            if ($(this).val().length === 0 || $(this).val().length > 1) {

                setImages();
            }

        });

        $('.image-picker__select').click(function () {
         setActiveImage();
        });

        $('.image-picker-preview__remove').click(function (e) {
            e.stopPropagation();
            clearPreviewImage();
            imageAdded = false;
        });

        function setActiveImage() {

            previewContainer.css('background-image', 'url(/' + path + ')');
            $('.image-picker-preview__add').addClass('image-picker-preview__add--hide');
            $('#image-picker-id').val(id);
            imageAdded = true;

            let src = $(previewContainer).css('background-image');
            let url = src.match(/\((.*?)\)/)[1].replace(/('|")/g, '');

            let img = new Image();
            img.onload = function () {
                previewContainer.css('background-color', 'transparent');
            };

            img.src = url;
            if (img.complete) img.onload();

        }

        previewContainer.hover(function () {

            if (imageAdded) {
                $('.image-picker-preview__remove').fadeIn(100);
            }

        }, function () {
            $('.image-picker-preview__remove').fadeOut(100);
        });

        closeIcon.click(function () {
            clearSearch();
        });

        function setImages() {

            $('.image-picker__images').prepend('<div class="image-picker__overlay"></div>');

            searchIcon.hide();
            closeIcon.hide();
            loadingIcon.show();

            // Ajax request for getting images
            $.ajax({
                url: APP_URL + '/admin/media/getImages',
                method: 'get',
                data: {
                    search: searchInput.val()
                },
                success: function (result) {

                    images.html('');
                    console.log(result);

                    for (let i = 0; i < result.length; i++) {
                        images.append(' <div style="background-color:' + result[i].color + ';background-image: url(/' + result[i].path_thumbnail + ')" class="image-picker__item" data-name="' + result[i].name + '" data-path="' + result[i].path_thumbnail + '" data-id="' + result[i].id + '"></div>');
                    }

                    $('.image-picker__item').each(function (index, element) {

                        let src = $(element).css('background-image');
                        let url = src.match(/\((.*?)\)/)[1].replace(/('|")/g, '');

                        let img = new Image();
                        img.onload = function () {
                            $(element).css('background-color', 'transparent');
                        };

                        img.src = url;
                        if (img.complete) img.onload();

                    });

                    if (result.length === 0) {
                        $('.image-picker__images').html('<div class="image-picker__empty">No Images found.</div>');
                    }

                    if (searchInput.val().length === 0) {
                        searchIcon.show();
                        closeIcon.hide();
                    }

                    else {
                        closeIcon.show();
                        searchIcon.hide();
                    }

                    loadingIcon.hide();

                }
            });

        }

        // Changes tab
        function changeTab(tab, selector) {

            if (tab === 1) {
                clearDropzone();
                setImages();
                setSelectBtnState('disabled');
                $('.image-picker__library').show();
                $('.image-picker__upload').hide();
                $(selector).addClass('image-picker__tab--active');
                $(selector).next().removeClass('image-picker__tab--active');
            } else {
                $('.image-picker__library').hide();
                $('.image-picker__upload').show();
                clearSearch();
                clearActiveImage();
                setSelectBtnState('disabled');
                $(selector).addClass('image-picker__tab--active');
                $(selector).prev().removeClass('image-picker__tab--active');
            }

        }

        // Clears dropzone area
        function clearDropzone() {

            $('.dz-preview').remove();
            $('.dropzone').removeClass('dz-started');

        }

        function clearSearch() {

            if (searchInput.val().length > 0) {
                searchInput.val('');
                setImages();
                clearActiveImage();
            }

        }

        // Clears the active image
        function clearActiveImage() {
            activeMessage.html('No image selected.');
            $('.image-picker__item').removeClass('image-picker__item--active');
            setSelectBtnState('disabled');
            $('#image-picker-id').val('');
        }

        // Sets the select button's disabled property based on given state
        function setSelectBtnState(state) {
            if (state === 'disabled')
                $('.image-picker__select').prop('disabled', true);
            else
                $('.image-picker__select').prop('disabled', false);
        }

        function clearPreviewImage() {

            $('.image-picker-preview').attr('style', '');
            addIcon.removeClass('image-picker-preview__add--hide');
            $('.image-picker-preview__remove').hide();
            clearActiveImage();
            path = '';

        }

    }

    $('.grid__img, .list__img').each(function (index, element) {

        let src = $(element).css('background-image');
        let url = src.match(/\((.*?)\)/)[1].replace(/('|")/g, '');

        let img = new Image();
        img.onload = function () {
            $(element).css('background-color', 'transparent');
        };

        img.src = url;
        if (img.complete) img.onload();

    });


})(jQuery);