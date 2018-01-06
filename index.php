<?php

 require_once('./data.php');
 require_once('./functions.php');
 require_once('./sql_functions.php');
 require_once('./init.php');



	$categories = getCategories( $link );

	//получаем все лоты

	$lots = getLots( $link );

  $mainPageData['categories'] = $categories;
  $mainPageData['lots'] = $lots;
  $mainPageData['lotTimeRemaining'] = $lotTimeRemaining;

	$pageContent=includeTemplate('./templates/index_temp.php', $mainPageData );

  $layoutPageData['mainContent'] = $pageContent;
  $layoutPageData['categories'] = $categories;
  $layoutPageData['isAuth'] = $isAuth;
  $layoutPageData['userName'] = $userName;
  $layoutPageData['userAvatar'] = $userAvatar;
  $layoutPageData['title'] = "Главная";

	$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData  );
	print($layoutContent);





?>
