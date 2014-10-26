$(document).ready(function () {
    $('#ltd_home_form_button').on('click', function() {
        var errors = '';
        var email_regexp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!email_regexp.test($('#ltd_email').val())) {
            errors += 'Please enter a valid e-mail address.<br>';
        }
        if ($('#ltd_password').val().length < 1) {
            errors += 'Please enter your password.<br>';
        }
        if (errors != '') {
            $('#ltd_error_modal_text').html(errors);
            $('#ltd_error_modal').modal('show');
        } else {
            // VALIDATION PASSED; CHECK CREDENTIALS
            var email = $('#ltd_email').val();
            var password = $('#ltd_password').val();
            var login_post_data = {
                'email': email,
                'password': password
            };
            $.post('/index.php/login/log_in',login_post_data,function(result) {
                var login_result = JSON.parse(result);
                if (typeof login_result.error != 'undefined') {
                    $('#ltd_error_modal_text').html("You entered an invalid e-mail or password.");
                    $('#ltd_error_modal').modal('show');
                }
            });
        }
    });
    
    $('#ltd_home_form_create').on('click', function() {
        alert("CREATE ACCOUNT");
    });

});
