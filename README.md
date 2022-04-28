# AdminR v0.2.0

<p align="center">
<a href="https://travis-ci.org/thedevsbuddy/laravel-adminr"><img src="https://travis-ci.org/thedevsbuddy/laravel-adminr.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/thedevsbuddy/laravel-adminr"><img src="https://img.shields.io/packagist/dt/thedevsbuddy/laravel-adminr" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/thedevsbuddy/laravel-adminr"><img src="https://img.shields.io/packagist/v/thedevsbuddy/laravel-adminr" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/thedevsbuddy/laravel-adminr"><img src="https://img.shields.io/packagist/l/thedevsbuddy/laravel-adminr" alt="License"></a>
</p>

## About AdminR
 
AdminR is a simple admin panel built on top of [Laravel Framework](https://laravel.com) to help developers create laravel backend and APIs with ease so they can more focus on creating actual web app or any client side apps.

AdminR help to reduce approx 90% of the work for developers which they do to build a backend or admin panel and the APIs for their apps.

### Support me to add more feature
<center>
<a href="https://www.buymeacoffee.com/devsbuddy" target="_blank">
<img src="https://www.buymeacoffee.com/assets/img/guidelines/download-assets-2.svg"/>
</a>
</center>


#### When I will reach to ```$1000``` I will add relationship generator to the project.

| Goal  | Reached |
|-------|-------|
| $1000 | $0 |

## Get Started

Install the project
```bash
composer create-project thedevsbuddy/adminr <your-app-name>
```

Generate app key
```bash
php artisan key:generate
```

Setup / update database connection
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adminr
DB_USERNAME=root
DB_PASSWORD=secret
```

Migrate database and seed demo data
```bash
php artisan migrate --seed
```

Link storage folder
```bash
php artisan storage:link
```

By default you will get ```4``` users and role
```text
Developer (developer)
email: dev@adminr.com
pwd: password 

Super admin (super.admin)
email: super.admin@adminr.com
pwd: password 

Admin (admin)
email: admin@adminr.com
pwd: password

User (user)
email: user@adminr.com
pwd: password
```



That's it your project setup is completed.

Happy coding.

### Special thanks to
#### CoreUI
For the admin panel UI we have used [coreui](https://coreui.io) which is an awesome admin template out there.


## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Devsbuddy via [adminr@devsbuddy.com](mailto:adminr@devsbuddy.com). All security vulnerabilities will be promptly addressed.

## License

The AdminR is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
