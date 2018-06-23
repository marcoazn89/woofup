<?php
namespace ParkAlong\Libraries\Services\Signup\Interfaces;

/**
 * Signup Service Interface
 *
 * This interface is meant to be inherited by anybody writing a signup service
 *
 * @author Marco A Chang marco@parkalong.us
 * @version 0.1.0
 * @since 4/2/2016
 */
interface SignupServiceInterface
{
    const SUPERUSER = 1;

    const ADMIN = 2;

    const MULTI = 3;

    const SUPPLIER = 4;

    const DRIVER = 5;

    const USER = 6;

    /**
     * Create a user
     * @param  string $email    User's email
     * @param  string $password User's password
     * @param  int    $role     User's role id. Defaults to 6.
     * @throws ParkAlong\Libraries\Services\Signup\DuplicateSignupException
     * @throws \Exception
     * @return boolean          True on success.
     */
    public function createUser($email, $password, $role = self::USER);
}
