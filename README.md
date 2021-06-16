### Routes:
./routes is the folder where files like api.php and web.php are.
In these files you can register the routes like the following:

- Directly using functions: <code>Route::get('heartbeat',function (){echo 'Up and running';});</code>
- Using Controllers function: <code>Route::get('heartbeat',[ControllerClassName::class,"method of this class to be called"]);</code>

### Controllers:
./app/Http is the folder that contains controllers.

### PHP Artisan:
- Create controller: <code>php artisan make:controller ControllerName</code>
# laravel_guidelines_project
