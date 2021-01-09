function editWalks() {
    let post_vars = {
        dog_id : $('#dog_names').val(),
        reverse: true,
        csrf_test_name : $('[name=csrf_test_name]').val()
    };
    
    $.post('/edit/getWalks', post_vars, function(data) {
        var html = '<div class="col-xs-3"></div>';
        var walkCount = data.length;
        var y=0;
        var prev = -1;
        // generate HTML for *everything*
        for (var x = 0; x < walkCount; x++) {
            var tblCls = "editTable col-xs-6    ";
            if (x%10 === 0) {
                if (x !== 0) {
                    tblCls += " hideTable";
                }
                html += '<table class="' + tblCls + '" id="table_' + y + '">';
                html += '<tr class="tableHeader"><th>Date</th><th>Time</th><th>Activity</th><th>Notes</th><th></th></tr>';
            }
            html += '<tr class="standardRow';
            if (x%2 === 0) {
                html += ' evenRow';
            }
            html += '">';
            html += '<td>';
            html += '<input type="hidden" id="walk_id_' + x + '" value="' + data[x].walkID + '" />';
            html += '<span id="date_id_' + x + '">' + data[x].date + '</span></td>';
            html += '<td><span id="time_id_' + x + '">' + data[x].time + '</span></td>';
            html += '<input type="hidden" id="seconds_' + x + '" value="'+ data[x].seconds + '" />';
            html += '<td class="actionSpan"><span id="action_id_' + x + '">' + data[x].action + '</span></td>';
            html += '<td class="notesSpan"><span id="notes_id_' + x + '">' + data[x].walkNotes + '</span></td>';
            html += '<td>';
            html += '<input type="button" onClick="editWalk(' + x + ');"';
            html += ' id="editButton' + x + '" value="Edit" />';
            html += '<input type="button" onClick="deleteWalk(' + x + ');"';
            html += ' id="deleteButton' + x + '" value="Delete" />';
            html += '</td></tr>';
            if ((x % 10) === 9 || x === (walkCount-1)) {
                if (x === (walkCount-1)) {
                    var numEmpty = 10 - (walkCount%10);
                    for (var w = 0; w < numEmpty; w++) {
                        html += '<tr class="blankRow';
                        if ((x+w)%2 !== 0) {
                            html += ' evenRow';
                        }
                        html += '"><td><span class="noButton"></span></td>';
                        html += '<td><span class="noButton"></span></td>';
                        html += '<td><span class="noButton"></span></td>';
                        html += '<td></td><td><span class="noButton"></span></td></tr>';
                    }
                }
                html += '<tr>';
                prev = y-1;
                html += '<td>';
                if (y > 0) {
                    html += '<a class="pointer" onclick="prevPage(' + y + ');"><< prev</a>';
                }
                html += '</td><td></td><td></td><td>';
                if (typeof data[x+1] !== 'undefined') {
                    html += '<a class="pointer" onclick="nextPage('+ y +');">next >></a>';
                }
                html += '</td></tr>';
                html += '</table>';
                y++;
            }
        }
        html += '<div class="col-xs-3"></div>';
        $('#walk_list_container').html(html);
    }, 'json');
}

