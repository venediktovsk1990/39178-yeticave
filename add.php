<?php
require_once('./data.php');
require_once('./functions.php');
require_once('./sql_functions.php');
require_once('./init.php');


function checkFile( &$error, &$formData, &$dict ){

		if ( (isset( $_FILES['img']['name']) ) && ( $_FILES['img']['name'] != "" ) ) {

				$tmpName = $_FILES['img']['tmp_name'];
				$path = $_FILES['img']['name'];

				$fileType = mime_content_type($tmpName);
				if ( ($fileType !== "image/jpeg") && ($fileType !== "image/png") ) {
					$error['Файл'] = 'Загрузите картинку в формате png или jpeg или  gif';
				}
				else {
					move_uploaded_file($tmpName, "./img/" . $path);
					$formData['path'] =( "img/" . $path);

				}
		}
}


function checkStartCost( &$error, &$dict ){

	 	$startCost =  $_POST['lot-rate'];
		if( $startCost <=0 ){
				$error[$dict['lot-rate']] = 'Это поле должно быть больше 0';
		}

}

function checkBetStep ( &$error, &$dict ){

	 	$lotStep = $_POST['lot-step'];
		if( $lotStep <=0 ){
				$error[$dict['lot-step']] = 'Это поле должно быть больше 0';
		}

}


function checkFinishDate( &$error, &$dict ){

		global $secondsPerDay;
	 	$finishDate = $_POST['lot-date'] ;
		$finish = strtotime($finishDate);
		$now = strtotime('now');
		$time = $finish - $now;
		$howManyDays = ($time/$secondsPerDay);
		if( $howManyDays < 1 ){
				$error[$dict['lot-date']] = 'До конца торгов должно быть больше суток';
		}
}



function checkFormFields( &$formData, &$categories ){

		$required=['lot-name', 'category', 'message', 'lot-rate', 'lot-step', 'lot-date'];
		$math=['lot-rate', 'lot-step'];
		$dict=['lot-name'=>'Название', 'category'=>'Категория', 'message'=>'Описание', 'lot-rate'=>'Начальная цена', 'lot-step'=>'Шаг ставки', 'lot-date'=>'Дата окончания торгов'];
		$error=[];


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

			$value = checkInput($value);

			if( $value && in_array($key, $math)){
				if( !is_numeric($value) ){
					$error[$dict[$key]] = 'В это поле нужно вводить только числовые значения';
				}else{
					$value = (int)$value;
				}
			}
		}

		checkStartCost( $error, $dict );
		checkBetStep( $error, $dict  );
		checkFinishDate( $error, $dict  );
		checkFile( $error, $formData, $dict );

	return $error;
}






	$categories = getCategories( $link );

	if($_SERVER['REQUEST_METHOD'] == 'POST'){

		$formData = $_POST;
		$error = [];

		$error = checkFormFields( $formData, $categories );
		if( count($error) ){

			$mainPageData['categories'] = $categories;
			$mainPageData['formData'] = $formData;
			$mainPageData['errors'] = $error;

			$pageContent=includeTemplate('./templates/add_lot_temp.php', $mainPageData );

var_dump($error);
var_dump( $_FILES );

			$layoutPageData['mainContent'] = $pageContent;
			$layoutPageData['categories'] = $categories;
			$layoutPageData['isAuth'] = $isAuth;
			$layoutPageData['userName'] = $userName;
			$layoutPageData['userAvatar'] = $userAvatar;
			$layoutPageData['title'] = "Добавление нового лота";

			$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData );

			print($layoutContent);

		}else{

			$formData['categoryId'] = getCategoryId( $link, $formData );
			$formData['userId'] = $userId;
			$lotIndex = insertNewLot( $link, $formData );
			$address = "Location: http://yeticave/lot.php?lotIndex=" . (string)$lotIndex;
			header($address);
			exit();

		}

	}else{

			if( isset($_SESSION['user'] ) ){

				$mainPageData['categories'] = $categories;
				$pageContent=includeTemplate('./templates/add_lot_temp.php', $mainPageData );

				$layoutPageData['mainContent'] = $pageContent;
				$layoutPageData['categories'] = $categories;
				$layoutPageData['isAuth'] = $isAuth;
				$layoutPageData['userName'] = $userName;
				$layoutPageData['userAvatar'] = $userAvatar;
				$layoutPageData['title'] = "Добавление нового лота";

				$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData );
				print($layoutContent);

		}else{
			http_response_code(404);
			$location = getLocation('403.php');
			header($location);
			exit();
		}
	}



?>
