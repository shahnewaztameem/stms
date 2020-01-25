# STMS
This project is developed using laravel framefork.  A simple task management system.

### Setting up the environment

1.  clone the git
2.  composer update
3.  cp .env.example .env
 ` In .env you should configure mail infomation for notify client via email ex: use mailtrap `
4.  php artisan key:generate
5.  Create db and change the credential inside the env file[DB name, Username, password]    
6.  php artisan migrate --seed
    `This will create some dummy users & tasks`
7.  php artisan tinker
8.  App\User::create(['name'=> 'Admin', 'email'=>'admin@stms.com', 'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user_type'=> 0])
    `Login with these credentials Email: admin@stms.com, Password: password` 

9. exit

10. php artisan serve
 
 #### Before notify a client, you should run "pt 11" to get mail

11. php artisan queue:work
   
   `In new terminal for queueing the notifications`
