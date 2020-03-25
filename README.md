User-Authentication

edit .env.example file and make it as .env
change APP_URL and data base setup
based on your preference

Eg: APP_URL=http://localhost/User-Authentication/public
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=user-authentication   //database name
DB_USERNAME=root                  // username
DB_PASSWORD=password              // password

Commands to be executed:
composer update
php artisan migrate
php artisan key:generate  
php artisan passport:install

In case of Linux giving required permission:
sudo chgrp -R www-data /var/www/User-Authentication
sudo chmod -R 775 /var/www/User-Authentication/storage

API routes are:

// route to login user
Route::post('login', 'UserController@login');
//  route to create a user
fields are => name, email, mobile_number, password, password_confirmation
mobile no. need to be of 10 digits
Route::post('register', 'UserController@register');
// route to get user details based on user id
Route::get('user/{userId}', 'UserController@getUserDetails');

Route::group(['middleware' => 'auth:api'], function()
{
	// route to get logged in user details
   Route::post('details', 'UserController@details');
});