<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(){
        $services = Service::orderBy("id")->paginate(10);
        return view("panel/service/index",compact("services"));
    }

    public function create(){
     return view("panel/service/add_service");
    }

    public function store(Request $request){
        
        if(!empty($request->id)){
            $service = Service::where('id',$request->id)->update([
                'name' => $request->name,
              ]);
        }else{
            $service = Service::create($request->all());
        }
        
        if($service){
            return response()->json(["status" => true, "success"=> "Service add successfully"]);
    }else{
        return response()->json(["status" => false,"error"=> "Something went wrong"]);
    }
 }

 function delete($id){
    $dlt = Service::where('id',$id)->delete();
    if($dlt){
        return response()->json(["status" => true, "success"=> "Service deleted successfully"]);

    }else{
        return response()->json(["status" => false,"error"=> "Something went wrong"]);

    }
}
}
