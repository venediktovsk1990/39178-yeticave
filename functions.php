<?php

function includeTemplate( $tempName, $paramsArray){
	
	$result='';
	if( !file_exist($tempName) ){
		return $result;
	}
	
	if( isset($paramsArray)){
		requite_once($tempName);
	}

}

?>