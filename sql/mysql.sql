CREATE TABLE `tad_login_random_pass` (
  `uname` varchar(100) NOT NULL,
  `random_pass` varchar(255) NOT NULL,
  PRIMARY KEY (`uname`)
) ENGINE=MyISAM ;

CREATE TABLE `tad_login_config` (
  `config_id` smallint(5) unsigned NOT NULL auto_increment,
  `item` text NOT NULL,
  `group_id` smallint(5) unsigned NOT NULL default 0,
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM ;