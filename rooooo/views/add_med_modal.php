    <div id="med_add_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header yella">
                    <h4 id='med_add_modal_header_text' class="modal-title">Add a Medicine</h4>
                </div>
                <div class="modal-body" id="med_add_details">
                    <input type="hidden" id="med_add_dogID" />
                    <div class="row pad-bot-10">
                        <span class="col-xs-5 bold font-size-16">Name / type of medicine<span class="super">*</span>:</span>
                        <span class="col-xs-6"><input class="col-xs-10" type="text" id="med_add_name" /></span>
                    </div>
                    <div class="row pad-bot-10">
                        <span class="col-xs-5 font-size-16 bold">Dosage<span class="super">*</span>:</span>
                        <span class="col-xs-6"><input class="col-xs-10" type="text" id="med_add_dosage" /></span>
                    </div>
                    <div class="row pad-bot-10">
                        <span class="col-xs-9 font-size-16 bold">Check if this medicine is taken with a meal:</span>
                        <span class="col-xs-1"><input class="pull-right" type="checkbox" id="med_add_with_meal" /></span>
                    </div>
                    <div class="row">
                        <span class="col-xs-5 font-size-16 bold">Notes:</span>
                        <span class="col-xs-6"><textarea class="col-xs-10" type="text" id="med_add_notes"></textarea></span>
                    </div>
                    <div class="row">
                        <span class="dark-red italic font-size-12 pad-left-20"><span class="super">*</span>required</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="med_add_left_button" class="btn pull-left" data-dismiss="modal">Cancel</button>
                    <button id="med_add_right_button" class="btn btn-default">Submit</button>
                </div>
            </div>
        </div>
    </div>
