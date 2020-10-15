<?php

namespace Shonen\Genesis\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class PublicAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'genesis:public';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish all files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call(' vendor:publish --tag=genesis-abstracts');
        $this->info('Abstracts files were published in /app/Abstracts');

        Artisan::call(' vendor:publish --tag=genesis-config');
        $this->info('Config files were published in /config');

        Artisan::call(' vendor:publish --tag=genesis-dtos');
        $this->info('Dtos files were published in /app/Dtos');

        Artisan::call(' vendor:publish --tag=genesis-exceptions');
        $this->info('Exceptions files were published in /app/Exceptions');

        Artisan::call(' vendor:publish --tag=genesis-middlewares');
        $this->info('Middleware files were published in /app/Http/Middleware');

        Artisan::call(' vendor:publish --tag=genesis-migrations');
        $this->info('Migration files were published in /database/migrations');

        Artisan::call(' vendor:publish --tag=genesis-models');
        $this->info('Model files were published in /app/Models');

        Artisan::call(' vendor:publish --tag=genesis-observers');
        $this->info('Observers files were published in /app/Observers');

        Artisan::call(' vendor:publish --tag=genesis-providers');
        $this->info('Providers files were published in /app/Providers');

        Artisan::call(' vendor:publish --tag=genesis-resolvers');
        $this->info('Resolvers files were published in /app/Resolvers');

        Artisan::call(' vendor:publish --tag=genesis-schemas');
        $this->info('Schema files were published in /graphql');

        Artisan::call(' vendor:publish --tag=genesis-useCases');
        $this->info('UseCases files were published in /app/UseCases');
    }
}
