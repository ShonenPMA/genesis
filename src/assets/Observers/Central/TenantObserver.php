<?php

namespace App\Observers\Central;

use App\Models\Central\Tenant;
use App\Models\Tenant\User;

class TenantObserver
{
    public function creating(Tenant $tenant)
    {
        mkdir(base_path('/storage/tenant' . $tenant->id . '/app/public'), 0777, true);
        mkdir(base_path('/storage/tenant' . $tenant->id . '/logs'), 0777, true);
        $gitignore = fopen(base_path('storage/tenant' . $tenant->id . '/' . '.gitignore'), 'w');
        fwrite($gitignore, '*');
    }
    /**
     * Handle the tenant "created" event.
     *
     * @param  \App\Models\Central\Tenant  $tenant
     * @return void
     */
    public function created(Tenant $tenant)
    {
        $tenant->domains()->create([
            'domain' => $tenant->getTenantKey() . '.' . config('tenancy.central_domains')[0],
        ]);
        $tenant->save();

        $tenant->run(function () use ($tenant) {
            User::create([
                'name' => 'Tenant ' . $tenant->getTenantKey(),
                'email' => 'tenant_' . $tenant->getTenantKey() . '@' . config('tenancy.central_domains')[0],
                'password' => bcrypt('secret'),
                ]);
        });
    }

    /**
     * Handle the tenant "updated" event.
     *
     * @param  \App\Models\Central\Tenant  $tenant
     * @return void
     */
    public function updated(Tenant $tenant)
    {
        //
    }

    /**
     * Handle the tenant "deleted" event.
     *
     * @param  \App\Models\Central\Tenant  $tenant
     * @return void
     */
    public function deleted(Tenant $tenant)
    {
        rmdir(base_path('/storage/tenant' . $tenant->id));
    }

    /**
     * Handle the tenant "restored" event.
     *
     * @param  \App\Models\Central\Tenant  $tenant
     * @return void
     */
    public function restored(Tenant $tenant)
    {
        //
    }

    /**
     * Handle the tenant "force deleted" event.
     *
     * @param  \App\Models\Central\Tenant  $tenant
     * @return void
     */
    public function forceDeleted(Tenant $tenant)
    {
        //
    }
}
