Vehicle Rental Management System
Student Name: Prabin Kunwar

Login Credentials

This system does not use a login feature.

Username: Not required
Password: Not required

Setup Instructions

Install XAMPP (or any Apache and MySQL server).

Copy the full project folder into the htdocs directory.

Example:
C:\xampp\htdocs\vehicle_rental

Open phpMyAdmin.

Create a new database named:

vehicle_rental_db

Import the provided SQL file into this database.

Open the file db.php and confirm the database settings:

Host: localhost
Database name: vehicle_rental_db
Username: root
Password: (empty)

Open your web browser and run the project using:

http://localhost/vehicle_rental/public/index.php

List of Features Implemented

Add new vehicles

View all vehicles

Edit vehicle details

Delete vehicles

Book vehicles

Return vehicles

Booking system with availability status

Search vehicles using a normal search page (without Ajax)

Secure database operations using prepared statements

Output escaping to reduce XSS risks

Delete confirmation before removing records

Clean and responsive user interface

Known Issues

The system does not support overlapping or multiple bookings per vehicle.

Availability checking is basic and only uses a simple Available / Rented status.

No user authentication or login system is implemented.

Booking history per user is not maintained.
