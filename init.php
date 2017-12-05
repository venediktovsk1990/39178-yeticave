<?php

	session_start();
	if(isset($_SESSION['user']) ){
		$user_name = $_SESSION['user']['name'];
		$is_auth = true;
	}



?>