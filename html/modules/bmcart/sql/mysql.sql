##
## Group for item
##
CREATE TABLE {prefix}_{dirname}_category (
  `category_id` int(8) unsigned NOT NULL auto_increment,
  `category_name` varchar(255) NOT NULL,
  `parent_id` int(8) unsigned NOT NULL,
  PRIMARY KEY  (`category_id`)
) ENGINE = MYISAM;
##
## Stock
##
CREATE TABLE {prefix}_{dirname}_item (
  `item_id` int(8) unsigned NOT NULL auto_increment,
  `category_id` int(8) unsigned NOT NULL,
  `uid` int(8) unsigned NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_desc` text,
  `barcode` varchar(13),
  `price` decimal(13,2),
  `shipping_fee` decimal(13,2),
  `stock_qty` int(1) unsigned NOT NULL,
  `last_update` int(10) unsigned NOT NULL,
  `publish_date` int(10) unsigned NOT NULL,
  `expire_date` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`item_id`),
  KEY category_id (`category_id`),
  KEY uid (`uid`)
) ENGINE = MYISAM;
##
## Stock Keeping Unit
##
CREATE TABLE {prefix}_{dirname}_itemSku (
  `sku_id` int(8) unsigned NOT NULL auto_increment,
  `item_id` int(8) unsigned NOT NULL,
  `sku_name` varchar(255) NOT NULL,
  `sku_stock` int(1) unsigned NOT NULL,
  PRIMARY KEY  (`sku_id`),
  KEY item_id (`item_id`)
) ENGINE = MYISAM;
##
## Stock
##
CREATE TABLE {prefix}_{dirname}_itemImages (
  `image_id` int(8) unsigned NOT NULL auto_increment,
  `item_id` int(8) unsigned NOT NULL,
  `image_filename` varchar(255),
  `youtube_id` varchar(11),
  `weight` int(8) unsigned NOT NULL,
  PRIMARY KEY  (`image_id`)
) ENGINE = MYISAM;
##
## Cart
## item_status :
##
CREATE TABLE {prefix}_{dirname}_cart (
  `cart_id` int(8) unsigned NOT NULL auto_increment,
  `item_id` int(8) unsigned NOT NULL,
  `sku_id` int(8) unsigned,
  `uid` int(8) unsigned NOT NULL,
  `qty` int(1) unsigned NOT NULL,
  `last_update` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`cart_id`),
  KEY uid (`uid`)
) ENGINE = MYISAM;

##
## ORDER
## order_date = 注文日 / paid_date=入金日 / shipping_date=発送日
## payment_type: 0=not set, 1=by wire(cash), 2=by credit card
## 3=paid 4=shipped
##
CREATE TABLE {prefix}_{dirname}_order (
  `order_id` int(8) unsigned NOT NULL auto_increment,
  `uid` int(8) unsigned NOT NULL,
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `state` varchar(32) NOT NULL,
  `address` varchar(80) NOT NULL,
  `address2` varchar(80) NOT NULL,
  `phone` varchar(14) NOT NULL,
  `payment_type` tinyint(1) unsigned NOT NULL,
  `card_order_id` varchar(14),
  `sub_total` decimal(13,2),
  `tax` decimal(13,2),
  `shipping_fee` decimal(13,2),
  `amount` decimal(13,2),
  `order_date` int(10) unsigned,
  `paid_date` int(10) unsigned,
  `shipping_date` int(10) unsigned,
  `shipping_carrier` varchar(32),
  `shipping_number` varchar(24),
  `shipping_memo` text,
  `notify_date` int(10) unsigned,
  PRIMARY KEY  (`order_id`),
  KEY uid (`uid`)
) ENGINE = MYISAM;
##
## Order Items
##
CREATE TABLE {prefix}_{dirname}_orderItems (
  `orderItem_id` int(8) unsigned NOT NULL auto_increment,
  `order_id` int(8) unsigned NOT NULL,
  `item_id` int(8) unsigned NOT NULL,
  `sku_id` int(8) unsigned,
  `price` decimal(13,2),
  `shipping_fee` decimal(13,2),
  `qty` int(1) unsigned NOT NULL,
  PRIMARY KEY  (`orderItem_id`),
  KEY order_id (`order_id`)
) ENGINE = MYISAM;

##
## Check history
##
CREATE TABLE {prefix}_{dirname}_checkedItems (
  `uid` int(8) unsigned NOT NULL,
  `item_id` int(8) unsigned NOT NULL,
  `category_id` int(8) unsigned NOT NULL,
  `last_update` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`uid`,`item_id`)
) ENGINE = MYISAM;