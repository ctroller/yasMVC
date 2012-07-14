CREATE TABLE account (
	account_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	account_login VARCHAR(255) NOT NULL,
	account_password VARCHAR(255) NOT NULL,
	account_level INT(11) NOT NULL DEFAULT 1,
	PRIMARY KEY (account_id)
) ENGINE=InnoDB;

CREATE TABLE page (
	page_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	account_id INT(11) UNSIGNED NOT NULL,
	visible BOOLEAN NOT NULL DEFAULT 0,
	page_shortcut VARCHAR(255) NOT NULL,
	create_date DATETIME NOT NULL,
	edit_date DATETIME DEFAULT NULL,
	PRIMARY KEY (page_id)
) ENGINE=InnoDB;

CREATE TABLE page_content (
	page_id INT(11) UNSIGNED NOT NULL,
	language_code VARCHAR(10) NOT NULL,
	page_title VARCHAR(255) NOT NULL,
	page_content TEXT NOT NULL,
	PRIMARY KEY (page_id,language_code)
) ENGINE=InnoDB;

CREATE TABLE news (
	news_id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	account_id INT(11) UNSIGNED NOT NULL,
	create_date DATETIME NOT NULL,
	edit_date DATETIME DEFAULT NULL,
	visible BOOLEAN NOT NULL DEFAULT 0,
	PRIMARY KEY (news_id)
) ENGINE=InnoDB;

CREATE TABLE news_content (
	news_id INT(11) UNSIGNED NOT NULL,
	language_code VARCHAR(10) NOT NULL,
	news_title VARCHAR(255) NOT NULL,
	news_content TEXT NOT NULL,
	PRIMARY KEY (news_id,language_code)
) ENGINE=InnoDB;