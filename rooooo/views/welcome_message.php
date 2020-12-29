    <?php
        $submit_array = array(
            'name' => 'ltd_home_form_button',
            'id' => 'ltd_home_form_button',
            'content' => 'Log in',
            'class' => 'ltdButton'
        );
        $email = '';
        $password = '';
        $remember = '';
        
        echo link_tag(base_url().'css/home.css');
        echo '<script src="'.base_url().'js/home.js"></script>';
        $this->load->view('ruthie_graphic');
        $cookie = json_decode($this->input->cookie('ltd-login',TRUE),1);
        if ($cookie && $this->session->userdata('loggedOut') != true)    {
            $email = $cookie['1I1T1TLI11II'];
            $password = $cookie['I11T1TLI11IT'];
            $remember = 'checked';
        }
    ?>

    <div class='row-fluid drop12'>
        <div class='formField span12 fine-print text-center'>
            <a href='/home/create_account'>Don't have an account?<br />
            You can create one!</a>
        </div>
    </div>

    <div class='container' id='ltd_home_form'>
        <?php echo form_open('login/log_in'); ?>
        <div id='login_email' class='row-fluid'>
            <div class='formField span12'>
                <h4>
                    <input id='ltd_email' type='email' placeholder='Your e-mail' value="<?= $email ?>" />
                </h4>
            </div>
        </div>
        <div class='row-fluid' id='login_password'>
            <div class='formField span12'>
                <h4>
                    <input id='ltd_password' type='password' placeholder='Your password' value="<?= $password ?>" />
                </h4>
            </div>
        </div>
        <div class='row-fluid margin-bottom-10' id='login_remember'>
            <div class='checkbox formField span12'>
                <input id='ltd_remember' type='checkbox' <?= $remember ?> /> <span class="margin-left-20">Remember Me</span>
            </div>
            </div>
        </div>
        <div class='row-fluid'>
            <div class='formField span12'>
                <?php
                    echo form_button($submit_array);
                ?>
            </div>
        </div>
        <?php echo form_close(); ?>
    <div class='row-fluid'>
        <div class='formField span12 fine-print text-center'>
            <a class='pointer' onclick="forgotPassword();">Forgot your password?<br />
            You can reset it!</a>
        </div>
    </div>

    </div>

</body>
</html>