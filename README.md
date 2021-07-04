# Simple Loan API

### Steps To Install The Project
1. Clone this repository
2. run `cp cp .env.example .env`
3. run `composer install`
4. run `php artisan key:generate`
5. run `php artisan migrate`
6. run `php artisan serve`


### Authentication
For Authetication *Laravel Sanctum* has been used.

### Request Validation
For most of the post request validation, custom form request classes have been created to keep the controller methods clean.


