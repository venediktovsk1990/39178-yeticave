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
$lot_index=-1;

//Работа с БД
	
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
	
	//проверка как нам получить индекс лота
	if($_SERVER['REQUEST_METHOD'] == "GET" ){
		if( isset( $_GET['lotIndex']) ){
			$lot_index=intval($_GET['lotIndex']);
		}
	}else{
		$lot_index = intval( $_POST['lot_index'] );
	}
	
	
	if( $lot_index != -1){
		//получаем лоты
		$sql = 'SELECT lots.id, lots.title, lots.subscribe, lots.cost, lots.image, lots.current_cost, lots.cost_step step, 
		lots.bidding_ending, lots.creator_id, categories.title category FROM lots JOIN categories ON categories.id=lots.category_id 
		WHERE lots.id=' . $lot_index;
		$result = mysqli_query($link, $sql);

		if( !$result ){
			$error = mysqli_error($link);
			$page_content = include_template('templates/error_temp.php', ['error_text' => $error]);
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>$categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
			print($layout_content);
			exit();
		}
		$lot = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		//получаем ставки
		$sql = 'SELECT bids.bid_date, bids.cost,  users.name FROM bids JOIN users ON bids.user_id=users.id WHERE bids.lot_id=' . $lot_index;
		$result = mysqli_query($link, $sql);

		if( !$result ){
			$error = mysqli_error($link);
			$page_content = include_template('templates/error_temp.php', ['error_text' => $error]);
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>$categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
			print($layout_content);
			exit();
		}
		$bets = mysqli_fetch_all($result, MYSQLI_ASSOC);
	}	
	//проверяем делал ли авторизованный пользователь ставки по данному лоту
	if( isset($_SESSION['user']['id'] ) && ( $lot_index != -1 ) ){
		
		$sql = 'SELECT COUNT(id) count FROM bids WHERE lot_id=' . $lot_index . ' AND user_id = ' . $_SESSION['user']['id'];
		$result = mysqli_query($link, $sql);

		if( !$result ){
			$error = mysqli_error($link);
			$page_content = include_template('templates/error_temp.php', ['error_text' => $error]);
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>$categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
			print($layout_content);
			exit();
		}
		$bets_count = mysqli_fetch_all($result, MYSQLI_ASSOC);
	}
	
//Конец работы с БД
	
	if($_SERVER['REQUEST_METHOD'] == "GET" ){
		//пользователь перешел сам на данную страницу
		if( isset($_GET['lotIndex']) ){
			
			if( isset($_SESSION['user']) ){
				$template_data['is_auth'] = true;
				//проверяем остальные причины не показывать лот
				
				//получаем id лотов из куки - оставлено просто как кусок примера кода для работы с куки
				if( isset($_COOKIE[$cookie_name] ) ){
					$cookie_value_array = json_decode( $_COOKIE[$cookie_name], true);
					//проверяем что он еще не делал ставку по этому лоту
					foreach( $cookie_value_array as $key=>$cooky_lot){
						if( $lot_index == $cooky_lot['index'] ){
							$template_data['disabled'] = true;
						}
					}
				}
				
				//проверяем, что данный пользователь не создавал этот лот
				if( $template_data['disabled'] == false && isset($_SESSION['user']['id']) ){
					if( $_SESSION['user']['id'] == $lot[0]['creator_id']){
						$template_data['disabled'] = true;
					}
				}
				
				//проверка истечения срока аукциона
				if( $template_data['disabled'] == false ){
					$time = howLongTimeForEndDigit( $lot[0]['bidding_ending'] );
					if( $time <= 0 ){
						$template_data['disabled'] = true;
					}
				}
				
				//проверяем что данный пользователь не делал ставок по данному лоту основываясь на БД результаттах
				if( $template_data['disabled'] == false ){
					if( $bets_count[0]['count'] > 0){
						$template_data['disabled'] = true;
					}
				}

			}else{
				$template_data['is_auth'] = false;
			}
			
			$template_data['lot_index']=$lot_index;
			$page_content=includeTemplate('./templates/lot.php', ['categories'=>$categories, 'lot'=>$lot[0], 'template_data'=>$template_data, 'bets'=>$bets,] );
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content,  'is_auth'=>$is_auth, 'categories'=>$categories, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>$lot[0]['title']]  );
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
		
		//проверка на соответствие ставки заданым критериям
		$step = $lot[0]['step'];
		$current_cost = $lot[0]['current_cost'];
		$user_bid = $_POST['cost'];
		$min_value = $current_cost + $step;
		if( $user_bid < $min_value ){
			$has_errors = true;
		}
		
		//получаем индекс лота
		$lot_index = (int)$_POST['lot_index'];
		$template_data[]=[ 'lot_index'=>(int)$lot_index];
		
		//если есть ошибки снова выводим страницу
		if( $has_errors ){
			$template_data['is_auth'] = $is_auth;
			$template_data['lot_index']=$lot_index;
			$template_data['user_bid']=$user_bid;
			$page_content=includeTemplate('./templates/lot.php', ['categories'=>$categories, 'lot'=>$lot[0], 'template_data'=>$template_data, 'bets'=>$bets,] );
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>$categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>$lot[0]['title']]  );
			print($layout_content);
			
		}else{
			//иначе задаем куки
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
			
			//и добавляем новую ставку в базу
			$sql = 'INSERT INTO bids (bid_date, user_id, lot_id, cost, is_deleted) VALUES ( CURRENT_TIMESTAMP(), ?, ?, ?, FALSE)';
			$stmt = mysqli_prepare($link, $sql);
			mysqli_stmt_bind_param($stmt, 'iii', $_SESSION['user']['id'], $lot_index, $cost);
			$result = mysqli_stmt_execute($stmt);
			if( !$result ){
				$error = mysqli_error($link);
				$page_content = includeTemplate('templates/error_temp.php', ['error_text' => $error]);
				$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>$categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Ошибка']  );
				print($layout_content);
				exit();
			}else{
				header("Location: http://yeticave/mylots.php");
				exit();
			}
		}
	}
?>


	
