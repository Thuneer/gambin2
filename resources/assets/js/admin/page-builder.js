import jQuery from 'jquery';
import dragula from 'dragula';
import setupElementHoverEvents from './page-builder/pb-hover-events';
import setupElementDragEvents from './page-builder/elements-drag-events';
import state from './page-builder/state';
import setColumnHeights from './page-builder/set-column-heights';
import { buildHTMLToPB, buildHTMLToDatabase, columnControls } from './page-builder/html-builders';

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
        'articles__element--color-white',
        'articles__element--color-red'
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


    // Init
    (function init() {
        setupDragEvents();
        setupArticleElementEvents();
        setupDeleteElementEvent();
        setupCircleControlClickEvent();

        setupTextKeyUpEvent();
        setupTabSwitchingClickEvents();
        getImages();

        buildHTMLToDatabase();
        buildHTMLToPB();

    }());

    $('.pb-element__header-icon').click(function () {
        deselectActiveElement();
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
                addClassToActiveElement(value, ['black', 'grey', 'white', 'red'], colorClasses);
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

        setupElementDragEvents();

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

    // Deletes the active element
    function setupDeleteElementEvent() {
        $('#delete-element').click(() => {
            $(activeElement).remove();
            setColumnHeights();
        });
    }

    // Sets up dragula event for sorting rows
    function dragArticleRow() {

        state.drakeRow = dragula($('.articles__row').toArray(), {
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
               <div class="pb-articles__item" data-id="${article['id']}" data-path="${article['images'][0]['path']}" data-extension="${article['images'][0]['extension']}" data-title="${article['title']}" data-link="/articles/${article.slug}">
                  <div class="pb-articles__img" style="background-image: url('/${article['images'][0]['path'] + '.' + article['images'][0]['extension']}')"></div>
                  <h3 class="pb-articles__title">${article['title']}</h3>
                  
                  <i class="pb-articles__link fas fa-link"></i>
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

                        <div class="articles__column col-md-12">
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
        state.drakeElements.containers.push($('.articles__row').first().find('.articles__item')[0]);
        state.drakeElements.containers.push($('.articles__row').first().find('.articles__item')[1]);
        state.drakeElements.containers.push($('.articles__row').first().find('.articles__item')[2]);
        state.drakeRow.containers.push($('.articles__row')[0]);

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

        console.log(value);

        $(row).find('.articles__column').remove();

        if (value === '12') {
            $(row).append(addColumn('col-md-12', columnControls()));
        } else if (value === '6-6') {
            $(row).append(addColumn('col-md-6', columnControls()));
            $(row).append(addColumn('col-md-6', columnControls()));
        } else if (value === '4-6') {
            $(row).append(addColumn('col-md-4', columnControls()));
            $(row).append(addColumn('col-md-8', columnControls()));
        } else if (value === '6-4') {
            $(row).append(addColumn('col-md-8', columnControls()));
            $(row).append(addColumn('col-md-4', columnControls()));
        } else if (value === '4-4-4') {
            $(row).append(addColumn('col-md-4', columnControls()));
            $(row).append(addColumn('col-md-4', columnControls()));
            $(row).append(addColumn('col-md-4', columnControls()));
        }

        let containers = $(row).first().find('.articles__item');

        for (let i = 0; i < containers.length; i++) {
            state.drakeElements.containers.push(containers[i]);
        }

    });

    function addColumn(type, controls) {

        return `
    <div class="articles__column ${type}">
            <div class="articles__item">
       ${controls}

        </div>
        </div>`;

    }

}(jQuery));
