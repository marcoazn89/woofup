<?php
namespace ParkAlong\Libraries\Repositories;

use OAuth2Password\Interfaces\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface
{
    protected $db;

    public function __construct(\Illuminate\Database\MySqlConnection $db)
    {
        $this->db = $db;
    }

    public function validateCredentials($email, $password)
    {
        $user = $this->db->table('users')
            ->select('users.id', 'users.email', 'users.password', 'roles.role', 'profiles.id as profileId')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
            ->where('users.email', '=', $email)
            ->first();

        if (!$this->verifyPassword($password, $user['password'])) {
            return false;
        }

        if (empty($user['profileId'])) {
            $user['completed'] = false;
        } else {
            $user['completed'] = true;
        }

        unset($user['profileId']);
        unset($user['password']);

        return $user;
    }

    public function refreshToken($id)
    {
        $user = $this->db->table('users')
            ->select('users.id', 'users.email', 'roles.role', 'profiles.id as profileId')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
            ->where('users.id', '=', $id)
            ->first();

        if (empty($user['profileId'])) {
            $user['completed'] = false;
        } else {
            $user['completed'] = true;
        }

        unset($user['profileId']);

        return $user;
    }

    protected function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
