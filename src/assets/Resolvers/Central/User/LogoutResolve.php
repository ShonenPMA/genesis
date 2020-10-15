<?php

namespace App\Resolvers\Central\User;

use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\AuthenticationException;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class LogoutResolve
{
    /**
     * @param $rootValue
     * @param array                                                    $args
     * @param \Nuwave\Lighthouse\Support\Contracts\GraphQLContext|null $context
     * @param \GraphQL\Type\Definition\ResolveInfo                     $resolveInfo
     *
     * @throws \Exception
     *
     * @return array
     */
    public function resolve($rootValue, array $args, GraphQLContext $context = null, ResolveInfo $resolveInfo)
    {
        if (!Auth::guard('api')->check()) {
            throw new AuthenticationException('Not Authenticated', 'Not Authenticated');
        }
        // revoke user's token
        Auth::guard('api')->user()->token()->revoke();

        return [
            'status' => 'TOKEN_REVOKED',
            'message' => 'Your session has been terminated',
        ];
    }
}
