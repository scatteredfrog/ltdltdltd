<?php

    function gen_mail($mail_data) {
        $CI =& get_instance();
        $mailfig = array();
        $mailfig['mailtype'] = 'html';
        $mailfig['charset'] = 'utf-8';
        $CI->load->library('email');
        $CI->email->initialize($mailfig);
        $CI->email->from('webmaster@logthedog.com', 'Log the Dog');
        $CI->email->to($mail_data['to']);
        $CI->email->subject($mail_data['subject']);
        $CI->email->message($mail_data['message']);
        $CI->email->send();
    }