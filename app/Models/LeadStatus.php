<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadStatus extends Model
{
    protected $table = 'lead_status';

    protected $fillable = [
        'lead_id',
        'image',
        'contractor_id',
        'status'
    ];
}
