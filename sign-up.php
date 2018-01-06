<?php
require_once('./data.php');
require_once('./functions.php');
require_once('./sql_functions.php');
require_once('./init.php');


function checkFile( &$error, &$formData ){

		if ( (isset( $_FILES['photo2']['name']) ) && ( $_FILES['photo2']['name'] != "" ) ) {

				$tmpName = $_FILES['photo2']['tmp_name'];
				$path = $_FILES['photo2']['name'];

				$fileType = mime_content_type($tmpName);
				if ( ($fileType !== "image/jpeg") && ($fileType !== "image/png") && ($fileType !== "image/gif") ) {
					$error['Файл'] = 'Загрузите картинку в формате png или jpeg или  gif';
				}
				else {
					move_uploaded_file($tmpName, "./img/" . $path);
					$formData['path'] =( "img/" . $path);

				}
		}
}


function checkEmail( $link, &$error, &$formData ){

	$isEmailFree = true;

	if( isset($_POST['email']) ){
				$email = $_POST['email'];
				$result = filter_var( $email, FILTER_VALIDATE_EMAIL);
				if( $result == false ){
					$error['email']="Вы указали неверный email";
				}else{
						$userData = getUsersEmail($link );
						if( isset( $userData) ){
							foreach ($userData as $emailItem ) {
								if( $emailItem['email'] == $email ){
										$isEmailFree = false;
								}
							}
						}

						if( !$isEmailFree ){
								$error['email']="Данный email уже занят другим пользователем";
						}
			}
	}



}

function passwToHash( &$error, &$formData ){

	if( count($error) == 0 ){
			$hashPasw = $formData['password'];
			$hashPasw = password_hash( $formData['password'], PASSWORD_DEFAULT );

			if( $hashPasw == FALSE){
					$error[$dict['passsword'] ] = "при работе с этим полем возникла ошибка, измените его и поробуйте еще раз";
			}else{
				$formData['password'] = $hashPasw;
			}
	}

}

function checkFormFields( &$formData ){
		$required=['email', 'password', 'name', 'message'];
		$dict=['name'=>'Имя', 'email'=>'email', 'password'=>'Пароль', 'message'=>'Контактные данные'];
		$error=[];
		$formData = $_POST;
		global $link;

		foreach( $_POST as $key=>$value){
			if( in_array($key, $required)  ){
				if( !$value ){
					$error[$dict[$key]] = 'Это поле надо заполнить';
				}
			}
			//удаление из пользовательского ввода нежелательных символов
			$value = checkInput($value);
		}

		checkFile( $error, $formData );

		checkEmail( $link, $error, $formData );

		passwToHash( $error, $formData );


	return $error;
}


	$categories = getCategories( $link );


	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		$formData = [];
		$error = [];
		$error = checkFormFields( $formData );

		if( count($error) ){

				$mainPageData['categories'] = $categories;
			  $mainPageData['formData'] = $formData;
			  $mainPageData['errors'] = $error;
				$pageContent=includeTemplate('./templates/sign-up_temp.php', $mainPageData );

				$layoutPageData['mainContent'] = $pageContent;
			  $layoutPageData['categories'] = $categories;
			  $layoutPageData['isAuth'] = $isAuth;
			  $layoutPageData['userName'] = $userName;
			  $layoutPageData['userAvatar'] = $userAvatar;
			  $layoutPageData['title'] = "Добавление нового пользователя";

				$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData );

				print($layoutContent);
		}else{

			addNewUser( $link, $formData );
			$address = getLocation("login.php");
			header($address);
			exit();

		}

	}else{

			$mainPageData['categories'] = $categories;
			$pageContent=includeTemplate('./templates/sign-up_temp.php', $mainPageData );

			$layoutPageData['mainContent'] = $pageContent;
			$layoutPageData['categories'] = $categories;
			$layoutPageData['isAuth'] = $isAuth;
			$layoutPageData['userName'] = $userName;
			$layoutPageData['userAvatar'] = $userAvatar;
			$layoutPageData['title'] = "Добавление нового пользователя";

			$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData );

			print($layoutContent);

	}




?>
