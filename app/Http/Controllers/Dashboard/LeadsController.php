<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Illuminate\Support\Facades\Auth;
use App\Models\leads;
use App\Models\LeadStatus;
use App\Models\Service;
use App\Models\User;
use App\Models\userServices;
use App\Models\LeadServices;
use App\Models\imageLeads;
use Faker\Provider\Base;
use OpenAI\ValueObjects\Transporter\BaseUri;
use App\Jobs\LeadsRequestJob;
use App\Models\credits;
use App\Models\GlobalCredit;
use Illuminate\Support\Facades\DB;

class LeadsController extends Controller
{

    private $__userServicesInstance;
    function __construct()
    {
        $this->__userServicesInstance = new userServices();

    }

    public function leads()
    {
        $lead = leads::select('leads.*', DB::raw('GROUP_CONCAT(services.name) as service_name'))
        ->leftJoin('lead_services', 'lead_services.lead_id', '=', 'leads.id')
        ->leftJoin('services', 'services.id', '=', 'lead_services.service_id')
        ->groupBy('leads.id')                                                                                       
        ->paginate(10);
        return view('panel.admin.leads.index', compact('lead'));
    }

    function addLeads()
    {
        $services = Service::select('name', 'id')->get();

        return view('panel.admin.leads.add-leads', compact('services'));
    }

    public function editLeads($id)
    {
        // dd($id);
        // $lead = leads::leftJoin('image_lead', 'image_lead.id', '=', 'leads.lead_image_id')
        //     ->where('leads.id', $id)->select('leads.*', 'leads.id', 'leads.lead_image_id','image_lead.image',DB::raw("DATE_FORMAT(leads.first_meeting, '%d/%m/%Y') as formatted_first_meeting"))
        //     ->first();

        $lead = leads::leftJoin('image_lead', 'image_lead.id', '=', 'leads.lead_image_id')
        ->where('leads.id', $id)
        ->select('leads.*', 'leads.id', 'leads.lead_image_id', 'image_lead.image', DB::raw("DATE_FORMAT(leads.first_meeting, '%Y-%m-%d') as formatted_first_meeting"))
        ->first();

        $services = Service::select('name', 'id')->get();

        $selected_services = leadServices::where('lead_id', '=', $id)->get();  
        // dd($selected_services);
        return view('panel.admin.leads.edit', compact('lead', 'services', 'selected_services'));
    }


    public function deleteLeads($id)
    {
        $lead = leads::whereId($id)->firstOrFail();
        $lead->delete();
        return back()->with(['message' => 'Deleted Successfully', 'type' => 'success']);
    }

    public function leadsSave(Request $request)
    {
        $request->validate(
            [
                'full_name' => 'required',
                'email' => 'required|email',
                'phone_number' => 'required',
                'site_address' => 'required',
                'city' => 'required',
                'postal_code' => 'required|numeric',
                'type_of_work' => 'required',
                'type_of_property' => 'required',
                'area_of_property' => 'required',
                'permit' => 'required',
                'age_of_property' => 'required',
                'first_meeting' => 'required',
                'budget' => 'required',
                'start_up' => 'required',
                // 'project_to_begin' => 'required',
                // 'hiring_decision' => 'required',
                // 'additional_details' => 'required', 
                'credit_option' => 'required',
                'credit_value' => "required_if:credit_option,==,lead-value",
                'serviceDropdown1' => 'required'
            ],
            [
                'full_name.required' => 'Name Cannot be empty',
                'email.required' => 'Email Cannot be empty',
                'email.email' => 'Email should be valid',
                'phone_number.required' => 'phone number can not be empty',
                'site_address.required' => 'site address Cannot be empty',
                'city.required' => 'city Cannot be empty',
                'postal_code.numeric' => 'postal code should be numeric',
                'postal_code.required' => 'postal code can not be empty',
                'type_of_work.required' => 'what kind of work Cannot be empty',
                'type_of_property.required' => 'Property type Cannot be empty',
                'area_of_property.required' => 'Area of basement cannot be empty',
                'age_of_property.required' => 'Age of property cannot be empty',
                'first_meeting.required' => 'Time for first meeting cannot be empty',
                'budget.required' => 'budget cannot be empty',
                'start_up.required' => 'When Want To Start The Work cannot be empty',
                // 'project_to_begin.required' => 'Time For Project To Begin Cannot be Empty',
                // 'hiring_decision.required' => 'Hiring decision Cannot be Empty',
                // 'additional_details.required' => 'Additional Details Cannot be Empty', 
                'credit_option.required' => 'Credit Option Cannot be Empty',
                'credit_value.required_if' => 'Credit Value is required',
                'serviceDropdown1.required' => 'Services is required',
            ]
        );
        if ($request->hasFile('image')) {
            $image = base64_encode(file_get_contents($request->file('image')));
        } else {
            $image = '';
        }

        if($request->credit_option == "global-value"){
            $credit_value = globalCredit::first();
            $value = $credit_value->credit_value;
        }else{
            $value = $request->credit_value;
        }

        //Latitude & Longitude
        $address = $request->site_address;
        $apiKey = env('API_KEY');
        $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$apiKey);
        $geo = json_decode($geo, true); 
        
