SITS: Simple Issue Tracking System
===

SITS is a simple tool for tracking IT issues. There are many great and simple stand-alone bug tracking systems out there but they are geared mostly toward programing projects. It seems that most of the generic IT issue trackers exist as part of larger, more comprehensive infrastructures. SITS is lightweight, simple and generic making it easy to adapt to any setting.

DB Schema
---

*Ticket*

  * `ticketid` 		- int		primary key NOT NULL
  * `submitted_by`	- int		id of submitter (FK) NOT NULL
  * `assigned_to`	- int		id of the person assigned to the ticket
  * `submitted_on`	- datetime	date and time of submission
  * `subject`		- varchar 	brief description
  * `resolved`		- boolean	whether or not it's resolved
  * `contact`		- varchar	additional contact (cc'd on emails)
  * `priority`		- enum		low, medium, high, critical
  * `detail`		- text		detailed description, steps to reproduce, etc

*Comment*

  * `commentid`		- int		primary key
  * `ticketid`		- int		FK for ticket
  * `submitted_by`	- int		FK for user who posted the comment
  * `submitted_on`	- datetime	date and time of posting
  * `comment`		- text		text of the comment

*Tag*

  * `tagid`		- int		primary key
  * `name`		- varchar	name of the tag
  * `style`		- varchar	visual style attribute for ui

*TaggedTickets*

  * `tagid`		- int		fk for tag
  * `ticketid`		- int		fk for ticket
					PK is both together
