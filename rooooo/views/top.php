<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
        <meta name='viewport' content='width=device-width, initial-scale=1'>
	<title>Log the Dog</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
        .dauber-navbar a, .dauber-navbar a:link, .dauber-navbar a:visited { color: #fff; }
        
        .menuAnchor { color: #000 !important;}
	</style>
</head>
<body>
    <?
        echo link_tag(base_url().'css/main.css');
        echo link_tag(base_url().'css/home.css');
        echo link_tag(base_url().'css/dauber-navbar.css');
        echo link_tag(base_url().'css/bootstrap-theme.min.css');
        echo link_tag(base_url().'css/bootstrap.min.css');
        echo link_tag(base_url().'css/glyphicons.css');
        echo link_tag(base_url().'css/bootstrap.icon-large.css');
        echo '<script src="'.base_url().'js/jquery-2.1.1.min.js"></script>';
        echo '<script src="'.base_url().'js/bootstrap.min.js"></script>';
        echo '<script src="'.base_url().'js/top.js"></script>';
    ?>

    <div class='dauber-navbar no-select'>
    <?
        $this->load->helper('form');
        echo form_open();
    ?>
    <? if ($this->session->userdata('logged_in')) : ?>
        <a href="/home/main_menu">
    <? else: ?>
        <a href="/">
    <? endif ?>
            <div class='dn-item'>
                <span class='icon-home icon-white'></span><span class='hidden-xs'> Home</span>
            </div>
        </a>
        <div class='dn-item' onclick="notYetAvailable('provide our privacy policy');">
            <span class='icon-lock icon-white'></span><span class='hidden-xs'> Privacy Policy</span>
        </div>
        <div class='dn-item' onclick="notYetAvailable('tell you about Log the Dog');">
            <span class='dn-dog'></span><span class='hidden-xs'> About Log The Dog</span>
        </div>
        <a href="/home/contact_us">
            <div class='dn-item'>
                <span class='dn-msg'></span><span class='hidden-xs'> Contact Us</span>
            </div>
        </a>
        <?
            if ($this->session->userdata('firstName') === 'Friend') {
                ?> 
                <a href="/home/create_account">
                    <div class='dn-item'>
                        <span class='icon-user icon-white'></span><span class='hidden-xs'> Create Account</span>
                    </div>
                </a>
        <?
            } else {
                switch ($this->session->userdata('language')) {
                    case '0': // physiological terms
                        define('PEED', 'urinated');
                        define('POOPED', 'defecated');
                        define('BOTH', 'urinated and defecated');
                        break;
                    case '1': // numeric slang
                        define('PEED', 'did #1');
                        define('POOPED', 'did #2');
                        define('BOTH', 'did #1 and #2');
                        break;
                    case '2': // crude slang
                        define('PEED', 'peed');
                        define('POOPED', 'pooped');
                        define('BOTH', 'peed and pooped');
                        break;
                }
        ?>
                <a href="/account/getAccount">
                    <div class="dn-item">
                        <span class="icon-cog icon-white"></span>
                        <span class="hidden-xs"> My Account</span>
                    </div>
                </a>
                <div class='dn-item' onclick='logOut();'>
                    <span class='dn-ext'></span><span class='hidden-xs'> Log Out</span>
                </div>
        <?
            }
        ?>
        <div class='dn-item' style="float: right;">
            <span class="hidden-xs hidden-sm">Welcome, </span>
            <span class="hidden-md hidden-lg">Hi, </span>
                <? echo $this->session->userdata('firstName'); ?>!
        </div>
        <?
            echo form_close();
        ?>
    </div>
    
    <div style='margin-top: 50px;' class='desktop-only'></div>
    <div style='margin-top: 40px;' class='mobile-only'></div>