<?php


require_once('./data.php');
require_once('./functions.php');
require_once('./init.php');
$page_content='';
$layout_content='';
$numeric=['cost'];
$has_errors = false;
$template_data['disabled'] =(bool)false;
$cookie_domain="yeticave";
	
	if($_SERVER['REQUEST_METHOD'] == "GET" ){
		
		//пользователь перешел сам на данную страницу
		if( isset( $_GET['lotIndex'] ) && isset( $lots[ $_GET['lotIndex'] ] )  ){
			$lot_index=$_GET['lotIndex'];
			//получаем id лотов из куки
			if( isset($_COOKIE[$cookie_name] ) ){
				$cookie_value_array = json_decode( $_COOKIE[$cookie_name], true);
				foreach( $cookie_value_array as $key=>$lot){
					if( $lot_index == $lot['index'] ){
						$template_data['disabled'] =true;
					}
				}
			
			}
			
			//проверка истечения срока аукциона
			$now=strtotime('now');
			

			
			if( isset( $_SESSION['user']  ) ){
				$template_data['is_auth'] = true;
			}else{
				$template_data['is_auth'] = false;
			}
			
			$template_data['lot_index']=$lot_index;
			$page_content=includeTemplate('./templates/lot.php', ['categories'=>$categories, 'lot'=>$lots[$lot_index], 'template_data'=>$template_data, 'bets'=>$bets,] );
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>$lots[$lot_index]['name']]  );
			print($layout_content);
		 }else{
			http_response_code(404);
			
			$page_content=includeTemplate('./templates/404_temp.php', ['text'=>''] );
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'404 Page not found']  );
			print($layout_content);
		}
	}
	if($_SERVER['REQUEST_METHOD'] == "POST" ){
		//выполняем обработку формы после того, как пользователь сам сделал ставку
		foreach( $_POST as $key=>$value){
			$value = htmlspecialchars($value);
			if( in_array( $key, $numeric ) ){
				if( !is_numeric($value) ){
					$has_errors = true;
				}
			}
		}
		$lot_index = (int)$_POST['lot_index'];
		$template_data[]=[ 'lot_index'=>(int)$lot_index];
		if( $has_errors ){
			$page_content=includeTemplate('./templates/lot.php', ['categories'=>$categories, 'lot'=>$lots[$lot_index], 'template_data'=>$template_data, 'bets'=>$bets,] );
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>$lots[$lot_index]['name']]  );
			print($layout_content);
		}else{
			$path = "/";
			$current_date = time();
			$cookie_date = strtotime("+30 days");
			$cost = (int)$_POST['cost'];
			$cookie_value_string = '';
			$cookie_value_array =[];
			if( isset($_COOKIE[$cookie_name]) ){
				$cookie_value_array = json_decode( $_COOKIE[$cookie_name], true);
				$cookie_value_array[] = [ 'index'=>$lot_index, 'time'=>$current_date, 'cost'=>$cost] ;
			}else{
				$cookie_value_array[] = [ 'index'=>$lot_index, 'time'=>$current_date, 'cost'=>$cost ];
			}
			$cookie_value_string = json_encode($cookie_value_array);
			setcookie($cookie_name, $cookie_value_string, $cookie_date, $path, $cookie_domain);
			header("Location: http://yeticave/mylots.php");
			exit();
		}
	}
?>


	