function editMeds() {
    var post_vars = {
        dog_id : $('#dog_names').val(),
        reverse: true,
        csrf_test_name : $('[name=csrf_test_name]').val()
    };

    $.post('/edit/getMeds', post_vars, function(data) {
        let html = '<div class="col-xs-3"></div>';
        let medCount = data.length;
        let y=0;
        let prev = -1;
        // generate HTML for *everything*
        for (let x = 0; x < medCount; x++) {
            let tblCls = "editTable col-xs-6    ";
            if (x%10 === 0) {
                if (x !== 0) {
                    tblCls += " hideTable";
                }
                html += '<table class="' + tblCls + '" id="table_' + y + '">';
                html += '<tr class="tableHeader"><th>Date</th><th>Time</th><th>Med Type</th><th>Notes</th><th></th></tr>';
            }
            html += '<tr class="standardRow';
            if (x%2 === 0) {
                html += ' evenRow';
            }

            data[x].medType = (typeof data[x].medType == 'undefined') ? '' : data[x].medType;

            html += '">';
            html += '<td>';
            html += '<input type="hidden" id="med_id_' + x + '" value="' + data[x].medID + '" />';
            html += '<span id="date_id_' + x + '">' + data[x].date + '</span></td>';
            html += '<td><span id="time_id_' + x + '">' + data[x].time + '</span></td>';
            html += '<input type="hidden" id="seconds_' + x + '" value="'+ data[x].seconds + '" />';
            html += '<td><span id="type_id_' + x + '">' + data[x].medType + '</span>';
            html += '<input type="hidden" id="med_type_id_' + x + '" value="' + data[x].medTypeID + '" /> </td>';
            html += '<td class="notesSpan"><span id="notes_id_' + x + '">' + data[x].medNotes + '</span></td>';
            html += '<td>';
            html += '<input type="button" onClick="editMed(' + x + ');"';
            html += ' id="editButton' + x + '" value="Edit" />';
            html += '<input type="button" onClick="deleteMed(' + x + ');"';
            html += ' id="deleteButton' + x + '" value="Delete" />';
            html += '</td></tr>';
            if ((x % 10) === 9 || x === (medCount-1)) {
                if (x === (medCount-1)) {
                    var numEmpty = 10 - (medCount%10);
                    for (var w = 0; w < numEmpty; w++) {
                        html += '<tr class="blankRow';
                        if ((x+w)%2 !== 0) {
                            html += ' evenRow';
                        }
                        html += '"><td><span class="noButton"></span></td>';
                        html += '<td><span class="noButton"></span></td>';
                        html += '<td></td><td><span class="noButton"></span></td></tr>';
                    }
                }
                html += '<tr>';
                prev = y-1;
                html += '<td>';
                if (y > 0) {
                    html += '<a class="pointer" onclick="prevPage(' + y + ');"><< prev</a>';
                }
                html += '</td><td></td><td></td><td>';
                if (typeof data[x+1] !== 'undefined') {
                    html += '<a class="pointer" onclick="nextPage('+ y +');">next >></a>';
                }
                html += '</td></tr>';
                html += '</table>';
                y++;
            }
        }
        html += '<div class="col-xs-3"></div>';

        $('#med_list_container').html(html);
    }, 'json');
}

function editTreats() {
    let et_post_vars = {
        dog_id : $('#dog_names').val(),
        reverse: true,
        csrf_test_name : $('[name=csrf_test_name]').val()
    };

    $.post('/edit/getTreats', et_post_vars, function(data) {
        let thtml = '<div class="col-xs-3"></div>';
        let treatCount = data.length;
        let y=0;
        let prev = -1;
        // generate HTML for *everything*
        for (let x = 0; x < treatCount; x++) {
            let tblCls = "editTable col-xs-6    ";
            if (x%10 === 0) {
                if (x !== 0) {
                    tblCls += " hideTable";
                }
                thtml += '<table class="' + tblCls + '" id="table_' + y + '">';
                thtml += '<tr class="tableHeader"><th>Date</th><th>Time</th><th>Treat Type</th><th>Notes</th><th></th></tr>';
            }
            thtml += '<tr class="standardRow';
            if (x%2 === 0) {
                thtml += ' evenRow';
            }
            thtml += '">';
            thtml += '<td>';
            thtml += '<input type="hidden" id="treat_id_' + x + '" value="' + data[x].treatID + '" />';
            thtml += '<span id="date_id_' + x + '">' + data[x].date + '</span></td>';
            thtml += '<td><span id="time_id_' + x + '">' + data[x].time + '</span></td>';
            thtml += '<input type="hidden" id="seconds_' + x + '" value="'+ data[x].seconds + '" />';
            thtml += '<input type="hidden" id="treat_type_id_' + x + '" value="' + data[x].treatType + '" />';
            thtml += '<td><span id="type_id_' + x + '">';
            thtml += typeof data[x].treatName != 'undefined' ? data[x].treatName : data[x].treatType;
            thtml += '</span></td>';
            thtml += '<td class="notesSpan"><span id="notes_id_' + x + '">' + data[x].treatNotes + '</span></td>';
            thtml += '<td>';
            thtml += '<input type="button" onClick="editTreat(' + x + ');"';
            thtml += ' id="editButton' + x + '" value="Edit" />';
            thtml += '<input type="button" onClick="deleteTreat(' + x + ');"';
            thtml += ' id="deleteButton' + x + '" value="Delete" />';
            thtml += '</td></tr>';
            if ((x % 10) === 9 || x === (treatCount-1)) {
                if (x === (treatCount-1)) {
                    let numEmpty = 10 - (treatCount%10);
                    for (let w = 0; w < numEmpty; w++) {
                        thtml += '<tr class="blankRow';
                        if ((x+w)%2 !== 0) {
                            thtml += ' evenRow';
                        }
                        thtml += '"><td><span class="noButton"></span></td>';
                        thtml += '<td><span class="noButton"></span></td>';
                        thtml += '<td></td><td><span class="noButton"></span></td></tr>';
                    }
                }
                thtml += '<tr>';
                prev = y-1;
                thtml += '<td>';
                if (y > 0) {
                    thtml += '<a class="pointer" onclick="prevPage(' + y + ');"><< prev</a>';
                }
                thtml += '</td><td></td><td></td><td>';
                if (typeof data[x+1] !== 'undefined') {
                    thtml += '<a class="pointer" onclick="nextPage('+ y +');">next >></a>';
                }
                thtml += '</td></tr>';
                thtml += '</table>';
                y++;
            }
        }
        thtml += '<div class="col-xs-3"></div>';

        $('#treat_list_container').html(thtml);
    }, 'json');
}

