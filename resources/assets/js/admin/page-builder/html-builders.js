import state from "./state";
import setColumnHeights from "./set-column-heights";
import $ from 'jquery';

function buildHTMLToDatabase() {
    $(document).on('click', '.pb-header__icon', function (e) {

        let articles = $('.articles');
        let rows = articles.find('.articles__row');
        let output = document.createElement('div');
        output.className = 'articles container';

        for (let i = 0; i < rows.length; i++) {

            // Article Row
            let row = document.createElement('div');
            row.className = 'articles__row row';
            output.append(row);

            let columns = $(rows[i]).find('.articles__column');

            for (let j = 0; j < columns.length; j++) {

                let columnClassName = $(columns[j]).attr('class').split(' ')[1];

                // Article Column
                let column = document.createElement('div');
                column.classList = columns[j].classList;
                row.append(column);

                let articles = $(columns[j]).find('.articles__main-container');

                for (let k = 0; k < articles.length; k++) {

                    // Article Item
                    let article = document.createElement('a');
                    article.className = 'articles__item';
                    $(article).addClass($(columns[j]).find('.articles__box-container').first().attr('class').split(' ')[1]);
                    $(article).attr('href', $(articles[k]).attr('data-link'));
                    column.append(article);

                    let items = $(articles[k]).find('.articles__main').children();

                    for (let l = 0; l < items.length; l++) {

                        let item = null;

                        if ($(items[l]).hasClass('articles__img')) {

                            // Article Image
                            item = document.createElement('img');
                            item.classList = items[l].classList;
                            $(item).removeClass('articles__element--selected');
                            $(item).attr('data-src', $(items[l]).attr('src'));
                            $(item).attr('data-path', $(items[l]).attr('data-path'));
                            $(item).attr('data-extension', $(items[l]).attr('data-extension'));
                            $(item).attr('data-srcset', getSrcSet($(items[l]).attr('data-path'), $(items[l]).attr('data-extension'),$(items[l]).attr('src')));
                            $(item).attr('data-sizes', getSizes(columnClassName));

                        } else {

                            // Article Box Container
                            item = document.createElement('div');
                            item.classList = items[l].classList;
                            $(item).removeClass('articles__element--selected');
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
                                $(element).removeClass('articles__element--selected');
                                item.append(element);

                            }

                        }

                        article.append(item);

                    }

                }

            }

        }
        $('#pb-content').val(output.outerHTML);
    });
}

function getSrcSet(path, extension, imgSrc) {

    let imgAspectRatio = '';

    if (imgSrc.includes('21-9')) {
        imgAspectRatio = '-21-9-';
    } else if (imgSrc.includes('16-9')) {
        imgAspectRatio = '-16-9-';
    } else if (imgSrc.includes('1-1')) {
        imgAspectRatio = '-1-1-';
    } else {
        imgAspectRatio = '-4-3-';
    }

    return `/${path}${imgAspectRatio}sm.${extension} 360w, /${path}${imgAspectRatio}md.${extension} 550w, /${path}${imgAspectRatio}lg.${extension} 740w, /${path}${imgAspectRatio}xl.${extension} 1120w`;

}

function getSizes(className) {

    let string = '';

    if (className.includes('12')) {
        string = '(max-width: 360px) 360px, (max-width: 768px) 550px, (min-width: 992px) 1120px, (min-width: 768px) 740px, 1120px';
    } else if (className.includes('8')) {
        string = '(max-width: 360px) 360px, (max-width: 768px) 550px, (min-width: 768px) 740px, 1120px';
    } else if (className.includes('6')) {
        string = '(max-width: 360px) 360px, (max-width: 768px) 550px, (min-width: 768px) 550px, 1120px';
    } else {
        string = '(max-width: 360px) 360px, (max-width: 768px) 550px, (min-width: 768px) 360px, 1120px';
    }

    return string
}

function buildHTMLToPB() {
    $('.button--builder').click(function (e) {

        let articles = $('#pb-content').val();

        if ($(articles).hasClass('articles')) {

            $('.articles').children().each(function (index, element) {
                if (!$(element).hasClass('articles__new-container')) {
                    $(element).remove();
                }
            });

            let rows = $(articles).find('.articles__row');

            for (let i = 0; i < rows.length; i++) {

                let row = document.createElement('div');
                row.className = 'row articles__row';

                $(row).append(rowControls());

                $('.articles').append(row);
                state.drakeRow.containers.push(row);

                let columns = $(rows[i]).find('.articles__column');

                for (let j = 0; j < columns.length; j++) {

                    // Articles Column
                    let column = document.createElement('div');
                    column.classList = columns[j].classList;
                    row.append(column);

                    // Articles Item
                    let article_item = document.createElement('div');
                    article_item.className = 'articles__item';
                    $(article_item).append(columnControls());
                    column.append(article_item);

                    // Articles Main Container
                    let article_main_container = document.createElement('div');
                    article_main_container.className = 'articles__main-container';
                    $(article_main_container).attr('data-link', $(columns[j]).find('.articles__item').first().attr('href'));
                    $(article_item).append(article_main_container);
                    state.drakeElements.containers.push(article_item);

                    // Articles Main
                    let article_main = document.createElement('div');
                    article_main.className = 'articles__main';
                    $(article_main_container).append(article_main);

                    let topElements = $(columns[j]).find('.articles__item').first().children();

                    for (let k = 0; k < topElements.length; k++) {

                        if ($(topElements[k]).prop('tagName') === 'IMG') {

                            let image = document.createElement('img');
                            image.classList = topElements[k].classList;
                            $(image).attr('src', $(topElements[k]).attr('data-src'));
                            $(image).attr('data-path', $(topElements[k]).attr('data-path'));
                            $(image).attr('data-extension', $(topElements[k]).attr('data-extension'));

                            $(article_main).append(image);

                        } else {

                            let box_container = document.createElement('div');
                            box_container.classList = topElements[k].classList;
                            $(article_main).append(box_container);

                            let box = document.createElement('div');
                            box.className = 'articles__box';
                            $(box_container).append(box);

                            state.drakeElements.containers.push(box);

                            let elements = $(topElements[k]).children();

                            for (let l = 0; l < elements.length; l++) {

                                if ($(elements[l]).prop('tagName') === 'H2') {
                                    $(box).append(elements[l]);

                                } else if ($(elements[l]).prop('tagName') === 'P') {
                                    $(box).append(elements[l]);
                                }

                            }

                        }

                    }

                }

            }
            $('.articles-hand').hide();
            setColumnHeights();
        }

    });
}

function rowControls() {

    return `
 
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

       `;
}

function columnControls() {
    return `
 
            <div class="pb-column-controls">
            <div class="pb-column-controls__icon pb-column-controls__icon--drag fas fa-arrows-alt"></div>
            <div class="pb-column-controls__icon pb-column-controls__icon--menu fas fa-bars"></div>
            <div class="pb-column-controls__icon pb-column-controls__icon--delete fas fa-trash-alt"></div>
            </div>

            <div class="articles-hand">
            <div><i class="articles-hand__icon far fa-hand-point-down"></i></div>
        <p class="articles-hand__text">Drop article here</p>
        </div>

       `;
}

export { buildHTMLToDatabase, buildHTMLToPB, columnControls, rowControls }