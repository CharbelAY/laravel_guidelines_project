### Routes:
./routes is the folder where files like api.php and web.php are.
In these files you can register the routes like the following:

- Directly using functions: <code>Route::get('heartbeat',function (){echo 'Up and running';});</code>
- Using Controllers function: <code>Route::get('heartbeat',[ControllerClassName::class,"method of this class to be called"]);</code>
- Using apiResource to replace all 5 crud operations routes in one route only
    - <code>Route::apiResource("users",UserController::class);</code> is equivalent to
    - <code>Route::get('users',[UserController::class,'index']); Route::get('users/{id}',[UserController::class,'show']); Route::post('users',[UserController::class,'store']); Route::put('users/{id}',[UserController::class,'update']); Route::delete('users/{id}',[UserController::class,'destroy']);</code>

### Controllers: (UserController)
./app/Http is the folder that contains controllers.

### Models: (User)
./app/models folder contains models that are responsible for representing the data
- <code>protected $fillable = ['property1','property2'];</code>
    - is used to define which properties can be filled directly by the user request 
    because by default all properties are guarded to avoid mass assignment attacks 
    a user can for example send a request where user_admin is 1 giving himself an unwanted privilege.
    fillable tells laravel it is okay to let the user insert in this column
    - the opposite of fillable is guarded. Guarded can be used as well. the stuff not present in guarded are present in fillable
    - both guarded and fillable can be used at the same time
- <code>protected $hidden = ['password','remember_token'];</code>
    - hidden is used to tell laravel that these properties are not to be seen by the user at anypoint.
- 

### Migrations:
./database/migrations is the folder that holds the migrations
A migration file has a format of date_number_create_something_table
- Id: <code>$table->id();</code>
- strings: <code>$table->string("column_name");</code>
- timestamps: this gives created_at and updated_at <code>$table->timestamps();</code>

### Seeders: (UserSeeder)
./database/seeders is the folder that contains seeders.
seeders populate tables by runing inside of them factories.
- <code>User::factory()->count(20)->create();</code>
all seeders classes can be called in DatabaseSeeder.php where we do 
- <code>$this->call(SomethinSeeder::class);</code>

### Factories: (UserFactory)
./database/factories folder contains factories responsible for containing
the logic of populating one table of the database. They are run inside seeders.
- <code>'first_name' => $this->faker->firstName()</code>
- <code>'last_name' => $this->faker->lastName()</code>
- <code>'email' => $this->faker->unique()->safeEmail()</code>
- <code>'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password</code>

### Environment variables:
.env is the file where environment variables are stored
like database variables
- Database:
    - DB_CONNECTION=mysql
    - DB_HOST=db
    - DB_PORT=3306
    - DB_DATABASE=admin
    - DB_USERNAME=root
    - DB_PASSWORD=root

### REST API:
A rest api has usually 5 methods for controlling data.
We can register them in the ./routes folder in the api.php file like the following.
- <code>Route::get('users',[UserController::class,'index']);</code>
- <code>Route::get('users/{id}',[UserController::class,'show']);</code>
- <code>Route::post('users',[UserController::class,'store']);</code>
- <code>Route::put('users/{id}',[UserController::class,'update']);</code>
- <code>Route::delete('users/{id}',[UserController::class,'destroy']);</code>

index shows all the data of a table
show shows one item of the table
store will create a new item in the table
update will update an existing item in the table
destroy will delete an item in the table

