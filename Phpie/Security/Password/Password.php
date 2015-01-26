<?php
/**
 * Password Encryption
 */

namespace Phpie\Security\Password;


class Password
{
    public function generate($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}