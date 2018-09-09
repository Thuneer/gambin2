import $ from 'jquery';

/**
 *
 *  Setts up summernote text field for articles and posts
 *
 */

$(function() {
    $('#summernote').summernote({
        height:300,
        tabsize: 1,
        placeholder: 'Content here...'
    });
});