<?php
function check_email_fail($email, $max_len=50) {
	// to complete
	// use a regex object to test $email
	// $email should between 6 and 50 chars
    $format = '/^[a-z0-9][a-z0-9._-]{0,30}@[a-z0-9][a-z0-9]{0,30}\.[a-z0-9.]+[a-z]$/i';
    $len = strlen($email);
    if(
        0 == $len ||
        $max_len < $len ||
        !preg_match($format, $email)
    ) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function check_nickname_fail($name) {
	// to complete using preg_match
	// $name should between 6 and 30 chars
    $len = strlen($name);
    if(6 > $len || 30 < $len) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function check_password_fail($pass) {
	// to complete
	// $pass should between 6 and 16 chars
    $len = strlen($pass);
    if( 6 > $len || 16 < $len) {
		return TRUE;
	} else {
		return FALSE;
	}
}

function check_token_fail($token, $email, $salt)
{
    if(32 != strlen($token) || 7 > strlen($email) || 60 < strlen($email) || empty($salt)) {
        if(DEBUG) {
            echo '长度不对';
            echo 'token = '.$token.'<br />';
            echo 'email = '.$mail.'<br />';
            exit();
        }
        return TRUE;    // fail
    } else {
        $date = date('Ymd');
        $date2 = strval($date - 1);
        $token_string = $email.$salt.$date;
        $token_string2 = $email.$salt.$date2;
        $this_token = md5($token_string);
        $this_token2 = md5($token_string2);
        if($this_token == $token || $this_token2 == $token) {
            return FALSE;
        }
        if(DEBUG) {
        /*
            echo 'token -- '.$token.'<br />';
            echo 'tokenstring -- '.$token_string.'<br />';
            echo 'tokenstring2 -- '.$token_string2.'<br />';
            echo 'this_token -- '.$this_token.'<br />';
            echo 'this_token2 -- '.$this_token2.'<br />';
            exit();
            */
        }
        return TRUE;
    }
}

function generate_token($email, $salt)
{
    $date = date('Ymd');
    $token_string = $email.$salt.$date;
    return md5($token_string);
}
?>
