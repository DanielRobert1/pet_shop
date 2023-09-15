<?php

namespace App\Dto;


class AuthenticationParams 
{
    public function __construct(
        public readonly string $username,
        public readonly string $password,
        public readonly string $ip,
        public readonly string $userAgent,
        public readonly int $loginAt,
    ){}
}