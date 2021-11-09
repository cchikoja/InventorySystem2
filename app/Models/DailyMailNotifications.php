<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyMailNotifications extends Model
{
    use HasFactory;

    protected $table = 'contracts_emails_tbl';

    protected $fillable = [
        'date',
        'notified',
    ];
}