function editMeals() {
    let post_vars = {
        dog_id : $('#dog_names').val(),
        reverse: true,
        csrf_test_name : $('[name=csrf_test_name]').val()
    };
    
    $.post('/edit/getMeals', post_vars, function(data) {
        let html = '<div class="col-xs-3"></div>';
        let mealCount = data.length;
        let y=0;
        let prev = -1;
        // generate HTML for *everything*
        for (let x = 0; x < mealCount; x++) {
            let tblCls = "editTable col-xs-6    ";
            if (x%10 === 0) {
                if (x !== 0) {
                    tblCls += " hideTable";
                }
                html += '<table class="' + tblCls + '" id="table_' + y + '">';
                html += '<tr class="tableHeader"><th>Date</th><th>Time</th><th>Notes</th><th></th></tr>';
            }
            html += '<tr class="standardRow';
            if (x%2 === 0) {
                html += ' evenRow';
            }
            html += '">';
            html += '<td>';
            html += '<input type="hidden" id="meal_id_' + x + '" value="' + data[x].mealID + '" />';
            html += '<span id="date_id_' + x + '">' + data[x].date + '</span></td>';
            html += '<td><span id="time_id_' + x + '">' + data[x].time + '</span></td>';
            html += '<input type="hidden" id="seconds_' + x + '" value="'+ data[x].seconds + '" />';
            html += '<td class="notesSpan"><span id="notes_id_' + x + '">' + data[x].mealNotes + '</span></td>';
            html += '<td>';
            html += '<input type="button" onClick="editMeal(' + x + ');"';
            html += ' id="editButton' + x + '" value="Edit" />';
            html += '<input type="button" onClick="deleteMeal(' + x + ');"';
            html += ' id="deleteButton' + x + '" value="Delete" />';
            html += '</td></tr>';
            if ((x % 10) === 9 || x === (mealCount-1)) {
                if (x === (mealCount-1)) {
                    let numEmpty = 10 - (mealCount%10);
                    for (let w = 0; w < numEmpty; w++) {
                        html += '<tr class="blankRow';
                        if ((x+w)%2 !== 0) {
                            html += ' evenRow';
                        }
                        html += '"><td><span class="noButton"></span></td>';
                        html += '<td><span class="noButton"></span></td>';
                        html += '<td></td><td><span class="noButton"></span></td></tr>';
                    }
                }
                html += '<tr>';
                prev = y-1;
                html += '<td>';
                if (y > 0) {
                    html += '<a class="pointer" onclick="prevPage(' + y + ');"><< prev</a>';
                }
                html += '</td><td></td><td></td><td>';
                if (typeof data[x+1] !== 'undefined') {
                    html += '<a class="pointer" onclick="nextPage('+ y +');">next >></a>';
                }
                html += '</td></tr>';
                html += '</table>';
                y++;
            }
        }
        html += '<div class="col-xs-3"></div>';
        $('#meal_list_container').html(html);
    }, 'json');
}

function nextPage(unhide) {
    $('#table_' + unhide).css('display', 'none');
    $('#table_' + (unhide + 1)).css('display','block');
}

function prevPage(hide) {
    $('#table_' + hide).css('display', 'none');
    $('#table_' + (hide-1)).css('display','block');
}

