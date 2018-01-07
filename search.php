<?php

 require_once('./data.php');
 require_once('./functions.php');
 require_once('./sql_functions.php');
 require_once('./init.php');

 if( isset($_GET['search']) ){

      $keyWords = checkInput($_GET['search'] );
    	$categories = getCategories( $link );
      isset( $_GET['page'] ) ? $pageIndex = $_GET['page'] : $pageIndex = 1;
      $searchResult = getLotsBySearch( $link, $keyWords );
      $lotsCount = count( $searchResult );
      $pageCount = ceil( $lotsCount / $itemPerPage);

      $mainPageData['categories'] = $categories;
      $mainPageData['lots'] = $searchResult;
      $mainPageData['searchKey'] = $keyWords;
      $mainPageData['pageIndex'] = $pageIndex;
      $mainPageData['pageCount'] = $pageCount;

    	$pageContent=includeTemplate('./templates/search_temp.php', $mainPageData );

      $layoutPageData['mainContent'] = $pageContent;
      $layoutPageData['categories'] = $categories;
      $layoutPageData['isAuth'] = $isAuth;
      $layoutPageData['userName'] = $userName;
      $layoutPageData['userAvatar'] = $userAvatar;
      $layoutPageData['title'] = "Главная";

    	$layoutContent=includeTemplate('./templates/layout.php', $layoutPageData  );
    	print($layoutContent);

}else{



}



?>
