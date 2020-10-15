<?php

namespace App\Dtos\Tenant\User;

use App\Abstracts\DataTransferObject;

class UserLoginDto extends DataTransferObject
{
    public $email;
    public $password;
    public $remember_me;

    public static function fromRequest($request)
    {
        return new self($request->all());
    }

    public static function fromArray($array)
    {
        return new self($array);
    }
}
