<?php
require_once('./data.php');
require_once('./functions.php');
require_once('./init.php');

$page_content='';
$layout_content='';



	//валидация формы
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$required=['email', 'paswword'];
		$dict=['email'=>'Ваш email', 'password'=>'Пароль'];
		$errors=[];
		$form_data = $_POST;
		foreach( $form_data as $key=>$value){
			if( in_array($key, $required)  ){
				if( !$value ){
					$errors[$dict[$key]] = 'Это поле надо заполнить';
				}
			}
		}
			
		//получаем пользователей из БД
		if (!$link) {
			$error = mysqli_connect_error();
			$page_content = include_template('templates/error_temp.php', ['error_text' => $error]);
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>[], 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
			print($layout_content);
			exit();
		}
		//получаем категории
		$sql = 'SELECT * FROM users';
		$result = mysqli_query($link, $sql);

		if( !$result ){
			$error = mysqli_error($link);
			$page_content = include_template('templates/error_temp.php', ['error_text' => $error]);
			$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'categories'=>[], 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
			print($layout_content);
			exit();
		}
		$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
			
		if( $user = searchUserByEmail($form_data['email'], $users)) {
			if (password_verify($form_data['password'], $user['password'])) {
				$_SESSION['user'] = $user;
				
			}
			else {
				$errors[$dict['password']] = 'Вы ввели неверный пароль	';
			}
		}else {
			$errors[$dict['email']] = 'Такой пользователь не найден';
		}
		
		if (count($errors)) {
			$page_content = includeTemplate('./templates/login_temp.php', ['form_data' => $form_data, 'errors' => $errors]);
		}
		else {
			header("Location: http://yeticave");
			exit();
		}
	}
	else {
		$page_content = includeTemplate('./templates/login_temp.php', []);
	}
		
	$layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Регистрация']  );
	print($layout_content);
		
		
	
 
?>
