<?php


require_once('./data.php');
require_once('./functions.php');
require_once('./init.php');
$page_content='';
$layout_content='';

//получаем категории
	$sql = 'SELECT `title` FROM categories';
	$result = mysqli_query($link, $sql);

	if( !$result ){
		$error = mysqli_error($link);
		$page_content = includeTemplate('templates/error_temp.php', ['error_text' => $error]);
		$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>[], 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
		print($layout_content);
		exit();
	}
	$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		
	if( $is_auth ){
			
			
			
			//получаем лоты
			$sql = 'SELECT lots.image,lots.title, bids.cost, lots.bidding_ending, categories.title categories, bids.bid_date FROM bids JOIN lots ON lots.id=bids.lot_id JOIN categories ON lots.category_id=categories.id WHERE bids.user_id = ' . $user_id;
			$result = mysqli_query($link, $sql);
			if( !$result ){
				$error = mysqli_error($link);
				$page_content = includeTemplate('templates/error_temp.php', ['error_text' => $error]);
				$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>$categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
				print($layout_content);
				exit();
			}
			$bids = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
	
		
			
		$page_content=includeTemplate('./templates/mylots_temp.php', [ 'bids'=>$bids ] );
		$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>$categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Мои лоты']  );
		print($layout_content);
	
	
	}else{		
			
		http_response_code(403);
		header("Location: http://yeticave/403.php");
		exit();
	}
?>


	
