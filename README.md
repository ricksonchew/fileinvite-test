**API:**
* PHP 8++
* Laravel 9++
* Composer 2
* MySQL 8

**APP:**
* NPM

**NGINX setup with SSL:**

Set API server name to: https://api.fileinvite-test-local.com/

Set APP server name to: https://app.fileinvite-test-local.com/

Once you have set the API, please run the following commands:
* composer install
* php artisan migrate
* php artisan passport:install
* php artisan db:seed --class=RolesAndPermissionsSeeder
* php artisan db:seed --class=MeetingRoomsSeeder
* php artisan db:seed --class=TestDataSeeder

For the APP, please run the following commands:
* npm install
* npm run dev