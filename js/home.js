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
                'remember': remember,
                'csrf_test_name' : $('[name=csrf_test_name]').val()
            };
            $.post('/index.php/login/log_in',login_post_data,function(result) {
                var login_result = JSON.parse(result);
                if (typeof login_result.error != 'undefined' && login_result.error != false) {
                    $('#ltd_error_modal_text').html("You entered an invalid e-mail or password.");
                    $('#ltd_error_modal').modal('show');
                } else if (typeof login_result.logged_in != 'undefined' && login_result.logged_in) {
                    // User successfully logged in
                    location.href = '/home/main_menu';
                }
            });
        }
    });
    
    $('#ltd_email,#ltd_password').on('keydown',function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            $('#ltd_home_form_button').trigger('click');
        }
    });
    
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

function submitCreate() {
    var error = '';
    var success = true;
    var invalid = false;
    var sp = '<br />&nbsp;<br />';
    
    $('#user_name').val($.trim($('#user_name').val()));
    $('#user_email').val($.trim($('#user_email').val()));
    $('#user_remail').val($.trim($('#user_remail').val()));
    $('#user_password').val($.trim($('#user_password').val()));
    $('#re_pass').val($.trim($('#re_pass').val()));

    // Validate user name
    if ($('#user_name').val().length < 2) {
        success = false;
        error += 'Please provide your name.';
        if ($('#user_name').val().length === 1) {
            error += ' (Seriously? Just one character?!)';
        }
        error += sp;
    }
    
    // Validate e-mail
    var email_regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    if (!email_regex.test($('#user_email').val())) {
        success = false;
        invalid = true;
        error += 'Please provide a valid e-mail address.' + sp;
    }
    
    if (!invalid && $('#user_email').val() !== $('#user_remail').val()) {
        success = false;
        error += 'Please ensure your e-mail address is the same in both e-mail fields.' + sp;
    }
    invalid = false;
    
    // Validate the password
    var pass_reg = [/[A-Z]/,/[a-z]/,/[0-9]/];
    var pr_len = pass_reg.length;
    
    if ($('#user_password').val().length < 8) {
        success = false;
        error += 'Your password is too short; make it at least 8 characters.' + sp;
        invalid = true;
    }
    
    if (!invalid) {
        for (var x = 0; x < pr_len; x++) {
            if (!pass_reg[x].test($('#user_password').val())) {
                success = false;
                invalid = true;
                error += 'Your password must contain at least one capital letter, at least one ';
                error += 'number, and at least one lower-case letter.' + sp;
                break;
            }
        }
    }
    
    if (!invalid) {
        if ($('#user_password').val().toUpperCase().indexOf('PASSWORD') > -1) {
            success = false;
            error += 'Please do not use the word "password" as part of your password. ';
            error += 'That makes it too easy to guess.' + sp;
        }
    }
    // If anything went wrong, alert modal.
    if (!success) {
        $('#ltd_error_modal_text').html(error);
        $('#ltd_error_modal').modal('show');
        return false;
    }
    
    var create_post = {
        'user_email': $('#user_email').val(),
        'user_remail': $('#user_remail').val(),
        'user_name' :  $('#user_name').val(),
        'user_password' : $('#user_password').val(),
        'user_repass' : $('#re_pass').val(),
        'language' : $('[name=language]:checked').val(),
        'csrf_test_name' : $('[name=csrf_test_name]').val()
    };
    
    $.post('/index.php/login/create_account', create_post, function(data) {
        if (data.success) {
            var conf_text = 'Thank you. Your account has been created, and ';
            conf_text += 'you will be logged in.';
            if (typeof data.dogs !== 'undefined') { // pre-registered dog[s] found!
                var dog_length = data.dogs.length;
                conf_text += '<br />&nbsp;<br />It looks like somebody has ';
                conf_text += 'already designated you to be ';
                if (dog_length === 1) {
                    conf_text += '<span class="bold">' + data.dogs[0] + '\'s</span> caretaker!';
                } else if (dog_length > 1) {
                    conf_text += 'the caretaker of the following dogs:<br />';
                    for (var x = 0; x < dog_length; x++) {
                        conf_text += '<span class="bold">' + data.dogs[x] + '</span><br />';
                    }
                }
            }
            $('#ltd_confirm_modal_subheader').html(conf_text);
            var login_json = {
                'email' : $('#user_email').val(),
                'csrf_test_name' : $('[name=csrf_test_name]').val(),
                'password' : $('#user_password').val()
            };
            $('#ltd_confirm_modal_ok').on('click', function() {
                $.post('/index.php/login/log_in', login_json, function(lData) {
                    if (lData.success) {
                        location.href = '/index.php/home/main_menu';
                    }
                },'json');
            });
            $('#ltd_confirm_modal').modal('show');
        } else {
            $('#ltd_error_modal_text').html(data.error);
            $('#ltd_error_modal').modal('show');
        }
    },'json');
}

function notYetAvailable(verb) {
    $('#ltd_error_modal .modal-dialog').addClass('modal-sm');
    $('#ltd_error_modal_header_text').html('Function Not Yet Implemented');
    $('#ltd_error_modal_text').html('Sorry -- we can\'t ' + verb + ' yet.');
    $('#ltd_error_modal').modal('show');
}

function quickLook() {
    $('#ql_modal_header_text,#ql_modal_text').html('');
    var post_vars = {
        'csrf_test_name' : $('[name=csrf_test_name]').val(),
    };
    
    $.post('/log/getQuickLook', post_vars, function(data) {
        if (data.indexOf('<select') === 0) {
            $('#ql_modal_header_text').html('Please choose a dog: ' + data);
        } else {
            // only one dog
            var dataSplit = data.split('<script>getDogDeets("');
            var dogID = dataSplit[1].split('"');
            dogID = dogID[0];
            getDogDeets(dogID);
        }   
    }, 'json');
    $('#ql_modal').modal('show');    
}