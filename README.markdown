SITS: Simple Issue Tracking System
===

SITS is a simple tool for tracking IT issues. There are many great and simple stand-alone bug tracking systems out there but they are geared mostly toward programing projects. It seems that most of the generic IT issue trackers exist as part of larger, more comprehensive infrastructures. SITS is lightweight, simple and generic making it easy to adapt to any setting.

Privacy Modes
---

  * Public Mode 	- all tickets are public and no log in is necessary to view them
  * Private Mode 	- users have to log in to view tickets


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
