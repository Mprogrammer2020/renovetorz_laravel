<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class credits extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'credits';

    protected $fillable = [
        'user_id',
        'leads_count',
        'credit_value',
        'amount',
        'status',
        ];
}
