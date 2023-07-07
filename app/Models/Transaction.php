<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'creditor',
        'debitor',
        'amount',
        'is_credit',
        'currency',
        'created_by',
        'updated_by'
    ];
}
