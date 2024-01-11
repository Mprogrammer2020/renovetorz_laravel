<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    use HasFactory;
    protected $table = 'contractor_location';

    protected $fillable = [
        'postal_code',
        'distance',
        'contract_id',
        'location_id',
        'status',
    ];
}
