$(function() {

    $('#sendNotificationButton').on('click', function() {
        $.post('/send-notification.php', {
           identity: $('#identityInput').val()
        }, function(response) {
            $('#identityInput').val('');
            $('#message').html(response.message);
            console.log(response);
        });
    });
});