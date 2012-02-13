Data Models
===

This directory contains data models that implement CRUD operations for the SITS entities.

Ticket
---

Members:

  * `$data["ticketid"]` (int)
  * `$data["submitted_by"]` (string)
  * `$data["assigned_to"]` (string)
  * `$data["submitted_on"]` (datetime)
  * `$data["subject"]` (string)
  * `$data["resolved"]` (bool)
  * `$data["contact"]` (string)
  * `$data["priority"]` (enum: low, medium, high, critical)
  * `$data["detail"]` (text)
  * `$is_empty` (bool)

Methods:

  * create: `$submitted_by` (string), `$assigned_to` (string), `$subject` (string), `$contact` (string), `$priority` (enum), `$detail` (text)
  * read: `$id` (int)
  * update: no params
  * delete: no params

Comment
---

Members:

  * `$data["commentid"]` (int)
  * `$data["ticketid"]` (int)
  * `$data["submitted_by"]` (string)
  * `$data["submitted_on"]` (datetime)
  * `$data["comment"]` (text)
  * `$is_empty` (bool)


Methods:

  * create: `$ticketid` (int), `$submitted_by` (string), `$comment` (text)
  * populate: `$ticketid` (int), `$submitted_by` (string), `$comment` (text)
  * read: `$id` (int)
  * update: no params
  * delete: no params

