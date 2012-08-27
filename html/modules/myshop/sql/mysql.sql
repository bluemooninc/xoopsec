CREATE TABLE `myshop_manufacturer` (
  `manu_id` int(10) unsigned NOT NULL auto_increment,
  `manu_name` varchar(255) NOT NULL,
  `manu_commercialname` varchar(255) NOT NULL,
  `manu_email` varchar(255) NOT NULL,
  `manu_bio` text NOT NULL,
  `manu_url` varchar(255) NOT NULL,
  `manu_photo1` varchar(255) NOT NULL,
  `manu_photo2` varchar(255) NOT NULL,
  `manu_photo3` varchar(255) NOT NULL,
  `manu_photo4` varchar(255) NOT NULL,
  `manu_photo5` varchar(255) NOT NULL,
  PRIMARY KEY  (`manu_id`),
  KEY `manu_name` (`manu_name`),
  KEY `manu_commercialname` (`manu_commercialname`),
  FULLTEXT KEY `manu_bio` (`manu_bio`)
) ENGINE=MyISAM;


CREATE TABLE `myshop_products` (
  `product_id` int(11) unsigned NOT NULL auto_increment,
  `product_cid` int(5) unsigned NOT NULL default '0',
  `product_title` varchar(255) NOT NULL default '',
  `product_store_id` int(10) unsigned NOT NULL,
  `product_sku` varchar(60) NOT NULL COMMENT 'product sku',
  `product_extraid` varchar(50) NOT NULL,
  `product_width` varchar(50) NOT NULL,
  `product_length` varchar(50) NOT NULL,
  `product_unitmeasure1` varchar(20) NOT NULL,
  `product_url` varchar(255) NOT NULL COMMENT 'URL to external page',
  `product_image_url` varchar(255) NOT NULL COMMENT 'URL of big picture',
  `product_thumb_url` varchar(255) NOT NULL COMMENT 'URL of thumbnail',
  `product_submitter` int(11) unsigned NOT NULL default '0',
  `product_online` tinyint(1) NOT NULL default '0',
  `product_date` varchar(255) NOT NULL COMMENT 'date of product publication',
  `product_submitted` int(10) unsigned NOT NULL default '0' COMMENT 'Date of product publication on site',
  `product_hits` int(11) unsigned NOT NULL default '0' COMMENT 'How many displays of the product page',
  `product_rating` double(6,4) NOT NULL default '0.0000',
  `product_votes` int(11) unsigned NOT NULL default '0',
  `product_comments` int(11) unsigned NOT NULL default '0',
  `product_price` decimal(7,2) NOT NULL,
  `product_shipping_price` decimal(7,2) NOT NULL,
  `product_discount_price` decimal(7,2) NOT NULL,
  `product_stock` mediumint(8) unsigned NOT NULL COMMENT 'Product quantity in stock',
  `product_alert_stock` mediumint(8) unsigned NOT NULL COMMENT 'Product quantity for Stock Alert',
  `product_summary` text NOT NULL,
  `product_description` text NOT NULL,
  `product_attachment` varchar(255) NOT NULL,
  `product_weight` varchar(20) NOT NULL,
  `product_unitmeasure2` varchar(20) NOT NULL,
  `product_vat_id` mediumint(8) unsigned NOT NULL,
  `product_download_url` varchar(255) NOT NULL COMMENT 'URL todownloadthe product',
  `product_recommended` date NOT NULL,
  `product_metakeywords` varchar(255) NOT NULL,
  `product_metadescription` varchar(255) NOT NULL,
  `product_metatitle` varchar(255) NOT NULL,
  `product_delivery_time` mediumint(8) unsigned NOT NULL,
  `product_ecotaxe` decimal(7,2) NOT NULL,
  PRIMARY KEY  (`product_id`),
  KEY `product_cid` (`product_cid`),
  KEY `product_online` (`product_online`),
  KEY `product_title` (`product_title`),
  KEY `product_unitmeasure1` (`product_unitmeasure1`),
  KEY `product_weight` (`product_weight`),
  KEY `product_store_id` (`product_store_id`),
  KEY `product_extraid` (`product_extraid`),
  KEY `product_width` (`product_width`),
  KEY `recent_online` (`product_online`,`product_submitted`),
  KEY `product_recommended` (`product_recommended`),
  FULLTEXT KEY `product_summary` (`product_summary`),
  FULLTEXT KEY `product_description` (`product_description`)
) ENGINE=MyISAM;


