<?php

function email_valid($email) {
    $email_regex = '/^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i';
    return preg_match($email_regex, $email);
}

function valid_password($password, $email, $username = '') {
    $sp = '<br />&nbsp;<br />';
    $error = '';
    $valid = true;
    $retArray = array();

    if (strlen($password) < 8) {
        $valid = false;
        $error .= 'Your password is too short; make it at least 8 characters.'. $sp;
    }

    // Make sure password matches security criteria
    if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) ||
            !preg_match('/[0-9]/', $password)) {
        $valid = false;
        $error .= 'Your password must contain at least one capital letter, at least one ';
        $error .= 'number, and at least one lower-case letter.' . $sp;
    }

    $password = strtolower($password);

    if (strtoupper($password) == strtoupper($email)) {
        $valid = false;
        $error .= 'Please do not use your e-mail address as your password.' . $sp;
    }

    if ($password == $username) {
        $valid = false;
        $error .= 'Please do not use your user name as your password.' . $sp;
    }

    if ($password == 'logthedog' || $password == 'logthedog.com') {
        $valid = false;
        $error .= 'That password is much too easy to guess.' . $sp;
    }

    if (stristr(strtolower($password), 'password')) {
        $valid = false;
        $error .= 'Please do not use the word "password" in your password. ';
        $error .= 'That makes it too easy to guess.' . $sp;
    }

    $retArray['valid'] = $valid;
    $retArray['error'] = $error;
    return $retArray;
}

// Do the passwords match?
function blow_me($password, $hashword) {
    // $password = unhashed password
    // $hashword = pre-hashed password
    // $fudgicle = salt
    // Salts and hashes the unhashed password, returns it. Calling function
    // compares this result to already-hashed password.
    $fudgicle = substr($hashword,0,29);
    return crypt($password, $fudgicle);
}