        if (isset($geo['status']) && ($geo['status'] == 'OK')) {
          $latitude = $geo['results'][0]['geometry']['location']['lat'];
          $longitude = $geo['results'][0]['geometry']['location']['lng']; 
        }

        $data = array(
            "lead_image_id" => $request->lead_image_id,
            // "image" => $image,
            "full_name" => $request->full_name,
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "site_address" => $request->site_address,
            "city" => $request->city,
            "postal_code" => $request->postal_code,
            "type_of_work" => $request->type_of_work,
            "type_of_property" => $request->type_of_property,
            "area_of_property" => $request->area_of_property,
            "permit" => $request->permit,
            "age_of_property" => $request->age_of_property,
            "first_meeting" => $request->first_meeting,
            "budget" => $request->budget,
            "start_up" => $request->start_up,
            "project_to_begin" => $request->project_to_begin,
            "hiring_decision" => $request->hiring_decision,
            "additional_details" => $request->additional_details,
            "status" => "pending",
            "credit_option" => $request->credit_option,
            "credit_value" => $value,
            "latitude"=>$latitude,
            "longitude"=>$longitude,
        );
        if (isset($request->lead_id)) {
            leads::where('id', $request->lead_id)->update($data);
            $lead = $request->lead_id;
        } else {
            $data = leads::create($data);
            if (isset($data)) {
                $lead = $data->id;

            //     $users = User::select('latitude','longitude')->where('role_id','=','3')->get();
            //     foreach($users as $user){
            //         $user_lat = $user->latitude;
            //         $user_long = $user->longitude;

            //         $haversine = "(6371 * acos(cos(radians($latitude))
            //         * cos(radians($user_lat)) 
            //         * cos(radians($user_long) 
            //         - radians($longitude))
            //         + sin(radians($latitude)) 
            //         * sin(radians($user_lat))))";

            //         $distance = User::leftJoin('contractor_location', 'contractor_location.contract_id', '=', 'users.id')
            //         ->selectRaw("$haversine AS distance, contractor_location.distance as contractor_location_distance")
            //         ->where('users.email', '=', 'yash.contractor@yopmail.com')
            //         ->first();
                
            //         if ($distance && $distance->distance < $distance->contractor_location_distance) {
            //             dd($distance->distance);
            //         } else {
            //             dd('Condition not met');
            //         }
            // }
                dispatch(new LeadsRequestJob($data));
            } else {
                return response()->json(['status' => false, 'message' => 'Something went wrong.']);
            }
        }

