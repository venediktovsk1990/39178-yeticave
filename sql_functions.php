<?php

function createBDConnect(){
		$link = mysqli_connect("localhost", "root", "", "yeticave");
		if( !$link ){
			$error_msg = 'Произошла ошибка соединения с БД - ' . mysqli_connect_error();
			errorSqlMessage( $error_msg );
		}else{
			mysqli_set_charset( $link, "utf8");
			return $link;
		}

}


function getCategories( $link ){

	$sql = 'SELECT title FROM categories';
		$result = mysqli_query($link, $sql);

		if( !$result ){
			$error = mysqli_error($link);
			errorSqlMessage( $error );
		}

		$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $categories;
}

function getCategoryId( $link, &$formData ){

	$sql = 'SELECT id FROM categories WHERE title="' . $formData['category'] . '"';
	$result = mysqli_query($link, $sql);

	if( !$result ){
		$error = mysqli_error($link);
		errorSqlMessage( $error );
	}
	$categoryId = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $categoryId;

}


function getLots( $link ){

		$sql = 'SELECT lots.id, lots.title, lots.cost, lots.image, lots.current_cost, lots.bidding_ending,
		categories.title category FROM lots JOIN categories ON categories.id=lots.category_id';

		$result = mysqli_query($link, $sql);
		if( !$result ){
			$error = mysqli_error($link);
			errorSqlMessage( $error );
		}
		$lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $lots;
}


function getUsersEmail( $link ){
	$sql = 'SELECT email  FROM users';
	$result = mysqli_query($link, $sql);

	if( !$result ){

		$error = mysqli_error($link);
		errorSqlMessage( $error );
	}

	$email = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $email;

}


function getUsers( $link ){
	$sql = 'SELECT *  FROM users';
	$result = mysqli_query($link, $sql);

	if( !$result ){

		$error = mysqli_error($link);
		errorSqlMessage( $error );
	}

	$email = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $email;

}


function getLotById( $link, $lotIndex ){

	//получаем лоты
	$sql = 'SELECT lots.id, lots.title, lots.subscribe, lots.cost, lots.image, lots.current_cost, lots.cost_step step,
	lots.bidding_ending, lots.creator_id, categories.title category FROM lots JOIN categories ON categories.id=lots.category_id
	WHERE lots.id=' . $lotIndex;
	$result = mysqli_query($link, $sql);

	if( !$result ){
		$error = mysqli_error($link);
		errorSqlMessage( $error );
	}
	$lot = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $lot;

}


function getBetsOfLot( $link, $lotIndex ){

	$sql = 'SELECT bids.bid_date, bids.cost,  users.name FROM bids JOIN users ON bids.user_id=users.id WHERE bids.lot_id=' . $lotIndex;
	$result = mysqli_query($link, $sql);

	if( !$result ){
		$error = mysqli_error($link);
		errorSqlMessage( $error );
	}
	$bets = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $bets;

}

function getBetsCountOfUser( $link, $userId, $lotIndex ){

	$sql = 'SELECT COUNT(id) count FROM bids WHERE lot_id=' . $lotIndex . ' AND user_id = ' . $userId;
	$result = mysqli_query($link, $sql);

	if( !$result ){
		$error = mysqli_error($link);
		errorSqlMessage( $error );
		exit();
	}
	$betsCount = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $betsCount;

}


function getLotsWhereUserBids( $link, $userId ){

	$sql = 'SELECT lots.image,lots.title, bids.cost, lots.bidding_ending, categories.title categories, bids.bid_date FROM bids JOIN lots ON lots.id=bids.lot_id JOIN categories ON lots.category_id=categories.id WHERE bids.user_id = ' . $userId;

	$result = mysqli_query($link, $sql);
	if( !$result ){
		$error = mysqli_error($link);
		errorSqlMessage( $error );
		exit();
	}
	$bids = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return  $bids;

}


function addNewUser( $link, &$userValues ){

	$sql = 'INSERT INTO users (users.name, users.date_registration, users.email, users.password, users.contacts, users.avatar) VALUES( ?, CURRENT_TIMESTAMP(), ?, ?,  ?, ? )';
	$stmt = mysqli_prepare($link, $sql);
	if( !isset($userValues['path']) ){
		$userValues['path'] = NULL;
	}

	mysqli_stmt_bind_param($stmt, 'sssss', $userValues['name'],  $userValues['email'], $userValues['password'], $userValues['message'], $userValues['path'] );
	$result = mysqli_stmt_execute($stmt);
	if( !$result ){
			$error = mysqli_error($link);
			errorSqlMessage( $error );
	}
}


function insertNewLot( $link, &$lotData ){

	$sql = 'INSERT INTO lots (lots.date_creation, lots.title, lots.category_id, lots.bidding_ending, lots.creator_id, lots.cost, lots.image, lots.cost_step, lots.subscribe, lots.current_cost) VALUES(CURRENT_TIMESTAMP(), ?, ?,  ?, ?, ?, ?, ?, ?, ? )';

	$stmt = mysqli_prepare($link, $sql);
	mysqli_stmt_bind_param($stmt, 'sisiisisi', $lotData['lot-name'], $lotData['categoryId'], $lotData['lot-date'], $lotData['userId'],  $lotData['lot-rate'], $lotData['path'], $lotData['lot-step'], $lotData['message'], $lotData['lot-rate'] );
	$result = mysqli_stmt_execute($stmt);
	if( !$result ){
		$error = mysqli_error($link);
		errorSqlMessage( $error );
	}

	$lotIndex = mysqli_insert_id($link);
	return $lotIndex;

}

function insertNewBit( $link, $userId, $lotIndex, $cost ){

		$sql = 'INSERT INTO bids (bid_date, user_id, lot_id, cost, is_deleted) VALUES ( CURRENT_TIMESTAMP(), ?, ?, ?, FALSE)';
		$stmt = mysqli_prepare($link, $sql);
		mysqli_stmt_bind_param($stmt, 'iii', $userId, $lotIndex, $cost);
		$result = mysqli_stmt_execute($stmt);
		if( !$result ){
			$error = mysqli_error($link);
			errorSqlMessage( $error );
		}

}

?>
