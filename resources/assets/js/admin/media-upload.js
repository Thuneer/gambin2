import * as Dropzone from "../dropzone";
import $ from 'jquery';

Dropzone.autoDiscover = false;

if (document.querySelector('#my-awesome-dropzone') !== null) {

    var myDropzone = new Dropzone("#my-awesome-dropzone", {
        url: "/admin/media",
        headers: {
            'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
        },
        parallelUploads: 20,
        maxFilesize: 2,
        acceptedFiles: '.jpg,.png,.mp4',
        success(file, res) {


            if ($('.grid')[0]) {

                addGridItem(res);
                console.log('grid');

            }
            else {

                addListColumn(res);
            }

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
        processing() {
            console.log("ff");
        },
        dictDefaultMessage: '<div class="dropzone-message"><i class="dropzone-message__icon fas fa-upload"></i><div>Drop files here</div><div class="dropzone-message__or">or</div><div class="dropzone-message__btn">click to upload</div></div>    '


    });
}

function addListColumn(response) {

    let string = `
    
    <tr class="list__column">

                        <input class="list-id" type="hidden" value="${response.id}">
                        <input class="list-name" type="hidden" value="${response.name}">

                        <td class="list__td list__primary list__checkbox">
                            <input class="list__checkbox" type="checkbox">
                        </td>

                        <td class="list__td list__primary">
                            <a class="list__link" href="/">      
                                 <span class="list__img current-${response.id}" style="background-color: ${response.color};background-image: url(/${response.path_thumbnail})"></span>
                                ${response.name}
                            </a>
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


function addGridItem(response) {

    let string = `
    
    <div class="grid__item" data-toggle="modal" data-target="#mediaDetails">

                    <div data-info="{
                    &quot;name&quot;: &quot;${response.name}&quot;,
                    &quot;path&quot;: &quot;${response.path_large}&quot;,
                    &quot;updated&quot;: &quot;Just now&quot;,
                    &quot;size&quot;: &quot;${(response.size / 100000).toFixed(2)} MB&quot;,
                    &quot;extension&quot;: &quot;${response.extension}&quot; }"></div>

                    <div class="grid__img current-${response.id}" style="background-color: ${response.color};background-image: url(/${response.path_thumbnail})"></div>
                    <div class="grid__details">
                        f
                    </div>
                </div>
    
    
    `;

    $('.grid').prepend(string);

}

$('#mediaAdd').on('hidden.bs.modal', function () {
    $('.dz-preview').remove();
    $('.dropzone').removeClass('dz-started');
});
