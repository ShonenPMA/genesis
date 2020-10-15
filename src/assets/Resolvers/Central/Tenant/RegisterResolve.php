<?php

namespace App\Resolvers\Central\Tenant;

use App\Models\Central\Tenant;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class RegisterResolve
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
        $model = new Tenant();
        $input = collect($args)->except('password_confirmation')->toArray();
        $model->id = $input['domain'];
        $model->save();

        return [
            'status' => 'SUCCESS',
        ];
    }
}
