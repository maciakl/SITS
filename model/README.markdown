Data Models
===

This directory contains data models that implement CRUD operations for the SITS entities.

TicketModel
---

Extends ***Model***.

### Members:

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

### Public Methods:

  * ***create*** - create a new ticket and write to the db.
  
    * Params:
      * `$submitted_by` (string)
      * `$assigned_to` (string)
      * `$subject` (string)
      * `$contact` (string)
      * `$priority` (enum)
      * `$detail` (text)
  
    * Returns:
      * (int) - the id of the inserted record
  
    * Side Effects:
      * `$this` is populated with the above data, plus current date
  
  * ***read*** - read a ticket record from db 
  
    * Params:
      * `$id` (int)
  
    * Returns:
      * no return value
  
    * Side effects:
      * `$this` is populated with the record from the db

  * ***update*** - update the db with current values
  
    * Params:
      * no params
  
    * Returns:
      * no return value
  
    * Side Effects:
      * writes current values to DB using `$data["ticketid"]` as the PK
  
  * ***delete*** - delete current record from DB
  
    * Params:
      * no params
  
    * Returns:
      * no return value
  
    * Side Effects:
      * deletes current record from DB using `$data["ticketid"]` as the PK

CommentModel
---

Extends ***Model***.

### Members:

  * `$data["commentid"]` (int)
  * `$data["ticketid"]` (int)
  * `$data["submitted_by"]` (string)
  * `$data["submitted_on"]` (datetime)
  * `$data["comment"]` (text)
  * `$is_empty` (bool)


### Public Methods:

  * ***create*** - creates a new comment and writes it into the db
  
    * Params:
      * `$ticketid` (int)
      * `$submitted_by` (string)
      * `$comment` (text)
  
    * Returns:
      * (int) id of the created comment
  
    * Side Effects:
      * `$this` is populated
  
  * ***populate*** -  populates the object without writing to db
  
    * Params:
      * `$ticketid` (int)
      * `$submitted_by` (string)
      * `$comment` (text)
  
    * Returns:
      * no return value
  
    * Side Effects:
      * `$this` is populated
  
  * ***read*** - read a comment record from db 
  
    * Params:
      * `$id` (int)
  
    * Returns:
      * no return value
  
    * Side effects:
      * `$this` is populated with the record from the db

  * ***update*** - update the db with current values
  
    * Params:
      * no params
  
    * Returns:
      * no return value
  
    * Side Effects:
      * writes current values to DB using `$data["commentid"]` as the PK
  
  * ***delete*** - delete current record from DB
  
    * Params:
      * no params
  
    * Returns:
      * no return value
  
    * Side Effects:
      * deletes current record from DB using `$data["commentid"]` as the PK
