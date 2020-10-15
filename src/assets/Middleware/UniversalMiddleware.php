<?php
declare(strict_types=1);
namespace App\Http\Middleware;

use Closure;
use Stancl\Tenancy\Tenancy;
use Stancl\Tenancy\Middleware\IdentificationMiddleware;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class UniversalMiddleware extends IdentificationMiddleware
{
    /** @var callable|null */
    public static $onFail;

    /** @var Tenancy */
    protected $tenancy;

    /** @var DomainTenantResolver */
    protected $resolver;

    public function __construct(Tenancy $tenancy, DomainTenantResolver $resolver)
    {
        $this->tenancy = $tenancy;
        $this->resolver = $resolver;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array($request->getHost(), config('tenancy.central_domains'))) {
            return $next($request);
        }

        return $this->initializeTenancy(
            $request,
            $next,
            $request->getHost()
        );
    }
}
