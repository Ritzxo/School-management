# School Management System

A university coursework project built with PHP, MySQL, HTML, CSS and JavaScript. The application brings pupil, class, parent, staff, library and dinner money records together in a browser interface.

I built the frontend, backend and relational database while learning PHP. The project helped me practise connecting forms to database operations and working with related records. All included school data is simulated.

## Features

* Pages for managing pupils, classes, parents, teachers and teaching assistants.
* Dinner money records with amounts and payment dates.
* Library book records linked to pupils.
* Forms and tables for adding, viewing, editing and deleting records across the application.
* Database populated dropdowns for selecting existing IDs.
* A pupil and parent junction table to represent a many-to-many relationship.
* Foreign key constraints to maintain relationships between records.
* Prepared statements in several handlers, including dinner money insertion.
* A Bootstrap interface and a demonstration login page.

## Technologies

* PHP with MySQLi for backend database access.
* MySQL or MariaDB for the relational database.
* HTML, CSS, JavaScript and Bootstrap 5 for the interface.
* phpMyAdmin for importing the supplied database export.

## Running locally

These instructions describe the intended local setup. The current upload has the limitations listed below and has not been verified end to end in a clean environment.

1. Install a local PHP and database environment, such as XAMPP, with the MySQLi extension enabled.
2. Download or clone this repository.
3. Place the project files in a folder named `School-management` inside your web server's document root. For a typical Windows XAMPP installation, this is `C:\xampp\htdocs\School-management`.
4. Start Apache and the database service.
5. Open phpMyAdmin and create an empty database named `school management`, including the space.
6. Select that database and import `school_management (1).sql`. The export contains the tables, sample records, indexes and foreign key constraints. It does not create the database itself.
7. Check the connection settings in the PHP files. The current code uses `localhost`, user `root`, an empty password and database `school management`. If your local credentials differ, update the connections before running the application.
8. Open `http://localhost/School-management/login.html` through the local web server.

The demonstration login uses username `admin` and password `password123`. These are public demo values checked in browser JavaScript, not secure authentication. Keep this version local and use simulated data.

Bootstrap and some icons load from external CDNs, so an internet connection is needed for those assets.

## Database design

The supplied export contains eight tables:

* `classes`
* `pupils`
* `parents_guardians`
* `pupils_parents`
* `teachers`
* `teaching assistants`
* `dinner_money`
* `library_books`

Pupils link to classes. Dinner money and library records link to pupils. The `pupils_parents` table connects pupils with parents or guardians. Teachers and teaching assistants also link to classes.

The export uses cascading deletes and updates on its foreign keys. Deleting a class or pupil can therefore also remove related records.

## What I learned

* Translating a school management scenario into related database tables.
* Using primary keys, foreign keys and a junction table.
* Connecting PHP forms to SQL queries and displaying results.
* Using dropdowns to reduce manual ID entry mistakes.
* Working through unfamiliar PHP syntax while implementing application logic.

## Current limitations and improvements

This is an academic learning project, not a production school system.

* The active login uses JavaScript and browser session storage. Protected pages and actions need consistent server-side authentication and authorisation.
* `Authenticate.php` is separate from the active login flow. It references a `users` table absent from the SQL export and redirects to `dashboard.php` and `login.php`, which are not included.
* `add_dinner_money.php` redirects to `dinner_money.php`, but the uploaded page is named `Dinner_money.php`. This needs consistent casing on case-sensitive systems.
* Prepared statements and input validation need to be applied consistently throughout the application.
* Delete actions need POST requests and CSRF protection.
* Database connections are repeated across files and should be moved into shared configuration.
* Dinner money amounts are currently whole numbers. Library issue and return dates are stored as integers in the export and need proper date fields.
* Automated tests and screenshots are future improvements.

## Author

Kaif Abdullah Channa
