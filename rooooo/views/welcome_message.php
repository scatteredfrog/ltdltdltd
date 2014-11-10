    <?
        $submit_array = array(
            'name' => 'ltd_home_form_button',
            'id' => 'ltd_home_form_button',
            'content' => 'Log in'
        );

        $create_array = array(
            'name' => 'ltd_home_form_create',
            'id' => 'ltd_home_form_create',
            'content' => 'Create an account'
        );
        echo link_tag(base_url().'css/home.css');
        echo '<script src="'.base_url().'js/home.js"></script>';
    ?>

    <div id="dog_container" class='container desktop-only'>
        <div id='logo' class='span12'>
            <?= img('/assets/images/RuthieMusicSized75.png'); ?>
        </div>
    </div>
    <div id="dog_container_mobile" class='container mobile-only'>
        <div id='logo' class='span12'>
            <?= img('/assets/images/RuthieMusicSized75.png'); ?>
        </div>
    </div>
    
    <div class='container' id='ltd_home_form'>
        <?= form_open('login/log_in'); ?>
        <div id='login_email' class='row-fluid'>
            <div class='formField span12'>
                <h4>
                    <input id='ltd_email' type='email' placeholder='Your e-mail' />
                </h4>
            </div>
        </div>
        <div class='row-fluid' id='login_password'>
            <div class='formField span12'>
                <h4>
                    <input id='ltd_password' type='password' placeholder='Your password' />
                </h4>
            </div>
        </div>
        <div class='row-fluid'>
            <div class='formField span12'>
                <?
                    echo form_button($submit_array);
                ?>
        </div>
        <div class='row-fluid'>
            <div class='formField span12'>
                <?
                    echo form_button($create_array);
                ?>
        </div>
        <?= form_close(); ?>
    </div>
            

</body>
</html>