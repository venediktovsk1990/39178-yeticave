<?php
require_once('./data.php');
require_once('./functions.php');
$page_content='';
$layout_content='';

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
				if( ($key=='category') && ( !in_array($value, $categories) ) ){
					$error[$dict[$key]] = 'Выбирите категорию';
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
		print( isset( $_FILES['jpg_img']['name'] )); //не нормальное поведение при повторной отправки формы на проверке без загрузки файла.
		if ( (isset( $_FILES['jpg_img']['name']) ) && ( $_FILES['jpg_img']['name'] != "" ) ) {
			$tmp_name = $_FILES['jpg_img']['tmp_name'];
			$path = $_FILES['jpg_img']['name'];

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
		
			$lots[] = [ 'name'=>$form_values['lot-name'], 'category'=>$form_values['category'], 'cost'=>$form_values['lot-rate'], 'img'=>$form_values['path'] ];
			$lotIndex = count($lots)-1;
			$page_content=includeTemplate('./templates/lot.php', ['categories'=>$categories, 'lot'=>$lots[$lotIndex], 'bets'=>$bets,] );
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>$lots[$lotIndex]['name']]  );
			print($layout_content);
		}
		
	}else{
		$page_content=includeTemplate('./templates/add_lot_temp.php', ['categories'=>$categories, [] ] );
		$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Добавление нового лота'] );
		print($layout_content);
	}
		
	
 
?>
