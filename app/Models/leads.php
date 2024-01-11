<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class leads extends Model
{
    protected $table = 'leads';

    protected $fillable = [
        'lead_image_id',
        'image',
        'full_name',
        'email',
        'phone_number',
        'site_address',
        'city',
        'postal_code',
        'type_of_work',
        'type_of_property',
        'area_of_property',
        'permit',
        'age_of_property',
        'first_meeting',
        'budget',
        'start_up',
        'project_to_begin',
        'hiring_decision',
        'additional_details',
        'status',
        'latitude',
        'longitude',
        'credit_value',
        'credit_option',
    ];

    // public function leadsImage($id){
    //     $users = DB::table('leads')
    //                 ->leftJoin('image_lead', 'leads.lead_image_id', '=', 'image_lead.id')
    //                 ->where('leads.id', $id)
    //                 ->first();
    //     return $users;
    // }
}
