<?php
require_once('./data.php');
require_once('./functions.php');
require_once('./sql_functions.php');
require_once('./init.php');


	$categories = getCategories( $link );

	if( $isAuth ){

			$bids = getLotsWhereUserBids( $link, $userId );

			$mainPageData['categories'] = $categories;
			$mainPageData['bids'] = $bids;

			$pageContent=includeTemplate('./templates/mylots_temp.php', $mainPageData );
			$layoutPageData['mainContent'] = $pageContent;
			$layoutPageData['categories'] = $categories;
			$layoutPageData['isAuth'] = $isAuth;
			$layoutPageData['userName'] = $userName;
			$layoutPageData['userAvatar'] = $userAvatar;
			$layoutPageData['title'] = "Мои лоты";

			$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData );
			print($layoutContent);
	}else{

		http_response_code(403);
		$location = getLocation('403.php');
		header($location);
		exit();
	}
?>