function editMeal(mealID) {
    $('#edit_meal_mealID').val($('#meal_id_'+mealID).val());
    $('#edit_meal_date').val($('#date_id_' + mealID).text());
    $('#edit_meal_hour').val($('#time_id_' + mealID).text().substr(0,2));
    $('#edit_meal_minute').val($('#time_id_' + mealID).text().substr(3,2));
    $('#edit_meal_seconds').val($('#seconds_' + mealID).val());
    $('#edit_meal_ampm').val($('#time_id_' + mealID).text().substr(6,2));
    $('#edit_meal_notes').val($('#notes_id_' + mealID).text());
    $('#edit_meal_modal').modal('show');
    $('#edit_meal_date').datepick({
        dateFormat: 'mm/dd/yyyy',
        showOnFocus: true,
        rangeSelect: false,
        maxDate: "new Date()"
    });

    $('#edit_meal_right_button').on('click', function(e) {
        e.preventDefault();
        let confirm_date = $('#edit_meal_date').val();
        let meal_date = confirm_date.split('/');
        let formatted_meal_date = meal_date[2] + '-' + meal_date[0] + '-' + meal_date[1] + ' ';
        let confirm_hour = $('#edit_meal_hour').val();
        let meal_hour = parseInt(confirm_hour);
        if ($('#edit_meal_ampm').val() === 'pm' && meal_hour !== 12) {
            meal_hour += 12;
        } else if ($('#edit_meal_ampm').val() === 'am' && meal_hour === 12) {
            meal_hour = '00';
        } else if (meal_hour < 10) {
            meal_hour = '0' + meal_hour;
        }

        formatted_meal_date += meal_hour + ':' + $('#edit_meal_minute').val() + ':' + $('#edit_meal_seconds').val();
        let meal_post_vars = {
            csrf_test_name : $('[name=csrf_test_name]').val(),
            meal_id : $('#edit_meal_mealID').val(),
            meal_date: formatted_meal_date,
            meal_notes: $('#edit_meal_notes').val()
        };
        $.post('/edit/editMeal', meal_post_vars, function(data) {
            $('#edit_meal_modal').modal('hide');
            if (data.success) {
                // Update time in the list
                $('#date_id_' + mealID).text(confirm_date);
                $('#time_id_' + mealID).text(confirm_hour + ':' + $('#edit_meal_minute').val() + ' ' + $('#edit_meal_ampm').val());
                $('#notes_id_'+ mealID).text(meal_post_vars.meal_notes);
                $('#ltd_confirm_modal_subheader').html('This meal has been updated.');
                setTimeout(function() {
                    $('#ltd_confirm_modal').modal('show');
                }, 400);
            } else {
                $('#ltd_error_modal_text').html('There was a problem, and this meal might not have been updated.');
                setTimeout(function() {
                    $('#ltd_error_modal').modal('show');
                }, 400);
            }
        }, 'json');
    });
}

