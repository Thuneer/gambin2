import dragula from "dragula";
import $ from 'jquery';
import setColumnHeights from './set-column-heights';
import state from './state';

/*
 * This module handles the dragula drag events on everything except
 * the article__rows and article__columns
 */

export default function setupElementDragEvent() {
    state.drakeElements = dragula($('.articles__item').toArray(), {
        revertOnSpill: true,
        accepts: function (el, target, source, sibling) {

            // Article box
            if (($(el).hasClass('articles__box-container') || $(el).hasClass('articles__img')) && ($(target).hasClass('articles__item') ||
                $(target).hasClass('pb-articles__container') || $(target).hasClass('articles__box'))) {
                return false;
            }

            // Header, paragraph
            if (($(el).hasClass('articles__header') || $(el).hasClass('articles__paragraph')) &&
                ($(target).hasClass('articles__item') || $(target).hasClass('articles__main'))) {
                return false;
            }

            // Sidebar header, paragraph
            if (($(el).attr('id') === 'element-header' || $(el).attr('id') === 'element-paragraph') &&
                ($(target).hasClass('articles__item') || $(target).hasClass('articles__main') || $(target).hasClass('pb-elements__container'))) {
                return false;
            }

            // Sidebar box, image
            if (($(el).attr('id') === 'element-box' || $(el).attr('id') === 'element-image') && ($(target).hasClass('articles__item') ||
                $(target).hasClass('articles__box') || $(target).hasClass('pb-elements__container'))) {
                return false;
            }

            // Sidebar article
            if (($(el).hasClass('pb-articles__item')) && ($(target).hasClass('pb-articles__container') ||
                $(target).hasClass('articles__box') || $(target).hasClass('articles__main'))) {
                return false;
            }

            // Main
            if (($(el).hasClass('articles__main-container')) && ($(target).hasClass('pb-articles__container') ||
                $(target).hasClass('articles__box') || $(target).hasClass('articles__main'))) {
                return false;
            }

            return true;

        },
        isContainer: function (el) {
            return $(el).hasClass('pb-elements__container') || $(el).hasClass('pb-delete') ||
                $(el).hasClass('pb-articles__container') || $(el).hasClass('articles__box') || $(el).hasClass('articles__main');
        },
        copy: function (el, source) {
            return $(source).hasClass('pb-elements__container') || $(source).hasClass('pb-articles__container');
        },
        moves: function (el, container, handle) {
            return !$(handle).hasClass('pb-column-controls') &&
                !$(handle).hasClass('pb-column-controls__icon') &&
                !$(el).hasClass('articles-hand');
        }
    }).on('drop', function (el, target, source, sibling) {

        if ($(target).hasClass('pb-delete')) {
            state.drakeElements.cancel(true);
            $(el).remove();
        }

        if ($(source).hasClass('pb-articles__container') && $(target).hasClass('articles__item')) {
            $(target).find('.articles__main-container').remove();

            let article = {
                id: $(el).attr('data-id'),
                title: $(el).attr('data-title'),
                path: $(el).attr('data-path'),
                extension: $(el).attr('data-extension'),
                link: $(el).attr('data-link')
            };

            setTimeout(function () {
                $(target).find('.articles-hand').hide();
            }, 20);
            $(el).replaceWith(insertArticle(article));

            state.drakeElements.containers.push($(target).find('.articles__item')[0]);

        }

        if ($(el).attr('id') === 'element-header') {
            $(el).replaceWith('<h2 class="articles__header articles__element articles__element--bg-white articles__element--color-black articles__element--font-size-l articles__element--font-weight-l">Header text</h2>')
        }
        else if ($(el).attr('id') === 'element-paragraph') {
            $(el).replaceWith('<h2 class="articles__paragraph articles__element articles__element--bg-white articles__element--color-black articles__element--font-size-s articles__element--font-weight-s">Paragraph text</h2>')
        }
        else if ($(el).attr('id') === 'element-box') {
            $(el).replaceWith(
                `
                    <div class="articles__box-container articles__element--bg-white">
                         <div class="articles__box">
                     
                        </div>
                    </div>                    `)
        }
        else if ($(el).attr('id') === 'element-image') {
            $(el).replaceWith('<div class="articles__img-container">\n' +
                '                                    <img src="http://mycms.test/img/test.jpg" class="articles__img articles__element">\n' +
                '                                </div>')
        }

        setColumnHeights();

    }).on('over', function (el, container, source) {

        if ($(container).hasClass('articles__item')) {
            $(container).parent().find('.articles-hand').hide();
            setColumnHeights();
        }

        if ($(container).hasClass('pb-delete')) {

            $('.pb-delete').addClass('pb-delete__hover');
            $(el).hide();

            if ($(el).hasClass('articles__container')) {
                $(container).parent().parent().find('.articles-hand').show();
            }

        }

        if ($(container).hasClass('articles__box')) {
            setColumnHeights();
        }

    }).on('out', function (el, container, source) {

        if ($(container).hasClass('articles__item')) {
            setColumnHeights();
        }

        if (($(container).hasClass('articles__item')) && ($(el).hasClass('pb-articles__item'))) {

            if ($(container).find('.articles__main').length === 0) {
                $(container).find('.articles-hand').show();
            }

        }

        if ($(container).hasClass('pb-delete')) {
            $('.pb-delete').removeClass('pb-delete__hover');
            $(el).show();
        }

    }).on('drag', function (el, target, source, sibling) {

        if (!$(el).hasClass('pb-elements__item')) {
            $('.pb-delete').fadeIn(250);
        }

    }).on('dragend', function () {
        $('.pb-delete').fadeOut(250);
    });

}


function insertArticle(article) {

    return `
        <div class="articles__main-container" data-id="${article.id}" data-link="${article.link}">     
                <div class="articles__main">
        
                   <img class="articles__img articles__element--image-height-s lazy" src="/${article['path'] + '-21-9-md.' + article['extension']}" alt="" data-path="${article['path']}" data-extension="${article['extension']}">              
           
                    <div class="articles__box-container articles__element--bg-white">
                         <div class="articles__box">
                            <h2 class="articles__element articles__header articles__element--bg-white articles__element--color-black articles__element--font-size-l articles__element--font-weight-l">
                            ${article['title']}
                            </h2>
                        </div>
                    </div>
           
             </div>
        </div>`;

}