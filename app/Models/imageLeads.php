<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class imageLeads extends Model
{
    use HasFactory;
    protected $table = 'image_lead';

    protected $fillable = [
        'image',
    ];
}