function editMed(medID) {
    // First, get a list of meds associated with this dog.
    let get_med_post = {
        csrf_test_name : $('[name=csrf_test_name]').val(),
        dog_id : $('#dog_names').val()
    };

    $.post('/edit/getDogMeds',get_med_post, function(medData) {
        if ($('#med_picker > option').length < 1) {
            medData.forEach(function (x) {
                $('#med_picker').append(new Option(x.medName, x.id));
            });
            $('#med_picker').append(new Option('(other)', 'other'));
        }

        $('#med_picker > option').each(function() {
            if ($(this).val() == $('#med_type_id_'+medID).val()) {
                $(this).prop('selected', 'selected');
            } else {
                $(this).prop('selected', false);
            }
        });
    }, 'json');

    $('#med_picker').on('change', function() {
        if ($('#med_picker').val() == 'other') {
//            $('.otherMedRow').show();
            $('#med_add_modal').modal('show');
            setTimeout(function() {
                $('#med_add_right_button').on('click', function(e) {
                    e.preventDefault();
                    $('#med_add_modal').modal('hide');
                    $('#med_add_name,#med_add_dosage,#med_add_notes').val('');
                    $('#med_add_with_meal').prop('checked', false);
                    setTimeout(function() {
                        let new_med_post_vars = {
                            csrf_test_name : $('[name=csrf_test_name]').val(),
                            dogID : $('#dog_names').val(),
                            medName: $('#med_add_name').val(),
                            dosage: $('#med_add_dosage').val(),
                            medNotes: $('#med_add_notes').val(),
                            withMeal: $('#med_add_with_meal').prop('checked') ? 1 : 0
                        };
                        $.post('/logit/newMedicine', new_med_post_vars, function(nm_data) {
                            setTimeout(function() {
                                if (nm_data.success) {
                                    $('#med_picker').append(new Option(new_med_post_vars.medName, nm_data.insert_id));
                                    $('#med_picker > option').each(function() {
                                        if ($(this).val() == nm_data.insert_id) {
                                            $(this).prop('selected', 'selected');
                                        } else {
                                            $(this).prop('selected', false);
                                        }
                                    });
                                } else {
                                    $('#ltd_error_modal_header_text').html('Error');
                                    $('#ltd_error_modal_text').html('There was a problem adding the new medicine.');
                                    $('#ltd_error_modal').modal('show');
                                }
                            }, 500);
                        }, 'json');
                    }, 500);
                });
            }, 500);

        } else {
//            $('.otherMedRow').hide();
        }
    });

    $('#edit_med_medID').val($('#med_id_'+medID).val());
    $('#edit_med_date').val($('#date_id_' + medID).text());
    $('#edit_med_hour').val($('#time_id_' + medID).text().substr(0,2));
    $('#edit_med_minute').val($('#time_id_' + medID).text().substr(3,2));
    $('#edit_med_seconds').val($('#seconds_' + medID).val());
    $('#edit_med_ampm').val($('#time_id_' + medID).text().substr(6,2));
    $('#edit_med_notes').val($('#notes_id_' + medID).text());
    $('#edit_med_modal').modal('show');
    $('#edit_med_date').datepick({
        dateFormat: 'mm/dd/yyyy',
        showOnFocus: true,
        rangeSelect: false,
        maxDate: "new Date()"
    });
    
    
    $('#edit_med_right_button').on('click', function(e) {
        e.preventDefault();
        let confirm_date = $('#edit_med_date').val();
        let med_date = confirm_date.split('/');
        let formatted_med_date = med_date[2] + '-' + med_date[0] + '-' + med_date[1] + ' ';
        let confirm_hour = $('#edit_med_hour').val();
        let med_hour = parseInt(confirm_hour);
        if ($('#edit_med_ampm').val() === 'pm' && med_hour !== 12) {
            med_hour += 12;
        } else if ($('#edit_med_ampm').val() === 'am' && med_hour === 12) {
            med_hour = '00';
        } else if (med_hour < 10) {
            med_hour = '0' + med_hour;
        }

        formatted_med_date += med_hour + ':' + $('#edit_med_minute').val() + ':' + $('#edit_med_seconds').val();
        let med_post_vars = {
            csrf_test_name : $('[name=csrf_test_name]').val(),
            med_id : $('#edit_med_medID').val(),
            med_date: formatted_med_date,
            med_notes: $('#edit_med_notes').val(),
            med_type: $('#med_picker').val(),
            dog_id: get_med_post.dog_id,
        };

        $.post('/edit/editMed', med_post_vars, function(data) {
            $('#edit_med_modal').modal('hide');
            if (data.success) {
                // Update time in the list
                $('#date_id_' + medID).text(confirm_date);
                $('#time_id_' + medID).text(confirm_hour + ':' + $('#edit_med_minute').val() + ' ' + $('#edit_med_ampm').val());
                $('#notes_id_' + medID).text(med_post_vars.med_notes);
                $('#type_id_' + medID).text($('#med_picker option:selected').text());
                $('#med_type_id_' + medID).val(med_post_vars.med_type);
                $('#ltd_confirm_modal_subheader').html('This med has been updated.');
                $('#with_meal').val(0);
                setTimeout(function() {
                    $('#ltd_confirm_modal').modal('show');
                }, 400);
            } else {
                $('#ltd_error_modal_text').html('There was a problem, and the med might not have been updated.');
                setTimeout(function() {
                    $('#ltd_error_modal').modal('show');
                }, 400);
            }
        }, 'json');
    });
}

