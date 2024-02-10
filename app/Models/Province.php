<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    use HasFactory;

    protected $table = 'api_province';

    protected $fillable = [
        'province_id',
        'province',
        'created_at',
        'updated_at'
    ];

    // Relationship dengan Cities
    public function cities()
    {
        return $this->hasMany(City::class, 'province_id');
    }

    public static function createProvincesWithTransaction($provincesData)
    {
        self::truncate();

        DB::transaction(function () use ($provincesData) {
            self::insert($provincesData);
        });
    }
}
