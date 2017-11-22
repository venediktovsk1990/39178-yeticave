<?php

 
 require_once('./data.php');

 require_once('./functions.php');
 
 $page_content=includeTemplate('./templates/index.php', ['categories'=>$categories, 'lots'=>$lots, 'lot_time_remaining'=>$lot_time_remaining] );
 
 $layout_content=includeTemplate('./templates/layout.php', ['main_content'=>$page_content, 'is_auth'=>$is_auth, 'user_name'=>$user_name, 'user_avatar'=>$user_avatar, 'title'=>'Главная']  );
 
 print($layout_content);
 
?>
