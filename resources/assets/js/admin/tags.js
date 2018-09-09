import $ from "jquery";

/**
 *
 *  Tags on articles
 *
 */

$(function () {

    let tagContainer = $('.post-tags__container');

    if (document.querySelector('.post-tags') !== null) {

        $('.post-tags__item').click(function () {

            let activeTags = $('.post-tags__tag').find('.post-tags__text');
            let postItemName = $(this).html().replace(/\s/g, '');
            let found = false;
            let foundTag;

            activeTags.each(function (index, element) {

                let name = $(element).html().replace(/\s/g, '');

                if (name === postItemName) {
                    found = true;
                    foundTag = element;
                }

            });

            if (!found) {
                addNewTag($(this).html(), $(this).data('id'));
                $(this).addClass('post-tags__item--active');
            } else {

                $(foundTag).parent().remove();
                $(this).removeClass('post-tags__item--active');

                if ($('.post-tags__tag').length === 0)
                    addEmptyString();

            }

        });

        $(document).on('click', '.post-tags__tag', function () {

            let tags = $('.post-tags__item');
            let clickedName = $(this).find('.post-tags__text').html().replace(/\s/g, '');


            tags.each(function (index, element) {

                let foundName = $(element).html().replace(/\s/g, '');

                if (foundName === clickedName)
                    $(this).removeClass('post-tags__item--active');

            });

            $(this).remove();

            if ($('.post-tags__tag').length === 0)
                addEmptyString();

        });

    }

    function addNewTag(tag, id) {

        let string = `
            
             <div class="post-tags__tag">
                 <div class="post-tags__text">${tag}</div>
                 <i class="post-tags__remove fas fa-times"></i>
                 <input type="hidden" name="tags[${id}]">
             </div>
                   
            `;

        tagContainer.append(string);

        $('.post-tags__empty').remove();

    }

    function addEmptyString() {

        let string = '<div class="post-tags__empty">No tags selected</div>';
        tagContainer.append(string);

    }

});