<?
    $form_attribs = array(
        'class' => 'form-inline',
        'id' => 'registry_form'
    );

    echo form_open('', $form_attribs);
    
    ?>

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
        <div class="row" id="more_deets">
            <div class="col-xs-12 bottom5 top5">
                <a onclick="additionalDetails();">Want to add more details about your dog? Click here.</a>
            </div>
        </div>
        <div id="reg_ex_container">
            <div class="row">
                <a onclick="reveal('physical_description');"><h4>Add physical description...</h4></a>
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
                <a onclick="reveal('dog_misc');"><h4>Add miscellaneous info (birthdate, chipping, etc.)...</h4></a>
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
        </div>
        <div class="row" id="designation_row">
            <div class="col-xs-10 bottom5 top5">
                You will be automatically designated as this dog's caretaker. If you would like to 
                designate others (family members, dog walkers, etc.) to take care of your dog,
                please click the "Designate" button -- and be sure to have their e-mail addresses handy!
                (You may designate caretakers later if you wish.)<br />
                <input class="top5" type="button" id="designate" value="Designate" onclick="addDesignee();" /><br />
            </div>
            <div id="desspace" class="col-xs-10 bottom5 top5 underscore"></div>
        </div>
        <div class="row">
            <div class="col-xs-10 top5">
                <button type="button" id="register_the_dog" onclick="registerDog();">
                    Register Dog
                </button>
            </div>
        </div>
    </div>

<?
    echo form_close();
