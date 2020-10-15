# Genesis

 Basic setup for multitenancy projects using passport and graphql

## Dependencies
  - laravel/passport : "^9.3"
  - laravel/framework: "^7.0",
  - laravel/ui: "^2.1",
  - mll-lab/laravel-graphql-playground: "^2.3",
  - nuwave/lighthouse: "^4.16",
  - stancl/tenancy: "^3.1"

## Instalation

```bash
composer require shonen/genesis
```

## Quickstart guide

To publish all files run the command :

```bash
php artisan genesis:public
```

Then, you have to include the providers in your `config/app.php` file

```php
'providers' => [
    ...,
    App\Providers\SchemaLighthouseServiceProvider::class,
    App\Providers\TenancyServiceProvider::class,
]
```

After that, you have to register universal routes for passport in `app/Http/Kernel.php` file

```php
protected $middlewareGroups = [
        ...
        ,
        'universal' => [],
    ];
```

Moreover, you have to add your guard in `config/auth.php` file

```php
    'guards' => [
        ...
        'api' => [  //central
            'driver' => 'passport',
            'provider' => 'users',
            'hash' => false,
        ],
        'tenant' => [
            'driver' => 'passport',
            'provider' => 'tenantUsers',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\Central\User::class,
        ],
        'tenantUsers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Tenant\User::class,
        ]
    ],
```

Furthermore, you have to add in `app/Providers/AppServiceProvider` file

```php
    use App\Models\Central\Tenant;
    use App\Observers\Central\TenantObserver;
    use Laravel\Passport\Passport;
    use Laravel\Passport\Console\ClientCommand;
    use Laravel\Passport\Console\InstallCommand;
    use Laravel\Passport\Console\KeysCommand;
    ...
    public function register()
    {
        Passport::ignoreMigrations();
        Passport::routes(null, ['middleware' => 'universal']);
    }

    public function boot()
    {
        Tenant::observe(TenantObserver::class);

        $this->commands([
            InstallCommand::class,
            ClientCommand::class,
            KeysCommand::class,
        ]);
    }
```

Finally,  you have to change your central domain in `config.tenancy.php` file

```php
    'central_domains' => [
        'test', // your central domain here...
    ],
```