<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userServices extends Model
{

    use HasFactory;
    protected $table = 'user_services';

    protected $fillable = [
        'user_id',
        'service_id',
        'status'
    ];

    public function getUserServices($id){
        return userServices::join('services','services.id','=', 'user_services.service_id')
        ->where('user_services.user_id', '=', $id)->get();
    }
}
