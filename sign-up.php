<?php
require_once('./data.php');
require_once('./functions.php');
require_once('./init.php');
require_once("./slq_functions.php");
$page_content='';
$layout_content='';

	
	$categories = getLots($link, $page_content, $layout_content);


	//валидация формы
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
	

		$required=['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
		$math=['lot-rate', 'lot-step'];
		$dict=['lot-name'=>'Название', 'category'=>'Категория', 'message'=>'Описание', 'lot-rate'=>'Начальная цена', 'lot-step'=>'Шаг ставки', 'lot-date'=>'Дата окончания торгов'];
		$error=[];
		$form_values = $_POST;
		
		foreach( $_POST as $key=>$value){
			if( in_array($key, $required)  ){
				if( !$value ){
					$error[$dict[$key]] = 'Это поле надо заполнить';
				}
				if( $key == 'category') {
					$flag = false;
					
					foreach( $categories as $category=>$val ){
						if( $value == $val['title'] ){
							$flag = true;
						}
					}
					if( !$flag ){
						$error[$dict[$key]] = 'Выбирите категорию';
					}
				}
			}
			
			//удаление из пользовательского ввода нежелательных символов
			$value = strip_tags($value);
			
			
			//проверка что ввели только числа
			if( $value && in_array($key, $math)){
				if( !is_numeric($value) ){
					$error[$dict[$key]] = 'В это поле нужно вводить только числовые значения';
				}else{
					$value = (int)$value;
				}
			}
		}
		
		//проверка загрузки файла
		//print( isset( $_FILES['jpg_img']['name'] )); //не нормальное поведение при повторной отправки формы на проверке без загрузки файла.
		if ( (isset( $_FILES['img']['name']) ) && ( $_FILES['img']['name'] != "" ) ) {
			$tmp_name = $_FILES['img']['tmp_name'];
			$path = $_FILES['img']['name'];

			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$file_type = finfo_file($finfo, $tmp_name);
			if ( ($file_type !== "image/jpeg") && ($file_type !== "image/png") && ($file_type !== "image/gif") ) {
				$error['Файл'] = 'Загрузите картинку';
			}
			else {
				move_uploaded_file($tmp_name, "./img/" . $path);
				$form_values['path'] =( "/img/" . $path);
				
			}
		}else{
			$error['Файл']="Вы не загрузили файл";
		}
		

		//в зависимости от валидации выводим разные страницы
		if( count($error) ){
			$page_content=includeTemplate('./templates/add_lot_temp.php', ['categories'=>$categories, 'form_values'=>$form_values, 'errors'=>$error,] );
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Добавление нового лота'] );
			print($layout_content);
		}else{
			//добавляем новый лот
			
			//получаем id категории
			//получаем категории
			$sql = 'SELECT id FROM categories WHERE title="' . $form_values['category'] . '"';
			$result = mysqli_query($link, $sql);

			if( !$result ){
				$error = mysqli_error($link);
				$page_content = includeTemplate('templates/error_temp.php', ['error_text' => $error]);
				$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
				print($layout_content);
				exit();
			}
			$category_id = mysqli_fetch_all($result, MYSQLI_ASSOC);
			
			$sql = 'INSERT INTO lots (lots.date_creation, lots.title, lots.category_id, lots.bidding_ending, lots.creator_id, lots.cost, lots.image, lots.cost_step, lots.subscribe, lots.current_cost) VALUES(CURRENT_TIMESTAMP(), ?, ?,  ?, ?, ?, ?, ?, ?, ? )';
			$stmt = mysqli_prepare($link, $sql);
			mysqli_stmt_bind_param($stmt, 'sisiisisi', $form_values['lot-name'], $category_id, $form_values['lot-date'], $user_id,  $form_values['lot-rate'], $form_values['path'], $form_values['lot-step'], $form_values['message'], $form_values['lot-rate'] );
			$result = mysqli_stmt_execute($stmt);
			if( !$result ){
				$error = mysqli_error($link);
				$page_content = includeTemplate('templates/error_temp.php', ['error_text' => $error]);
				$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>$categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Ошибка']  );
				print($layout_content);
				exit();
			}
					
			$lotIndex = mysqli_insert_id($link);
			$address = "Location: http://yeticave/lot.php?lotIndex=" . (string)$lotIndex;
			header($address);
			exit();
		}
		
	}else{
			$page_content=includeTemplate('./templates/sign-up_temp.php', ['categories'=>$categories, [] ] );
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>$categories, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Добавление нового пользователя'] );
			print($layout_content);
		
	}
	
		
	
 
?>
