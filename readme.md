# Ignite 2016

##Info
This webapp allows students to apply for the Ignite mentorship program, and for mentors to rate and interview applicants.

### Prerequisites
* LAMP stack and Composer
  * PHP
  * MySQL
  * Apache/NGINX
  * Composer: [instructions here](https://getcomposer.org/doc/00-intro.md)

###Installation
* Run `composer install`
* Copy `.env.example` to `.env` and configure your MySQL credentials (and create a new database if you haven't already)
  * Create the database. Type the following in your Terminal
     * `mysql -u root -p`
     * `create database ignite;`
* Run `php artisan migrate`
* Run `php artisan db:seed`
* Generate an application key: `php artisan key:generate`

To create an account, go to http://APPLICATION_URL/register
You will need to go into the database to change a user's role to admin.
