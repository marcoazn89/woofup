<?php
namespace ParkAlong\Libraries\ORM;

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Role extends Interfaces\ORM {
    const SUPERUSER = 'superuser';

    const ADMIN = 'admin';

    const MULTI = 'multi';

    const SUPPLIER = 'supplier';

    const DRIVER = 'driver';

    const USER = 'user';
}
