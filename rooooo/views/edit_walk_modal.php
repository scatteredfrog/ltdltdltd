<?php
    $lang = $this->session->userdata('language');
    $l_action['0']['1'] = 'urinated';
    $l_action['0']['2'] = 'defecated';    
    $l_action['1']['1'] = 'did #1';
    $l_action['2']['2'] = 'did #2';
    $l_action['2']['1'] = 'peed';
    $l_action['2']['2'] = 'pooped';
?>
<div id="edit_walk_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header yella">
                <h4 id='edit_walk_modal_header_text' class="modal-title">Edit a Walk</h4>
            </div>
            <div class="modal-body" id="edit_walk_details">
                <input type="hidden" id="edit_walk_walkID" />
                <div class="row pad-bot-10">
                    <span class="pull-right pad-right-20 font-size-12">
                        <a class="pointer dark-red" onclick="deleteWalk();">Remove walk</a>
                    </span>
                </div>
                <div class="row pad-bot-10">
                    <span class="col-xs-5 bold font-size-16">Date<span class="super">*</span>:</span>
                    <span class="col-xs-6"><input class="col-xs-10" type="text" id="edit_walk_date" /></span>
                </div>
                <div class="row pad-bot-10">
                    <span class="col-xs-5 font-size-16 bold">Time<span class="super">*</span>:</span>
                    <span class="col-xs-6">
                        <select id="edit_walk_hour">
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select> :
                        <select id="edit_walk_minute">
                            <option value="00">00</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                            <option value="32">32</option>
                            <option value="33">33</option>
                            <option value="34">34</option>
                            <option value="35">35</option>
                            <option value="36">36</option>
                            <option value="37">37</option>
                            <option value="38">38</option>
                            <option value="39">39</option>
                            <option value="40">40</option>
                            <option value="41">41</option>
                            <option value="42">42</option>
                            <option value="43">43</option>
                            <option value="44">44</option>
                            <option value="45">45</option>
                            <option value="46">46</option>
                            <option value="47">47</option>
                            <option value="48">48</option>
                            <option value="49">49</option>
                            <option value="50">50</option>
                            <option value="51">51</option>
                            <option value="52">52</option>
                            <option value="53">53</option>
                            <option value="54">54</option>
                            <option value="55">55</option>
                            <option value="56">56</option>
                            <option value="57">57</option>
                            <option value="58">58</option>
                            <option value="59">59</option>
                        </select> 
                        <select id="edit_walk_ampm">
                            <option value="am">am</option>
                            <option value="pm">pm</option>
                        </select>
                        <input type="hidden" id="edit_walk_seconds" />
                    </span>
                </div>
                <div class="row pad-bot-10">
                    <span class="col-xs-5 bold font-size-16">Activity<span class="super">*</span>:</span>
                    <span class="col-xs-6">
                        <select class="col-xs-10" id="edit_walk_activity">
                            <option value="0">didn't go</option>
                            <option value="1">
                                <?php echo $l_action[$lang]['1']; ?>
                            </option>
                            <option value="2">
                                <?php echo $l_action[$lang]['2']; ?>
                            </option>
                            <option value="3">Both</option>
                        </select>
                    </span>
                </div>
                <div class="row">
                    <span class="col-xs-5 font-size-16 bold">Notes:</span>
                    <span class="col-xs-6"><textarea class="col-xs-10" id="edit_walk_notes"></textarea></span>
                </div>
                <div class="row">
                    <span class="dark-red italic font-size-12 pad-left-20"><span class="super">*</span>required</span>
                </div>
            </div>
            <div class="modal-footer">
                <button id="edit_walk_left_button" class="btn pull-left" data-dismiss="modal">Cancel</button>
                <button id="edit_walk_right_button" class="btn btn-default">Submit</button>
            </div>
        </div>
    </div>
</div>