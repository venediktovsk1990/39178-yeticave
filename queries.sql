/*заполняем таблицу пользователей*/
	INSERT INTO users SET
			email ='ignat.v@gmail.com',
			name = 'Игнат',
			password = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka',
			date_registration = CURRENT_TIMESTAMP(),
			contacts ='Moscow city',
			avatar ='img/user.jpg',
			is_deleted = FALSE;

	INSERT INTO users SET
			email ='kitty_93@li.ru',
			name = 'Леночка',
			password = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW',
			date_registration = CURRENT_TIMESTAMP(),
			contacts ='Monako, Saint Gracia',
			avatar ='img/user2.jpg',
			is_deleted = FALSE;


	INSERT INTO users SET
			email ='warrior07@mail.ru',
			name = 'Руслан',
			password = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW',
			date_registration = CURRENT_TIMESTAMP(),
			contacts ='Narnia. Uzbek street avenu 3',
			avatar ='img/user3.jpg',
			is_deleted = FALSE;

	/*заполняем таблицу катгорий		*/
	INSERT INTO categories SET
			title = 'Доски и лыжи',
			is_deleted = FALSE;

	INSERT INTO categories SET
			title = 'Крепления',
			is_deleted = FALSE;

	INSERT INTO categories SET
			title = 'Ботинки',
			is_deleted = FALSE;

	INSERT INTO categories SET
			title = 'Одежда',
			is_deleted = FALSE;

	INSERT INTO categories SET
			title = 'Инструменты',
			is_deleted = FALSE;

	INSERT INTO categories SET
			title = 'Разное',
			is_deleted = FALSE;

	/*заполнение таблицы лотов*/
	INSERT INTO lots SET
			title = '2014 Rossignol District Snowboard',
			category_id = (SELECT  id FROM categories WHERE  title = 'Доски и лыжи'),
			date_creation = CURRENT_TIMESTAMP(),
			bidding_ending = '2017-12-30 18:20:30',
			creator_id = 2,
			cost = 10999,
			current_cost = 10999,
			cost_step = 100,
			subscribe = 'Легкий маневренный сноуборд, готовый дать жару в любом парке, растопив
							снег
							мощным щелчкоми четкими дугами. Стекловолокно Bi-Ax, уложенное в двух направлениях, наделяет этот
							снаряд
							отличной гибкостью и отзывчивостью, а симметричная геометрия в сочетании с классическим прогибом
							кэмбер
							позволит уверенно держать высокие скорости. А если к концу катального дня сил совсем не останется,
							просто
							посмотрите на Вашу доску и улыбнитесь, крутая графика от Шона Кливера еще никого не оставляла
							равнодушным',
			image = 'img/lot-1.jpg',
			is_deleted = FALSE;

	INSERT INTO lots SET
			title = 'DC Ply Mens 2016/2017 Snowboard',
			category_id = (SELECT  id FROM categories WHERE  title = 'Доски и лыжи'),
			date_creation = CURRENT_TIMESTAMP(),
			bidding_ending = '2017-12-21 08:20:30',
			creator_id = 1,
			cost = 15999,
			current_cost = 15999,
			cost_step = 100,
			image = 'img/lot-2.jpg',
			is_deleted = FALSE;

	INSERT INTO lots SET
			title = 'Крепления Union Contact Pro 2015 года размер L/XL',
			category_id = (SELECT  id FROM categories WHERE  title = 'Крепления'),
			date_creation = CURRENT_TIMESTAMP(),
			bidding_ending = '2017-12-24 19:25:30',
			creator_id = 1,
			cost = 8000,
			current_cost = 8000,
			cost_step = 10,
			image = 'img/lot-3.jpg',
			is_deleted = FALSE;

	INSERT INTO lots SET
			title = 'Ботинки для сноуборда DC Mutiny Charocal',
			category_id = (SELECT  id FROM categories WHERE  title = 'Ботинки'),
			date_creation = CURRENT_TIMESTAMP(),
			bidding_ending = '2018-01-30 14:00:00',
			creator_id = 3,
			cost = 10999,
			current_cost = 10999,
			cost_step = 50,
			image = 'img/lot-4.jpg',
			is_deleted = FALSE;
	INSERT INTO lots SET
			title = 'Куртка для сноуборда DC Mutiny Charocal',
			category_id = (SELECT  id FROM categories WHERE  title = 'Одежда'),
			date_creation = CURRENT_TIMESTAMP(),
			bidding_ending = '2017-12-28 18:00:00',
			creator_id = 2,
			cost = 7500,
			current_cost = 7500,
			cost_step = 60,
			image = 'img/lot-5.jpg',
			is_deleted = FALSE;

	INSERT INTO lots SET
			title = 'Маска Oakley Canopy',
			category_id = (SELECT  id FROM categories WHERE  title = 'Разное'),
			date_creation = CURRENT_TIMESTAMP(),
			bidding_ending = '2017-12-17 12:00:00',
			creator_id = 3,
			cost = 5400,
			current_cost = 5400,
			cost_step = 50,
			image = 'img/lot-6.jpg',
			is_deleted = FALSE;


	/* заполняем таблицу ставо */

	INSERT INTO bids SET
			bid_date = CURRENT_TIMESTAMP(),
			user_id = (SELECT  id FROM users WHERE  name = 'Игнат'),
			lot_id = (SELECT  id FROM lots WHERE  title = '2014 Rossignol District Snowboard'),
			cost = 11999,
			is_deleted = FALSE;

	INSERT INTO bids SET
			bid_date = CURRENT_TIMESTAMP(),
			user_id = (SELECT  id FROM users WHERE  name = 'Леночка'),
			lot_id = (SELECT  id FROM lots WHERE  title = 'DC Ply Mens 2016/2017 Snowboard'),
			cost = 16999,
			is_deleted = FALSE;

	INSERT INTO bids SET
			bid_date = CURRENT_TIMESTAMP(),
			user_id = (SELECT  id FROM users WHERE  name = 'Руслан'),
			lot_id = (SELECT  id FROM lots WHERE  title = 'Крепления Union Contact Pro 2015 года размер L/XL'),
			cost = 8010,
			is_deleted = FALSE;
