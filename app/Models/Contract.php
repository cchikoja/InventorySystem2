<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contracts_tbl';

    protected $fillable = [
        'title',
        'start_date',
        'expiry_date',
        'path',
        'status',
        'description',
        'uploader',
        'company'
    ];

    public static function getContract($id){
        return Contract::find($id);
    }

    public static function getExpiredDays($id): int
    {
        $contract = Contract::find($id);
        $expiryDate = date_create(date('Y-m-d', strtotime($contract->expiry_date)));
        $date = date_create(date('Y-m-d'));
        $difference = date_diff($date, $expiryDate);
        return (int)$difference->format('%R%a days');
    }
}
