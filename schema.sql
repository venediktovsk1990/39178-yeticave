CREATE DATABASE yeticave;
USE yeticave;
CREATE TABLE users (
	id INT AUTO_INCREMENT PRIMARY KEY,
	name CHAR(128),
	date_registration DATETIME,
	email CHAR(128),
	password CHAR(32),
	contacts CHAR(128),
	avatar CHAR(250),
	is_deleted TINYINT(1)
	);
	
CREATE UNIQUE INDEX email_uniq ON users(email);
CREATE INDEX name_index ON users(name);
CREATE INDEX email_index ON users(email);



CREATE TABLE lots (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title CHAR(128),
	category_id INT,
	date_creation DATETIME,
	bidding_ending DATETIME,
	creator_id CHAR(128),
	winer_id INT,
	cost INT,
	cost_step INT,
	subscribe BLOB(1024),
	is_deleted TINYINT(1)
);

CREATE INDEX title_index ON lots(title);
CREATE INDEX subscribe_index ON lots(subscribe);
CREATE INDEX bidding_ending_index ON lots(bidding_ending);
	
	CREATE TABLE bids (
	id INT AUTO_INCREMENT PRIMARY KEY,
	bid_date DATETIME,
	user_id CHAR(128),
	lot_id INT,
	cost INT,
	is_deleted TINYINT(1)
);

CREATE TABLE categories (
	id INT AUTO_INCREMENT PRIMARY KEY,
	title CHAR(128),
	is_deleted TINYINT(1)
);

CREATE UNIQUE INDEX categories_uniq ON categories(title);
	
