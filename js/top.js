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

function changeGender() {
    var gender_change = 'this dog';
    var neut = 'spayed / neutered';
    switch($("#dog_gender").val()) {
        case 'm':
            gender_change = 'he';
            neut = 'neutered';
            break;
        case 'f':
            gender_change = 'she';
            neut = 'spayed';
            break;
        default:
            gender_change = 'this dog';
            neut = 'spayed / neutered';
            break;
    }
    $('.this_dog').html(gender_change);
    $('#neut').html(neut);
}

function changeMonth() {
    switch($('#birth_month').val()) {
        case '1':
        case '3':
        case '5':
        case '7':
        case '8':
        case '10':
        case '12':
            $('.only31,.notFebruary').show();
            break;
        case '4':
        case '6':
        case '9':
        case '11':
            $('.notFebruary').show();
            $('.only31').hide();
            break;
        default:
            $('.only31,.notFebruary').hide();
    }
}

function chipClick() {
    if ($('#is_chipped').prop('checked')) {
        $('#chip_block').show();
    } else {
        $('#chip_block').hide();
    }
}

function reveal(section) {
    if ($('#' + section).css('display') === 'none') {
        $('#' + section).show();
    } else {
        $('#' + section).hide();
    }
}

function registerDog() {
    var caretakers = '';
    $('.careName').each(function() {
        caretakers += $(this).val() + '^' + $(this).next().val() + '~';
    });
    if (caretakers.length > 0) {
        caretakers = caretakers.slice(0, -1);
    }
    
    var neutered = $('#neutered').prop('checked') ? 1 : 0;
    var chipped = $('#is_chipped').prop('checked') ? 1 : 0;

    var register_data = {
        dog_name: $('#dog_name').val(),
        dog_weight: $('#weight').val(),
        dog_length: $('#length').val(),
        dog_height: $('#height').val(),
        neutered: neutered,
        dog_gender: $('#dog_gender').val(),
        breed: $('#breed').val(),
        dog_color: $('#color').val(),
        dog_features: $('#features').val(),
        dog_bmonth: $('#birth_month').val(),
        dog_bdate: $('#birth_date').val(),
        dog_byear: $('#birth_year').val(),
        dog_altName: $('#alt_name').val(),
        dog_afflictions: $('#afflictions').val(),
        dog_fears: $('#fears').val(),
        commands: $('#commands').val(),
        chipped: chipped,
        chip_brand: $('#chip_brand').val(),
        chip_id: $('#chip_id').val(),
        caretakers: caretakers,
        'csrf_test_name' : $('[name=csrf_test_name]').val(),
        confirm: 0,
        update: 0
    };
    
    $.post('/index.php/log/register_a_dog', register_data, function(data) {
        if (data['success']) {
            // dog successfully registered
            dogRegistered($('#dog_name').val(), false);
        } else if (data['error'].indexOf('Do you want to add this dog anyway') > 0) {
            $('#ltd_dual_options_modal_subheader').html(data['error']);
            $('#ltd_dual_options_left_button').html('No');
            $('#ltd_dual_options_right_button').html('Yes');
            $('#ltd_dual_options_modal').modal('show');
            $('#ltd_dual_options_right_button').on('click', function() {
                $('#ltd_dual_options_modal').modal('hide');
                register_data.confirm = true;
                $.post('/index.php/log/register_a_dog', register_data, function(subData) {
                    if (subData['success']) {
                        // dog successfully registered
                        dogRegistered($('#dog_name').val());
                    }
                },'json');
            });
        } else {
            $('#ltd_error_modal_text').html(data['error']);
            $('#ltd_error_modal').modal('show');
        }
    }, 'json');
}

$(document).on('click', '.deleteCt', function() {
    $(this).parent().remove();
});

function dogRegistered(name, is_update) {
    var dt;
    if (is_update) {
        dt = "'s details have been changed.";
    } else {
        dt = " has been registered.";
    }
    
    $('#ltd_confirm_modal_subheader').html(name + dt);
    $('#ltd_confirm_modal').modal('show');
    $('#ltd_confirm_modal_ok').on('click', function() {
        location.href = '/';
    });
}

$(document).on('click', '#select_this_dog', function () {
    var post_vars = {
        dog_id : $('#dog_selector').val(),
        'csrf_test_name' : $('[name=csrf_test_name]').val(),
    };
    
    getDogDeets(post_vars.dog_id);
    if ((location.href.indexOf('med') > -1) || (location.href.indexOf('meal') > -1)) {
        getMeds(post_vars);
    }
}); 

function getMeds(post_vars) {
    if ($('#med_select').length > 0) {
        $('#med_select').remove();
    }
    $.post('/log/getMeds', post_vars, function(data) {
        var dc = data.length;
        if (location.href.indexOf('med') > -1) {
            var html = '<select id="med_select">';
            if (data.length > 0) {
                for (var x = 0; x < dc; x++) {
                    html += '<option value="' + data[x].id + '">';
                    html += data[x].medName + '</option>';
                }
                html += '<option value="_">** other **</option>';
            } else {
                $('#med_add_dogID').val(post_vars.dog_id);
                $('#med_add_modal').modal('show');
                setTimeout(function() {
                    $('#med_add_right_button').on('click', function() {
                        $('#med_add_modal').modal('hide');
                        setTimeout(function() {
                            addMedicine(true);
                        }, 500);
                    });
                }, 500);
            }
            html += '</select>';
            $('#med_type_container').html(html);

            $('#med_select').on('change', function() {
                if ($('#med_select').val() === '_') {
                    $('#med_add_modal').modal('show');
                    $('#med_add_right_button').on('click', function() {
                        $('#med_add_modal').modal('hide');
                        setTimeout(function() {
                            addMedicine(true);
                        }, 500);
                    });
                }
            });
        } else if (location.href.indexOf('meal') > -1) {
            var html = '';
            for (var x = 0; x < dc; x++) {
                if (data[x].withMeal == '1') {
                    html += '<div class="row">';
                    html += '<input type="checkbox" id="med_check_' + x + '" value="' + data[x].id + '" /> ';
                    html += data[x].medName;
                    html += '</div>';
                }
            }
            if (html !== '') {
                $('#med_checklist').html(html);
                $('#med_with_meal').css('display', 'block');
            } else {
                $('#med_with_meal').css('display', 'none');
            }
        }
    }, 'json');
}

