# STMS
This project is developed using laravel framefork.  A simple task management system.

### Setting up the environment

1.  clone the git
2.  composer update
3.  cp .env.example .env
4.  php artisan key:generate
5.  Create db and change the credential inside the env file[DB name, Username, password]    
7.  php artisan migrate --seed
    `This will create some dummy users & tasks`
8.  php artisan tinker
9.  App\User::create(['name'=> 'Admin', 'email'=>'admin@stms.com', 'password'=>'password', 'user_type'=> 0])
    `Login with these credentials` 

