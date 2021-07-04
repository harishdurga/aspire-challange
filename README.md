# Simple Loan API

### Steps To Install The Project
1. Clone this repository
2. run `cp cp .env.example .env`
3. Update the database credentials
   ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=aspire
    DB_USERNAME=remoteroot
    DB_PASSWORD=123456
   ``` 
4. run `composer install`
5. run `php artisan key:generate`
6. run `php artisan migrate`
7. run `php artisan serve`


### Authentication
For Authetication *Laravel Sanctum* has been used.

### Request Validation
For most of the post request validation, custom form request classes have been created to keep the controller methods clean.