function getDogDeets(dogID) {
    var activity;
    if (location.href.substr(-5) === '.com/') { 
        activity = 'quick_look';
    } else {
        var url_parts = location.href.split('/');
        activity = url_parts[url_parts.length-1];
        activity = activity === 'main_menu' ? 'quick_look' : activity;
    }
    var post_data = {
        'dogID' : dogID,
        'csrf_test_name' : $('[name=csrf_test_name]').val(),
        'activity' : activity
    };
    
    $.post('/index.php/log/getDogInfo', post_data, function(data) {
        if (data && data['success']) {
            $('.dogName').html(data['dog']['dogName']);
            $('#doggie_data').css('display','block');
            if (activity == 'quick_look') {
                if (data.success == true && typeof data.html !== 'undefined') {
                    $('#ql_modal_header_text').html(data.dog.dogName + "'s Recent Activities");
                    $('#ql_modal_text').html(data.html);
                }
            } else {
                if (data['dog']['latest_' + activity]['date']) {
                    var gender_walk = data['dog']['gender'] == '1' ? 'Her ' : 'His ';
                    gender_walk += 'latest ' + activity + ' was ';
                    $('#gender_' + activity).html(gender_walk);
                    $('#when_' + activity + '_was').html(data['dog']['latest_' + activity]['date'] + ' at ' + data['dog']['latest_' + activity]['time']);
                } else {
                    $('#gender_' + activity).html('This will be ' + data['dog']['dogName'] + '\'s first logged ' + activity + '!');
                    $('#when_' + activity + '_was').html('');
                }
                var today = new Date();
                var hh = today.getHours();
                var h = hh;
                var ampm = 'am';

                if (h >= 12) {
                    h = hh-12;
                    ampm = 'pm';
                }
                if (h == 0) {
                    h = 12;
                }

                $('#' + activity + '_date').val(("0" + (today.getMonth() + 1)).slice(-2) + '/' + ("0" + today.getDate()).slice(-2) + '/' + today.getFullYear());
                $('#' + activity + '_date').datepick({
                    showOnFocus: true,
                    rangeSelect: false,
                    maxDate: "new Date()"
                });
                $('#' + activity + '_time').val(("0" + h).slice(-2) + ':' + ("0" + today.getMinutes()).slice(-2));
                $('#' + activity + '_seconds').val(("0" + today.getSeconds()).slice(-2));
                $('#' + activity + '_ampm').val(ampm);
            }
        } else {
            $('#ltd_error_modal_text').html('There was a problem and we couldn\'t retrieve your dog\'s information.');
            $('#ltd_error_modal').modal('show');
        }
    }, 'json');
}

function submitWalk() {
    var date_parts = $('#walk_date').val().split('/');
    var time_parts = $('#walk_time').val().split(':');
    time_parts[2] = $('#walk_seconds').val();
    time_parts[0] = parseInt(time_parts[0]);
    
    // format the time
    if ($('#walk_ampm').val() === 'pm') {
        if (time_parts[0] != 12) {
            time_parts[0] += 12;
        }
    } else if (time_parts[0] == 12) {
        time_parts[0] = '00';
    } else {
        time_parts[0] = ("0" + time_parts[0]).slice(-2);
    }
    
    var walkDate = date_parts[2] + '-' + date_parts[0] + '-' + date_parts[1];
    var action = 0;
    
    walkDate += ' ' + time_parts[0] + ':' + time_parts[1] + ':' + time_parts[2];
    
    if ($('#num1').prop('checked') == true) {
        if ($('#num2').prop('checked') == true) {
            action = 3;
        } else {
            action = 1;
        }
    } else if ($('#num2').prop('checked')) {
        action = 2;
    }
    
    var post_vars = {
        'csrf_test_name' : $('[name=csrf_test_name]').val(),
        'dogID' : $('#dog_selector').val(),
        'walkDate' : walkDate,
        'action' : action,
        'walkNotes' : $('#walk_notes').val(),
        'userID' : $('#user_id').val()
    };

    $.post('/index.php/log/logWalk', post_vars, function (data) {
        if (data['success'] == true) {
            $('#ltd_dual_options_modal_subheader').html('What would you like to do next?');
            $('#ltd_dual_options_modal_header_text').html($('.dogName:first').text() + '\'s walk has been logged!');
            $('#ltd_dual_options_left_button').html('Return home');
            $('#ltd_dual_options_right_button').html('Log another walk');
            $('#ltd_dual_options_modal').modal('show');
            $('#ltd_dual_options_left_button').on('click', function () {
                location.href = '/';
            });
            $('#ltd_dual_options_right_button').on('click', function () {
                location.href = '/log/walk';
            });
            
        } else {
            $('#ltd_error_modal_text').html('There was a problem; this walk might not have been logged.');
            $('#ltd_error_modal').modal('show');
        }
    },'json');
}

