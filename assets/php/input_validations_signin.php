<?php
function validateAllFields($arr)
{
    $s = '11';
    if (empty($arr['email'])) {
        $s[0] = '0';
    }
    if (empty($arr['password'])) {
        $s[1] = '0';
    }
    print_r($s);
}

validateAllFields($_POST);
