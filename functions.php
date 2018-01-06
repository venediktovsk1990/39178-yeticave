<?php

/**
Функция формирует страницу с сообщением об ошибке при работе с БД
*/
function errorSqlMessage( &$error ){

	global $isAuth;
	global $userName;
	global $userAvatar;

	$pageContent ="";
	$layoutContent ="";

	$pageContent = includeTemplate('templates/error_temp.php', ['error_text' => $error]);

	$layoutContent=includeTemplate('./templates/layout.php', ['main_content'=>$pageContent, 'categories'=>[], 'isAuth'=>$isAuth, 'userName'=>$userName, 'userAvatar'=>$userAvatar, 'title'=>'Главная']  );

	print($layoutContent);
	exit();


}

/**
Функция-шаблонизатор
@param $tempName - адресс страницы - подключаемого шаблона
@paramsArray - массив данных,  которые пердаются в шаблон
@return полностью сформированную страницу
*/

function includeTemplate( $tempName, $paramsArray){

	extract($paramsArray);
	$result='';
	if( !file_exists($tempName) ){
		return $result;
	}
	if( isset($paramsArray)){
		ob_start();
        include_once $tempName;
        $result=ob_get_clean();
	}
	return $result;
}

/**
Функциявыбирает подходящее окончания для числительного.
@param number - соответсвующее число
@param  $endingArray - массив всех возможных падежей числительного
@return строку - подходящее под число числительное
*/
function getNumEnding( $number, $endingArray){
	$result = '';
	$number = $number % 100;
	if( $number>=11 && $number<=19 ){
		$result = $endingArray[2];
	}else{
		$x = $number%10;
		switch($x){
			case(1): $result = $endingArray[0]; break;
			case(2):
			case(3):
			case(4): $result = $endingArray[1]; break;
			default: $result = $endingArray[2];
		}
	}
	return $result;
}


/**
Функция фомрирует строку URL для перенаправления пользователя
в рамках сайта.
@param page - имя страницы на которую нужно перенаправить пользователя
@return строку - параметр для функции header()
*/
function getLocation( string $page ){

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$result = "Location: http://$host$uri/$page";
	return $result;

}


/**
Функция обрабатывает пользовательские данные удаляя все лишнее и опасное из них.
@param data - пользовательские данные
@return отчищенные данные пользователя
*/
function  checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
Функция используется для преобразования времени совершения ставки
в строку заданного формата.
@param $lastSqlTime - временная метка которую нужно приобразовать
в строку
@return строку - параметр для функции header()
*/

function howLongTime(  $lastSqlTime ){
	$lastTime = strtotime($lastSqlTime);
	$now=strtotime('now');
	$hoursName=["час", "часа", "часов"];
	$minutesName=["минута", "минуты", "минут"];
	$diff = $now-$lastTime;
	$hours=$diff/3600;
	$minutes=($diff/60)%60;
	$seconds=$diff-($hours*3600 + $minutes*60);
	if($hours>24){
		return date("d.m.y в H.i", $lastTime);
	}
	if($hours<1){
		$result = sprintf( " %d %s назад", $minutes, getNumEnding($minutes, $minutesName) );
		return $result;
	}

	$result = sprintf( " %d %s назад", $hours, getNumEnding($hours, $hoursName) );

	return $result;
}

/**
Функция проверяет есть ли пользователь с заданым email в массиве пользователей.
@param $email - имя страницы на которую нужно перенаправить пользователя
@param -
@return строку - параметр для функции header()
*/
function searchUserByEmail($email, $users) {
	$result = null;
	foreach ($users as $user) {
		if ($user['email'] == $email) {
			$result = $user;
			break;
		}
	}

	return $result;
}

/**
функция вычесляет временную метку до конца торгов и переводит ее в формат php.
@param finishSqlDate - временная метка в формате SQL окончания торгов
@return строку - текстовое представление времени до конца торгов
*/
function howLongTimeForEndString( $finishSqlDate){
	$finish = strtotime($finishSqlDate);
	$now = strtotime('now');
	$time = $finish - $now;
	$result = "";
	if( $time <= 0){
		$result = "0/0 0:0";
	}else{
	  $result = date("m/d H:i", $finish - $now);
	}
	return $result;
}

/**
функция вычесляет временную метку до конца торгов и переводит ее в формат php.
@param finishSqlDate - временная метка в формате SQL окончания торгов
@return число - время до конца торгов
*/
function howLongTimeForEndDigit( $finishSqlDate){
	$finish = strtotime($finishSqlDate);
	$now = strtotime('now');
	return ($finish - $now);
}

/**
функция не используется, оставлена как пример кода для работы с куки
*/
function setCooky(){

	$path = "/";
	$current_date = time();
	$cookie_date = strtotime("+30 days");
	$cost = (int)$_POST['cost'];
	$cookie_value_string = '';
	$cookie_value_array =[];
	if( isset($_COOKIE[$cookie_name]) ){
		$cookie_value_array = json_decode( $_COOKIE[$cookie_name], true);
		$cookie_value_array[] = [ 'index'=>$lotIndex, 'time'=>$current_date, 'cost'=>$cost] ;
	}else{
		$cookie_value_array[] = [ 'index'=>$lotIndex, 'time'=>$current_date, 'cost'=>$cost ];
	}
	$cookie_value_string = json_encode($cookie_value_array);
	setcookie($cookie_name, $cookie_value_string, $cookie_date, $path, $cookie_domain);


}



?>
