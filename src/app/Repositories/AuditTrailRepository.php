<?php

namespace App\Repositories;

use App\Models\AuditTrail;
use Illuminate\Support\Facades\DB;

class AuditTrailRepository extends Repository
{
    /*
    |--------------------------------------------------------------------------
    | CONSTANTS
    |--------------------------------------------------------------------------
   */
    public static function model()
    {
        return AuditTrail::class;
    }

    public static function create(array $request)
    {
        return self::model()::create([
            self::model()::USER_ID => $request[self::model()::USER_ID],
            self::model()::EVENT => $request[self::model()::EVENT],
            self::model()::FEATURE => $request[self::model()::FEATURE],
            self::model()::DATA => $request[self::model()::DATA],
        ]);
    }
}
