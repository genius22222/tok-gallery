$(document).ready(function () {
    var tok_default_preview_image = $('#tok_preview_image').attr('src');
    $('.submit > #submit').bind('click', function () {
        $('#tok_preview_image').attr('src', tok_default_preview_image);
    })
});