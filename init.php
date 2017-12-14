<?php

$page_content='';
$layout_content='';

	session_start();
	if(isset($_SESSION['user']) ){
		$user_name = $_SESSION['user']['name'];
		$user_avatar = $_SESSION['user']['avatar'];
		$user_id = $_SESSION['user']['id'];
		$is_auth = true;
	}

	//подключение к БД
	$link = @mysqli_connect("localhost", "root", "", "yeticave");
	if( !$link ){
		$error_msg = 'Произошла ошибка соединения с БД - ' . mysqli_connect_error();
		$page_content= includeTemplate('./templates/error_temp.php', [ 'error_text'=>$error_msg ] );
		$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Ошибка подключения в БД']  );
		print($layout_content);	
	
		exit();
	}else{
	
		mysqli_set_charset( $link, "utf8");
	}

?>