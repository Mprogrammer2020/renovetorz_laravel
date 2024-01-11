<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\leads;
use App\Models\imageLeads;

class LeadController extends Controller
{
    public function leads(){
        $leads = leads::all();
        $totalRecords = leads::count();
        // $leads = leads::leftJoin('image_lead', 'image_lead.id', '=', 'leads.lead_image_id')->get();
        return array('status' => true, 'message' => "Leads get successfully", 'records' => $totalRecords, 'data' => $leads);

    }

    public function getLeads($id){
        $leads = leads::where('id', $id)->first();
        $leads = leads::leftJoin('image_lead', 'image_lead.id', '=', 'leads.lead_image_id')->where('leads.id', $id)->first();
        return array('status' => true, 'message' => "Leads get successfully", 'data' => $leads);

    }
}