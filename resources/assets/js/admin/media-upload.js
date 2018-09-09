import * as Dropzone from "../dropzone";
import $ from 'jquery';

/**
 *
 *  Handles uploading files in the media section with dropzone
 *
 */

Dropzone.autoDiscover = false;

$(function () {

    if (document.querySelector('#media-upload-dropzone') !== null) {

        // THis is the dropzone instance for uploading files
        let mediaDropzone = new Dropzone("#media-upload-dropzone", {
            url: "/admin/media",
            headers: {
                'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
            },
            parallelUploads: 20,
            maxFilesize: 2,
            acceptedFiles: '.jpg,.png,.mp4',
            success(file, res) {

                // Adds either grid or list item depending on what is currently open
                if ($('.grid')[0]) {
                    addGridItem(res);
                }
                else {
                    addListColumn(res);
                }

                // Sets the background color to transparent when image is finished loading
                let src = $('.current-' + res.id).css('background-image');
                let url = src.match(/\((.*?)\)/)[1].replace(/('|")/g, '');

                let img = new Image();
                img.onload = function () {
                    $('.current-' + res.id).css('background-color', 'transparent');
                };

                img.src = url;
                if (img.complete) img.onload();

                $(file.previewElement).find('.dz-success-mark').css('display', 'block');
                $('#none-found').hide();
            },
            previewTemplate: '        <div class="dz-preview dz-file-preview">\n' +
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

    // Adds a new list item to the list
    function addListColumn(response) {

        let string = `
    
    <tr class="list__column">

                        <input class="list-id" type="hidden" value="${response.id}">
                        <input class="list-name" type="hidden" value="${response.name}">

                        <td class="list__td list__primary">
                            <input class="list__checkbox" id="styled-checkbox-${response.id}" type="checkbox">
                            <label for="styled-checkbox-${response.id}"></label>
                        </td>

                        <td class="list__td list__primary">

                                <span class="imageInfo" data-id="${response.id}" data-name="${response.name}" data-path="${response.path + '.' + response.extension}}" data-updated="1 minute ago" data-size="2.37 MB" data-alt="" data-title="" data-resx="1280" data-resy="720" data-extension="jpg">
                                </span>
    
                            <button class="list__link" data-popshow="mediaDetails">
                                    <span class="list__img current-${response.id}" style="background-color: ${response.name}; background-image: url(/${response.path + '.' + response.extension})"></span>
    
                                <span class="list__title">img3</span>
    
                            </button>
                            <i class="list-dropdown__show fas fa-eye"></i>
                         </td>   

            
                        <td class="list__td">${response.extension}</td>

                        <td class="list__td">${response.size}</td>
                        <td class="list__td">Yes</td>



                        <td class="list__td">

                            <button class="list__edit">Edit</button>
                            <button class="list__delete" data-toggle="modal" data-target="#deleteModal">Delete</button>

                        </td>

                    </tr>
    
    `;

        $('tbody').prepend(string);

    }


    // Adds a new grid item to the grid
    function addGridItem(response) {

        let string = `
    
    <div class="grid__item" data-popshow="mediaDetails">

             <span class="imageInfo"
                            data-id="${response.id}"
                            data-name="${response.name}}"
                            data-path="${response.path + '.' + response.extension}"   
                    ></span>

                    <div class="grid__img current-${response.id}" style="background-color: ${response.color};background-image: url(/${response.path + '.' + response.extension})"></div>
                    <div class="grid__details">
                        f
                    </div>
                </div>
    
    
    `;

        $('.grid').prepend(string);

    }

    // Event that is run when upload modal is closed
    $('#mediaAddModal').on('hidden.bs.modal', function () {
        $('.dz-preview').remove();
        $('.dropzone').removeClass('dz-started');
    });

});