CREATE TABLE `myshop_productsmanu` (
  `pm_id` int(10) unsigned NOT NULL auto_increment,
  `pm_product_id` int(10) unsigned NOT NULL,
  `pm_manu_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`pm_id`),
  KEY `pm_product_id` (`pm_product_id`),
  KEY `pm_manu_id` (`pm_manu_id`)
) ENGINE=MyISAM;


CREATE TABLE `myshop_caddy` (
  `caddy_id` int(10) unsigned NOT NULL auto_increment,
  `caddy_product_id` int(10) unsigned NOT NULL,
  `caddy_qte` mediumint(8) unsigned NOT NULL,
  `caddy_price` decimal(7,2) NOT NULL,
  `caddy_cmd_id` int(10) unsigned NOT NULL,
  `caddy_shipping` double(7,2) NOT NULL,
  `caddy_pass` varchar(32) NOT NULL,
  PRIMARY KEY  (`caddy_id`),
  KEY `caddy_cmd_id` (`caddy_cmd_id`),
  KEY `caddy_pass` (`caddy_pass`),
  KEY `caddy_product_id` (`caddy_product_id`)
) ENGINE=MyISAM;


CREATE TABLE `myshop_cat` (
  `cat_cid` int(5) unsigned NOT NULL auto_increment,
  `cat_pid` int(5) unsigned NOT NULL default '0',
  `cat_title` varchar(255) NOT NULL default '',
  `cat_imgurl` varchar(255) NOT NULL default '',
  `cat_description` text NOT NULL,
  `cat_advertisement` text NOT NULL COMMENT 'Category Advertisement',
  `cat_metatitle` varchar(255) NOT NULL,
  `cat_metadescription` varchar(255) NOT NULL,
  `cat_metakeywords` varchar(255) NOT NULL,
  `cat_footer` text NOT NULL,
  PRIMARY KEY  (`cat_cid`),
  KEY `cat_pid` (`cat_pid`),
  FULLTEXT KEY `cat_title` (`cat_title`),
  FULLTEXT KEY `cat_description` (`cat_description`)
) ENGINE=MyISAM ;


CREATE TABLE `myshop_commands` (
  `cmd_id` int(10) unsigned NOT NULL auto_increment,
  `cmd_uid` int(10) unsigned NOT NULL COMMENT 'ID user',
  `cmd_date` date NOT NULL,
  `cmd_state` tinyint(1) unsigned NOT NULL,
  `cmd_ip` varchar(32) NOT NULL,
  `cmd_lastname` varchar(255) NOT NULL,
  `cmd_firstname` varchar(255) NOT NULL,
  `cmd_adress` text NOT NULL,
  `cmd_zip` varchar(30) NOT NULL,
  `cmd_town` varchar(255) NOT NULL,
  `cmd_country` varchar(3) NOT NULL,
  `cmd_telephone` varchar(30) NOT NULL,
  `cmd_email` varchar(255) NOT NULL,
  `cmd_articles_count` mediumint(8) unsigned NOT NULL,
  `cmd_total` double(7,2) NOT NULL,
  `cmd_shipping` decimal(7,2) NOT NULL,
  `cmd_bill` tinyint(1) unsigned NOT NULL default '0' COMMENT 'Customer require a printed invoice ?',
  `cmd_password` varchar(32) NOT NULL COMMENT 'Used to print invoices on line',
  `cmd_text` text NOT NULL,
  `cmd_cancel` varchar(32) NOT NULL,
  PRIMARY KEY  (`cmd_id`),
  KEY `cmd_date` (`cmd_date`),
  KEY `cmd_state` (`cmd_state`),
  KEY `cmd_uid` (`cmd_uid`)
) ENGINE=MyISAM;

CREATE TABLE `myshop_related` (
  `related_id` int(10) unsigned NOT NULL auto_increment,
  `related_product_id` int(10) unsigned NOT NULL COMMENT 'Id of related product ',
  `related_product_related` int(10) unsigned NOT NULL COMMENT 'Id of related product to show',
  PRIMARY KEY  (`related_id`),
  KEY `seealso` (`related_product_id`,`related_product_related`),
  KEY `related_product_id` (`related_product_id`),
  KEY `related_product_related` (`related_product_related`)
) ENGINE=MyISAM;

CREATE TABLE `myshop_vat` (
  `vat_id` mediumint(8) unsigned NOT NULL auto_increment,
  `vat_rate` double(5,2) NOT NULL,
  PRIMARY KEY  (`vat_id`),
  KEY `vat_rate` (`vat_rate`)
) ENGINE=MyISAM;

CREATE TABLE `myshop_votedata` (
  `vote_ratingid` int(11) unsigned NOT NULL auto_increment,
  `vote_product_id` int(11) unsigned NOT NULL default '0',
  `vote_uid` int(11) unsigned NOT NULL default '0',
  `vote_rating` tinyint(3) unsigned NOT NULL default '0',
  `vote_ratinghostname` varchar(60) NOT NULL default '',
  `vote_ratingtimestamp` int(10) NOT NULL default '0',
  PRIMARY KEY  (`vote_ratingid`),
  KEY `vote_ratinguser` (`vote_uid`),
  KEY `vote_ratinghostname` (`vote_ratinghostname`),
  KEY `vote_product_id` (`vote_product_id`)
) ENGINE=MyISAM;

CREATE TABLE `myshop_discounts` (
  `disc_id` int(10) unsigned NOT NULL auto_increment,
  `disc_title` varchar(255) NOT NULL,
  `disc_group` int(10) unsigned NOT NULL COMMENT 'Group reduction (0=All groups)',
  `disc_cat_cid` int(10) unsigned NOT NULL COMMENT 'Category reduction (0=All categories)',
  `disc_store_id` int(10) unsigned NOT NULL COMMENT 'Reduction of Brand products (0=All Brand)',
  `disc_product_id` int(10) unsigned NOT NULL COMMENT 'Product reduction (0=All Products)',
  `disc_price_type` tinyint(1) unsigned NOT NULL COMMENT 'Type of reduction (graduated, amount/percentage)',
  `disc_price_degress_l1qty1` mediumint(8) unsigned NOT NULL,
  `disc_price_degress_l1qty2` mediumint(8) unsigned NOT NULL,
  `disc_price_degress_l1total` decimal(7,2) NOT NULL,
  `disc_price_degress_l2qty1` mediumint(9) NOT NULL,
  `disc_price_degress_l2qty2` mediumint(9) NOT NULL,
  `disc_price_degress_l2total` decimal(7,2) NOT NULL,
  `disc_price_degress_l3qty1` mediumint(9) NOT NULL,
  `disc_price_degress_l3qty2` mediumint(9) NOT NULL,
  `disc_price_degress_l3total` decimal(7,2) NOT NULL,
  `disc_price_degress_l4qty1` mediumint(9) NOT NULL,
  `disc_price_degress_l4qty2` mediumint(9) NOT NULL,
  `disc_price_degress_l4total` decimal(7,2) NOT NULL,
  `disc_price_degress_l5qty1` mediumint(9) NOT NULL,
  `disc_price_degress_l5qty2` mediumint(9) NOT NULL,
  `disc_price_degress_l5total` decimal(7,2) NOT NULL,
  `disc_price_amount_amount` double(7,2) NOT NULL COMMENT 'Amount or percentage of reduction',
  `disc_price_amount_type` tinyint(1) unsigned NOT NULL COMMENT 'percentage or euros ?',
  `disc_price_amount_on` tinyint(1) unsigned NOT NULL COMMENT 'Product or cart ?',
  `disc_price_case` tinyint(1) unsigned NOT NULL COMMENT 'How to apply? All, if it is the first buy',
  `disc_price_case_qty_cond` tinyint(1) NOT NULL COMMENT 'superior, inferior, equal',
  `disc_price_case_qty_value` mediumint(8) NOT NULL COMMENT 'Quantity of product to test',
  `disc_shipping_type` tinyint(1) unsigned NOT NULL,
  `disc_shipping_free_morethan` double(7,2) NOT NULL,
  `disc_shipping_reduce_amount` double(7,2) NOT NULL,
  `disc_shipping_reduce_cartamount` double(7,2) NOT NULL,
  `disc_shipping_degress_l1qty1` mediumint(8) unsigned NOT NULL,
  `disc_shipping_degress_l1qty2` mediumint(8) unsigned NOT NULL,
  `disc_shipping_degress_l1total` double(7,2) NOT NULL,
  `disc_shipping_degress_l2qty1` mediumint(8) unsigned NOT NULL,
  `disc_shipping_degress_l2qty2` mediumint(8) unsigned NOT NULL,
  `disc_shipping_degress_l2total` double(7,2) NOT NULL,
  `disc_shipping_degress_l3qty1` mediumint(8) unsigned NOT NULL,
  `disc_shipping_degress_l3qty2` mediumint(8) unsigned NOT NULL,
  `disc_shipping_degress_l3total` double(7,2) NOT NULL,
  `disc_shipping_degress_l4qty1` mediumint(8) unsigned NOT NULL,
  `disc_shipping_degress_l4qty2` mediumint(8) unsigned NOT NULL,
  `disc_shipping_degress_l4total` double(7,2) NOT NULL,
  `disc_shipping_degress_l5qty1` mediumint(8) unsigned NOT NULL,
  `disc_shipping_degress_l5qty2` mediumint(8) unsigned NOT NULL,
  `disc_shipping_degress_l5total` double(7,2) NOT NULL,
  `disc_date_from` int(10) unsigned NOT NULL COMMENT 'Starting date of the promo',
  `disc_date_to` int(10) unsigned NOT NULL COMMENT 'End date of the promo',
  `disc_description` text NOT NULL,


  PRIMARY KEY  (`disc_id`),
  KEY `disc_group` (`disc_group`),
  KEY `disc_title` (`disc_title`),
  KEY `disc_price_type` (`disc_price_type`),
  KEY `disc_price_case` (`disc_price_case`),
  KEY `disc_date` (`disc_date_from`,`disc_date_to`),
  KEY `disc_shipping_type` (`disc_shipping_type`)
) ENGINE=MyISAM;


CREATE TABLE `myshop_stores` (
  `store_id` int(10) unsigned NOT NULL auto_increment,
  `store_name` varchar(150) NOT NULL,
  PRIMARY KEY  (`store_id`),
  KEY `store_name` (`store_name`)
) ENGINE=MyISAM;

CREATE TABLE `myshop_files` (
  `file_id` int(10) unsigned NOT NULL auto_increment,
  `file_product_id` int(10) unsigned NOT NULL,
  `file_filename` varchar(255) NOT NULL,
  `file_description` varchar(255) NOT NULL,
  `file_mimetype` varchar(255) NOT NULL,
  PRIMARY KEY  (`file_id`),
  KEY `file_product_id` (`file_product_id`),
  KEY `file_filename` (`file_filename`),
  KEY `file_description` (`file_description`)
) ENGINE=InnoDB;

CREATE TABLE `myshop_persistent_cart` (
  `persistent_id` int(10) unsigned NOT NULL auto_increment,
  `persistent_product_id` int(10) unsigned NOT NULL,
  `persistent_uid` mediumint(8) unsigned NOT NULL,
  `persistent_date` int(10) unsigned NOT NULL,
  `persistent_qty` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`persistent_id`),
  KEY `persistent_product_id` (`persistent_product_id`),
  KEY `persistent_uid` (`persistent_uid`),
  KEY `persistent_date` (`persistent_date`)
) ENGINE=InnoDB;
