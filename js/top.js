function logOut() {
    var lo_json = { 'csrf_test_name' : $('[name=csrf_test_name]').val() };

    $.post('/index.php/login/log_out', lo_json, function(data) {
        if (data) {
            location.href = "/";
        } else {
            $('#ltd_error_modal_text').html("COULD NOT LOG OUT");
            $('#ltd_error_modal').modal('show');
        }
    }, 'json');
}