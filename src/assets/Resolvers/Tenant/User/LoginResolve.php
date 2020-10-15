<?php

namespace App\Resolvers\Tenant\User;

use App\Dtos\Tenant\User\UserLoginDto;
use App\UseCases\Tenant\User\LoginUseCase;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class LoginResolve
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
        $loginDto = UserLoginDto::fromArray($args);
        $loginUseCase = new LoginUseCase();

        return $loginUseCase->execute($loginDto);
    }
}
