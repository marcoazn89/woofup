<?php
namespace ParkAlong\Libraries\ORM;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends Interfaces\ORM
{
    use SoftDeletingTrait;

    protected $fillable = [
        'role_id',
        'email'
    ];

    protected $hidden = [
        'id',
        'password',
        'updated_at',
        'deleted_at'
    ];

    public function role()
    {
        return $this->belongsTo('ParkAlong\Libraries\ORM\Role');
    }

    public function profile() {
        return $this->hasOne('ParkAlong\Libraries\ORM\Profile');
    }

    public function vehicles()
    {
        return $this->hasMany('ParkAlong\Libraries\ORM\Vehicle');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = password_hash($value, PASSWORD_DEFAULT);
    }
}
