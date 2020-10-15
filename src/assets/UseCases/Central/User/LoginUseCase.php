<?php
namespace App\UseCases\Central\User;

use App\Dtos\Central\User\UserLoginDto;
use App\Exceptions\AuthenticationException;
use App\Models\Central\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

final class LoginUseCase
{
    protected $user;
    public function execute(UserLoginDto $loginDto)
    {
        $this->validateCredentials($loginDto->email, $loginDto->password);
        $token = $this->createToken($loginDto->remember_me);

        return [
            'message' => 'Bienvenido(a) ' . $this->user->name,
            'access_token' => $token->accessToken,
            'expires_at' => $token->token->expires_at,
            'token_name' => $token->token->name,
            'user' => $this->user,
        ];
    }

    public function validateCredentials($email, $password)
    {
        $this->user = User::where('email', $email)->first();
        if ($this->user === null || !Hash::check($password, $this->user->password)) {
            throw new AuthenticationException(
                'Error en la autenticación',
                'Correo y/o clave incorrecta'
            );
        }
    }

    public function createToken($remember_me = false)
    {
        $tokenUser = $this->user->createToken('Central Personal Access Token');
        $token = $tokenUser->token;
        if ($remember_me) {
            $token->expires_at = Carbon::now()->addMonths(1);
        }
        $token->save();

        return $tokenUser;
    }
}