function submitMeal() {
    var date_parts = $('#meal_date').val().split('/');
    var time_parts = $('#meal_time').val().split(':');
    time_parts[2] = $('#meal_seconds').val();
    time_parts[0] = parseInt(time_parts[0]);
    
    // format the time
    if ($('#meal_ampm').val() === 'pm') {
        if (time_parts[0] != 12) {
            time_parts[0] += 12;
        }
    } else if (time_parts[0] == 12) {
        time_parts[0] = '00';
    } else {
        time_parts[0] = ("0" + time_parts[0]).slice(-2);
    }
    
    var mealDate = date_parts[2] + '-' + date_parts[0] + '-' + date_parts[1];
    
    mealDate += ' ' + time_parts[0] + ':' + time_parts[1] + ':' + time_parts[2];
    
    var post_vars = {
        'csrf_test_name' : $('[name=csrf_test_name]').val(),
        'dogID' : $('#dog_selector').val(),
        'mealDate' : mealDate,
        'mealNotes' : $('#meal_notes').val(),
        'userID' : $('#user_id').val()
    };
    
    // If we're logging medicine too...
    if ($('#med_with_meal').css('display') === 'block') {
        var med_string = '';
        $('[id^=med_check_]').each(function() {
            if ($(this).prop('checked') == true) {
                med_string += $(this).val() + '~';
            }
        });
        med_string = med_string.slice(0, -1);
        
        var med_post = {
            'csrf_test_name' : $('[name=csrf_test_name]').val(),
            'dogID' : $('#dog_selector').val(),
            'userID' : $('#user_id').val(),
            'medDate' : mealDate,
            'medNotes' : $('#meal_notes').val(),
            'medString' : med_string
        }
    }
    
    $.post('/index.php/log/logMeal', post_vars, function (data) {
        if (data['success'] == true) {
            if (typeof med_post !== 'undefined') {
                $.post('/log/logMultimeds', med_post, function(mdata) {
                    if (mdata['success'] == true) {
                        $('#ltd_dual_options_modal_subheader').html('What would you like to do next?');
                        $('#ltd_dual_options_modal_header_text').html($('.dogName:first').text() + '\'s meal and medicine have been logged!');
                        $('#ltd_dual_options_left_button').html('Return home');
                        $('#ltd_dual_options_right_button').html('Log another meal');
                        $('#ltd_dual_options_modal').modal('show');
                        $('#ltd_dual_options_left_button').on('click', function () {
                            location.href = '/';
                        });
                        $('#ltd_dual_options_right_button').on('click', function () {
                            location.href = '/log/meal';
                        });
                    } else {
                        var mhtml = 'The food has been logged, but there was a problem logging the ';
                        mhtml += 'medicine, which may not have been successfully logged.';
                        $('#ltd_error_modal_text').html(mhtml);
                        $('#ltd_error_modal').modal('show');
                    }
                }, 'json');
            } else {
                $('#ltd_dual_options_modal_subheader').html('What would you like to do next?');
                $('#ltd_dual_options_modal_header_text').html($('.dogName:first').text() + '\'s meal has been logged!');
                $('#ltd_dual_options_left_button').html('Return home');
                $('#ltd_dual_options_right_button').html('Log another meal');
                $('#ltd_dual_options_modal').modal('show');
                $('#ltd_dual_options_left_button').on('click', function () {
                    location.href = '/';
                });
                $('#ltd_dual_options_right_button').on('click', function () {
                    location.href = '/log/meal';
                });
            }
        } else {
            $('#ltd_error_modal_text').html('There was a problem; this meal might not have been logged.');
            $('#ltd_error_modal').modal('show');
        }
    },'json');
}

function submitTreat() {
    var date_parts = $('#treat_date').val().split('/');
    var time_parts = $('#treat_time').val().split(':');
    time_parts[2] = $('#treat_seconds').val();
    time_parts[0] = parseInt(time_parts[0]);
    
    // format the time
    if ($('#treat_ampm').val() === 'pm') {
        if (time_parts[0] != 12) {
            time_parts[0] += 12;
        }
    } else if (time_parts[0] == 12) {
        time_parts[0] = '00';
    } else {
        time_parts[0] = ("0" + time_parts[0]).slice(-2);
    }
    
    var treatDate = date_parts[2] + '-' + date_parts[0] + '-' + date_parts[1];
    
    treatDate += ' ' + time_parts[0] + ':' + time_parts[1] + ':' + time_parts[2];
    
    var post_vars = {
        'csrf_test_name' : $('[name=csrf_test_name]').val(),
        'dogID' : $('#dog_selector').val(),
        'treatDate' : treatDate,
        'treatNotes' : $('#treat_notes').val(),
        'treatType' : $('#treat_type').val(),
        'userID' : $('#user_id').val()
    };
    
    $.post('/index.php/log/logTreat', post_vars, function (data) {
        if (data['success'] == true) {
            $('#ltd_dual_options_modal_subheader').html('What would you like to do next?');
            $('#ltd_dual_options_modal_header_text').html($('.dogName:first').text() + '\'s treat has been logged!');
            $('#ltd_dual_options_left_button').html('Return home');
            $('#ltd_dual_options_right_button').html('Log another treat');
            $('#ltd_dual_options_modal').modal('show');
            $('#ltd_dual_options_left_button').on('click', function () {
                location.href = '/';
            });
            $('#ltd_dual_options_right_button').on('click', function () {
                location.href = '/log/treat';
            });
        } else {
            $('#ltd_error_modal_text').html('There was a problem; this treat might not have been logged.');
            $('#ltd_error_modal').modal('show');
        }
    },'json');
}

