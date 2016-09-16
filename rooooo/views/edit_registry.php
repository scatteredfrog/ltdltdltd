
<div class="container">
<?php

if (isset($_SESSION['dogs'])) {
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
} else {
?>
    <input type="hidden" id="dog_choice" value="new" />
    <script>
        $(document).ready(function () {
            $('#register_the_dog').css('display', 'block');
            selectDog();        
        });
    </script>
<?
}
?>
</div>