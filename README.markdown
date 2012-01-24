SITS: Simple Issue Tracking System
===

SITS is a simple tool for tracking IT issues. There are many great and simple stand-alone bug tracking systems out there but they are geared mostly toward programing projects. It seems that most of the generic IT issue trackers exist as part of larger, more comprehensive infrastructures. SITS is lightweight, simple and generic making it easy to adapt to any setting.


Configuration
---

To configure your environment use the `config.php` file.

  * `SITS_DB_HOSTNAME`	- the ip or name of the server where the db is located (likely `localhost`)
  * `SITS_DB_NAME`	- the name of the MySQL database. This is usually `sits` unless you changed it
  * `SITS_DB_USER`	- the username you wan to use to access the db (dont' use root)
  * `SITS_DB_PASSWORD`	- the password in plain text
  * `SITS_PUBLIC_MODE`	- set this to false if you want to require users to log in to view tickets


Privacy Modes
---

  * Public Mode 	- all tickets are public and no log in is necessary to view them
  * Private Mode 	- users have to log in to view tickets

Privacy mode can be changed via the `config.php` file.

Implementation Details
===

This info is for those who want to learn more about the code in order to build upon it.

Files
---

  * `config.php`	- the configuration file
  * `user.model.php`	- handles CRUD operations for `sits_user` table
  * `ticket.model.php`	- handles CRUD operations for `sits_ticket` table
  * `comment.model.php`	- handles CRUD operations for `sits_comment` table
  * `tag.model.php`	- handles CRUD operations of `sits_tag` table


User Types
---

  * admin 	- can add new users and create new tags, edit everyone's tickets
  * standard	- can create new tickets and edit their own
  * user	- can only post comments
  * read-only 	- can view tickets in which they are a `contact` if SITS is in Private Mode.

DB Schema
---

**sits_user**

  * `email`		- varchar	unique username PK
  * `password`		- int		hashed password
  * `type`		- enum		admin, standard, user, read-only

**sits_ticket**

  * `ticketid` 		- int		primary key NOT NULL
  * `submitted_by`	- varchar	id of submitter (FK) NOT NULL
  * `assigned_to`	- int		id of the person assigned to the ticket
  * `submitted_on`	- datetime	date and time of submission
  * `subject`		- varchar 	brief description
  * `resolved`		- boolean	whether or not it's resolved
  * `contact`		- varchar	additional contact (cc'd on emails)
  * `priority`		- enum		low, medium, high, critical
  * `detail`		- text		detailed description, steps to reproduce, etc

**sits_comment**

  * `commentid`		- int		primary key
  * `ticketid`		- int		FK for ticket
  * `submitted_by`	- varchar	FK for user who posted the comment
  * `submitted_on`	- datetime	date and time of posting
  * `comment`		- text		text of the comment

**sits_tag**

  * `tagname`		- varchar	primary key
  * `style`		- varchar	visual style attribute for ui

**sits_tagged_tickets**

  * `tagid`		- int		fk for tag
  * `ticketid`		- int		fk for ticket
					PK is both together

Dependencies
---

  * PHP
  * MySQL (or whatever DB is supported by ADatabase module)
  * Web server