function submitMed() {
    var date_parts = $('#med_date').val().split('/');
    var time_parts = $('#med_time').val().split(':');
    time_parts[2] = $('#med_seconds').val();
    time_parts[0] = parseInt(time_parts[0]);

    // format the time
    if ($('#med_ampm').val() === 'pm') {
        if (time_parts[0] != 12) {
            time_parts[0] += 12;
        }
    } else if (time_parts[0] == 12) {
        time_parts[0] = '00';
    } else {
        time_parts[0] = ("0" + time_parts[0]).slice(-2);
    }

    var medDate = date_parts[2] + '-' + date_parts[0] + '-' + date_parts[1];

    medDate += ' ' + time_parts[0] + ':' + time_parts[1] + ':' + time_parts[2];

    var post_vars = {
        'csrf_test_name' : $('[name=csrf_test_name]').val(),
        'dogID' : $('#dog_selector').val(),
        'medDate' : medDate,
        'medNotes' : $('#med_notes').val(),
        'medType' : $('#med_select').val(),
        'userID' : $('#user_id').val()
    };
    
    $.post('/index.php/log/logMed', post_vars, function (data) {
        if (data['success'] == true) {
            $('#ltd_dual_options_modal_subheader').html('What would you like to do next?');
            $('#ltd_dual_options_modal_header_text').html($('.dogName:first').text() + '\'s medicine has been logged!');
            $('#ltd_dual_options_left_button').html('Return home');
            $('#ltd_dual_options_right_button').html('Log another medicine');
            $('#ltd_dual_options_modal').modal('show');
            $('#ltd_dual_options_left_button').on('click', function () {
                location.href = '/';
            });
            $('#ltd_dual_options_right_button').on('click', function () {
                location.href = '/log/med';
            });
        } else {
            $('#ltd_error_modal_text').html('There was a problem; this medicine might not have been logged.');
            $('#ltd_error_modal').modal('show');
        }
    },'json');
}

function saveAccountChanges() {
    var lang = '';
    switch ($('[name=language]:checked').val()) {
        case '0':
            lang = 'professional';
            break;
        case '1':
            lang = 'numeric';
            break;
        case '2':
            lang = 'slang';
            break;
    }
    var conf_text = 'You are about to save the following information:<br /><br />';
    conf_text += '<span class="bold col-xs-6">Your name:</span> <span class="col-xs-6 plain">';
    conf_text += $('#username').val() + '</span><br />';
    conf_text += '<span class="bold col-xs-6">Your e-mail:</span> <span class="plain col-xs-6">';
    conf_text += $('#email').val() + '</span><br />';
    conf_text += '<span class="bold col-xs-6">Language preference:</span> <span class="plain col-xs-6">';
    conf_text += lang + '</span>';
    conf_text += '<span class="bold col-xs-6">Quick Look limit:</span> <span class="plain col-xs-6">';
    conf_text += $('#ql_num').val() + ' entries</span><br />';
    conf_text += '<span class="bold col-xs-6">Quick Look order:</span> <span class="plain col-xs-6">';
    conf_text += ($('#ql_ord').val() === '1' ? 'ascending' : 'descending') + '</span><br />';
    $('#ltd_dual_options_modal_subheader').html(conf_text);
    $('#ltd_dual_options_left_button').html('Cancel');
    $('#ltd_dual_options_right_button').html('OK');
    $('#ltd_dual_options_modal').modal('show');
    
    $('#ltd_dual_options_right_button').on('click', function() {
        var post_vars = {
            'username' : $('#username').val(),
            'email' : $('#email').val(),
            'language' : $('[name=language]:checked').val(),
            'csrf_test_name' : $('[name=csrf_test_name]').val(),
            'ql_num' : $('#ql_num').val(),
            'ql_ord' : $('#ql_ord').val(),
        };
        
        $.post('/index.php/account/saveAccountChanges', post_vars, function(data) {
            $('#ltd_dual_options_modal').modal('hide');
            if (data == true) {
                $('.yay-update').css('display', 'block');
            } else {
                $('#ltd_error_modal_header_text').html('There was a problem...');
                $('#ltd_error_modal_text').html('Your information might not have been saved.');
                $('#ltd_error_modal').modal('show');
            }
        })
    });
}

function hideYay() {
    $('.yay-update').css('display','none');
}

