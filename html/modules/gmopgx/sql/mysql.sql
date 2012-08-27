##
## orderId = YYMMDDHHMMSS-UID
## status = 0: Un paid 1: Paid
##
CREATE TABLE {prefix}_{dirname}_payment (
  `id` int(8) unsigned NOT NULL auto_increment,
  `uid` int(8) unsigned NOT NULL,
  `orderId` varchar(27) NOT NULL,
  `cardSeq` int(8) unsigned NOT NULL,
  `amount` decimal(9,2),
  `tax` decimal(9,2),
  `accessId` varchar(32) NOT NULL,
  `accessPass` varchar(32) NOT NULL,
  `utime` int(10) unsigned NOT NULL,
  `status` int(1) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY uid (`uid`)
) ENGINE = MYISAM ;
