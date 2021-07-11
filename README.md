

# Aspire mini app API

## Prerequisites

1. Composer 
2. PHP 7+


## Setup

1. Clone This Repo
2. cd `aspire-api` and then run `composer install` 
3. create `.env` from `.env_sample` 
4. Create database with name `aspire` in `localhost/phpmyadmin`
5. Set `DB_DATABASE=`, `DB_PORT=`  in `.env`
6. `php artisan migrate`
7. `php artisan passport:install`
8. Now open `storage/oauth-private.key` and open `storage/oauth-public.key` and pasted it in `.env` as below

`PASSPORT_PRIVATE_KEY="content of oauth-private.key"`

`PASSPORT_PUBLIC_KEY="content of oauth-public.key"`

9. Check .env_sample for reference
10. run `php artisan serve`

11. Check the endpoint in postman
 http://127.0.0.1:8000/api/register (name,email,password)
 http://127.0.0.1:8000/api/login (email,password)
 http://127.0.0.1:8000/api/apply-loan (amount,term)
 http://127.0.0.1:8000/api/accept-loan (loan_id)
 http://127.0.0.1:8000/api/loan-repayment-amount/1
 http://127.0.0.1:8000/api/loan-repayment (loan_id,amount)



```

## Tests

Testing is done using the built in Laravel Testing Suite, which is built on top of PHPUnit:

* https://laravel.com/docs/7.x/testing
* https://laravel.com/docs/7.x/http-tests

* Run `php artisan test` to execute full test suite

