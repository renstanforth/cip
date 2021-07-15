CREATE TABLE `cip_restaurants` (
  `id` mediumint(9) NOT NULL,
  `time` timestamp NULL DEFAULT current_timestamp(),
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY  (id)
) __charset_collate__;

CREATE TABLE `cip_products` (
  `id` mediumint(9) NOT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp(),
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` float NOT NULL,
  `resto_id` int(11) NOT NULL,
  PRIMARY KEY  (id)
) __charset_collate__;

CREATE TABLE `cip_orders` (
  `id` mediumint(9) NOT NULL,
  `date_created` timestamp NULL DEFAULT current_timestamp(),
  `prod_id` int(11) NOT NULL,
  `resto_id` int(11) NOT NULL,
  `fees` float NOT NULL,
  `transfer` float NOT NULL,
  `client_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` float NOT NULL,
  PRIMARY KEY  (id)
) __charset_collate__;