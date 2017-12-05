<?php
require_once('./data.php');
require_once('./functions.php');
require_once('./init.php');
$page_content='';
$layout_content='';
	$page_content=includeTemplate('./templates/403_temp.php', ['text'=>''] );
	$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'404 Page not found']  );
	print($layout_content);


?>