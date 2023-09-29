<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    public const USER_ID = 'user_id';
    public const EVENT = 'event';
    public const FEATURE = 'feature';
    public const DATA = 'data';

    protected $fillable = [
        self::USER_ID,
        self::EVENT,
        self::FEATURE,
        self::DATA,
    ];
}