function editTreat(treatID) {
    let treat_post = {
        csrf_test_name : $('[name=csrf_test_name]').val(),
        dog_id : $('#dog_names').val()
    };
    let other_exists = false;
    let found_value = false;

    $.post('/edit/getDogTreats', treat_post, function(tData) {
        if ($('#treat_given > option').length < 1) {
            tData.forEach(function(tx) {
                $('#treat_given').append(new Option(tx.treatName, tx.id));
            });
        } else {
            tData.forEach(function(ntx) {
                if (typeof $('#treat_given option[value=' + ntx.id +']').val() == "undefined") {
                    $('#treat_given').append(new Option(ntx.treatName, ntx.id));
                }
            });
        }
        $('#treat_given >option').each(function() {
            if (this.value == 'flirzelkwerp') {
                other_exists = true;
                $(this).prop('selected', false);
            } else if ($(this).val() == $('#treat_type_id_' + treatID).val()) {
                $(this).prop('selected', true);
                found_value = true;
            } else {
                $(this).prop('selected', false);
            }
        });

        if (!other_exists) {
            $('#treat_given').append(new Option('(other)', 'flirzelkwerp'));
        }

        if (!found_value) {
            $('#treat_given').val('flirzelkwerp').change();
            $('.otherTreat').show();
        } else {
            $('.otherTreat').hide();
        }

    }, 'json');

    $('#treat_given').on('change', function() {
        if ($('#treat_given').val() == 'flirzelkwerp') {
            // Add an unlisted treats
            $('.otherTreat').show();
        } else {
            $('.otherTreat').hide();
        }
    });

    $('#edit_treat_treatID').val($('#treat_id_'+treatID).val());
    $('#edit_treat_date').val($('#date_id_' + treatID).text());
    $('#edit_treat_hour').val($('#time_id_' + treatID).text().substr(0,2));
    $('#edit_treat_minute').val($('#time_id_' + treatID).text().substr(3,2));
    $('#edit_treat_seconds').val($('#seconds_' + treatID).val());
    $('#treat_given').val($('#type_id_' + treatID).text());
    $('#edit_treat_ampm').val($('#time_id_' + treatID).text().substr(6,2));
    $('#edit_treat_notes').val($('#notes_id_' + treatID).text());
    $('#edit_treat_modal').modal('show');
    $('#edit_treat_date').datepick({
        dateFormat: 'mm/dd/yyyy',
        showOnFocus: true,
        rangeSelect: false,
        maxDate: "new Date()"
    });


    $('#edit_treat_right_button').on('click', function(e) {
        e.preventDefault();
        let confirm_date = $('#edit_treat_date').val();
        let treat_date = confirm_date.split('/');
        let formatted_treat_date = treat_date[2] + '-' + treat_date[0] + '-' + treat_date[1] + ' ';
        let confirm_hour = $('#edit_treat_hour').val();
        let treat_hour = parseInt(confirm_hour);
        if ($('#edit_treat_ampm').val() === 'pm' && treat_hour !== 12) {
            treat_hour += 12;
        } else if ($('#edit_med_ampm').val() === 'am' && treat_hour === 12) {
            treat_hour = '00';
        } else if (treat_hour < 10) {
            treat_hour = '0' + treat_hour;
        }

        formatted_treat_date += treat_hour + ':' + $('#edit_treat_minute').val() + ':' + $('#edit_treat_seconds').val();

        // What if the user is entering a new treat here? Handle it!
        let other_treat = typeof $('#other_treat').val() == 'undefined' ? '' : $('#other_treat').val();
        let other_treat_notes = typeof $('#other_treat_notes').val() == 'undefined' ? '' : $('#other_treat_notes').val();

        let treat_post_vars = {
            csrf_test_name : $('[name=csrf_test_name]').val(),
            dog_id : $('#dog_names').val(),
            treat_id : $('#edit_treat_treatID').val(),
            treat_date: formatted_treat_date,
            treat_notes: $('#edit_treat_notes').val(),
            treat_type: $('#treat_given').val(),
            other_treat: other_treat,
            other_treat_notes: other_treat_notes
        };

        $.post('/edit/editTreat', treat_post_vars, function(data) {
            $('#edit_treat_modal').modal('hide');
            if (data.success) {
                // Update time in the list
                $('#date_id_' + treatID).text(confirm_date);
                $('#time_id_' + treatID).text(confirm_hour + ':' + $('#edit_treat_minute').val() + ' ' + $('#edit_treat_ampm').val());
                $('#notes_id_' + treatID).text(treat_post_vars.treat_notes);
                $('#type_id_' + treatID).text(treat_post_vars.treat_type);
                $('#ltd_confirm_modal_subheader').html('This treat has been updated.');
                setTimeout(function() {
                    $('#ltd_confirm_modal').modal('show');
                }, 400);
            } else {
                $('#ltd_error_modal_text').html('There was a problem, and the treat might not have been updated.');
                setTimeout(function() {
                    $('#ltd_error_modal').modal('show');
                }, 400);
            }
        }, 'json');
    });
}

