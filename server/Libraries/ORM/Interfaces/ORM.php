<?php
namespace Roadbot\Libraries\ORM\Interfaces;

use Illuminate\Database\Eloquent\Model;

abstract class ORM extends Model
{
    protected $connection = 'mysql';
}
