<?php

 
 require_once('./data.php');
 require_once('./functions.php');
 require_once('./init.php');
 
	 if (!$link) {
		$error = mysqli_connect_error();
		$page_content = include_template('templates/error_temp.php', ['error_text' => $error]);
		$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>[], 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
		print($layout_content);
		exit();
	}
	//получаем категории
	$sql = 'SELECT `title` FROM categories';
	$result = mysqli_query($link, $sql);
	if( !$result ){
		$error = mysqli_error($link);
		$page_content = include_template('templates/error_temp.php', ['error_text' => $error]);
		$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>[], 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
		print($layout_content);
		exit();
	}
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	//получаем все лоты
	$sql = 'SELECT * FROM lots';
	$result = mysqli_query($link, $sql);
	if( !$result ){
		$error = mysqli_error($link);
		$page_content = include_template('templates/error_temp.php', ['error_text' => $error]);
		$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>[], 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
		print($layout_content);
		exit();
	}
	$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
	$page_content=includeTemplate('./templates/index.php', ['categories'=>$categories, 'lots'=>$lots, 'lot_time_remaining'=>$lot_time_remaining] );
	$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>$categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
	print($layout_content);
	

	 
	 
 
?>
