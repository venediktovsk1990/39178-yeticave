<?php
require_once('./data.php');
require_once('./functions.php');
require_once('./sql_functions.php');
require_once('./init.php');

	$categories = getCategories( $link );
 
	$pageContent=includeTemplate('./templates/403_temp.php', $mainPageData );


	$layoutPageData['mainContent'] = $pageContent;
	$layoutPageData['categories'] = $categories;
	$layoutPageData['isAuth'] = $isAuth;
	$layoutPageData['userName'] = $userName;
	$layoutPageData['userAvatar'] = $userAvatar;
	$layoutPageData['title'] = "404 Page not found";

	$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData );
	print($layoutContent);


?>
