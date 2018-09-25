import $ from 'jquery';

export default function setColumnHeights() {
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