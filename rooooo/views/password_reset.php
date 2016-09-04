<?php
    if (!$success) {
        ?>
        <script>
            setTimeout(function () {
                $('#ltd_error_modal_header_text').html('Cannot reset password');
                $('#ltd_error_modal_text').html('<h4><?=$message ?></h4>');
                $('#ltd_error_modal_ok').on('click', function() {
                    $('#ltd_error_modal').modal('hide');
                    location.href = '/';
                });
                $('#ltd_error_modal').modal('show');
            }, 500);
        </script>
    <?
    }
    
    if ($success) {
        echo $message;
        echo '<input id="email" type="hidden" value="' . $email . '"/>';
        echo '<input id="username" type="hidden" value="' . $username . '"/>';
?>
<div class="row-fluid">
    <div class="formField span12">
        <h4>
            <input id="reset_pw" type="password" value="" placeholder="Enter a new password" />
        </h4>
    </div>
</div>
<div class="row-fluid">
    <div class="formField span12">
        <h4>
            <input id="reset_conf" type="password" value="" placeholder="Enter it again" />
        </h4>
    </div>
</div>
<div class="row-fluid">
    <div class="formField span12">
        <h4 class="text-center drop12">
            <input id="reset_submit" onclick="updatePassword(<?= $id ?>)" type="button" value="Submit" />
        </h4>
    </div>
</div>
<?
    }