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