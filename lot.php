<?php


require_once('./data.php');
require_once('./functions.php');
$page_content='';
$layout_content='';

	if( isset( $_GET['lotIndex'] ) && isset( $lots[ $_GET['lotIndex'] ] )  ){
		$lotIndex=$_GET['lotIndex'];
		$page_content=includeTemplate('./templates/lot.php', ['categories'=>$categories, 'lot'=>$lots[$lotIndex], 'bets'=>$bets,] );
		$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>$lots[$lotIndex]['name']]  );
		print($layout_content);
	 }else{
			http_response_code(404);
			
			$page_content=includeTemplate('./templates/404.php', ['text'=>''] );
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'404 Page not found']  );
			print($layout_content);
		}
 
?>


	
