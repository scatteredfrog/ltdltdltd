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
            var remember = $('#ltd_remember').is(':checked');
            var login_post_data = {
                'email': email,
                'password': password,
                'remember': remember
            };
            $.post('/index.php/login/log_in',login_post_data,function(result) {
                var login_result = JSON.parse(result);
                if (typeof login_result.error != 'undefined') {
                    $('#ltd_error_modal_text').html("You entered an invalid e-mail or password.");
                    $('#ltd_error_modal').modal('show');
                } else if (typeof login_result.logged_in != 'undefined' && login_result.logged_in) {
                    // User successfully logged in
                    location.href = '/index.php/home/main_menu';
                }
            });
        }
    });
    
    $('#ltd_home_form_create').on('click', function() {
        alert("CREATE ACCOUNT");
    });

    $('#ltd_email,#ltd_password').on('keydown',function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#ltd_home_form_button').trigger('click');
        }
    })
});

function submitContact() {
    var errors = [];
    var email_regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    // validate name
    if ($.trim($('#cu_name').val()).length < 2) {
        errors.push('Please provide a valid name.<br />&nbsp;<br />');
    }
    
    // validate e-mail
    if (!email_regex.test($.trim($('#cu_email').val()))) {
        errors.push('Please provide a valid e-mail address.<br />&nbsp;<br />');
    }
    
    // validate comments
    if ($.trim($('#cu_comments').val()).length < 10) {
        errors.push('We need helpful comments -- at least ten characters!');
    }
    
    if (errors.length) {
        $('#ltd_error_modal_text').html(errors);
        $('#ltd_error_modal').modal('show');
    } else {
        var contact_post = {
            'name' : $.trim($('#cu_name').val()),
            'email' : $.trim($('#cu_email').val()),
            'comment' : $.trim($('#cu_comments').val()),
            'csrf_test_name' : $('[name=csrf_test_name]').val()
        };
        $.post('/index.php/home/sendContact', contact_post, function(data) {
            if (!data.success) {
                $('#ltd_error_modal_text').html(data.errors);
                $('#ltd_error_modal').modal('show');
            } else {
                $('#ltd_confirm_modal').modal('show');
            }
        },'json');
    }
    
    $('#ltd_confirm_modal').on('hidden.bs.modal', function () {
        $('#cu_name,#cu_email,#cu_comments').val('');
    });
}