function updatePassword(id) {
    var success = true;
    var invalid = false;
    var sp = '<br />&nbsp;<br />';
    var error = '';
    
    // Validate the password
    var pass_reg = [/[A-Z]/,/[a-z]/,/[0-9]/];
    var pr_len = pass_reg.length;
    
    if ($('#reset_pw').val().length < 8) {
        success = false;
        error += 'Your password is too short; make it at least 8 characters.' + sp;
        invalid = true;
    }
    
    if (!invalid) {
        for (var x = 0; x < pr_len; x++) {
            if (!pass_reg[x].test($('#reset_pw').val())) {
                success = false;
                invalid = true;
                error += 'Your password must contain at least one capital letter, at least one ';
                error += 'number, and at least one lower-case letter.' + sp;
                break;
            }
        }
    }
    
    if (!invalid) {
        if ($('#reset_pw').val().toUpperCase().indexOf('PASSWORD') > -1) {
            success = false;
            error += 'Please do not use the word "password" as part of your password. ';
            error += 'That makes it too easy to guess.' + sp;
        }
    }

    // Make sure the passwords match
    if ($('#reset_pw').val() !== $('#reset_conf').val()) {
        success = false;
        error += 'Please ensure your password is the same in both password fields.';
    }
    
    // If anything went wrong, alert modal.
    if (!success) {
        $('#ltd_error_modal_text').html(error);
        $('#ltd_error_modal').modal('show');
        return false;
    } else { // all went right so far
        var post_vars = {
            'csrf_test_name' : $('[name=csrf_test_name]').val(),
            'reset_pw' : $('#reset_pw').val(),
            'reset_conf' : $('#reset_conf').val(),
            'username' : $('#username').val(),
            'email' : $('#email').val()
        };
        
        $.post('/account/doResetPassword', post_vars, function(data) {
            if (!data.success) {
                $('#ltd_error_modal_text').html(data.error_message);
                $('#ltd_error_modal').modal('show');
            } else {
                $('#ltd_confirm_modal_header_text').html('Your password has been changed!');
                $('#ltd_confirm_modal_subheader').html(data.message);
                $('#ltd_confirm_modal').modal('show');
                $('#ltd_confirm_modal_ok').on('click', function() {
                    $('ltd_confirm_modal').modal('hide');
                    location.href = '/';
                });
            }
        }, 'json');
    }
}

function selectDog() {
    if ($('#dog_choice').val() === 'new') {
        resetRegistry();
        $('.newDog').hide();
        $('#dog_registry').css('display', 'block');
        $('.edit-dog').css('display', 'none');
        $('.add-dog').css('display', 'inline');
        return;
    } else {
        $('.newDog').show();
        $('.edit-dog').css('display', 'inline');
        $('.add-dog').css('display', 'none');
    }
    populateDog($('#dog_choice').val());
}

function populateDog(idx) {
    var post_vars = { 
        'idx' : idx,
        'csrf_test_name' : $('[name=csrf_test_name]').val(),
    };
    $.post('/log/popDogDeets', post_vars, function(data) {
        resetRegistry();
        if (typeof data.dogID !== 'undefined') {
            // DO STUFF
            $('#dog_id').val(data.dogID);
            $('#dog_name').val(data.dogName);
            $('#dog_registry').css('display', 'block');
            if (data.dogWeight != '0') {
                $('#weight').val(data.dogWeight);
            }
            if (data.dogHeight != '0') {
                $('#height').val(data.dogHeight);
            }
            if (data.dogLength != '0') {
                $('#length').val(data.dogLength);
            }
            
            switch(data.gender) {
                case '2':
                    $('#dog_gender').val('m');
                    break;
                case '1':
                    $('#dog_gender').val('f');
                    break;
            }
            
            if (data.spayneuter == '1') {
                $('#neutered').prop('checked',true);
            } else {
                $('#neutered').prop('checked', false);
            }
            
            $('#breed').val(data.breed);
            $('#color').val(data.dogColor);
            $("#features").val(data.dogFeatures);
            
            if (data.dogBirthdate != '' && data.dogBirthdate !== null) {
                var birthdate = data.dogBirthdate.split(' ');
                if (birthdate[0] === 'Approx.') {
                    if (birthdate.length === 3) {
                        $('#birth_year').val(birthdate[2]);
                        $('#birth_month').val(getNumberFromMonth(birthdate[1]));
                    } else if (birthdate.length === 2) {
                        $('#birth_year').val(birthdate[1]);
                    }
                } else if (birthdate[1].indexOf(',') > -1) {
                    $('#birth_year').val(birthdate[2]);
                    $('#birth_month').val(getNumberFromMonth(birthdate[0]));
                    var birthday = birthdate[1].split(',');
                    $('#birth_date').val(birthday[0]);
                }
            }
            
            $('#alt_name').val(data.dogAltName);
            $('#afflictions').val(data.dogAfflictions);
            $('#fears').val(data.dogFear);
            $('#commands').val(data.commands);
            
            if (data.chipped == '1') {
                $('#is_chipped').prop('checked', true);
                $('#chip_block').css('display', 'block');
                $('#chip_brand').val(data.chip_brand);
                $('#chip_id').val(data.chip_id);
            }
            
            // get caretakers
            var ct_data = { 
                'dog_id' : data.dogID,
                'csrf_test_name' : $('[name=csrf_test_name]').val()
            }; 
            
            // get meds
            $.post('/log/getMeds', ct_data, function(med_data) {
                var mdl = med_data.length;
                var mhtml = '';
                if (mdl > 0) {
                    $('#medicine_edit .container').css('display', 'block');
                    var b = 0;
                    for (var a = 0; a < mdl; a++) {
                        a = parseInt(a);
                        mhtml += '<div class="row med-row" id="med_row_' + a + '">';
                        mhtml += '<input type="hidden" id="med_id_' + a + '"value="' + med_data[a].id + '" />';
                        mhtml += '<div class="col-xs-3">';
                        mhtml += '<span id="medName' + a + '">' + med_data[a].medName + '</span>';
                        mhtml += '<span id="mealToggle' + a + '">';
                        if (med_data[a].withMeal != '0') {
                            mhtml += ' (w/meal)</span><input type="hidden" id="withMeal' + a + '" value="1" />';
                        } else {
                            mhtml += '</span><input type="hidden" id="withMeal' + a + '" value="0" />';
                        }
                        mhtml += '</div>';
                        mhtml += '<div class="col-xs-3">';
                        mhtml += '<span class="col-xs-10 crunch" id="dosage' + a + '">' + med_data[a].dosage + '</span>';
                        mhtml += '</div>';
                        mhtml += '<div class="col-xs-4">';
                        mhtml += '<span class="col-xs-10 crunch" id="notes' + a + '">' + med_data[a].medNotes + '</span>';
                        mhtml += '</div>';
                        mhtml += '<div class="col-xs-2">';
                        mhtml += '<input class="pull-right" type="button" value="Update" onclick="updateMed(' + a + ');" />';
                        mhtml += '</div>';
                        mhtml += '</div>';
                        b = a;
                    }
                    $('#medicine_edit .container').append(mhtml);
                    $('#med_row_' + b).css('border-bottom', 0);
                }
            }, 'json');

            // get caretakers
            $.post('/log/getCaretakers', ct_data, function(ct_stuff) {
                var ctl = ct_stuff.length;
                var html = '';
                if (ctl > 0) {
                    $('#designated_edit .container').css('display', 'block');
                    var y = 0;
                    for (var x = 0; x < ctl; x++) {
                        x = parseInt(x);
                        html += '<div class="row" id="ct_row_' + x + '">';
                        html += '<input type="hidden" id="ct_id_' + x + '" value="' + ct_stuff[x].id + '" />';
                        html += '<div class="col-xs-3">';
                        html += '<span id="ctName' + x + '">' + ct_stuff[x].caretakerName + '</span>';
                        html += '</div>';
                        html += '<div class="col-xs-4">';
                        html += '<span class="col-xs-10" id="ctEmail' + x + '">' + ct_stuff[x].caretakerEmail + '</span>';
                        html += '</div>';
                        html += '<div class="col-xs-4">';
                        html += '<input class="pull-right" type="button" value="Update" onclick="updateCt(' + x + ');" />';
                        html += '</div>';
                        html += '</div>';
                        y = x;
                    } 
                    $('#designated_edit .container').append(html);
                    $('#ct_row_'+y).css('border-bottom', 0);
                } else {
                        $('#designated_edit').hide();
                        $('#designation_row').show();
                }
            }, 'json');
            $('select[id!=dog_choice]').trigger('change');  
            showRegistryButton();
        }
    }, 'json');
}

