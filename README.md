# Basic Login & Registration 
This project implements a simple login and registration system with basic security using PHP and MySQL. 

## Requirements

* A web server environment (e.g., XAMPP, WAMP, MAMP, or a live server).
* PHP
* MySQL

XAMPP is recommended for local development as it includes PHP, MySQL, Apache, and phpMyAdmin.

## Database Setup

1.  **Create a Database:**
    * Open phpMyAdmin or your preferred MySQL management tool.
    * Create a new database. The article uses the name `phplogin`.
    * Choose `utf8mb4_unicode_ci` as the collation.

2.  **Create `users` Table:**
    Execute the following SQL query in your `users` database:
    ``` CREATE TABLE `users` (  `id` int(5) NOT NULL,
      `username` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `password` varchar(255) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
    ```
  
