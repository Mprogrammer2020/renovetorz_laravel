<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadServices extends Model
{

    use HasFactory;
    protected $table = 'lead_services';

    protected $fillable = [
        'lead_id',
        'service_id',
        'status'
    ];
}
