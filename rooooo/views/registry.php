<?
    $form_attribs = array(
        'class' => 'form-inline',
        'id' => 'registry_form'
    );

    echo form_open('', $form_attribs);
    
    ?>
    <input type="hidden" id="dog_id" />
    <div id="dog_registry" class="container">
        <div class="row">
            <h1>Register a Dog</h1>
        </div>
        <div class="row">
            <div class="col-xs-12 bottom5 top5">
                Dog's name:<br />
                <input type="text" class="col-xs-10" id="dog_name" name="dog_name" placeholder="Name" />
            </div>
        </div>
        <div id="reg_ex_container">
            <div class="row">
                <a onclick="reveal('physical_description');"><h4><span class="add-dog">Add p</span><span class="edit-dog">P</span>hysical description...</h4></a>
            </div>
            <div id="physical_description">
                <div class="row">
                    <div class="col-xs-4 bottom5 top5">
                        How much does <span class='this_dog'>this dog</span> weigh?<br />
                        <input type="text" class="col-xs-4" id="weight" name="weight" placeholder="Weight" />&nbsp; pounds
                    </div>
                    <div class="col-xs-4 bottom5 top5">
                        How long is <span class='this_dog'>this dog</span>?<br />
                        <input type="text" class="col-xs-4" id="length" name="length" placeholder="Length" />&nbsp; inches
                    </div>
                    <div class="col-xs-4 bottom5 top5">
                        How tall is <span class='this_dog'>this dog</span>?<br />
                        <input type="text" class="col-xs-4" id="height" name="height" placeholder="Height" />&nbsp; inches
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom5 top5">
                        What gender is this dog?<br />
                        <select id="dog_gender" onchange="changeGender();">
                            <option value="x">(please choose)</option>
                            <option value='m'>male</option>
                            <option value='f'>female</option>
                        </select> &nbsp; &nbsp;
                        <input type="checkbox" id="neutered" /> <span id="neut">spayed / neutered</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom5 top5">
                        What breed is <span class="this_dog">this dog</span>?<br />
                        <input type="text" class="col-xs-10" id="breed" name="breed" placeholder="Breed" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom5 top5">
                        What color is <span class="this_dog">this dog</span>?<br />
                        <input type="text" class="col-xs-10" id="color" name="color" placeholder="Color" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom5 top5">
                        Does <span class="this_dog">this dog</span> have any distinguishing marks or features?<br />
                        <input type="text" class="col-xs-10" id="features" name="features" placeholder="Features" />
                    </div>
                </div>
            </div>
            <div class="row">
                <a onclick="reveal('dog_misc');"><h4><span class="add-dog">Add m</span><span class="edit-dog">M</span>iscellaneous info (birthdate, chipping, etc.)...</h4></a>
            </div>
            <div id="dog_misc">
                <div class="row">
                    <div class="col-xs-12 bottom5 top5">
                        (approximately) What is <span class="this_dog">this dog's</span> date of birth?<br />
                        <span class="hidden-xs hidden-sm fine-print">
                            (If you don't know month or date, that's okay, but at least the year -- even if approximate -- would be nice.)
                        </span><br />
                        <select id='birth_month' onchange='changeMonth();'>
                            <option value='0'>(month)</option>
                            <option value='1'>January</option>
                            <option value='2'>February</option>
                            <option value='3'>March</option>
                            <option value='4'>April</option>
                            <option value='5'>May</option>
                            <option value='6'>June</option>
                            <option value='7'>July</option>
                            <option value='8'>August</option>
                            <option value='9'>September</option>
                            <option value='10'>October</option>
                            <option value='11'>November</option>
                            <option value='12'>December</option>
                        </select>
                        <select id='birth_date'>
                            <option value='0'>(date)</option>
                            <?
                                for ($x = 1; $x < 30; $x++) {
                                    echo '<option value="' . $x . '">' . $x . '</option>';
                                }
                            ?>
                            <option value='30' class='notFebruary' style='display: none;'>30</option>
                            <option value='31' class='only31' style='display: none;'>31</option>
                        </select>, 
                        <input type='number' id='birth_year' placeholder='Year' name='birth_year' min='1982' max='<?= Date("Y"); ?>' />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom5 top5">
                        Does this dog answer to any other name? If so, put it here:<br />
                        <input type="text" class="col-xs-10" id="alt_name" name="alt_name" placeholder="Also answers to..." />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom5 top5">
                        Does <span class="this_dog">this dog</span> suffer any known illnesses or afflictions?<br />
                        <input type="text" class="col-xs-10" id="afflictions" name="afflictions" placeholder="Afflictions" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom5 top5">
                        Does <span class="this_dog">this dog</span> have any known fears?<br />
                        <input type="text" class="col-xs-10" id="fears" name="fears" placeholder="Fears" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom5 top5">
                        What commands, if any, does <span class="this_dog">this dog</span> know?<br />
                        <input type="text" class="col-xs-10" id="commands" name="commands" placeholder="Commands" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 bottom5 top5">
                        Check the box if <span class="this_dog">this dog</span> microchipped.
                        <input type="checkbox" id="is_chipped" name="is_chipped" onclick="chipClick();"/>
                    </div>
                </div>
                <div class="row" id="chip_block">
                    <div class="col-xs-4 bottom5 top5">
                        Brand of microchip:<br />
                        <input type="text" class="col-xs-4" id="chip_brand" name="chip_brand" placeholder="Brand" />
                    </div>
                    <div class="col-xs-4 bottom5 top5">
                        Microchip ID number:<br />
                        <input type="text" class="col-xs-4" id="chip_id" name="chip_id" placeholder="Microchip ID" />
                    </div>
                </div>
            </div>
            <div class="newDog row">
                <a onclick="reveal('caretakers');"><h4>Designated caretakers...</h4></a>
            </div>
            <div class="newDog" id="caretakers">
                <div class="row edit-dog" id="designated_edit">
                    <div class="container col-xs-10">
                        
                    </div>
                </div>
                <div class="row add-dog" id="designation_row">
                    <div class="col-xs-10 bottom5 top5">
                        You are automatically designated as this dog's caretaker. If you would like to 
                        designate others (family members, dog walkers, etc.) to take care of your dog,
                        please click the link below -- and be sure to have their e-mail addresses handy!
                        (You may designate caretakers later if you wish.)<br />
                    </div>
                </div>
                <div class="row">
                    <span class="pad-left-20"><a onclick="addCaretaker();" class="dark-red pointer">
                        Click here to add a caretaker</a>
                    </span>
                </div>
            </div>
            <div class="newDog row">
                <a onclick="reveal('medicine');"><h4>Medicine...</h4></a>
            </div>
            <div class="newDog" id="medicine">
                <div class="row edit-med pad-bot-10" id="medicine_edit">
                    <div class="container col-xs-10">
                        
                    </div>
                </div>
                <div class="row pad-bot-10">
                    <span class="pad-left-20"><a onclick="addMedicine();" class="dark-red pointer">
                        Click here to add a medicine</a>
                    </span>
                </div>
            </div>
            <div id="desspace" class="col-xs-10 bottom5 top5 underscore"></div>
            <div class="row">
                <div class="col-xs-10 top5">
                    <button type="button" id="register_the_dog" onclick="registerDog();">
                        Register Dog
                    </button>
                    <button type="button" id="change_the_dog" onclick="changeDog();">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="ct_edit_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header yella">
                    <h4 id='ct_edit_modal_header_text' class="modal-title">Edit / Remove Caretaker</h4>
                </div>
                <div class="modal-body" id="ct_details">
                    <input type="hidden" id="ct_edit_id" />
                    <div class="row pad-bot-10">
                        <span class="pull-right pad-right-20 font-size-12">
                            <a class="pointer dark-red" onclick="deleteCt();">Remove caretaker</a>
                        </span>
                    </div>
                    <div class="row pad-bot-10">
                        <input type="hidden" id="row_to_delete" />
                        <span class="col-xs-4 bold font-size-16">Caretaker's name:</span>
                        <span class="col-xs-6"><input class="col-xs-10" type="text" id="ct_name" /></span>
                    </div>
                    <div class="row">
                        <span class="col-xs-4 font-size-16 bold">Caretaker's e-mail:</span>
                        <span class="col-xs-6"><input class="col-xs-10" type="text" id="ct_email" /></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="ct_left_button" class="btn pull-left" data-dismiss="modal">Cancel</button>
                    <button id="ct_right_button" class="btn btn-default">Update</button>
                </div>
            </div>
        </div>
    </div>
    <div id="ct_add_modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header yella">
                    <h4 id='ct_add_modal_header_text' class="modal-title">Add a Caretaker</h4>
                </div>
                <div class="modal-body" id="ct_add_details">
                    <input type="hidden" id="ct_add_dogID" />
                    <div class="row pad-bot-10">
                        <span class="col-xs-4 bold font-size-16">Caretaker's name:</span>
                        <span class="col-xs-6"><input class="col-xs-10" type="text" id="ct_add_name" /></span>
                    </div>
                    <div class="row">
                        <span class="col-xs-4 font-size-16 bold">Caretaker's e-mail<span class="super">*</span>:</span>
                        <span class="col-xs-6"><input class="col-xs-10" type="text" id="ct_add_email" /></span>
                    </div>
                    <div class="row">
                        <span class="dark-red italic font-size-12 pad-left-20"><span class="super">*</span>required</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="ct_add_left_button" class="btn pull-left" data-dismiss="modal">Cancel</button>
                    <button id="ct_add_right_button" class="btn btn-default">Submit</button>
                </div>
            </div>
        </div>
    </div>
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

    <div id="med_edit_modal" class="modal fade">
        <input type="hidden" id="med_row_to_delete" />
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="hidden" id="med_edit_id" />
                <div class="modal-header yella">
                    <h4 id='med_edit_modal_header_text' class="modal-title">Edit / Remove Medicine</h4>
                </div>
                <div class="modal-body" id="med_edit_details">
                    <input type="hidden" id="med_edit_dogID" />
                    <div class="row pad-bot-10">
                        <span class="pull-right pad-right-20 font-size-12">
                            <a class="pointer dark-red" onclick="deleteMed();">Remove medicine</a>
                        </span>
                    </div>
                    <div class="row pad-bot-10">
                        <span class="col-xs-5 bold font-size-16">Name / type of medicine<span class="super">*</span>:</span>
                        <span class="col-xs-6"><input class="col-xs-10" type="text" id="med_edit_name" /></span>
                    </div>
                    <div class="row pad-bot-10">
                        <span class="col-xs-5 font-size-16 bold">Dosage<span class="super">*</span>:</span>
                        <span class="col-xs-6"><input class="col-xs-10" type="text" id="med_edit_dosage" /></span>
                    </div>
                    <div class="row pad-bot-10">
                        <span class="col-xs-9 font-size-16 bold">Check if this medicine is taken with a meal:</span>
                        <span class="col-xs-1"><input class="pull-right" type="checkbox" id="med_edit_with_meal" /></span>
                    </div>
                    <div class="row">
                        <span class="col-xs-5 font-size-16 bold">Notes:</span>
                        <span class="col-xs-6"><textarea class="col-xs-10" type="text" id="med_edit_notes"></textarea></span>
                    </div>
                    <div class="row">
                        <span class="dark-red italic font-size-12 pad-left-20"><span class="super">*</span>required</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="med_edit_left_button" class="btn pull-left" data-dismiss="modal">Cancel</button>
                    <button id="med_edit_right_button" class="btn btn-default">Submit</button>
                </div>
            </div>
        </div>
    </div>
<?
    for ($x = 0; $x < 5; $x++) {
        echo '&nbsp;<br />';
    }
    echo form_close();
?>

<script>
    $(document).on('mouseenter', '.crunch', function() {
        var $this = $(this);
        if (this.offsetWidth < this.scrollWidth) {
            $this.data('toggle', 'tooltip');
            $this.data('placement', 'top');
            $this.data('title', $this.text());
            $this.css('cursor', 'pointer');
            $this.tooltip();
            $this.tooltip('show');
        }
    });
</script>        