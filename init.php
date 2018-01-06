<?php

	session_start();
	if(isset($_SESSION['user']) ){
		$userName = $_SESSION['user']['name'];
		$userAvatar = $_SESSION['user']['avatar'];
		$userId = $_SESSION['user']['id'];
		$isAuth = true;
	}else{

		$userName ="";
		$userAvatar ="";
		$userId = -1;
		$isAuth = false;

	}

	//подключение к БД
	$link = createBDConnect();

?>
