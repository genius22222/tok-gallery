$(document).ready(function () {
    $('#tok_add_image_button').click(function () {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function (props, attachment) {
            $('#upload_image').val(attachment.url);
            console.log(props+'---------');
            console.log(attachment);
            wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open();
        return false;
    });
});