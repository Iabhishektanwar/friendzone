<?php
    function validateAllFields($arr) {
        $s = '111111';
		if (empty($arr['fname'])){
            $s[0] = '0';
        }
        if (empty($arr['lname'])){
            $s[1] = '0';
        }
        if (empty($arr['uname'])){
            $s[2] = '0';
        }
        if (empty($arr['ema'])){
            $s[3] = '0';
        }
        if (empty($arr['pas'])){
            $s[4] = '0';
        }
        if (empty($arr['cpas'])){
            $s[5] = '0';
        }
        print_r($s);
	}

    validateAllFields($_POST);
?>