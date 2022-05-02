<?php

class Settings
{
    public function get_settings($id)
    {
        $DB = new Database();
        $sql = "select * from users where userid = '$id' limit 1";
        $row = $DB->read($sql);

        if (is_array($row)) {
            return $row[0];
        }
    }

    public function save_settings($data, $id)
    {
        $DB = new Database();

        $sql = "update users set ";
        foreach ($data as $key => $value) {
            $sql .= $key . "='" . $value . "',";
        }
        $sql = trim($sql, ",editdetails='Update',");
        $sql .= "' where userid = '$id' limit 1";
        $DB->save($sql);
    }
}
