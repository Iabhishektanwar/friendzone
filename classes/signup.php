<?php

class Signup
{
    private $error = "";

    public function evaluate($data)
    {
        foreach ($data as $key => $value) {
            if (empty($value)) {
                $this->error = $this->error . $key . " is required<br>";
            }
            if ($key == "email") {
                if (!preg_match("/^[a-zA-Z0-9._]+@[a-zA-Z0-9._]+\.[a-zA-Z]{1,}$/i", $value)) {
                    $this->error = $this->error . " Please enter a <em>valid</em> email address<br>";
                }
            }
            if ($key == "firstName") {
                if (is_numeric($value)) {
                    $this->error = $this->error . " First name must begin with a letter and connot contain numbers<br>";
                }
                if (strstr($value, " ")) {
                    $this->error = $this->error . " First name cannot contain spaces<br>";
                }
            }
            if ($key == "lastName") {
                if (is_numeric($value)) {
                    $this->error = $this->error . " Last name must begin with a letter and connot contain numbers<br>";
                }
                if (strstr($value, " ")) {
                    $this->error = $this->error . " Last name cannot contain spaces<br>";
                }
            }
            if ($key == "username") {
                if (strstr($value, " ")) {
                    $this->error = $this->error . " Username cannot contain spaces<br>";
                }
            }
        }
        if ($this->error == "") {
            $this->create_user($data);
        } else {
            return $this->error;
        }
    }

    private function hash_text($text)
    {
        $text = hash("sha1", $text);
        return $text;
    }

    public function create_user($data)
    {
        $first_name = ucfirst($data['firstName']);
        $last_name = ucfirst($data['lastName']);
        $email = $data['email'];
        $username = $data['username'];
        $password = $data['password'];
        $hashpassword = $this->hash_text($password);

        $userid = $this->create_userid();
        $url_address = strtolower($first_name) . "-" . strtolower($last_name);

        $query = "insert into users (userid, first_name, last_name, email, username, password, url_address) values ('$userid', '$first_name', '$last_name', '$email', '$username', '$hashpassword', '$url_address')";

        $DB = new Database();
        $DB->save($query);
    }

    private function create_userid()
    {
        $length = rand(4, 19);
        $number = "";
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number = $number . $new_rand;
        }
        return $number;
    }
}
