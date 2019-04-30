$('.login').append('<div>Login JS working</div>');

$(document).ready(function ($) {
    $.post('/wp-admin/admin-ajax.php', {
        action: 'mps_authentication_action',
        test: 'Sending up'
    }).done(function (data) {
        $('.login').append('<div>' + JSON.parse(data)['test'] + '</div>');
    })
});