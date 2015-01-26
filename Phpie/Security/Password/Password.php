<?php
/**
 * Password Encryption
 */

namespace Phpie\Security\Password;


class Password
{
    /**
     * @param $password
     * @return bool|false|string
     */
    public static function generate($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param $password
     * @param $hash
     * @return bool
     */
    public static function verify($password, $hash)
    {
        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }
}