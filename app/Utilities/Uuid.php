<?php 

namespace App\Utilities;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    static function generate()
    {
        return RamseyUuid::uuid4()->toString();
    }
}