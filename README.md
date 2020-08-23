# pic_sharing_social_media
This is an API for the backend of a picture sharing social media

0) composer install

1) Create a schema (DB) on your MySQL.

2) rename .env.example to .env

3) add you DB name and credentials

4) php artisan migrate

5) check api.php file for routes


Note: For each API call check methods Validations for required params. Also don't forget to add the Authorization as key and bearer JWT key you get from login.
