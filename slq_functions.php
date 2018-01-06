<?php

function getLots( $connection, &$pageContent, &$layoutContent ){

$sql = 'SELECT title FROM categories';
	$result = mysqli_query($connection, $sql);
	if( !$result ){
		$error = mysqli_error($connection);
		$pageContent = includeTemplate('templates/error_temp.php', ['error_text' => $error]);
		$layoutContent=includeTemplate('./templates/layout.php', ['main_content'=>$pageContent, 'categories'=>[], 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
		print($layout_content);
		exit();
	}
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $categories;


}



?>