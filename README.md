# Simple Loan API

### Software Version
- Laravel (8.49.1)
- PHP (8.0.5)

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
7. run `php artisan db:seed`(This will add admin user into the users table as the first user) 
8. run `php artisan serve`

### Install And Run Script
After step 3 run `chmod +x install_and_run.sh` and then run `./install_and_run.sh` this perform steps from 4 to 8.

### Authentication
For Authetication *Laravel Sanctum* has been used as it's very easy to implement and suitable for apis.
#### Admin Credentials
**email**:admin@admin.com, **passowrd**:Test@2022

### Request Validation
For most of the post request validation, custom form request classes have been created to keep the controller methods clean.  `FailedValidationJsonResponse` trait has been added to all the custom form requests to be able to send response in json format in case of failed validation.

### Testing
To run tests we can either run `vendor/bin/phpunit` or `php artisan test`

### Approving The Loan
Only with a token that is generated by using the admin credentials one will be able to approve/reject the loan.

### API Resources
Laravel `APIResource` and `ResourceCollection` classes have been used to transform the models and send json response.

### Model Relationships
- `TermLoan` belongs to `User`
- `TermLoan` has many `TermLoanRepayment`
- `TermLoanRepayment` belongs to `TermLoan`

