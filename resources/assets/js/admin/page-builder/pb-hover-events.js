import $ from 'jquery';

// Sets up the active element hover class as the user hovers over the elements
export default function setupElementHoverEvents() {
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
