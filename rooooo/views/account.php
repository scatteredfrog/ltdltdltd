<?= form_open(); ?>
<div class="container">
    <div class="row h1">
        <?= $username ?>'s Details
    </div>
    <div class="row">
        <div class="col-xs-12 bottom5 top5">
            User name:<br />
            <input type="text" onchange="hideYay();" class="col-xs-10" id="username" name="username" value="<?= $username ?>" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 bottom5 top5">
            E-mail address:<br />
            <input type="text" onchange="hideYay();" class="col-xs-10" id="email" name="email" value="<?= $eMail ?>" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 bottom5 top5">
            Language preference:<br />
            <input type="radio" name="language" value="0" onchange="hideYay();" 
                <? if ($language == 0): ?> checked="checked"<? endif ?> /> professional (log when my dog 'urinates' and 'defecates')<br />
            <input type="radio" name="language" value="1" onchange="hideYay();" 
                <? if ($language == 1): ?>
                   checked="checked"
                <? endif ?>
            /> numeric (log when my dog 'does #1' and '#2')<br />
            <input type="radio" name="language" value="2" onchange="hideYay();" 
                <? if ($language == 2): ?>
                   checked="checked"
                <? endif ?>
            /> slang (log when my dog 'pees' and 'poops')<br />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 bottom5 top5">
            <input type="button" value="Save Changes" onclick="saveAccountChanges();" />
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 bottom5 top5 text-center yay-update">
            Your information has been updated!
        </div>
    </div>
</div>
<?= form_close(); ?>
