function editMeals() {
    var post_vars = {
        dog_id : $('#dog_names').val(),
        reverse: true,
        csrf_test_name : $('[name=csrf_test_name]').val()
    };
    
    $.post('/edit/getMeals', post_vars, function(data) {
        var html = '<div class="col-xs-3"></div>';
        var mealCount = data.length;
        var y=0;
        var prev = -1;
        // generate HTML for *everything*
        for (var x = 0; x < mealCount; x++) {
            var tblCls = "editTable col-xs-6    ";
            if (x%10 === 0) {
                var ct=x;
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
                    var numEmpty = 10 - (mealCount%10);
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
        var confirm_date = $('#edit_meal_date').val();
        var meal_date = confirm_date.split('/');
        var formatted_meal_date = meal_date[2] + '-' + meal_date[0] + '-' + meal_date[1] + ' ';
        var confirm_hour = $('#edit_meal_hour').val();
        var meal_hour = parseInt(confirm_hour);
        if ($('#edit_meal_ampm').val() === 'pm' && meal_hour !== 12) {
            meal_hour += 12;
        } else if ($('#edit_meal_ampm').val() === 'am' && meal_hour === 12) {
            meal_hour = '00';
        } else if (meal_hour < 10) {
            meal_hour = '0' + meal_hour;
        }

        formatted_meal_date += meal_hour + ':' + $('#edit_meal_minute').val() + ':' + $('#edit_meal_seconds').val();
        var post_vars = {
            csrf_test_name : $('[name=csrf_test_name]').val(),
            meal_id : $('#edit_meal_mealID').val(),
            meal_date: formatted_meal_date,
            meal_notes: $('#edit_meal_notes').val()
        };
        $.post('/edit/editMeal', post_vars, function(data) {
            $('#edit_meal_modal').modal('hide');
            if (data.success) {
                // Update time in the list
                $('#date_id_' + mealID).text(confirm_date);
                $('#time_id_' + mealID).text(confirm_hour + ':' + $('#edit_meal_minute').val() + ' ' + $('#edit_meal_ampm').val());
                $('#notes_id_' + mealID).text(post_vars.meal_notes);
                $('#ltd_confirm_modal_subheader').html('This meal has been updated.');
                setTimeout(function() {
                    $('#ltd_confirm_modal').modal('show');
                }, 400);
            } else {
                $('#ltd_error_modal_text').html('There was a problem, and the meal might not have been updated.');
                setTimeout(function() {
                    $('#ltd_error_modal').modal('show');
                }, 400);
            }
        }, 'json');
    });
}

function deleteMeal(x) {
    var post_vars = {
        csrf_test_name : $('[name=csrf_test_name]').val(),
        mealID: $('#meal_id_' + x).val()
    };
    $('#edit_meal_modal').modal('hide');
    var html = "Are you sure you wish to delete the meal logged on " + $('#date_id_' + x).text();
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