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

?>