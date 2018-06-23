<?php
namespace ParkAlong\Libraries\ORM;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Vehicle extends Interfaces\ORM
{
    use SoftDeletingTrait;

    protected $fillable = [
        'vehicle_size_id',
        'user_id',
        'vin',
        'fuel_type',
        'type',
        'make',
        'model',
        'year',
        'color',
        'plate',
        'display'
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function vehicleSize()
    {
        return $this->belongsTo('ParkAlong\Libraries\ORM\VehicleSize');
    }

    public function user()
    {
        return $this->belongsTo('ParkAlong\Libraries\ORM\User');
    }
}