function editWalk(walkID) {
    $('#edit_walk_walkID').val($('#walk_id_'+walkID).val());
    $('#edit_walk_date').val($('#date_id_' + walkID).text());
    $('#edit_walk_hour').val($('#time_id_' + walkID).text().substr(0,2));
    $('#edit_walk_minute').val($('#time_id_' + walkID).text().substr(3,2));
    $('#edit_walk_seconds').val($('#seconds_' + walkID).val());
    $('#edit_walk_ampm').val($('#time_id_' + walkID).text().substr(6,2));
    $('#edit_walk_activity').val($('#action_id_' + walkID).text());
    $('#edit_walk_notes').val($('#notes_id_' + walkID).text());
    $('#edit_walk_modal').modal('show');
    $('#edit_walk_date').datepick({
        dateFormat: 'mm/dd/yyyy',
        showOnFocus: true,
        rangeSelect: false,
        maxDate: "new Date()"
    });
    
    
    $('#edit_walk_right_button').on('click', function(e) {
        e.preventDefault();
        let confirm_date = $('#edit_walk_date').val();
        let walk_date = confirm_date.split('/');
        let formatted_walk_date = walk_date[2] + '-' + walk_date[0] + '-' + walk_date[1] + ' ';
        let confirm_hour = $('#edit_walk_hour').val();
        let walk_hour = parseInt(confirm_hour);
        if ($('#edit_walk_ampm').val() === 'pm' && walk_hour !== 12) {
            walk_hour += 12;
        } else if ($('#edit_walk_ampm').val() === 'am' && walk_hour === 12) {
            walk_hour = '00';
        } else if (walk_hour < 10) {
            walk_hour = '0' + walk_hour;
        }

        formatted_walk_date += walk_hour + ':' + $('#edit_walk_minute').val() + ':' + $('#edit_walk_seconds').val();
        let post_vars = {
            csrf_test_name : $('[name=csrf_test_name]').val(),
            walk_id : $('#edit_walk_walkID').val(),
            walk_date: formatted_walk_date,
            activity: $('#edit_walk_activity').val(),
            walk_notes: $('#edit_walk_notes').val()
        };
        $.post('/edit/editWalk', post_vars, function(data) {
            $('#edit_walk_modal').modal('hide');
            if (data.success) {
                // Update time in the list
                $('#date_id_' + walkID).text(confirm_date);
                $('#time_id_' + walkID).text(confirm_hour + ':' + $('#edit_walk_minute').val() + ' ' + $('#edit_walk_ampm').val());
                $('#notes_id_' +walkID).text(post_vars.walk_notes);
                $('#action_id_' + walkID).text(post_vars.activity);
                $('#ltd_confirm_modal_subheader').html('This walk has been updated.');
                setTimeout(function() {
                    $('#ltd_confirm_modal').modal('show');
                }, 400);
            } else {
                $('#ltd_error_modal_text').html('There was a problem, and this walk might not have been updated.');
                setTimeout(function() {
                    $('#ltd_error_modal').modal('show');
                }, 400);
            }
        }, 'json');
    });
}

function deleteMeal(x) {
    let post_vars = {
        csrf_test_name : $('[name=csrf_test_name]').val(),
        mealID: $('#meal_id_' + x).val()
    };
    $('#edit_meal_modal').modal('hide');
    let html = "Are you sure you wish to delete the meal logged on " + $('#date_id_' + x).text();
    html += ' at ' + $('#time_id_' + x).text() + '?';
    
    setTimeout(function() {
        $('#ltd_dual_options_modal_subheader').html(html)
        $('#ltd_dual_options_left_button').html("No");
        $('#ltd_dual_options_right_button').html("Yes");
        $('#ltd_dual_options_modal').modal('show');

        $('#ltd_dual_options_right_button').on('click', function(e) {
            e.preventDefault(); 
            $('#ltd_dual_options_modal').modal('hide');
            setTimeout(function() {
                $.post('/edit/removeMeal', post_vars, function(data) {
                    if (data.success) {
                        // update table
                        editMeals();
                        $('#ltd_confirm_modal_subheader').html('This meal has been deleted.');
                        setTimeout(function() {
                            $('#ltd_confirm_modal').modal('show');
                        }, 400);
                    } else {
                        $('#ltd_error_modal_text').html('There was a problem, and the meal might not have been deleted.');
                        setTimeout(function() {
                            $('#ltd_error_modal').modal('show');
                        }, 400);
                    }
                }, 'json');
            }, 500);
        });
    }, 500);
}

