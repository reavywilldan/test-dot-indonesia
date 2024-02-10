<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class City extends Model
{
    use HasFactory;

    protected $table = 'api_city';

    protected $fillable = [
        'city_id',
        'city_name',
        'type',
        'postal_code',
        'province_id',
        'province',
        'created_at',
        'updated_at'
    ];

    // Relationship dengan Province
    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public static function createCitiesWithTransaction($citiesData)
    {
        self::truncate();

        DB::transaction(function () use ($citiesData) {
            self::insert($citiesData);
        });
    }
}
