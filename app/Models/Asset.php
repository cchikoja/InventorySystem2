<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $table = 'assets_tbl';

    protected $fillable = [
        'asset',
        'serial_no',
        'model',
        'bought',
        'expires',
        'value',
        'recorder',
        'assigned',
    ];

    public static function checkAsset($no): bool
    {
        if (Asset::where('serial_no', $no)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
