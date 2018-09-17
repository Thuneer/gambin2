import $ from "jquery";
import * as Dropzone from "../dropzone";

/**
 *
 *  This is the image picker which is used to select images
 *  when creating or editing articles, pages and users
 *
 */

$(function () {

    let libraryContainer = $('.picker__library');
    let uploadContainer = $('.picker__upload');
    let overlayContainer = $('.picker__overlay');
    let modalContainer = $('.picker__modal');
    let listContainer = $('.picker-list');
    let gridContainer = $('.picker-grid');

    let loadingIcon = $('.picker__loading');

    let selectedText = $('.picker__footer-selected');
    let selectBtn = $('.picker__select-btn');
    let emptyText = $('.picker__empty');

    let imagePreview = $('.image-picker-preview');
    let previewAdd = $('.image-picker-preview__add');
    let previewRemove = $('.image-picker-preview__remove');

    let sidebarBtn = $('.picker-sidebar__btn');
    let exitBtn = $('.picker__exit');
    let gridToggleBtn = $('#gridBtn');
    let listToggleBtn = $('#listBtn');

    let pickedImage = {
        path: '',
        id: -1,
        name: ''
    };

    let inputSearch = $('.picker-top__input');
    let searchBtn = $('.picker-top__search-btn');
    let clearBtn = $('.picker-top__clear-btn');

    let previewIdentifier = $('#image-picker-id');
    let imagePicked = false;

    // Only runs INIT function if class exists on page
    if (document.querySelector('.image-picker-preview') !== null) {

        (function init() {

            setExistingImage();

            setupEvents();

            initializeDropzone();

        }());

    }

    function setExistingImage() {
        if (previewIdentifier.data('path')) {
            pickedImage.path = previewIdentifier.data('path');
            pickedImage.id = previewIdentifier.data('id');
            pickImage();
        }
    }

    function setupEvents() {

        // Changes between the library and upload tab from the sidebar
        sidebarBtn.click(function () {
            let tab = $(this).data('tab');
            changeTab(tab);
        });

        // Exit button on the top right closes image picker
        exitBtn.click(function () {
            hideModal();
        });

        // Switches between list ang grid mode for images
        $(listToggleBtn).add(gridToggleBtn).click(function () {

            let list = $(this).data('list');

            if (list === 1) {
                setListMode(this);
            } else {
                setGridMode(this);
            }

        });

        // Opens up the image picker when user clicks on the preview image
        imagePreview.click(function () {
            showModal();
        });

        // Fades in a cross icon when user hovers over selected preview image to indicate removal action
        imagePreview.hover(function () {
            if (imagePicked)
                previewRemove.fadeIn(150);

        }, function () {
            previewRemove.hide();
        });

        // Removes selected preview image when user clicks cross
        previewRemove.click(function (e) {
            e.stopPropagation();
            removePickedImage();
        });

        // Selects the image from the image picker
        selectBtn.click(function () {
            pickImage();
            hideModal();
        });

        // Hides the image picker if user clicks anywhere outside it
        overlayContainer.click(function () {
            hideModal();
        });

        // Ajax search for the images
        inputSearch.keyup(function () {

            if ($(this).val().length > 1) {
                clearBtn.show();
                searchBtn.hide();
                getImages();

            } else if ($(this).val().length === 0) {

                clearBtn.hide();
                searchBtn.show();
                getImages();

            }

        });

        // Clears the search text for ajax image seach
        clearBtn.click(function () {
            clearSearch();
        });

        $(document).on('click', '.picker-grid__item,.picker-list__item,.dz-preview--picker', function () {

            let id = $(this).data('id');
            let name = $(this).data('name');
            clickImage(id, name, this);

        });
    }

    function initializeDropzone() {
        // Initialize dropzone with image-picker id
        let myDropzone = new Dropzone("#imagePickerDropzone", {
            url: "/admin/media",
            headers: {
                'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
            },
            parallelUploads: 20,
            maxFilesize: 2,
            acceptedFiles: '.jpg,.png,.mp4',
            success(file, res) {

                $(file.previewElement).find('.dz-success-mark').css('display', 'block');
                $(file.previewElement).attr('data-path', res.path + '-4-3-sm' + '.' + res.extension);
                $(file.previewElement).attr('data-id', res.id);
                $(file.previewElement).attr('data-name', res.name);


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

    function getImages() {

        loadingIcon.show();
        gridContainer.html('');
        listContainer.html('');
        emptyText.css('display', 'none');

        setTimeout(function () {

            // Ajax request for getting images
            $.ajax({
                url: '/admin/media/getImages',
                method: 'get',
                data: {
                    search: inputSearch.val()
                },
                success: function (result) {

                    gridContainer.html('');
                    loadingIcon.hide();

                    for (let i = 0; i < result.length; i++) {
                        gridContainer.append(getGridItem(result[i]));
                        listContainer.append(getListItem(result[i]));
                    }

                    // Sets the background-color to transparent after images are loaded
                    $('.picker-grid__item').each(function (index, element) {

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
                        emptyText.css('display', 'flex');
                    } else {
                        emptyText.css('display', 'none');
                    }

                }
            });

        }, 50);


    }

    function clearSearch() {
        inputSearch.val('');
        clearBtn.hide();
        searchBtn.show();
        getImages();
    }

    // Creates and returns the HTML for a grid item
    function getGridItem(item) {

        return `<div class="picker-grid__item" style="
        background-color: ${item.color};
        background-image: url('/${item.path + '-4-3-sm' + '.' + item.extension}')" 
        data-id="${item.id}" 
        data-name="${item.name}" 
        data-path="${item.path + '.' + item.extension}">
        </div>`;

    }

    // Creates and returns the HTML for a list item
    function getListItem(item) {

        return `<div class="picker-list__item" data-id="${item.id}" data-name="${item.name}" data-path="${item.path}">
                    <div class="picker-list__img" style="background-image: url('/${item.path + '-4-3-sm' + '.' + item.extension}')"></div>
                    <div class="picker-list__title">${item.name}</div>
                    <i class="picker-list__check fas fa-check"></i>
                </div>`;

    }


    function pickImage() {
        imagePreview.css('background-image', 'url("/' + pickedImage.path + '")');
        previewAdd.hide();
        imagePicked = true;
        previewIdentifier.val(pickedImage.id);

        // Sets the background-color to transparent after image is loaded
        let src = $(imagePreview).css('background-image');
        let url = src.match(/\((.*?)\)/)[1].replace(/('|")/g, '');

        let img = new Image();
        img.onload = function () {
            imagePreview.css('background-color', 'transparent');
        };

        img.src = url;
        if (img.complete) img.onload();

    }

    function removePickedImage() {
        imagePreview.css('background-image', '');
        pickedImage.path = '';
        previewAdd.css('display', 'block');
        previewRemove.hide();
        imagePicked = false;
        imagePreview.prop('style', '');
        previewIdentifier.val('');
    }

    function resetLibrary() {
        selectBtn.prop('disabled', true);
        selectedText.html('');
    }

    function clearDropzone() {
        $('.dz-preview').remove();
        $('.dropzone').removeClass('dz-started');
    }

    function clickImage(id, name, that) {

        let items = $('.picker__library').find(`[data-id='${id}']`);

        $('.picker-grid__item').removeClass('picker-grid__item--active');
        $('.picker-list__item').removeClass('picker-list__item--active');

        $(items[0]).addClass('picker-grid__item--active');
        $(items[1]).addClass('picker-list__item--active');

        selectedText.html('You selected <b>' + name + '</b>.');

        pickedImage.path = $(that).data('path');
        pickedImage.id = $(that).data('id');
        pickedImage.name = $(that).data('name');

        selectBtn.prop('disabled', false);

    }

    // Change between library and upload tabs
    function changeTab(tab) {

        if (tab === 'library') {
            getImages();
            $('#libraryTabBtn').addClass('picker-sidebar__btn--active');
            $('#uploadTabBtn').removeClass('picker-sidebar__btn--active');
            libraryContainer.fadeIn(200);
            uploadContainer.hide();
            clearDropzone();
        } else {
            $('#uploadTabBtn').addClass('picker-sidebar__btn--active');
            $('#libraryTabBtn').removeClass('picker-sidebar__btn--active');
            libraryContainer.hide();
            uploadContainer.fadeIn(200);
        }

    }

    // Change to list mode for images
    function setListMode(that) {
        listContainer.fadeIn(200);
        gridContainer.hide();
        $(that).addClass('picker-top__icon--active');
        $(that).prev().removeClass('picker-top__icon--active');
    }

    // Change to grid mode for images
    function setGridMode(that) {
        listContainer.hide();
        gridContainer.fadeIn(200);
        $(that).addClass('picker-top__icon--active');
        $(that).next().removeClass('picker-top__icon--active');
    }

    // Hide image picker
    function hideModal() {
        modalContainer.fadeOut(200);
        overlayContainer.fadeOut(200);
        resetLibrary();
        clearDropzone();
    }

    function showModal() {
        getImages();
        modalContainer.fadeIn(200);
        overlayContainer.fadeIn(200);
    }

});