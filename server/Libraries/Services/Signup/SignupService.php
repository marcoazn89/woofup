<?php
namespace ParkAlong\Libraries\Services\Signup;

use ParkAlong\Libraries\ORM;

/**
 * Signup Service
 *
* This is an implementation that only works with matching environments.
 *
 * @author Marco A Chang marco@parkalong.us
 * @version 0.1
 * @since 4/2/2016
 */
class SignupService implements Interfaces\SignupServiceInterface
{
    /**
     * Create a user
     * @param  string $email    User's email
     * @param  string $password User's password
     * @param  int    $role     User's role id
     * @return boolean          True on success and DuplicateSignupException
     *                          when user already exists
     */
    public function createUser($email, $password, $role = self::USER)
    {
        $user = new ORM\User;
        $user->email = $email;
        $user->password = $password;
        $user->role_id = $role;

        try {
            return $user->save();
        } catch (\Exception $e) {
            throw new Exceptions\DuplicateSignupException('User already exists');
        }
    }
}
