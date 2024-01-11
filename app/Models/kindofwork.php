<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kindofwork extends Model
{
    use HasFactory;

    protected $table = 'kindofwork';

    protected $fillable = [
        'name',
        'description',
    ];
}