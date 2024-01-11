<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GlobalCredit extends Model
{
    protected $table = 'global_credits';

    protected $fillable = [
        'no_of_leads',
        'credit_value',
        'status'
    ];
}
