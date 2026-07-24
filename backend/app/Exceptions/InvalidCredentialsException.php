<?php

namespace App\Exceptions;

class InvalidCredentialsException extends ApiException
{
    public function __construct()
    {
        parent::__construct(
            message: 'Invalid email or password.',
            status: 401
        );
    }
}
