<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Nuwave\Lighthouse\Schema\Source\SchemaSourceProvider;
use Nuwave\Lighthouse\Schema\Source\SchemaStitcher;

class SchemaLighthouseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(SchemaSourceProvider::class, function () {
            if (in_array(request()->getHost(), config('tenancy.central_domains'))) {
                return new SchemaStitcher(
                    config('lighthouse.schema.central', '')
                );
            }

            return new SchemaStitcher(
                config('lighthouse.schema.tenant', '')
            );
        });
    }
}