function getNumberFromMonth(monthWord) {
    var month = {
        'January' : '1',
        'February' : '2',
        'March' : '3',
        'April' : '4',
        'May' : '5',
        'June' : '6',
        'July' : '7',
        'August' : '8',
        'September' : '9',
        'October' : '10',
        'November' : '11',
        'December' : '12'
    };
    return month[monthWord];
}

function showRegistryButton() {
    if ($('#dog_id').val() != '') {
        $('#change_the_dog').css('display', 'block');
    } else {
        $('#register_the_dog').css('display', 'block');
    }
}

function resetRegistry(inc_dog_choice) {
    var csrf = $('[name=csrf_test_name]').val();
    // Reset the dropdowns
    $('select').each(function() {
        var id = '#' + $(this).attr('id');
        if (id !== '#dog_choice' || inc_dog_choice) {
            $(id).val($(id+' option:first').val());
        }
    });
    
    // Reset the input boxes
    $('input[type!=button]').val('');
    
    // Reset the checkboxes
    $('input[type=checkbox]').prop('checked', false);
    
    // Reset the caretakers
    $('#designated_edit .container').empty().css('display','none');    
    
    // Maintain the CSRF contents
    $('[name=csrf_test_name]').val(csrf);
    return;
}

function addMedicine(logMed) {
    if (typeof logMed === 'undefined') {
        logMed = false;
    }
    
    if (!logMed) {
        $('#med_add_dogID').val($('#dog_id').val());
        $('#med_add_modal').modal('show');
        
        $('#med_add_right_button').on('click', function(e) {
            e.preventDefault();
            var post_vars = {
                csrf_test_name : $('[name=csrf_test_name]').val(),
                dogID : $('#med_add_dogID').val(),
                medName: $('#med_add_name').val(),
                dosage: $('#med_add_dosage').val(),
                medNotes: $('#med_add_notes').val(),
                withMeal: $('#med_add_with_meal').prop('checked') ? 1 : 0
            };
        });
    } else {
        var post_vars = {
            csrf_test_name : $('[name=csrf_test_name]').val(),
            dogID : $('#med_add_dogID').val(),
            medName: $('#med_add_name').val(),
            dosage: $('#med_add_dosage').val(),
            medNotes: $('#med_add_notes').val(),
            withMeal: $('#med_add_with_meal').prop('checked') ? 1 : 0
        };
        
        postNewMed(post_vars, true);
    }
}

