--
-- Create schema sits
--

CREATE DATABASE IF NOT EXISTS sits;
USE sits;


--
-- Definition of table `sits_user`
--

DROP TABLE IF EXISTS `sits_user`;
CREATE TABLE `sits_user` (
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `type` enum('admin','standard','user','read-only') NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Definition of table `sits_ticket`
--

DROP TABLE IF EXISTS `sits_ticket`;
CREATE TABLE `sits_ticket` (
  `ticketid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `submitted_by` varchar(100) NOT NULL,
  `assigned_to` varchar(100) DEFAULT NULL,
  `submitted_on` datetime NOT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `subject` text NOT NULL,
  `detail` text,
  `priority` enum('low','medium','high','critical') DEFAULT 'low',
  `resolved` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ticketid`),
  KEY `FK_sits_ticket_submitted_by` (`submitted_by`),
  KEY `FK_sits_ticket_assigned_to` (`assigned_to`),
  KEY `Index_submitted_on` (`submitted_on`),
  CONSTRAINT `FK_sits_ticket_assigned_to` FOREIGN KEY (`assigned_to`) REFERENCES `sits_user` (`email`),
  CONSTRAINT `FK_sits_ticket_submitted_by` FOREIGN KEY (`submitted_by`) REFERENCES `sits_user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `sits_comment`
--

DROP TABLE IF EXISTS `sits_comment`;
CREATE TABLE `sits_comment` (
  `commentid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ticketid` int(10) unsigned NOT NULL,
  `submitted_by` varchar(100) NOT NULL,
  `submitted_on` datetime NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`commentid`),
  KEY `FK_sits_comment_submitted_by` (`submitted_by`),
  KEY `FK_sits_comment_ticketid` (`ticketid`),
  CONSTRAINT `FK_sits_comment_ticketid` FOREIGN KEY (`ticketid`) REFERENCES `sits_ticket` (`ticketid`),
  CONSTRAINT `FK_sits_comment_submitted_by` FOREIGN KEY (`submitted_by`) REFERENCES `sits_user` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Definition of table `sits_tag`
--

DROP TABLE IF EXISTS `sits_tag`;
CREATE TABLE `sits_tag` (
  `tagname` varchar(45) NOT NULL,
  `style` text,
  PRIMARY KEY (`tagname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Definition of table `sits_tagged_tickets`
--

DROP TABLE IF EXISTS `sits_tagged_tickets`;
CREATE TABLE `sits_tagged_tickets` (
  `tagname` varchar(45) NOT NULL,
  `ticketid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`tagname`,`ticketid`),
  KEY `FK_sits_tagged_tickets_ticketid` (`ticketid`),
  CONSTRAINT `FK_sits_tagged_tickets_ticketid` FOREIGN KEY (`ticketid`) REFERENCES `sits_ticket` (`ticketid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


insert into sits_user values ('admin', 'password', 'admin');

insert into sits_ticket (ticketid, submitted_by, submitted_on, subject, priority, detail) values ('1', 'admin', NOW(), 'TEST', 'low', 'testting testing');

insert into sits_ticket (ticketid, submitted_by, submitted_on, subject, priority, detail) values ('2', 'admin', NOW(), 'TEST2', 'low', 'testting testing 222');


insert into sits_comment (commentid, ticketid, submitted_by, submitted_on, comment) values ('1', '1', 'admin', NOW(), 'this is a test');

insert into sits_tag values('test', 'test');

insert into sits_tagged_tickets values ('test', '1');

