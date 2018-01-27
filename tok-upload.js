$(document).ready(function () {
    $('#tok_add_image_button').click(function () {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function (props, attachment) {
            $('#tok_preview_image').attr('src', attachment.url);
            $('#tok_image').val(attachment.url);
            wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open();
        return false;
    });
    $('#tok_remove_image_button').click(function () {
        $('#tok_preview_image').attr('src', tok_default_image.img);
        $('#tok_image').val('delete');
    });
});