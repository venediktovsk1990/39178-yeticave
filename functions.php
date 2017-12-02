<?php

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



function howLongTime( int $lastTime ){
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

?>