function deleteWalk(w) {
    let walk_post_vars = {
        csrf_test_name: $('[name=csrf_test_name]').val(),
        walkID: $('#walk_id_' + w).val()
    };

    $('#edit_walk_modal').modal('hide');
    let walk_html = "Are you sure you wish to delete the walk logged on " + $('#date_id_' + w).text();
    walk_html += " at " + $('#time_id_' + w).text() + "?";

    setTimeout(function() {
        $('#ltd_dual_options_modal_subheader').html(walk_html)
        $('#ltd_dual_options_left_button').html("No");
        $('#ltd_dual_options_right_button').html("Yes");
        $('#ltd_dual_options_modal').modal('show');

        $('#ltd_dual_options_right_button').on('click', function(e) {
            e.preventDefault();
            $('#ltd_dual_options_modal').modal('hide');
            setTimeout(function() {
                $.post('/edit/removeWalk', walk_post_vars, function(data) {
                    if (data.success) {
                        // update table
                        editWalks();
                        $('#ltd_confirm_modal_subheader').html('This walk has been deleted.');
                        setTimeout(function() {
                            $('#ltd_confirm_modal').modal('show');
                        }, 400);
                    } else {
                        $('#ltd_error_modal_text').html('There was a problem, and this walk might not have been deleted.');
                        setTimeout(function() {
                            $('#ltd_error_modal').modal('show');
                        }, 400);
                    }
                }, 'json');
            }, 500);
        });
    }, 500);
}

function deleteMed(x) {
    let post_vars = {
        csrf_test_name : $('[name=csrf_test_name]').val(),
        medID: $('#med_id_' + x).val()
    };
    $('#edit_med_modal').modal('hide');
    let html = "Are you sure you wish to delete the med logged on " + $('#date_id_' + x).text();
    html += ' at ' + $('#time_id_' + x).text() + '?';

    setTimeout(function() {
        $('#ltd_dual_options_modal_subheader').html(html)
        $('#ltd_dual_options_left_button').html("No");
        $('#ltd_dual_options_right_button').html("Yes");
        $('#ltd_dual_options_modal').modal('show');

        $('#ltd_dual_options_right_button').on('click', function(e) {
            e.preventDefault();
            $('#ltd_dual_options_modal').modal('hide');
            setTimeout(function() {
                $.post('/edit/removeMed', post_vars, function(data) {
                    if (data.success) {
                        // update table
                        editMeds();
                        $('#ltd_confirm_modal_subheader').html('This med has been deleted.');
                        setTimeout(function() {
                            $('#ltd_confirm_modal').modal('show');
                        }, 400);
                    } else {
                        $('#ltd_error_modal_text').html('There was a problem, and the med might not have been deleted.');
                        setTimeout(function() {
                            $('#ltd_error_modal').modal('show');
                        }, 400);
                    }
                }, 'json');
            }, 500);
        });
    }, 500);
}

function deleteTreat(t) {
    let treat_post_vars = {
        csrf_test_name : $('[name=csrf_test_name]').val(),
        treatID: $('#treat_id_' + t).val()
    };
    $('#treat_med_modal').modal('hide');
    let treat_html = "Are you sure you wish to delete the treat logged on " + $('#date_id_' + x).text();
    treat_html += ' at ' + $('#time_id_' + t).text() + '?';

    setTimeout(function() {
        $('#ltd_dual_options_modal_subheader').html(treat_html)
        $('#ltd_dual_options_left_button').html("No");
        $('#ltd_dual_options_right_button').html("Yes");
        $('#ltd_dual_options_modal').modal('show');

        $('#ltd_dual_options_right_button').on('click', function(e) {
            e.preventDefault();
            $('#ltd_dual_options_modal').modal('hide');
            setTimeout(function() {
                $.post('/edit/removeTreat', treat_post_vars, function(data) {
                    if (data.success) {
                        // update table
                        editTreats();
                        $('#ltd_confirm_modal_subheader').html('This treat has been deleted.');
                        setTimeout(function() {
                            $('#ltd_confirm_modal').modal('show');
                        }, 400);
                    } else {
                        $('#ltd_error_modal_text').html('There was a problem, and this treat might not have been deleted.');
                        setTimeout(function() {
                            $('#ltd_error_modal').modal('show');
                        }, 400);
                    }
                }, 'json');
            }, 500);
        });
    }, 500);
}