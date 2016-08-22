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

function additionalDetails() {
    $('#reg_ex_container').show();
    $('#more_deets').hide();
}

function addDesignee() {
    var html_bef = '<div class="col-xs-10 bottom5 caretaker">';
    html_bef += '<input type="text" class="careName" placeholder="Caretaker\'s name" /> ';
    html_bef += '<input type="email" class="careEmail" placeholder="Caretaker\'s e-mail" />';
    html_bef += '<input type="button" value="Delete" class="deleteCt" />';
    html_bef += '</div>';
    $('#desspace').before(html_bef);
    if ($('#designate').val() === 'Designate') {
        $('#designate').val('Designate another');
    }
}

function reveal(section) {
    $('#' + section).show();
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
        confirm: 0
    };
    
    $.post('/index.php/log/register_a_dog', register_data, function(data) {
        if (data['success']) {
            // dog successfully registered
            dogRegistered($('#dog_name').val());
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

function dogRegistered(name) {
    $('#ltd_confirm_modal_subheader').html(name + ' has been registered.');
    $('#ltd_confirm_modal').modal('show');
    $('#ltd_confirm_modal_ok').on('click', function() {
        location.href = '/';
    });
}

$(document).on('click', '#select_this_dog', function () {
   getDogDeets($('#dog_selector').val());
}); 

function getDogDeets(dogID) {
    var url_parts = location.href.split('/');
    var activity = url_parts[url_parts.length-1];
    var post_data = {
        'dogID' : dogID,
        'csrf_test_name' : $('[name=csrf_test_name]').val(),
        'activity' : activity
    };
    
    $.post('/index.php/log/getDogInfo', post_data, function(data) {
        if (data && data['success']) {
            $('.dogName').html(data['dog']['dogName']);
            $('#doggie_data').css('display','block');
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
    
    $.post('/index.php/log/logMeal', post_vars, function (data) {
        if (data['success'] == true) {
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
        'medType' : $('#med_type').val(),
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
    $('#ltd_dual_options_modal_subheader').html(conf_text);
    $('#ltd_dual_options_left_button').html('Cancel');
    $('#ltd_dual_options_right_button').html('OK');
    $('#ltd_dual_options_modal').modal('show');
    
    $('#ltd_dual_options_right_button').on('click', function() {
        var post_vars = {
            'username' : $('#username').val(),
            'email' : $('#email').val(),
            'language' : $('[name=language]:checked').val(),
            'csrf_test_name' : $('[name=csrf_test_name]').val()
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
