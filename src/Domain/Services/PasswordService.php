<?php

namespace PhpBundle\Crypt\Domain\Services;

use PhpBundle\Crypt\Domain\Exceptions\InvalidPasswordException;
use PhpBundle\Crypt\Domain\Interfaces\Services\PasswordServiceInterface;
use PhpLab\Core\Legacy\Yii\Base\Security;

class PasswordService implements PasswordServiceInterface
{

    private $security;

    public function __construct()
    {
        $this->security = new Security;
    }

    public function validate(string $password, string $hash): bool
    {
        $isValidPassword = $this->security->validatePassword($password, $hash);
        if( ! $isValidPassword) {
            throw new InvalidPasswordException;
        }
        return $isValidPassword;
    }

    public function generateHash(string $password, int $cost = null): string
    {
        return $this->security->generatePasswordHash($password, $cost);
    }

}