function postNewMed(post_vars, logMed) {
    if (typeof logMed === 'undefined') {
        logMed = false;
    }
    $.post('/log/newMedicine', post_vars, function(data) {
        $('#med_add_modal').modal('hide');
        setTimeout(function() {
            if (data.success) {
                if (!logMed) {
                    $('#medicine_edit').show();
                    $('#medicine_edit .container').show();
                    var num_rows = $('[id^=med_row_]').length;
                    var html = '<div class="row" id="med_row_' + num_rows + '">';
                    html += '<input id="med_id_' + num_rows + '" type="hidden" value="' + data.insert_id + '" />' ;
                    html += '<div class="col-xs-3 crunch">';
                    html += '<span id="medName' + num_rows + '">' + post_vars.medName + '</span>';
                    html += '<span id="mealToggle' + num_rows + '">';
                    if (post_vars.withMeal) {
                        html += ' (w/meal)</span><input type="hidden" id="withMeal' + num_rows + '" value="1" />' ;
                    } else {
                        html += '</span><input type="hidden" id="withMeal' + num_rows + '" value="0" />';
                    }
                    html += '</div>';
                    html += '<div class="col-xs-3">';
                    html += '<span id="dosage' + num_rows + '" class="col-xs-10 crunch">' + post_vars.dosage + '</span>';
                    html += '</div>';
                    html += '<div class="col-xs-4">';
                    html += '<span class="col-xs-10 crunch" id="notes' + num_rows + '">' + post_vars.medNotes + '</span>';
                    html += '</div>';
                    html += '<div class="col-xs-2">';
                    html += '<input class="pull-right" type="button" onclick="updateMed(' + num_rows + ');" value="Update" />';
                    html += '</div>';
                    html += '</div>';
                    $('#medicine_edit .container').append(html);
                    $('#med_row_' + (num_rows-1)).css('border-bottom-width', '1px');
                    $('#med_row_' + (num_rows-1)).css('border-bottom-color', '#000');
                    $('#med_row_' + (num_rows-1)).css('border-bottom-style', 'solid');
                    $('#med_row_' + num_rows).css('border-bottom', 0);
                    $('#ltd_confirm_modal_subheader').html('Medicine has been added!');
                    $('#ltd_confirm_modal').modal('show');
                } else {
                    $('#med_select').append('<option selected = "selected" value="' + data.insert_id + '">' + post_vars.medName + '</option>');
                }
            } else {
                if (data.error) {
                    $('#ltd_error_modal_text').html(data.error);
                    $('#ltd_error_modal').modal('show');
                }
            }
        }, 500);
    }, 'json');
}

function addCaretaker() {
    $('#ct_add_dogID').val($('#dog_id').val());
    $('#ct_add_modal').modal('show');
    
    $('#ct_add_right_button').on('click', function(e) {
        e.preventDefault();
        var post_vars = {
            csrf_test_name : $('[name=csrf_test_name]').val(),
            dogID : $('#ct_add_dogID').val(),
            caretakerName : $('#ct_add_name').val(),
            caretakerEmail: $('#ct_add_email').val()
        };
        $.post('/log/newCaretaker', post_vars, function(data) {
            $('#ct_add_modal').modal('hide');
            setTimeout(function() {
                if (data.success) {
                    $('#designated_edit').show();
                    $('#designated_edit .container').show();
                    var num_rows = $('[id^=ct_row_]').length;
                    var html = '<div class="row" id="ct_row_' + num_rows + '">';
                    html += '<input id="ct_id_' + num_rows + '" type="hidden" value="' + data.insert_id + '" />' ;
                    html += '<div class="col-xs-3">';
                    html += '<span id="ctName' + num_rows + '">' + post_vars.caretakerName + '</span>';
                    html += '</div>';
                    html += '<div class="col-xs-4">';
                    html += '<span id="ctEmail' + num_rows + '" class="col-xs-10">' + post_vars.caretakerEmail + '</span>';
                    html += '</div>';
                    html += '<div class="col-xs-4">';
                    html += '<input class="pull-right" type="button" onclick="updateCt(' + num_rows + ');" value="Update" />';
                    html += '</div>';
                    html += '</div>';
                    $('#designated_edit .container').append(html);
                    $('#ct_row_' + (num_rows-1)).css('border-bottom-width', '1px');
                    $('#ct_row_' + (num_rows-1)).css('border-bottom-color', '#000');
                    $('#ct_row_' + (num_rows-1)).css('border-bottom-style', 'solid');
                    $('#ct_row_' + num_rows).css('border-bottom', 0);
                    $('#ltd_confirm_modal_subheader').html('Caretaker has been added!');
                    $('#ltd_confirm_modal').modal('show');
                } else {
                    if (data.error) {
                        $('#ltd_error_modal_text').html(data.error);
                        $('#ltd_error_modal').modal('show');
                    }
                }
            }, 500);
        }, 'json');
    });
}

function changeDog() {
    var neutered = $('#neutered').prop('checked') ? 1 : 0;
    var chipped = $('#is_chipped').prop('checked') ? 1 : 0;

    var post_vars = {
        dog_id: $('#dog_id').val(),
        dog_name : $('#dog_name').val(),
        dog_weight: $('#weight').val(),
        dog_length: $('#length').val(),
        dog_height: $('#height').val(),
        dog_gender: $('#dog_gender').val(),
        neutered: neutered,
        breed: $('#breed').val(),
        dog_color: $('#color').val(),
        dog_features: $('#features').val(),
        dog_bmonth: $('#birth_month').val(),
        dog_bdate: $('#birth_date').val(),
        dog_byear: $('#birth_year').val(),
        dog_altName: $('#alt_name').val(),
        dog_afflictions: $('#afflitions').val(),
        dog_fears: $('#fears').val(),
        commands: $('#commands').val(),
        chipped: chipped,
        chip_brand: $('#chip_brand').val(),
        chip_id: $('#chip_id').val(),
        confirm: 1,
        csrf_test_name : $('[name=csrf_test_name]').val(),
        update: 1
    };
    
    $.post('/log/register_a_dog', post_vars, function(data) {
        if (data.success) {
            dogRegistered(post_vars.dog_name, true);
        } else {
            $('#ltd_error_modal_text').html("There was a problem and " + post_vars.dog_name + "'s info might not have updated.");
            $('#ltd_error_modal').modal('show');
        }
    },'json');
}

