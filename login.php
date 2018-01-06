<?php
require_once('./data.php');
require_once('./functions.php');
require_once('./sql_functions.php');
require_once('./init.php');

function checkUser( $link, &$error, &$formData ){

			$users = getUsers( $link );

			if( $user = searchUserByEmail($formData['email'], $users)) {
				if (password_verify($formData['password'], $user['password'])) {
					$_SESSION['user'] = $user;

				}
				else {
					$errors[$dict['password']] = 'Вы ввели неверный пароль	';
				}
			}else {
				$errors[$dict['email']] = 'Такой пользователь не найден';
			}

}



function checkFormFields( &$formData ){
		$required=['email', 'paswword'];
		$dict=['email'=>'Ваш email', 'password'=>'Пароль'];
		$errors=[];
		$formData = $_POST;
		global $link;
		foreach( $formData as $key=>$value){
			if( in_array($key, $required)  ){
				if( !$value ){
					$errors[$dict[$key]] = 'Это поле надо заполнить';
				}
			}
		}

		checkuser( $link, $error, $formData );


	return $error;
}


	$categories = getCategories($link );

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

				$formData = [];
				$errors = [];
				$errors = checkFormFields( $formData );

					if (count($errors)) {

							$mainPageData['categories'] = $categories;
							$mainPageData['formData'] = $formData;
							$mainPageData['errors'] = $error;
							$pageContent=includeTemplate('./templates/login_temp.php', $mainPageData );

					}
					else {
							$address = getLocation("");
							header($address);
							exit();
							//header("Location: http://yeticave");
							//exit();
					}
			}
			else {
				$mainPageData['categories'] = $categories;
				$pageContent = includeTemplate('./templates/login_temp.php', $mainPageData );
			}



	$layoutPageData['mainContent'] = $pageContent;
	$layoutPageData['categories'] = $categories;
	$layoutPageData['isAuth'] = $isAuth;
	$layoutPageData['userName'] = $userName;
	$layoutPageData['userAvatar'] = $userAvatar;
	$layoutPageData['title'] = "Регистрация";

	$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData );

	print($layoutContent);




?>
