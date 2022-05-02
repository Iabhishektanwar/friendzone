<?php

class Login
{
    private $error = "";
    public function evaluate($data)
    {

        $email = addslashes($data['email']);
        $password = addslashes($data['password']);

        $query = "select * from users where email = '$email' limit 1";

        $DB = new Database();
        $result = $DB->read($query);
        if ($result) {
            $row = $result[0];
            if ($this->hash_text($password) == $row['password']) {
                $_SESSION['friendzone_userid'] = $row['userid'];
            } else {
                $this->error .= "You have entered an invalid username or password.<br>";
                $_SESSION['error_mess'] = "You have entered an invalid username or password.";
            }
        } else {
            $this->error .= "The FriendZone account doesn't exist. Enter a different account or get a new one.<br>";
            $_SESSION['error_mess'] = "The FriendZone account doesn't exist. Enter a different account or get a new one.";
        }
        return $this->error;
    }

    public function check_login($id, $redirect = true)
    {
        if (is_numeric($id)) {
            $query = "select * from users where userid = '$id' limit 1";

            $DB = new Database();
            $result = $DB->read($query);
            if ($result) {
                $user_data = $result[0];
                return $user_data;
            } else {
                if ($redirect) {
                    header("Location: signin.php");
                    die;
                } else {
                    $_SESSION['friendzone_userid'] = 0;
                }
            }
        } else {
            if ($redirect) {
                header("Location: signin.php");
                die;
            } else {
                $_SESSION['friendzone_userid'] = 0;
            }
        }
    }

    private function hash_text($text)
    {
        $text = hash("sha1", $text);
        return $text;
    }
}
