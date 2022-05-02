<?php

	$connection = mysqli_connect("localhost", "root", "", "friendzone");

    if(isset($_POST['check_submit_btn'])){
		$em = $_POST['email_id'];
		$email_query = "SELECT * FROM users where email = '$em'";
		
		$email_query_run = mysqli_query($connection, $email_query);

		if(mysqli_num_rows($email_query_run) > 0){
			$message = "This email is already associated with an account.";
			print_r($message);
            exit();
		}
	}
