import jQuery from 'jquery';
import dragula from 'dragula';

(function ($) {

    let backgroundColorClasses = [
        'articles__element--bg-white',
        'articles__element--bg-red',
        'articles__element--bg-green',
        'articles__element--bg-blue',
        'articles__element--bg-purple',
        'articles__element--bg-black'
    ];

    let colorClasses = [
        'articles__element--color-black',
        'articles__element--color-grey',
        'articles__element--color-white'
    ];

    let fontSizeClasses = [
        'articles__element--font-size-xs',
        'articles__element--font-size-s',
        'articles__element--font-size-m',
        'articles__element--font-size-l',
        'articles__element--font-size-xl',
    ];

    let fontWeightClasses = [
        'articles__element--font-weight-s',
        'articles__element--font-weight-m',
        'articles__element--font-weight-l',
    ];

    let imageHeightClasses = [
        'articles__element--image-height-s',
        'articles__element--image-height-m',
        'articles__element--image-height-l',
        'articles__element--image-height-xl',
    ];

    let articlesTab = $('.pb-articles');
    let elementsTab = $('.pb-elements');
    let elementTab = $('.pb-element');

    let activeElement = null;
    let drakeRow, drakeElements;

    let ajaxArticlePage = 1;

    // Init
    (function init() {
        setupDragEvents();
        setupArticleElementEvents();
        setupDeleteElementEvent();
        setupCircleControlClickEvent();
        setupTextKeyUpEvent();
        setupTabSwitchingClickEvents();
        getImages();
    }());

    $('.pb-element__header-icon').click(function () {
        deselectActiveElement();
    });

    $(document).on('click', '.pb-header__icon', function (e) {

        let articles = $('.articles');
        let rows = articles.find('.articles__row');
        let output = document.createElement('div');
        output.className = 'articles container';

        for (let i = 0; i < rows.length; i++) {

            let row = document.createElement('div');
            row.className = 'articles__row row';
            output.append(row);

            let columns = $(rows[i]).find('.articles__column');

            for (let j = 0; j < columns.length; j++) {

                let column = document.createElement('div');
                column.classList = columns[j].classList;
                row.append(column);

                let articles = $(columns[j]).find('.articles__main');

                for (let k = 0; k < articles.length; k++) {

                    let article = document.createElement('a');
                    article.className = 'articles__item';
                    $(article).attr('href', '/a/eee');
                    column.append(article);


                    let items = $(articles[k]).children();

                    for (let l = 0; l < items.length; l++) {

                        let item = null;

                        if ($(items[l]).hasClass('articles__img')) {

                            item = document.createElement('img');
                            item.classList = items[l].classList;
                            $(item).attr('src', $(items[l]).attr('src'));

                        } else {

                            item = document.createElement('div');
                            item.classList = items[l].classList;

                            let elements = $(items[l]).find('.articles__box').children();

                            for (let m = 0; m < elements.length; m++) {

                                let element = null;

                                if ($(elements[m]).hasClass('articles__header')) {
                                    element = document.createElement('H2');
                                } else {
                                    element = document.createElement('P');
                                }

                                $(element).text($(elements[m]).text());
                                element.classList = elements[m].classList;
                                item.append(element);

                            }


                        }

                        article.append(item);

                    }

                }

            }

        }

        $('#pb-content').val(output.outerHTML);

        console.log(output);

    });

    function deselectActiveElement() {
        $(activeElement).removeClass('articles__element--selected');
        activeElement = null;
        elementTab.hide();
    }

    function addClassToActiveElement(value, identifiers, array) {

        for (let i = 0; i < identifiers.length; i++) {

            if (value.includes(identifiers[i])) {
                $(activeElement).addClass(array[i]);
            }

        }

    }

    function setupCircleControlClickEvent() {

        $('.pb-element__circle').click((e) => {

            e.stopPropagation();

            let parent = $(e.target).parent();
            let activeClass = parent.attr('data-active');
            let value = $(e.target).attr('data-value');

            if ($(e.target).attr('id') === 'delete-element') {
                return;
            }

            if (value.includes('bg')) {
                removeClassesFromElement(backgroundColorClasses, activeElement);
                addClassToActiveElement(value, ['white', 'red', 'green', 'blue', 'purple', 'black'], backgroundColorClasses);
            }
            else if (value.includes('color')) {
                removeClassesFromElement(colorClasses, activeElement);
                addClassToActiveElement(value, ['black', 'grey', 'white'], colorClasses);
            }
            else if (value.includes('font-size')) {
                removeClassesFromElement(fontSizeClasses, activeElement);
                addClassToActiveElement(value, ['font-size-xs', 'font-size-s', 'font-size-m', 'font-size-l', 'font-size-xl'], fontSizeClasses);
            }
            else if (value.includes('font-weight')) {
                removeClassesFromElement(fontWeightClasses, activeElement);
                addClassToActiveElement(value, ['font-weight-s', 'font-weight-m', 'font-weight-l'], fontWeightClasses);
            }
            else if (value.includes('image-height')) {

                removeClassesFromElement(imageHeightClasses, activeElement);
                addClassToActiveElement(value, ['image-height-s', 'image-height-m', 'image-height-l', 'image-height-xl'], imageHeightClasses);

                let imageString = '';

                if (value === 'image-height-s') {
                    imageString = '-21-9-md.';
                }
                else if (value === 'image-height-m') {
                    imageString = '-16-9-md.';
                }
                else if (value === 'image-height-l') {
                    imageString = '-4-3-md.';
                }
                else if (value === 'image-height-xl') {
                    imageString = '-1-1-md.';
                }

                $(activeElement).attr('src', '/' + $(activeElement).attr('data-path') + imageString + $(activeElement).attr('data-extension'));

            }

            parent.children().each(function (index, element) {
                $(element).removeClass(activeClass);
            });

            $(e.target).addClass(activeClass);
            setColumnHeights();

        });
    }

    function hideAllElementGroups() {

        let elementGroups = $('.pb-element__container').find('.pb-element__group');

        for (let i = 0; i < elementGroups.length; i++) {
            if (i !== 0) {
                $(elementGroups[i]).hide();
            }
        }

    }

    function setTabMode(mode) {

        articlesTab.hide();
        elementsTab.hide();

        if (mode === 'articles') {
            articlesTab.show();
        } else if (mode === 'elements') {
            elementsTab.show();
        }

    }

    function removeClassesFromElement(classes, element) {

        for (let i = 0; i < classes.length; i++) {
            if ($(element).addClass(classes[i])) {
                $(element).removeClass(classes[i]);
            }
        }

    }

    function setElementType() {

        let type = null;

        if ($(activeElement).prop('tagName') === 'H2') {
            type = 'Heading';
        } else if ($(activeElement).prop('tagName') === 'P') {
            type = 'Paragraph';
        } else if ($(activeElement).prop('tagName') === 'IMG') {
            type = 'Image';
        } else if ($(activeElement).prop('tagName') === 'DIV') {
            type = 'Box';
        }

        $('#pb-element-type').text(type);

        return type;

    }

    function setElementText() {
        let textEle = $('.pb-element__text');
        let activeText = $(activeElement).text().replace(/\s+/g, ' ').trim();
        textEle.val(activeText);
    }

    function setupTextKeyUpEvent() {
        $(document).on('keyup', '.pb-element__text', function () {
            $(activeElement).text($(this).val());
        });
    }

    function setupElementStyles(classArray, position, groupClassName, activeClass, idPrefix) {

        let identifier = null;

        for (let i = 0; i < classArray.length; i++) {
            if ($(activeElement).hasClass(classArray[i])) {
                identifier = classArray[i].substr(position, 15);
            }
        }

        let circleElements = $(groupClassName).find('.pb-element__circle');

        for (let i = 0; i < circleElements.length; i++) {

            removeClassesFromElement([activeClass], circleElements[i]);

            if (identifier !== null && $(circleElements[i]).attr('id') === idPrefix + '-' + identifier) {
                $(circleElements[i]).addClass(activeClass);
            }
        }

    }

    // Changes between the articles and elements tab on the sidebar
    function setupTabSwitchingClickEvents() {
        $('.pb-controls__item').click(function (e) {

            let tab = $(e.target).attr('data-tab');

            if (tab === '0') {
                $(e.target).addClass('pb-controls__item--active');
                $(e.target).next().removeClass('pb-controls__item--active');
                setTabMode('articles');
            } else {
                $(e.target).addClass('pb-controls__item--active');
                $(e.target).prev().removeClass('pb-controls__item--active');
                setTabMode('elements')
            }

        });
    }

    function setupArticleElementEvents() {

        setupElementHoverEvents();

        $(document).on('click', '.articles__element,.articles__img,.articles__box-container', (e) => {

            /*
            if ($(e.target).hasClass('articles__box-container')) {
                return;
            }
            */

            e.stopPropagation();

            if (activeElement !== null) {
                $(activeElement).removeClass('articles__element--selected');
            }

            activeElement = $(e.target);

            $(activeElement).addClass('articles__element--selected');

            elementTab.show();
            setupElementStyles(backgroundColorClasses, 22, '#background-color-selection', 'pb-element__color--active', 'bgc');
            setupElementStyles(colorClasses, 25, '#color-selection', 'pb-element__color--active', 'co');
            setupElementStyles(fontSizeClasses, 29, '#font-size-selection', 'pb-element__size--active', 'fs');
            setupElementStyles(fontWeightClasses, 31, '#font-weight-selection', 'pb-element__size--active', 'fw');
            setupElementStyles(imageHeightClasses, 32, '#image-height-selection', 'pb-element__size--active', 'ih');
            setElementText();

            let type = setElementType();
            hideAllElementGroups();
            showElementGroups(type);

        });
    }

    // Sets up the active element hover class as the user hovers over the elements
    function setupElementHoverEvents() {
        $(document).on('mouseenter', '.articles__img,.articles__box-container', function (e) {
            e.stopPropagation();
            $(this).addClass('articles__element--active');
        });

        $(document).on('mouseleave', '.articles__img,.articles__box-container', function (e) {
            $(this).removeClass('articles__element--active');
        });


        $(document).on('mouseenter', '.articles__element', function (e) {
            e.stopPropagation();

            let box = $(e.target).parent().parent();

            if (box.hasClass('articles__box-container')) {
                box.removeClass('articles__element--active');
            }

            $(this).addClass('articles__element--active');
        });

        $(document).on('mouseleave', '.articles__element', function (e) {

            let box = $(e.target).parent().parent();

            if (box.hasClass('articles__box-container')) {
                box.addClass('articles__element--active');
            }

            $(this).removeClass('articles__element--active');

        });

    }

    // Shows the element options based on type of clicked DOM element
    function showElementGroups(type) {

        if (type === 'Heading' || type === 'Paragraph') {
            $('#text-selection').show();
            $('#background-color-selection').show();
            $('#color-selection').show();
            $('#font-size-selection').show();
            $('#font-weight-selection').show();
            $('#actions-selection').show();
        }

        if (type === 'Image') {
            $('#image-height-selection').show();
            $('#actions-selection').show();
        }

        if (type === 'Box') {
            $('#background-color-selection').show();
            $('#actions-selection').show();
        }

    }

    function setupDragEvents() {

        setupElementDragEvent();

        dragula($('.articles').toArray(), {
            direction: 'vertical',
            moves: function (el, container, handle) {
                return $(handle).hasClass('pb-row-controls__icon--drag');
            }
        });

        dragArticleRow();

        $('.pb__right').click(function (e) {

            if ($(e.target).hasClass('pb__right') && activeElement !== null) {
                deselectActiveElement();
            }

        });

    }

    function setColumnHeights() {
        setTimeout(() => {

            let rows = $('.articles__row');

            for (let i = 0; i < rows.length; i++) {

                let columns = $(rows[i]).find('.articles__main-container');
                let maxHeight = 0;

                for (let j = 0; j < columns.length; j++) {

                    $(columns[j]).attr('style', '');

                    let currentHeight = $(columns[j]).height();

                    if (maxHeight < currentHeight) {
                        maxHeight = currentHeight;
                    }

                }

                for (let j = 0; j < columns.length; j++) {

                    $(columns[j]).css({height: maxHeight + 'px'});
                }

            }

        }, 20);

    }

    // Deletes the active element
    function setupDeleteElementEvent() {
        $('#delete-element').click(() => {
            $(activeElement).remove();
            setColumnHeights();
        });
    }

    function setupElementDragEvent() {
        drakeElements = dragula($('.articles__item').toArray(), {
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
                drakeElements.cancel(true);
                $(el).remove();
            }

            if ($(source).hasClass('pb-articles__container') && $(target).hasClass('articles__item')) {
                $(target).find('.articles__main-container').remove();

                let article = {
                    id: $(el).attr('data-id'),
                    title: $(el).attr('data-title'),
                    path: $(el).attr('data-path'),
                    extension: $(el).attr('data-extension')
                };

                setTimeout(function () {
                    $(target).find('.articles-hand').hide();
                }, 20);
                $(el).replaceWith(insertArticle(article));

                drakeElements.containers.push($(target).find('.articles__item')[0]);

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

        $('.pb-delete').mouseup(function (e) {
            //activeElement.remove();
        });
    }


    // Sets up dragula event for sorting rows
    function dragArticleRow() {

        drakeRow = dragula($('.articles__row').toArray(), {
            direction: 'horizontal',
            moves: function (el, container, handle) {
                return $(handle).hasClass('pb-column-controls__icon--drag');
            },
            accepts: function (el, target, source, sibling) {
                return target == source;
            }
        });

    }

    function createSidebarArticle(article) {
        let string = `
        <div class="pb-articles__container">
               <div class="pb-articles__item" data-id="${article['id']}" data-path="${article['images'][0]['path']}" data-extension="${article['images'][0]['extension']}" data-title="${article['title']}">
                  <div class="pb-articles__img" style="background-image: url('/${article['images'][0]['path'] + '.' + article['images'][0]['extension']}')"></div>
                  <h3 class="pb-articles__title">${article['title']}</h3>
                  
                  <i class="pb-articles__link fas fa-link"></i>
              </div>
         </div>`;

        return string;

    }

    function insertArticle(article) {

        let string = `
        <div class="articles__main-container" data-id="${article.id}">     
                <div class="articles__main">
        
                   <img class="articles__img articles__element--image-height-s" src="/${article['path'] + '-21-9-md.' + article['extension']}" alt="" data-path="${article['path']}" data-extension="${article['extension']}">              
           
                    <div class="articles__box-container articles__element--bg-white">
                         <div class="articles__box">
                            <h2 class="articles__element articles__header articles__element--bg-white articles__element--color-black articles__element--font-size-l articles__element--font-weight-l">
                            ${article['title']}
                            </h2>
                        </div>
                    </div>
           
             </div>
        </div>`;

        return string;

    }

    function getImages() {

        // Ajax request for getting images
        $.ajax({
            url: '/admin/articles/1',
            method: 'get',
            data: {
                search: 'fff'
            },
            success: function (result) {

                for (let i = 0; i < result.length; i++) {
                    $('.pb-articles').append(createSidebarArticle(result[i]));
                }

            }
        });

    }

    // Adds new row to page
    $('.articles__new').click(function () {

        let string = `
<div class="row articles__row">
                        <div class="pb-row-controls">
                            <div class="pb-row-controls__icon pb-row-controls__icon--drag fas fa-arrows-alt"></div>
                            <div class="pb-row-controls__icon pb-row-controls__icon--menu fas fa-bars" type="button" data-toggle="dropdown"></div>
                            <div class="pb-row-controls__icon pb-row-controls__icon--delete fas fa-trash-alt"></div>
                            <div class="dropdown">
                                <div class="dropdown-menu">
                                    <h6 class="dropdown-header">Column types</h6>
                                    <button data-value="12" class="dropdown-item" type="button">Column 12</button>
                                    <button data-value="6-6" class="dropdown-item" type="button">Column 6 + 6</button>
                                    <button data-value="4-6" class="dropdown-item" type="button">Column 4 + 8</button>
                                    <button data-value="6-4" class="dropdown-item" type="button">Column 8 + 4</button>
                                    <button data-value="4-4-4" class="dropdown-item" type="button">Column 4 + 4 + 4</button>
                                </div>
                            </div>
                        </div>

                        <div class="articles__column col-md-4">
                            <div class="articles__item">
                                <div class="pb-column-controls">
                                    <div class="pb-column-controls__icon pb-column-controls__icon--drag fas fa-arrows-alt"></div>
                                    <div class="pb-column-controls__icon pb-column-controls__icon--menu fas fa-bars"></div>
                                    <div class="pb-column-controls__icon pb-column-controls__icon--delete fas fa-trash-alt"></div>
                                </div>

                                <div class="articles-hand">
                                    <div><i class="articles-hand__icon far fa-hand-point-down"></i></div>
                                    <p class="articles-hand__text">Drop article here</p>
                                </div>

                            </div>
                        </div>

                        <div class="articles__column col-md-4">
                            <div class="articles__item">
                                <div class="pb-column-controls">
                                    <div class="pb-column-controls__icon pb-column-controls__icon--drag fas fa-arrows-alt"></div>
                                    <div class="pb-column-controls__icon pb-column-controls__icon--menu fas fa-bars"></div>
                                    <div class="pb-column-controls__icon pb-column-controls__icon--delete fas fa-trash-alt"></div>
                                </div>

                                <div class="articles-hand">
                                    <div><i class="articles-hand__icon far fa-hand-point-down"></i></div>
                                    <p class="articles-hand__text">Drop article here</p>
                                </div>

                            </div>
                        </div>

                        <div class="articles__column col-md-4">
                            <div class="articles__item">
                                <div class="pb-column-controls">
                                    <div class="pb-column-controls__icon pb-column-controls__icon--drag fas fa-arrows-alt"></div>
                                    <div class="pb-column-controls__icon pb-column-controls__icon--menu fas fa-bars"></div>
                                    <div class="pb-column-controls__icon pb-column-controls__icon--delete fas fa-trash-alt"></div>
                                </div>

                                <div class="articles-hand">
                                    <div><i class="articles-hand__icon far fa-hand-point-down"></i></div>
                                    <p class="articles-hand__text">Drop article here</p>
                                </div>

                            </div>
                        </div>

                    </div>`;

        $('.articles__new-container').after(string);


        // Makes the new added element draggable
        drakeElements.containers.push($('.articles__row').first().find('.articles__item')[0]);
        drakeElements.containers.push($('.articles__row').first().find('.articles__item')[1]);
        drakeElements.containers.push($('.articles__row').first().find('.articles__item')[2]);
        drakeRow.containers.push($('.articles__row')[0]);

    });

    $(document).on('click', '.pb-row-controls__icon--delete', function (e) {
        $(e.target).parent().parent().remove();
        deselectActiveElement();
    });

    $(document).on('click', '.pb-column-controls__icon--delete', function (e) {

        let columns = $(e.target).parent().parent().parent().parent().find('.articles__column');
        let column = $(e.target).parent().parent().parent()[0];

        if (columns.length > 1) {
            $(column).remove();
        }

        if (columns.length === 3) {

            for (let i = 0; i < columns.length; i++) {
                $(columns[i]).removeClass('col-md-4');
                $(columns[i]).addClass('col-md-6');
            }

        } else if (columns.length === 2) {

            for (let i = 0; i < columns.length; i++) {
                $(columns[i]).removeClass('col-md-12');
                $(columns[i]).addClass('col-md-12');
            }

        } else if (columns.length === 1) {

            $(columns).find('.articles__container').remove();

        }

        setColumnHeights();
        $(elementTab).hide();
        deselectActiveElement();

    });

    $(document).on('click', '.dropdown-item', function (e) {

        let value = $(e.target).attr('data-value');
        let row = $(e.target).parent().parent().parent().parent();

        console.log(row);

        $(row).find('.articles__column').remove();

        if (value === '12') {
            $(row).append(addColumn('col-md-12'));
        } else if (value === '6-6') {
            $(row).append(addColumn('col-md-6'));
            $(row).append(addColumn('col-md-6'));
        } else if (value === '4-6') {
            $(row).append(addColumn('col-md-4'));
            $(row).append(addColumn('col-md-8'));
        } else if (value === '6-4') {
            $(row).append(addColumn('col-md-8'));
            $(row).append(addColumn('col-md-4'));
        } else if (value === '4-4-4') {
            $(row).append(addColumn('col-md-4'));
            $(row).append(addColumn('col-md-4'));
            $(row).append(addColumn('col-md-4'));
        }

        let containers = $(row).first().find('.articles__item');

        for (let i = 0; i < containers.length; i++) {
            drakeElements.containers.push(containers[i]);
        }

    });

    function addColumn(type) {

        return `
    <div class="articles__column ${type}">
            <div class="articles__item">
            <div class="pb-column-controls">
            <div class="pb-column-controls__icon pb-column-controls__icon--drag fas fa-arrows-alt"></div>
            <div class="pb-column-controls__icon pb-column-controls__icon--menu fas fa-bars"></div>
            <div class="pb-column-controls__icon pb-column-controls__icon--delete fas fa-trash-alt"></div>
            </div>

            <div class="articles-hand">
            <div><i class="articles-hand__icon far fa-hand-point-down"></i></div>
        <p class="articles-hand__text">Drop article here</p>
        </div>

        </div>
        </div>`;

    }

}(jQuery));
