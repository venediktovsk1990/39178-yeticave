<?php
require_once('./data.php');
require_once('./functions.php');
$page_content='';
$layout_content='';

	//валидация формы
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		$required=['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
		$dict=['lot-name'=>'Название', 'category'=>'Категория', 'message'=>'Описание', 'lot-rate'=>'Начальная цена', 'lot-step'=>'Шаг ставки', 'lot-date'=>'Дата окончания'];
		$error=[];
		$gif = $_POST;
		foreach( $_POST as $key=>$value){
			if( in_array($key, $required)  ){
				if( !$value ){
				
					$error[$dict[$key]] = 'Это поле надо заполнить';
				}
			}
		}
		
		print( count($error) );
		if (isset($_FILES['gif_img']['name'])) {
			$tmp_name = $_FILES['gif_img']['tmp_name'];
			$path = $_FILES['gif_img']['name'];

			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$file_type = finfo_file($finfo, $tmp_name);
			if ($file_type !== "image/png") {
				$error['Файл'] = 'Загрузите картинку в формате GIF';
			}
			else {
				move_uploaded_file($tmp_name, 'img/' . $path);
				$gif['path'] = $path;
			}
		}else{
			$error['Файл']="Вы не загрузили файл";
		}
		
		$form_values = $gif;
		//print( count($error) );
		if( count($error) ){
			$page_content=includeTemplate('./templates/add_lot_temp.php', ['categories'=>$categories, 'form_values'=>$form_values, 'errors'=>$error,] );
		}else{
			//$page_content=includeTemplate('./templates/add_lot_temp.php', ['categories'=>$categories] );
		}
		
	}else{
		$page_content=includeTemplate('./templates/add_lot_temp.php', ['categories'=>$categories, [] ] );
	}
		$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Добавление нового лота'] );
		print($layout_content);
	
 
?>
