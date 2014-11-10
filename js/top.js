function logOut() {
    $.post('/index.php/login/log_out',function(data) {
        if (data) {
            location.href = "/";
        } else {
            $('#ltd_error_modal_text').html("COULD NOT LOG OUT");
            $('#ltd_error_modal').modal('show');
        }
    });
}