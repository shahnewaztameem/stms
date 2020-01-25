# STMS
This project is developed using laravel framefork.  A simple task management system.

### Setting up the environment

1.  clone the git
2.  composer update
3.  cp .env.example .env
 ``` In .env you should configure mail infomation for notify client via email ex: use mailtrap ```
4.  php artisan key:generate
5.  Create db and change the credential inside the env file[DB name, Username, password]    
7.  php artisan migrate --seed
    `This will create some dummy users & tasks`
8.  php artisan tinker
9.  App\User::create(['name'=> 'Admin', 'email'=>'admin@stms.com', 'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user_type'=> 0])
    `Login with these credentials Email: admin@stms.com, Password: password` 
10. exit
11. php artisan serve
 
 #### Before notify a client, you should run "pt 12" to get mail

12. php artisan queue:work
   
   `In new terminal for queueing the notifications`
