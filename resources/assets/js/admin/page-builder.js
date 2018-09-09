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

    let articlesTab = $('.pb-articles');
    let elementsTab = $('.pb-elements');
    let elementTab = $('.pb-element');

    let activeElement = null;
    let drakeRow, drakeElements;

    // Setup stuff
    init();

    $('.pb-element__header-icon').click(function () {

        deselectActiveElement();

    });

    function deselectActiveElement() {
        activeElement.classList.remove('articles__element--selected');
        activeElement = null;
        elementTab.hide();
    }

    function init() {
        setupDragEvents();
        setupArticleElementEvents();
        setupDeleteElementEvent();
        setupCircleControlClickEvent();
        setupTextKeyUpEvent();
        setupTabSwitchingClickEvents();
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

                if (value.includes('white')) {
                    activeElement.classList.add(backgroundColorClasses[0]);
                }
                else if (value.includes('red')) {
                    activeElement.classList.add(backgroundColorClasses[1]);
                }
                else if (value.includes('green')) {
                    activeElement.classList.add(backgroundColorClasses[2]);
                }
                else if (value.includes('blue')) {
                    activeElement.classList.add(backgroundColorClasses[3]);
                }
                else if (value.includes('purple')) {
                    activeElement.classList.add(backgroundColorClasses[4]);
                }
                else if (value.includes('black')) {
                    {
                        activeElement.classList.add(backgroundColorClasses[5]);
                    }
                }
            }
            else if (value.includes('color')) {

                removeClassesFromElement(colorClasses, activeElement);

                if (value.includes('black')) {
                    activeElement.classList.add(colorClasses[0]);
                }
                else if (value.includes('grey')) {
                    activeElement.classList.add(colorClasses[1]);
                }
                else if (value.includes('white')) {
                    activeElement.classList.add(colorClasses[2]);
                }
            }
            else if (value.includes('font-size')) {

                removeClassesFromElement(fontSizeClasses, activeElement);

                if (value.includes('font-size-xs')) {
                    activeElement.classList.add(fontSizeClasses[0]);
                }
                else if (value.includes('font-size-s')) {
                    activeElement.classList.add(fontSizeClasses[1]);
                }
                else if (value.includes('font-size-m')) {
                    activeElement.classList.add(fontSizeClasses[2]);
                }
                else if (value.includes('font-size-l')) {
                    activeElement.classList.add(fontSizeClasses[3]);
                }
                else if (value.includes('font-size-xl')) {
                    activeElement.classList.add(fontSizeClasses[4]);
                }
            }
            else if (value.includes('font-weight')) {

                removeClassesFromElement(fontWeightClasses, activeElement);

                if (value.includes('font-weight-s')) {
                    activeElement.classList.add(fontWeightClasses[0]);
                }
                else if (value.includes('font-weight-m')) {
                    activeElement.classList.add(fontWeightClasses[1]);
                }
                else if (value.includes('font-weight-l')) {
                    activeElement.classList.add(fontWeightClasses[2]);
                }
            }

            parent.children().each(function (index, element) {
                $(element).removeClass(activeClass);
            });

            e.target.classList.add(activeClass);

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
            if (element.classList.contains(classes[i])) {
                element.classList.remove(classes[i]);
            }
        }

    }

    function setElementType() {

        let type = null;

        if (activeElement.tagName === 'H2') {
            type = 'Heading';
        } else if (activeElement.tagName === 'P') {
            type = 'Paragraph';
        } else if (activeElement.tagName === 'IMG') {
            type = 'Image';
        } else if (activeElement.tagName === 'DIV') {
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

        // Extra identifier from class array
        for (let i = 0; i < classArray.length; i++) {
            if (activeElement.classList.contains(classArray[i])) {
                identifier = classArray[i].substr(position, 10);
            }
        }

        let circleElements = $(groupClassName).find('.pb-element__circle');

        for (let i = 0; i < circleElements.length; i++) {

            removeClassesFromElement([activeClass], circleElements[i]);

            if (identifier !== null && $(circleElements[i]).attr('id') === idPrefix + '-' + identifier) {
                circleElements[i].classList.add(activeClass);
            }
        }

    }

    // Deletes the active element
    function setupDeleteElementEvent() {
        $('#delete-element').click(function () {
            activeElement.remove(true);
            activeElement = null;
            elementTab.hide();
        });
    }

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

        $(document).on('click', '.articles__element,.articles__container', (e) => {

            if ($(e.target).hasClass('articles__droppable--container')) {
                return;
            }

            e.stopPropagation();

            if (activeElement !== null) {
                activeElement.classList.remove('articles__element--selected');
            }

            activeElement = e.target;
            activeElement.classList.add('articles__element--selected');

            elementTab.show();
            setupElementStyles(backgroundColorClasses, 22, '#background-color-selection', 'pb-element__color--active', 'bgc');
            setupElementStyles(colorClasses, 25, '#color-selection', 'pb-element__color--active', 'co');
            setupElementStyles(fontSizeClasses, 29, '#font-size-selection', 'pb-element__size--active', 'fs');
            setupElementStyles(fontWeightClasses, 31, '#font-weight-selection', 'pb-element__size--active', 'fw');
            setElementText();

            let type = setElementType();
            hideAllElementGroups();
            showElementGroups(type);

        });
    }

    // Sets up the active element hover class as the user hovers over the elements
    function setupElementHoverEvents() {
        $(document).on('mouseenter', '.articles__element', function (e) {

            e.stopPropagation();

            $(this).addClass('articles__element--active');
            $('.articles__container').removeClass('articles__element--active');

        });

        $(document).on('mouseleave', '.articles__element', function (e) {
            $(this).removeClass('articles__element--active');
            if (!e.target.classList.contains('articles__img-container') &&
                !e.target.classList.contains('articles__img')) {

                let parent = $(this).parent().parent();

                if (parent != null) {
                    if (!parent.hasClass('articles__column')) {
                        $(this).parent().parent().addClass('articles__element--active');
                    }
                }
            }
        });

        $(document).on('mouseenter', '.articles__container', function (e) {

            e.stopPropagation();

            $(this).addClass('articles__element--active');

        });

        $(document).on('mouseleave', '.articles__container', function (e) {
            $(this).removeClass('articles__element--active');
        });

        $(document).on('mouseleave', '.articles__img-container', function (e) {

            let parent = $(this).parent().parent();

            if (parent != null) {
                if (!parent.hasClass('articles__column')) {
                    $(this).parent().parent().addClass('articles__element--active');
                }
            }

        });
    }

    function showElementGroups(type) {

        if (type === 'Heading' || type === 'Paragraph') {
            $('#text-selection').show();
            $('#color-selection').show();
            $('#font-size-selection').show();
            $('#font-weight-selection').show();
            $('#actions-selection').show();
        }

        if (type === 'Heading' || type === 'Paragraph' || type === 'Box') {
            $('#background-color-selection').show();
            $('#actions-selection').show();
        }

        if (type === 'Image') {
            $('#image-size-selection').show();
            $('#actions-selection').show();
        }

    }

    function setupDragEvents() {

        setupElementDragEvent();

        dragula($('.articles').toArray(), {
            moves: function (el, container, handle) {
                return handle.classList.contains('pb-row-controls__icon--drag');
            }
        });

        dragArticleRow();

        $('.pb__right').click(function (e) {

            if ($(e.target).hasClass('pb__right') && activeElement !== null) {
                deselectActiveElement();
            }

        });

    }

    function setupElementDragEvent() {
        drakeElements = dragula($('.articles__droppable').toArray(), {
            revertOnSpill: true,
            accepts: function (el, target, source, sibling) {

                if ($(target).hasClass('pb-elements__container')) {
                    return false
                }
                else if ($(el).hasClass('articles__container') && $(target).hasClass('articles__droppable--container')) {
                    return false
                }
                else if ($(el).attr('id') === 'element-box' && $(target).hasClass('articles__droppable--container')) {
                    return false
                }

                return true;

            },
            isContainer: function (el) {
                return $(el).hasClass('pb-elements__container') || $(el).hasClass('pb-delete');
            },
            copy: function (el, source) {
                return $(source).hasClass('pb-elements__container');
            },
            moves: function (el, container, handle) {
                return !handle.classList.contains('pb-column-controls') && !handle.classList.contains('pb-column-controls__icon');
            }
        }).on('drop', function (el, target, source, sibling) {

            if($(target).hasClass('pb-delete')) {
                drakeElements.cancel(true);
                console.log('fff');
                $(el).remove();
            }




            if ($(el).attr('id') === 'element-text') {
                $(el).replaceWith('<h2 class="articles__element articles__element--bg-white articles__element--color-black articles__element--font-size-l articles__element--font-weight-l">Header text</h2>')
            } else if ($(el).attr('id') === 'element-image') {
                $(el).replaceWith('<div class="articles__img-container">\n' +
                    '                                    <img src="http://mycms.test/img/test.jpg" class="articles__img articles__element">\n' +
                    '                                </div>')
            } else if ($(el).attr('id') === 'element-box') {
                $(el).replaceWith('<div class="articles__container articles__element--bg-white">\n' +
                    '                                    <div class="articles__droppable articles__droppable--container">\n' +
                    '                                        \n' +
                    '                                        \n' +
                    '                                    </div>\n' +
                    '                                </div>');

                if (sibling != null) {

                    drakeElements.containers.push($(sibling).prev().find('.articles__droppable')[0]);
                } else {

                    drakeElements.containers.push($(target).find('.articles__droppable')[0]);

                }


            }

        }).on('over', function (el, container, source) {

            if($(container).hasClass('pb-delete')) {

                $('.pb-delete').addClass('pb-delete__hover');
                $(el).hide();

            }

        }).on('out', function (el, container, source) {

            if($(container).hasClass('pb-delete')) {

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

    function dragArticlesItem() {

    }


    function dragArticleRow() {

        drakeRow = dragula($('.articles__row').toArray(), {
            moves: function (el, container, handle) {
                return handle.classList.contains('pb-column-controls__icon--drag');
            }
        });

    }

    $('.articles__new').click(function () {

        let string = `
            <div class="row articles__row">
                        <div class="pb-row-controls">
                            <div class="pb-row-controls__icon pb-row-controls__icon--drag fas fa-arrows-alt"></div>
                            <div class="pb-row-controls__icon pb-row-controls__icon--menu fas fa-bars"></div>
                            <div class="pb-row-controls__icon pb-row-controls__icon--delete fas fa-trash-alt"></div>
                        </div>

                        <div class="articles__column col-md-12">

                            <article class="articles__item articles__droppable">

                                <div class="pb-column-controls">
                                    <div class="pb-column-controls__icon pb-column-controls__icon--drag fas fa-arrows-alt"></div>
                                    <div class="pb-column-controls__icon pb-column-controls__icon--menu fas fa-bars"></div>
                                    <div class="pb-column-controls__icon pb-column-controls__icon--delete fas fa-trash-alt"></div>
                                </div>
                                
                                <div class="articles__container articles__element--bg-white">
                                    <div class="articles__droppable articles__droppable--container">
                                        <h2 class="articles__element articles__element--bg-white articles__element--color-black articles__element--font-size-l articles__element--font-weight-l">
                                            Header text
                                        </h2>

                                    </div>
                                </div>

                            </article>
                        </div>

                    </div>

        `;

        $('.articles__new-container').after(string);

        // Makes the new added element draggable
        drakeElements.containers.push($('.articles__row').first().find('.articles__droppable')[0]);
        drakeElements.containers.push($('.articles__row').first().find('.articles__droppable')[1]);

    });

    $(document).on('click', '.pb-row-controls__icon--delete', function (e) {
        $(e.target).parent().parent().remove();
        deselectActiveElement();
    });

}(jQuery));
