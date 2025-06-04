<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';

    public $timestamps = false;

    protected $fillable = [
        'iso',
        'name',
        'nicename',
        'iso3',
        'numcode',
        'phonecode',
    ];

    public static function getAllPhoneCodes(): array
    {
        return self::pluck('phonecode')->toArray();
    }

    public static function getAllCountryNames(): array
    {
        return self::pluck('name')->toArray();
    }
}
