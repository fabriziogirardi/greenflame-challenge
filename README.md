## About this application

This application was designed to fulfill a challenge by GreenFlame, in order to continue the process of a job position request. It was build using Laravel 8


## Deployment requirements

- PHP 7.4.19
- MySQL 5.7.24


## Deployment process

- Copy the repository to the public folder inside your web server
- Rename `.env.example` to `.env` then edit the file and set the correct values to the MySQL connection database
- Run the command `composer install` while inside your project's folder
- Run the command `php artisan key:generate` while inside your project's folder
- Run the command `php artisan migrate:fresh --seed` in order to completely run migrations and seed the database with default data
- Run the command `php artisan optimize` to renew the cache and avoid having old cached routes that may conflict with the deployment
- Access the website using you web browser, and login using `admin@example.com` as the user, and `password` as the password
- All done


## Author

All the code inside here, was made by Fabrizio Girardi de Sosa. You are completely free to copy, reproduce, and modify without any consent from me, but please, if you do, give credits.
