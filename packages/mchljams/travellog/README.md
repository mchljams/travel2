# Laravel Travel Log Package

## Installation

0. Add the package as a dependency in the project composer.json

    ```
    "require": {
        ...
        "mchljams/travellog": "dev-master"
    },
    ```
1. In the project composer.json add the repositories key with the following configuration:

    ```
    "repositories": [
        {
            "type": "path",
            "url": "./packages/mchljams/travellog/"
        }
    ],
    ```
2. In the app config/auth.php add the following guards:
    ```
    'admin_web' => [
        'driver' => 'session',
        'provider' => 'admin_users',
    ],

    'admin_api' => [
        'driver' => 'token',
        'provider' => 'admin_users',
        'hash' => false,
    ],
    ```
2. Additionally in the config/auth.php add  the new admin_users provider and change the model for the users provider
    ```
    'users' => [
        'driver' => 'eloquent',
        'model' => Mchljams\TravelLog\Models\User::class,
    ],

    'admin_users' => [
        'driver' => 'eloquent',
        'model' => Mchljams\TravelLog\Models\AdminUser::class,
    ],
    ```
    
## Database 


### Migration

The migrations can be run with the standard artisan command:
``` 
php artisan migrate
``` 

### Seeding 
If you want to seed the database for testing:
```
php artisan db:seed --class=Mchljams\\TravelLog\\Database\\Seeds\\TravelLogDatabaseSeeder
```

## Dependencies 

**darkaonline/l5-swagger package**

This package is dependent on the [darkaonline/l5-swagger package](https://github.com/DarkaOnLine/L5-Swagger). Assets from that 
package, as well as a configuration file must be published in order for the swagger 
documentation feature to work. 

**spatie/laravel-activitylog** 

The activity log uses the [spatie/laravel-activitylog package](https://github.com/spatie/laravel-activitylog). No additional steps 
required to make this functional.

## API Documentation 

The api documentation is auto generated based on the Open API Specification (Swagger). 
You can view the UI documentation by navigating to /api/documentation