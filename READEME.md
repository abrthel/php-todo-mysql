# MySQLi Assignment - To-Do List
by: Aaron Barthel

Create a To-Do list in PHP using MySQLi.

**Trello Link** [https://trello.com/b/HQ8qQTXG/mysqli-assignment-to-do-list](https://trello.com/b/HQ8qQTXG/mysqli-assignment-to-do-list)

**Unique Feature**

## Installation Instructions
1. Rename config.php.sample to config.php
2. Add in your local database connection information


## Requirements
* Create an ERD of your database
* Create an SQL file to import and create tables/seed any data (An instructor should be able to import your SQL file and be ready to go.) Make sure your .sql file has the name of the database at the top like this:
```sql
--
-- Database: `adventureworks`
--
```
* A task has a due date
* A task has a category
  * In the screenshot above there are two categories, Chores and Homework
* The user is able to add an item to the Active To-Do’s list by using the input field and add button
* The user is able to move an active to-do to the Complete To-Do’s list
* The user should be able to remove a task entirely
* There should be three statuses a task can have:
  * To do - tasks that are not complete and the due date has not passed
  * Overdue - tasks that are not complete and are past the due date
  * Completed - tasks that are complete

## Challenges:
* The ability to add/edit/remove Task Categories
* Styling the project to look nice
* An unexpected feature is present (Make sure you mention what it is in your README.md file.)
