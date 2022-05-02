<?php

class Profile
{
    public function get_profile($id)
    {
        $id = addslashes($id);
        $DB = new Database();
        $query = "select * from users where userid = '$id' limit 1";
        $data = $DB->read($query);
        return $data;
    }
}
