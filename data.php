<?php

$isAuth = (bool)false;
$userName = '';
$userAvatar = '';
$userId = -1;
$cookieName = "bits_data";
$pageContent="";
$layoutContent="";
$mainPageData = [];
$layoutPageData = [];

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lotTimeRemaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = strtotime('now');

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
$lotTimeRemaining=date("H:i", $tomorrow - $now);

$secondsPerDay = 86400;

$itemPerPage = 3;


 ?>
