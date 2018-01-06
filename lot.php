<?php
require_once('./data.php');
require_once('./functions.php');
require_once('./sql_functions.php');
require_once('./init.php');


function getLotIndex(){
	$index = -1;
	if($_SERVER['REQUEST_METHOD'] == "GET" ){
		if( isset( $_GET['lotIndex']) ){
			 $index = intval($_GET['lotIndex']);
		}
	}
	if( $_SERVER['REQUEST_METHOD'] == "POST"){
		$index = intval( $_POST['lotIndex'] );
	}
	return $index;
}


function isShowBetsForm( $link, &$lot, $userId, $lotId){

		$show = true;

		if( $userId > -1 ){

				if( $userId == $lot[0]['creator_id']){
					$show = false;
				}

				$time = howLongTimeForEndDigit( $lot[0]['bidding_ending'] );
				if( $time <= 0 ){
					$show = false;
				}

				$betsCount = getBetsCountOfUser( $link, $userId, $lotId );
				if( $betsCount[0]['count'] > 0){
					$show = false;
				}

		}else{
			$show = false;
		}
		return $show;

}



function checkForm( &$lot ){

	$numeric=['cost'];
	$hasErrors = false;

		foreach( $_POST as $key=>$value){
			$value = checkInput($value);
			if( in_array( $key, $numeric ) ){
				if( !is_numeric($value) ){
					$hasErrors = true;
				}
			}
		}

		$step = $lot[0]['step'];
		$currentCost = $lot[0]['current_cost'];
		$userBid = $_POST['cost'];
		$minValue = $currentCost + $step;
		if( $userBid < $minValue ){
			$hasErrors = true;
		}

		return $hasErrors;

}



$hasErrors = false;
$templateData['disabled'] =(bool)false;
$lotIndex=-1;
$categories = getCategories( $link );


if($_SERVER['REQUEST_METHOD'] == "GET" ){

	$lotIndex = getLotIndex();

	if( $lotIndex > -1 ){

			$lot = getLotById( $link, $lotIndex );
			$bets = getBetsOfLot( $link, $lotIndex );
			$templateData['show'] = isShowBetsForm( $link, $lot, $userId, $lotIndex );


			$templateData['lotIndex']=$lotIndex;
			$mainPageData['categories'] = $categories;
			$mainPageData['lot'] = $lot[0];
			$mainPageData['bets'] = $bets;
			$mainPageData['templateData'] = $templateData;

			$pageContent=includeTemplate('./templates/lot_temp.php', $mainPageData );


			$layoutPageData['mainContent'] = $pageContent;
			$layoutPageData['categories'] = $categories;
			$layoutPageData['isAuth'] = $isAuth;
			$layoutPageData['userName'] = $userName;
			$layoutPageData['userAvatar'] = $userAvatar;
			$layoutPageData['title'] = $lot[0]['title'];

			$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData );
			print($layoutContent);

	 }else{
			http_response_code(404);

			$pageContent=includeTemplate('./templates/404_temp.php', [] );

			$layoutPageData['mainContent'] = $pageContent;
			$layoutPageData['categories'] = $categories;
			$layoutPageData['isAuth'] = $isAuth;
			$layoutPageData['userName'] = $userName;
			$layoutPageData['userAvatar'] = $userAvatar;
			$layoutPageData['title'] = "404 Page not foun";

			$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData );
			print($layoutContent);

	}

}



if($_SERVER['REQUEST_METHOD'] == "POST" ){

	$hasErrors = checkForm( $lot );
	$lotIndex = getLotIndex();
	$templateData[]=[ 'lotIndex'=>is_numeric($lotIndex) ];
	$userBid = $_POST['cost'];

	if( $hasErrors ){

				$templateData['lotIndex']=$lotIndex;
				$templateData['userBid']=$userBid;
				$mainPageData['categories'] = $categories;
				$mainPageData['lot'] = $lot[0];
				$mainPageData['bets'] = $bets;
				$mainPageData['templateData'] = $templateData;

				$pageContent=includeTemplate('./templates/lot_temp.php', $mainPageData );

				$layoutPageData['mainContent'] = $pageContent;
				$layoutPageData['categories'] = $categories;
				$layoutPageData['isAuth'] = $isAuth;
				$layoutPageData['userName'] = $userName;
				$layoutPageData['userAvatar'] = $userAvatar;
				$layoutPageData['title'] = $lot[0]['title'];

				$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData );
				print($layoutContent);

	}else{

			insertNewBit( $link, $userId, $lotIndex, $userBid );
			$location = getLocation('mylots.php');
			header($location);
			exit();

	}
}
?>
