
<div class="container">
<?php

if (count($_SESSION['dogs']) > 1) {
?>
    <style>
        #dog_registry { display: none; }
    </style>

    <select id="dog_choice" onchange="selectDog();">
        <option value="no">(Select or a dog)</option>
<?
    foreach ($_SESSION['dogs'] as $k => $v) {
        echo '<option value="' . $k . '">' . $v['dogName'] . '</option>';
    }
?>
        <option value="new">Add a dog</option>
    </select>
    <input type="button" onclick="selectDog();" value="Select" />
<?
}
?>
</div>