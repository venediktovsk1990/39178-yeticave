<?php


require_once('./data.php');
require_once('./functions.php');
$page_content='';
$layout_content='';
		
		if( isset($_COOKIE[$cookie_name]) ){
			$cookie_value_array = json_decode( $_COOKIE[$cookie_name], true);
		}	
			
		$page_content=includeTemplate('./templates/mylots_temp.php', [ 'lots'=>$lots, 'my_lots'=>$cookie_value_array ] );
		$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Мои лоты']  );
		print($layout_content);
	
	//array(5) {
	
	//{ 
		//["index"]=> int(2) ["time"]=> int(1511893829) ["cost"]=> int(6) } 
	//{ ["index"]=> int(2) ["time"]=> int(1511894174) ["cost"]=> int(20) } [2]=> object(stdClass)#3 (3) { ["index"]=> int(1) ["time"]=> int(1511895431) ["cost"]=> int(5) } [3]=> object(stdClass)#4 (3) { ["index"]=> int(3) ["time"]=> int(1511896138) ["cost"]=> int(6) } [4]=> object(stdClass)#5 (3) { ["index"]=> int(1) ["time"]=> int(1511896970) ["cost"]=> int(4) } }		
	
?>


	