        $str = explode(',', $request->serviceDropdown1);
        foreach ($str as $string) {
            $service_data = array(
                "lead_id" => $lead,
                "service_id" => $string,
                "status" => 'Active',
            );
            LeadServices::create($service_data);
        }
        return response()->json(['status' => true, 'data' => $data, 'message' => 'Lead added successfully.']);
    }

    public function leadRequest(Request $request)
    {
        $results = $this->__userServicesInstance->getUserServices(Auth::user()->id);

        $serviceNameArray = [];
        foreach($results as $result){
            $serviceNameArray[] = $result->name;
        }
        $leadId = $request->get('lead_id');
        $leads = leads::select('leads.*', 'image_lead.image as lead_image','lead_services.service_id',DB::raw('GROUP_CONCAT(services.name) as service_name'))
            ->leftJoin('image_lead', 'image_lead.id', '=', 'leads.lead_image_id')
            ->leftJoin('lead_services', 'lead_services.lead_id', '=', 'leads.id')
            ->leftJoin('services', 'services.id', '=', 'lead_services.service_id')
            ->where('leads.status', '=', 'pending')    
            ->whereIn('services.name', $serviceNameArray)    
            ->groupBy('leads.id')
            ->orderBy('created_at', 'desc')                                                                                   
            ->get();

        $credits = credits::all();
        return view('panel.admin.leads.leads-request', compact('leads','leadId','credits'));
    }

    public function leadResponse()
    {
        $leads = leads::select('leads.*', 'image_lead.image as lead_image')
            ->leftJoin('lead_status', 'lead_status.lead_id', '=', 'leads.id')
            ->leftJoin('image_lead', 'image_lead.id', '=', 'leads.lead_image_id')
            ->where('leads.status', '=', 'accepted')
            ->where('lead_status.contractor_id', '=', Auth::user()->id)
            ->groupBy('leads.id')
            ->get();
    
        return view('panel.admin.leads.leads-response', compact('leads'));
    }
    

    function imageSave(Request $request)
    {

        $request->validate(
            [
                'image' => 'required',
            ],
            [
                'image.required' => 'Please select any image',
            ]
        );

        if ($request->hasFile('image')) {
            $image = base64_encode(file_get_contents($request->file('image')));
        } else {
            $image = '';
        }

        $data = array(
            "image" => $image,
        );

        $image = imageLeads::create($data);


        $id = $image->id;

        $images = imageLeads::find($id);
        // if (!$images) {
        //     abort(404);

        // }

        // $decodedImage = base64_decode($image->image);
        // dd($images);
        // return response($decodedImage)->header('Content-Type', 'image/png');
        //    $data = array(
        //     'id' => $id,
        //     'images' => $images
        // ); 


        if ($data) {
            return response()->json(['status' => true, 'data' => $data, 'message' => 'Status updated successfully.', 'id' => $id, 'images' => $images->image]);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong.']);
        }
    }

    function imageDelete($id)
    {   
        imageLeads::where('id',$id)->delete();
        $leads = leads::where('lead_image_id',$id)->update([
            'lead_image_id' => null,
        ]);
        if($leads){
            return back()->with(['message' => 'Deleted Successfully', 'type' => 'success']);
        }else{
            return back()->with(['message' => 'Something went wrong', 'type' => 'error']);
        }
    }

    function imageEditDelete($id)
    {
        // dd("wdfcwdfc");
        $dlt = imageLeads::whereId($id)->firstOrFail();
        $dlt->delete();
        return back()->with(['message' => 'Deleted Successfully', 'type' => 'success']);
    }

    function leadStatus($lead_id)
    {
        if (!empty($lead_id)) {

            //update lead status 
            $lead = leads::where('id', '=', $lead_id)->update(['status' => 'accepted']);


            //new entry insert in lead staus table  
            $user = Auth::user();
            $contractor_id = $user->id;
            $data = array(
                'lead_id' => $lead_id,
                'contractor_id' => $contractor_id,
                'status' => "accepted",
            );
            leadStatus::create($data);


            //update contractor credtis based on leads credit
            $leads = leads::find($lead_id);
            $lead_credit_value = $leads->credit_value;

            $user = Auth::user();
            $credits = $user->credit;

            $new_credits = $credits - $lead_credit_value;
            if($new_credits < 0){
                $new_credits == 0;
            }

            User::where('id', '=', $user->id)->update(['credit' => $new_credits]);


            //get leads 
            $leads = Leads::where("id", '=', $lead_id)->first();
            if ($leads) {
                return response()->json(["status" => true, "message" => "Leads status updated successfully , Now you can contact the person", "data" => $leads, "new_credits" => $new_credits]);
            } else {
                return response()->json(["status" => false, "message" => "Something went wrong"]);
            }
        }
    }

    function createCheckoutSession($lead_id,$package_id)
    {
        // if(!empty($lead_id)){
        $package_amount = credits::where('id',$package_id)->first();

        $stripe = new \Stripe\StripeClient('sk_test_51AScZUJIOxYZNW8vFjqeUN1WjoVI1NQsCeeR70Hp7HTZau1ZsHH6YYXBbvJgXYyLBdMEs6aFSlbEvPAgzru8Pr5p00EStmKUfO');
        $product = $stripe->products->create([
            'name' => 'Lead Purchase',
        ]);

        $priceDetail = $stripe->prices->create([
            'unit_amount' => $package_amount->amount * 100,
            'currency' => 'usd',
            // 'recurring' => ['interval' => 'month'],
            'product' => $product->id
        ]);

        \Stripe\Stripe::setApiKey('sk_test_51AScZUJIOxYZNW8vFjqeUN1WjoVI1NQsCeeR70Hp7HTZau1ZsHH6YYXBbvJgXYyLBdMEs6aFSlbEvPAgzru8Pr5p00EStmKUfO');

        $YOUR_DOMAIN = url('/');

        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price' => $priceDetail->id,
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/dashboard/leads/success/'.$lead_id.'/'.$package_id,
            // 'success_url' => $YOUR_DOMAIN . '/dashboard/leads/success?session={CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/dashboard/leads/cancel',
            'metadata' => ['lead_id' => $lead_id]
        ]);

        
        if($checkout_session->url){
            return response()->json(["status" => true, "message" => "Stripe session creates successfully", "data_url" => $checkout_session->url]);

        }else{
            return response()->json(["status" => false, "message" => "Somrthing went wrong", "data_url" => ""]);

        }
    }

    function stripeSuccess($lead_id,$package_id){
        $avaialble_credits = User::where('id',Auth::user()->id)->first();
        $avaialble_credits->credit;

        $package_amount = credits::where('id',$package_id)->first();

        if(!empty($avaialble_credits->credit) || $avaialble_credits->credit != null){
            
            User::where('id',Auth::user()->id)->update([
                'package_id' => $package_id,
                'credit' => $avaialble_credits->credit + $package_amount->amount,
            ]);

        }else{
            User::where('id',Auth::user()->id)->update([
                'package_id' => $package_id,
                'credit' => $package_amount->amount,
            ]);

        }
        

        //update status
        if (!empty($lead_id)) {
            $data = array(
                "contractor_id" => $user = Auth::user()->id,
                "lead_id" => $lead_id,
                "status" => 'accepted',
            );
            $result = LeadStatus::create($data);
            Leads::where('id', '=', $lead_id)->update([
                'status' => 'accepted',
            ]);
            //get leads 
            $leads = Leads::where("id", '=', $lead_id)->first();
            if ($result) {
                return redirect('/dashboard/leads/request/?lead_id='.$lead_id);
            } else {
                return redirect('/dashboard/leads/request');
            }
        }
    }

    function stripeCancel(){
        return response()->json(["status" => false, "message" => "Something went wrong"]);
    }

    function credits($lead_id){
        $lead = leads::find($lead_id);
        $credit_value = $lead->credit_value;
        // dd($credit_value);

        $user = Auth::user();
        $credits = $user->credit;
        // dd($credits,$credit_value);

        if($credits >= $credit_value){
            return response()->json(["status" => true, "message" => "Success", "available" => true]);
        }else{
            return response()->json(["status" => true, "message" => "Success", "available" => false]);
        }  
    }
}
