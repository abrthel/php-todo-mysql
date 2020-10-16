--
-- Database todos
--

DROP DATABASE IF EXISTS todos;
CREATE DATABASE todos;
USE todos;

CREATE TABLE categories(
  category_id int NOT NULL AUTO_INCREMENT,
  category varchar(30) NOT NULL,

  PRIMARY KEY(category_id)
);

CREATE TABLE  entries (
  entry_id int NOT NULL AUTO_INCREMENT,
  category_id int NOT NULL,
  date_due date NOT NULL,
  date_completed date DEFAULT NULL,
  description varchar(40) NOT NULL,

  PRIMARY KEY (entry_id)
);

ALTER TABLE entries ADD CONSTRAINT fk_entries_categories FOREIGN KEY (category_id) REFERENCES categories(category_id);

INSERT INTO categories (category)
VALUES
  ('Chores'),
  ('Homework');

INSERT INTO entries (category_id, date_due, date_completed, description)
VALUES
  (1, '2020-10-10', NULL, 'Change over to winter tires'),
  (2, '2020-11-28', NULL, 'Complete Milestone 3'),
  (2, '2020-10-16', '2020-10-16', 'Complete MySqli Assignment');