### Eloquent:
eloquent is an ORM object-relational mapper that allows to interact with the database using the model classes
- <code>User::all()</code> gets all users
- <code>User::find($id)</code> returns a user matching the given id
- <code>User::create()</code> 
    - can take $request->all(). 
    - or an array like: ['username'=>$request->input('username'),'last_name'=>'example'']
- <code>$user->update()</code>
    - can take an array like ['username'=>$request->input('username'),'last_name'=>'example'']
- <code>User::destroy($id);</code> delete item
- <code>$modelClass::paginate()</code>
    - This will paginate the results for index action for example.
    in the url we can add query params and paginate() will take care of them 
    ex. localhost:8000/api/users?page=2 here we indicate that page returned should be page 2 

### Default Request:
is a class responsible of giving request information
- <code>$request->all()</code> returns an array containing the data sent to the server 
- <code>$request->input('input_name'')</code> returns a specific output from the request

### Response:
is a class responsible of creating responses
The Response class has constants resolving to numbers signifying the status code of the response
an example is Response::HTTP_CREATED for 201
- <code>response($data_to_pass,Response::HTTP_CREATED);</code>

### Custom Request: (ModelNameActionRequest ex UserCreateRequest)
./app/Http/Requests folder contains the custom request classes
these classes control the rules. rules that define a valid request or no
if a request to add a user is sent and UserRequest defines that first_name is required
and first_name is not provided then the request is a bad request.
If the request is wrong an automatic error message will be sent.
like the following <code>{"message": "The given data was invalid.","errors": {"email": ["The email must be a valid email address."]}}</code>
- rules
    - required ex. <code>'first_name'=>'required'</code>
    - email ex. <code>'email'=>'email'</code>
    - same as another field ex. repeat_password <code>'repeat_password'=>'require|same:password'</code>
    - Operations:
        - combining rules (and) ex. <code>'email'=>'email|required'</code>
- functions:
    - <code>$request->only(array_containing_strings)</code> ex. array_containing_strings=['first_name','last_name']
    - <code>public function rules(){return [rules go here]}</code>

### PHP Artisan:
- Create controller: <code>php artisan make:controller ControllerName</code>
- migrate database: <code>php artisan migrate</code>
- creating a table seeder: <code>php artisan make:seeder tablename_seeder</code>
- running all seeders: <code>php artisan db:seed</code>
- list all routes registered in app: <code>php artisan route:list</code>
- creating a request: <code>php artisan make:request RequestName</code>

### Hashing:
a class called Hash can help to has things like a password
- <code>Hash::make($password)</code>

### Laravel Passport
is a package for handling user authentication
- Installation:
    - <code>composer require laravel/passport </code>
    - <code>php artisan migrate</code> to migrate the new tables that we get with passport installation
    - <code> php artisan passport:install </code> to generate keys 
    - Go to user model and add <code>use HasApiTokens</code> 
    - Go to ./app/Providers/AppServiceProvider and add in boot function <code>Passport::routes()</code> to register passport routes
    - Go to ./config/auth.php in guards --> api change driver from token to passport
    - create an AuthController using artisan 

### Authentication:
- Passport:
    - <code>Auth::attempt($request->only('email','password'))</code> step one to attempt and authenticate the user
    - <code>$user = Auth::user();\
    $token = $user->createToken('admin')->accessToken;\
    return [
         'token'=>$token,
         ];
    </code> Step 2 the if step one succeeds get the user create a token for him and send it back
### Responses codes:
- Created <code>Response::HTTP_CREATED</code> 201
- Updated <code>Response::HTTP_ACCEPTED</code> 202
- Deleted <code>Response::HTTP_NO_CONTENT</code> 204
- Unauthorized <code>Response::HTTP_UNAUTHORIZED</code> 401

### Middleware:
Are like layers they run before a certain action is done Middlewares can be like:
    - Authentication (check protecting routes section)

### Protecting routes: 
You can put routes under the same group protected by a middleware as follows
- <code>Route::group(['middleware'=>'auth:api'],function (){ \
            Route::apiResource("users",UserController::class);\
        });
  </code>
### IDE Helper:
this is useful to use because sometimes the ide does not recognise some functions of laravel
and highlights them in an annoying way.
- Steps:
    - <code>composer require --dev barryvdh/laravel-ide-helper</code>
    - <code>php artisan ide:generate</code> this will create a helper file in root directory
    called _ide_helper.php 
    - <code>php artisan ide:models</code> to create models helpers 
    - answer by no to insert the code in the _ide_helper_models file if you say yes it will be in the models class
    