function deleteMed() {
    var post_vars = {
        id: $('#med_edit_id').val(),
        csrf_test_name : $('[name=csrf_test_name]').val(),
    };
    
    $.post('/log/removeMed', post_vars, function(data) {
        $('#med_edit_modal').modal('hide');
        setTimeout(function() {
            if (data.success) {
                $($('#med_row_to_delete').val()).remove();
                var r= $('[id^=med_row_]').lenth;
                if (r === 0) {
                    $('#medicine_edit .container').css('display', 'none');
                } else {
                    $('#med_row_' + (r-1)).css('border-bottom', 0);
                }
                $('#ltd_confirm_modal_subheader').html('Medicine successfully removed!');
                $('#ltd_confirm_modal').modal('show');
            } else {
                $('#ltd_error_modal_text').html("There was a problem; that medicine may not have been removed.");
                $('#ltd_error_modal').modal('show');
            }
        }, 500);
    }, 'json');
}

function deleteCt() {
    var post_vars = {
        id: $('#ct_edit_id').val(),
        csrf_test_name : $('[name=csrf_test_name]').val(),
    };
    $.post('/log/removeCaretaker', post_vars, function(data) {
        $('#ct_edit_modal').modal('hide');
        setTimeout(function() {
            if (data.success) {
                $($('#row_to_delete').val()).remove();
                var r = $('[id^=ct_row_]').length;
                if (r === 0) {
                    $('#designated_edit .container').css('display', 'none');
                } else {
                    $('#ct_row_' + (r-1)).css('border-bottom', 0);
                }
                $('#ltd_confirm_modal_subheader').html('Caretaker successfully removed!');
                $('#ltd_confirm_modal').modal('show');
            } else {
                $('#ltd_error_modal_text').html("There was a problem; that caretaker may not have been removed.");
                $('#ltd_error_modal').modal('show');
            }
        }, 500);
    }, 'json');
}

function updateMed(x) {
    var updateData = {
        id : $('#med_id_' + x).val(),
        medName : $('#medName' + x).text(),
        dosage : $('#dosage' + x).text(),
        withMeal : $('#withMeal' + x).val(),
        medNotes : $('#notes' + x).text(),
        dogID : $('#dog_id').val()
    }
    $('#med_row_to_delete').val('#med_row_' + x);
    $('#med_edit_dogID').val(updateData.dogID);
    $('#med_edit_name').val(updateData.medName);
    $('#med_edit_dosage').val(updateData.dosage);
    $('#med_edit_notes').val(updateData.medNotes);
    $('#med_edit_id').val(updateData.id);
    
    if (updateData.withMeal == '1') {
        $('#med_edit_with_meal').prop('checked', true);
    } else {
        $('#med_edit_with_meal').prop('checked', false);
    }
        
    $('#med_edit_modal').modal('show');
    $('#med_edit_right_button').on('click', function(e) {
        e.preventDefault();
        var post_vars = {
            id : updateData.id,
            dogID: updateData.dogID,
            dosage: $('#med_edit_dosage').val(),
            withMeal: $('#med_edit_with_meal').prop('checked') == true ? '1' : '0',
            medNotes: $('#med_edit_notes').val(),
            medName: $('#med_edit_name').val(),
            csrf_test_name : $('[name=csrf_test_name]').val()
        };
        $.post('/log/editMedicine', post_vars, function(data) {
            $('#med_edit_modal').modal('hide');
            setTimeout(function() {
                if (data.success) {
                    $('#ltd_confirm_modal_subheader').html('Update successful!');
                    $('#ltd_confirm_modal').modal('show');
                    $('#medName' + x).text(post_vars.medName);
                    $('#withMeal' + x).val(post_vars.withMeal);
                    $('#dosage' + x).text(post_vars.dosage);
                    $('#notes' + x).text(post_vars.medNotes);
                    if (post_vars.withMeal == '0') {
                        $('#mealToggle' + x).text('');
                    } else {
                        $('#mealToggle' + x).text(' (w/meal)');
                    }
                } else {
                    $('#ltd_error_modal_text').html("There was a problem; that caretaker's details may not have been updated.");
                    $('#ltd_error_modal').modal('show');
                }
            }, 500);
        }, 'json');
    });
}

function updateCt(x) {
    var id = $('#ct_id_' + x).val();
    var caretakerName = $('#ctName' + x).text();
    var caretakerEmail = $('#ctEmail' + x).text();

    $('#ct_edit_id').val(id);
    $('#ct_name').val(caretakerName);
    $('#ct_email').val(caretakerEmail);
    $('#ct_edit_modal').modal('show');
    $("#row_to_delete").val('#ct_row_' + x);
    $('#ct_right_button').on('click', function(e) {
        e.preventDefault();
        var post_vars = {
            id : $('#ct_edit_id').val(),
            caretakerName : $('#ct_name').val(),
            caretakerEmail: $('#ct_email').val(),
            csrf_test_name : $('[name=csrf_test_name]').val()
        };
        $.post('/log/editCaretaker', post_vars, function(data) {
            $('#ct_edit_modal').modal('hide');
            setTimeout(function() {
                if (data.success) {
                    $('#ltd_confirm_modal_subheader').html('Update successful!');
                    $('#ltd_confirm_modal').modal('show');
                    $('#ctName' + x).text(post_vars.caretakerName);
                    $('#ctEmail' + x).text(post_vars.caretakerEmail);
                } else {
                    $('#ltd_error_modal_text').html("There was a problem; that caretaker's details may not have been updated.");
                    $('#ltd_error_modal').modal('show');
                }
            }, 500);
        }, 'json');
    });
}

function validateEmail(email) {
    var error = false;
    var email_regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    if (!email_regex.test(email)) {
        error = 'Please provide a valid e-mail address.';
    }
    
    return error;
}