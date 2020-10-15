<?php

namespace Shonen\Genesis;

use Illuminate\Support\ServiceProvider;
use Shonen\Genesis\Commands\PublicAll;

class GenesisServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                PublicAll::class,
            ]);
        }

        $this->publishes([
            __DIR__ . '/assets/Abstracts' => base_path('app/Abstracts'),
        ], 'genesis-abstracts');

        $this->publishes([
            __DIR__ . '/assets/Config' => base_path('config'),
        ], 'genesis-config');

        $this->publishes([
            __DIR__ . '/assets/Dtos' => base_path('app/Dtos'),
        ], 'genesis-dtos');

        $this->publishes([
            __DIR__ . '/assets/Exceptions' => base_path('app/Exceptions'),
        ], 'genesis-exceptions');

        $this->publishes([
            __DIR__ . '/assets/Middleware' => base_path('app/Http/Middleware'),
        ], 'genesis-middlewares');

        $this->publishes([
            __DIR__ . '/assets/migrations' => database_path('migrations'),
        ], 'genesis-migrations');

        $this->publishes([
            __DIR__ . '/assets/Models' => base_path('app/Models'),
        ], 'genesis-models');

        $this->publishes([
            __DIR__ . '/assets/Observers' => base_path('app/Observers'),
        ], 'genesis-observers');

        $this->publishes([
            __DIR__ . '/assets/Providers' => base_path('app/Providers'),
        ], 'genesis-providers');
        $this->publishes([
            __DIR__ . '/assets/Resolvers' => base_path('app/Resolvers'),
        ], 'genesis-resolvers');

        $this->publishes([
            __DIR__ . '/assets/Schemas' => base_path('graphql'),
        ], 'genesis-schemas');

        $this->publishes([
            __DIR__ . '/assets/UseCases' => base_path('app/UseCases'),
        ], 'genesis-useCases');
    }
}
