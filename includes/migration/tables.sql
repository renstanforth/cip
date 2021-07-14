CREATE TABLE `cip_restaurants` (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  name text NOT NULL,
  image varchar(255) DEFAULT '' NOT NULL,
  PRIMARY KEY  (id)
) __charset_collate__;

CREATE TABLE `cip_products` (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  name varchar(50) NOT NULL,
  price float NOT NULL,
  resto_id int NOT NULL,
  PRIMARY KEY  (id)
) __charset_collate__;

CREATE TABLE `cip_orders` (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  date_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
  client_name varchar(50) NOT NULL,
  prod_id int NOT NULL,
  quantity int NOT NULL,
  resto_id int NOT NULL,
  fees float NOT NULL,
  transfer float NOT NULL,
  PRIMARY KEY  (id)
) __charset_collate__;