<?php
namespace ParkAlong\Libraries\ORM;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Profile extends Interfaces\ORM
{
    use SoftDeletingTrait;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone'
    ];

    protected $hidden = [
        'id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo('ParkAlong\Libraries\ORM\User');
    }
}
