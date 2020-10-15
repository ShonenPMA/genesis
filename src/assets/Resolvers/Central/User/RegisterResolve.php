<?php

namespace App\Resolvers\Central\User;

use App\Dtos\Central\User\UserLoginDto;
use App\Models\Central\User;
use App\UseCases\Central\User\LoginUseCase;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Support\Facades\Hash;
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
        $model = new User();
        $input = collect($args)->except('password_confirmation')->toArray();
        $input['password'] = Hash::make($input['password']);
        $model->fill($input);
        $model->save();

        $loginDto = new UserLoginDto($args);
        $loginUseCase = new LoginUseCase();

        $response = $loginUseCase->execute($loginDto);

        return [
            'payload' => $response,
            'status' => 'SUCCESS',
        ];
    }
}
