<?php
 $categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];
 $lots = [
	[ 'name'=>'2014 Rossignol District Snowboard', 'category'=>'Доски и лыжи', 'cost'=>'10999', 'img'=>'img/lot-1.jpg'],
	[ 'name'=>'DC Ply Mens 2016/2017 Snowboard', 'category'=>'Доски и лыжи', 'cost'=>'159999', 'img'=>'img/lot-2.jpg'],
	[ 'name'=>'Крепления Union Contact Pro 2015 года размер L/XL', 'category'=>'Крепления', 'cost'=>'8000', 'img'=>'img/lot-3.jpg'],
	[ 'name'=>'Ботинки для сноуборда DC Mutiny Charocal', 'category'=>'Ботинки', 'cost'=>'10999', 'img'=>'img/lot-4.jpg'],
	[ 'name'=>'Куртка для сноуборда DC Mutiny Charocal', 'category'=>'Одежда', 'cost'=>'7500', 'img'=>'img/lot-5.jpg'],
	[ 'name'=>'Маска Oakley Canopy', 'category'=>'Разное', 'cost'=>'5400', 'img'=>'img/lot-6.jpg'],
 ];
 
 // ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = strtotime('now');

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
$lot_time_remaining=date("H:i", $tomorrow - $now);
 ?>