# About Questionnaire   
It is a technical assessment where admin user can create questionnaire and recorded students will notify through the mail, where students and admin data are seeded on application setup.


# Setup on local machine
#### 1. Clone the main branch from above repository.
#### 2. Make sure that you have ``` node 18.19.1``` ```Composer 2.2.6``` ``` php ^8.2``` and required mysql and other dependencies on your machine.


# Follow below steps on root directory
##### Inside project direcoty we have .env.example create .env from it or ``` cp .env.example .env ``` and update mysql and other relavent information on that newly created .env.
Once our env setup completed run following commands.
```unix
composer install

php artisan key:generate

php artisan migrate:fresh --seed //This will seed our default data

php artisan optimize:clear

php artisan serve

php artisan queue:work //for mail queue
```

  Make sure to update below information in .env file based on your SMTP information to verify mail functionality.
###
```php
MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
```

  ### To run test cases using pest, run below command on root directory

  ```php
  ./vendor/bin/pest
  ```

On the root directory we have notes.text file, where we have some informatin regarding assessment tasks.