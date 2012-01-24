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

  * **Public Mode** 	- all tickets are public and no log in is necessary to view them
  * **Private Mode** 	- users have to log in to view tickets

Privacy mode can be changed via the `config.php` file.

User Types
---

  * **admin**	 	- can add new users and create new tags, edit everyone's tickets
  * **standard**	- can create new tickets and edit their own
  * **user**		- can only post comments
  * **read-only** 	- can view tickets in which they are a `contact` if SITS is in Private Mode.

Implementation Details
===

This info is for those who want to learn more about the code in order to build upon it.

Files
---

  * `/config.php`	- the configuration file. Defines bunch of constants. Here is where you configure DB info, and enable Pirvate Mode.
  * `/model/model.php`		- abstract class defining CRUD operations for all `/model/*.model.php` files
  * `/model/user.model.php`	- extends `/model/model.php`; handles CRUD operations for `sits_user` table
  * `/model/ticket.model.php`	- extends `/model/model.php`; handles CRUD operations for `sits_ticket` table
  * `/model/comment.model.php`	- extends `/model/model.php`; handles CRUD operations for `sits_comment` table
  * `/model/tag.model.php`	- extends `/model/model.php`; handles CRUD operations of `sits_tag` table
  * `/model/tagged.model.php`	- extends `model/model.php`; handles CRUD operations of `sits_tagged_tickets` table

Building the DB Schema
---

The file `/sql/mysql_create_tables.sql` contains the SQL code necessary to build these tables for you for a MySQL database. To import it to your db use:

```tcsh
cd sql
mysql -u root -p < mysql_create_tables.sql
```

DB Structure
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
  * Web server (Apache, IIS, whatever)
  * The [ADatabase module](https://github.com/maciakl/ADatabase).
