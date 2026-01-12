📘 Documentation
https://filamentphp.com/docs/4.x/getting-started

📌 Project Overview

This demo application is built using Filament PHP and demonstrates the following features:

Post CRUD operations with category-wise filtering

Many-to-many relationship between Posts and Tags

Dependent dropdown module (Country → State → City) implemented in the User module

Dashboard featuring:

Stats (state) widgets

Chart widgets for data visualization

⚙️ Installation & Setup
Step 1: Environment & Database Setup

Configure your database credentials in the .env file

Install dependencies and run migrations:

-> composer install
-> php artisan migrate --seed

Step 2: Run the Application

Start the local development server:

php artisan serve

Step 3: Login Credentials

Use the following credentials to access the Filament Admin Panel:

Email:    test@test.com
Password: Test@123
