<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactsLinks extends Model
{
    use HasFactory;

    protected $table = 'contracts_relations_tbl';

    protected $fillable = [
      'subject',
      'object',
      'status',
    ];
}
