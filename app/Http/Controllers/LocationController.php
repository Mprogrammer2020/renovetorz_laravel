<?php

namespace App\Http\Controllers;
use App\Models\location;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index(){
        return view("panel/location/index");
    }

    public function create(){
     return view("panel/service/add_service");

    }

    public function saveLocation(Request $request){

        $request->validate([
            'postal_code' => 'required',
            'distance' => 'required',
        ],
        [
            'postal_code.required' => 'Postal Code Cannot be empty',
            'distance.required' => 'Distance Cannot be empty',
        ]);

        $data = array(
            "contract_id" =>  Auth::user()->id,
            "postal_code" => $request->postal_code,
            "distance" => $request->distance,
        );

        $user = location::updateOrCreate(
            ['contract_id' => Auth::user()->id],
            $data
        );
     
        return $user;
    }
}
