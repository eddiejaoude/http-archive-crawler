CREATE TABLE `urls` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `url` varchar(128) DEFAULT NULL,
  `depth` int(11) unsigned DEFAULT NULL,
  `limit` int(11) unsigned DEFAULT NULL,
  `spider_id` varchar(128) DEFAULT NULL,
  `queued` int(11) unsigned DEFAULT NULL,
  `skipped` int(11) unsigned DEFAULT NULL,
  `failed` int(11) unsigned DEFAULT NULL,
  `crawl_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `crawl_end` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1
