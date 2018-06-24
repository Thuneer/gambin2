import jQuery from 'jquery';

jQuery(document).ready(function($) {
    $('#summernote').summernote({
        height:300,
        tabsize: 1,
        placeholder: 'Content here...'
    });
});