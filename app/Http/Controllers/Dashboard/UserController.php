<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Gateways\PaypalController;
use App\Jobs\SendInviteEmail;
use App\Models\Activity;
use Illuminate\Validation\Rule; 
use App\Models\Gateways;
use App\Models\OpenAIGenerator;
use App\Models\OpenaiGeneratorFilter;
use App\Models\PaymentPlans;
use App\Models\Setting;
use App\Models\Subscriptions as SubscriptionsModel;
use App\Models\User;
use App\Models\socialMediaLinks;
use App\Models\Service;
use App\Models\leads;
use App\Models\UserAffiliate;
use App\Models\UserFavorite;
use App\Models\UserOpenai;
use App\Models\UserOpenaiChat;
use App\Models\UserOrder;
use App\Models\userServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Laravel\Cashier\Payment;
use Stripe\PaymentIntent;
use Stripe\Plan;
use enshrined\svgSanitize\Sanitizer;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function redirect(){
        if (Auth::user()->type == 'admin'){
            return redirect()->route('dashboard.admin.index');
        }else{
            return redirect()->route('dashboard.user.index');

        }
    }

    public function index($type=null){
        // $ongoingPayments = self::prepareOngoingPaymentsWarning();
        $ongoingPayments=null;
        // $ongoingPayments=PaypalController::getSubscriptionDetails();
        // $user = Auth::user();
        $tmp = PaymentController::checkUnmatchingSubscriptions();
        // $ongoingPayments = PaymentController::checkUnmatchingSubscriptions();

        $count = leads::count(); 
        if($type!=null){
            if($type == 'contractor'){
                $users = User::where('role_id', 3)->get();  
            }

            return view('panel.user.dashboard', compact('users','ongoingPayments','count'));
    
        }
        else{
            $users = User::where('role_id', "!=", 2)->get();
            return view('panel.user.dashboard', compact('users','ongoingPayments','count'));
        }


        // return view('panel.user.dashboard', compact('ongoingPayments')); //
    }

    function prepareOngoingPaymentsWarning(){
        $ongoingPayments = PaymentController::checkForOngoingPayments();
        if($ongoingPayments != null){
            return $ongoingPayments;
        }
        return null;
    }

    public function openAIList(){
        $list = OpenAIGenerator::all();
        $filters = OpenaiGeneratorFilter::get();
        // dd($filters);
        return view('panel.user.openai.list', compact('list', 'filters'));
    }

    public function openAIFavoritesList(){
        return view('panel.user.openai.list_favorites');
    }

    public function openAIFavorite(Request $request){
        $exists =  isFavorited($request->id);
        if ($exists){
            $favorite = UserFavorite::where('openai_id', $request->id)->where('user_id', Auth::id())->first();
            $favorite->delete();
            $html = '<svg width="16" height="15" viewBox="0 0 16 15" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.99989 11.8333L3.88522 13.9966L4.67122 9.41459L1.33789 6.16993L5.93789 5.50326L7.99522 1.33459L10.0526 5.50326L14.6526 6.16993L11.3192 9.41459L12.1052 13.9966L7.99989 11.8333Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>';
        }else{
            $favorite = new UserFavorite();
            $favorite->user_id = Auth::id();
            $favorite->openai_id = $request->id;
            $favorite->save();
            $html = '<svg width="16" height="15" viewBox="0 0 16 15" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
						<path d="M7.99989 11.8333L3.88522 13.9966L4.67122 9.41459L1.33789 6.16993L5.93789 5.50326L7.99522 1.33459L10.0526 5.50326L14.6526 6.16993L11.3192 9.41459L12.1052 13.9966L7.99989 11.8333Z" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>';

        }
        return response()->json(compact('html'));
    }

    public function openAIGenerator($slug){
        $openai = OpenAIGenerator::whereSlug($slug)->firstOrFail();
        $userOpenai = UserOpenai::where('user_id', Auth::id())->where('openai_id', $openai->id)->orderBy('created_at', 'desc')->get();
        return view('panel.user.openai.generator', compact('openai', 'userOpenai'));
    }


    public function openAIGeneratorWorkbook(Request $request, $slug, $id = null){
        $workbook_id = '';
        if ($id != null) {
          $workbook_id = $id;
        }
        
        $openai = OpenAIGenerator::whereSlug($slug)->firstOrFail();
        $settings = Setting::first();
        // Fetch the Site Settings object with openai_api_secret
        $apiKeys = explode(',',$settings->openai_api_secret);
        $apiKey = $apiKeys[array_rand($apiKeys)];

        $len=strlen($apiKey);
        $parts[] = substr($apiKey, 0, $l[] = rand(1,$len-5));
        $parts[] = substr($apiKey, $l[0], $l[] = rand(1,$len-$l[0]-3));
        $parts[] = substr($apiKey, array_sum($l));
        $apikeyPart1 = base64_encode($parts[0]);
        $apikeyPart2 = base64_encode($parts[1]);
        $apikeyPart3 = base64_encode($parts[2]);
        $apiUrl = base64_encode('https://api.openai.com/v1/chat/completions');
        return view('panel.user.openai.generator_workbook', compact('openai',
            'apikeyPart1',
            'apikeyPart2',
            'apikeyPart3',
            'apiUrl',
            'workbook_id'
        ));
    }

    public function openAIGeneratorWorkbookSave(Request $request){
        $workbook = UserOpenai::where('slug', $request->workbook_slug)->firstOrFail();
        $workbook->output = $request->workbook_text;
        $workbook->title = $request->workbook_title;
        $workbook->save();
        return response()->json([], 200);
    }

    //Chat
    public function openAIChat(){
        $chat = Auth::user()->openaiChat;
        return view('panel.user.openai.chat', compact('chat'));
    }

    public static function sanitizeSVG($uploadedSVG){
        $sanitizer = new Sanitizer();
        $content = file_get_contents($uploadedSVG);
        $cleanedData = $sanitizer->sanitize($content);
        $added = file_put_contents($uploadedSVG, $cleanedData);
        return $uploadedSVG;
    }

    //Profile user settings
    public function userSettings(){
        $user = Auth::user();
        $services = Service::select('name','id')->get();

        $user_id = Auth::user()->id;
        $selected_services = userServices::where('user_id','=',$user_id)->get();
        
        return view('panel.user.settings.index', compact('user','services','selected_services'));
    }

    public function userSettingsSave(Request $request){
        
        $request->validate([
            'image' => 'required',
            'name' => 'required',
            'surname' => 'required',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($request->id),
            ],
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal' => 'required|numeric',
            'type_of_work' => 'required',
            'type_of_property' => 'required',
            'area_of_property' => 'required',
            'permit' => 'required',
            'age_of_property' => 'required',
            'first_meeting' => 'required',
            'budget' => 'required',
            'start_up' => 'required',
            // 'serviceDropdown' => 'required',
            // 'company_logo' => 'image|mimes:jpeg,png,jpg,gif',
            // 'company_name' => 'required',
            // 'company_email' => 'required|email',
            // 'company_phone' => 'required',
            // 'company_website' => 'required',
            // 'company_strength' => 'required',
            // 'company_years' => 'required',
        ],
        [
            'image.required' => 'Image Cannot be empty',
            'name.required' => 'Name Cannot be empty',
            'surname.required' => 'surname Cannot be empty',
            'email.required' => 'Email Cannot be empty',
            'email.email' => 'Email should be valid',
            'phone.required' => 'phone number can not be empty',
            'address.required' => 'site address Cannot be empty',
            'city.required' => 'city Cannot be empty',
            'postal_code.numeric' => 'postal code should be numeric',
            'postal.required' => 'postal code can not be empty',
            'type_of_work.required' => 'what kind of work Cannot be empty',
            'type_of_property.required' => 'Property type Cannot be empty',
            'area_of_property.required' => 'Area of basement cannot be empty',
            'age_of_property.required' => 'Age of property cannot be empty',
            'first_meeting.required' => 'Time for first meeting cannot be empty',
            'budget.required' => 'budget cannot be empty',
            'start_up.required' => 'When Want To Start The Work cannot be empty',
            // 'serviceDropdown.required' => 'Please select atleast one service',
            // 'company_logo.required' => 'company logo cannot be empty',
            // 'company_name.required' => 'company name cannot be empty',
            // 'company_email.required' => 'company email cannot be empty',
            // 'company_phone.required' => 'company phone cannot be empty',
            // 'company_website.required' => 'company website cannot be empty',
            // 'company_strength.required' => 'company strength cannot be empty',
            // 'company_years.required' => 'company years cannot be empty',
        ]);

        if($request->hasFile('company_logo')){
            $company_logo = base64_encode(file_get_contents($request->file('company_logo')));
        }else{
            $company_logo = '';
        }

        if($request->hasFile('image')){
            $image = base64_encode(file_get_contents($request->file('company_logo')));
        }else{
            $image = '';
        }

        //Latitude & Longitude
        $address = $request->address;
        $apiKey = env('API_KEY');
        $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false&key='.$apiKey);
        $geo = json_decode($geo, true); 
        
        if (isset($geo['status']) && ($geo['status'] == 'OK')) {
          $latitude = $geo['results'][0]['geometry']['location']['lat'];
          $longitude = $geo['results'][0]['geometry']['location']['lng']; 
        }

        $data = array(
            "image" => $image,
            "name" => $request->name,
            "surname" => $request->surname,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "city" => $request->city,
            "postal" => $request->postal,
            // "type_of_work" => $request->type_of_work,
            // "type_of_property" => $request->type_of_property,
            // "area_of_property" => $request->area_of_property,
            // "permit" => $request->permit,
            // "age_of_property" => $request->age_of_property,
            // "first_meeting" => $request->first_meeting,
            // "budget" => $request->budget,
            // "start_up" => $request->start_up,
            "company_logo" => $company_logo,
            "company_name" => $request->company_name,
            "company_email" => $request->company_email,
            "company_phone" => $request->company_phone,
            "company_strength" => $request->company_strength,
            "company_years" => $request->company_years,
            "company_location" => $request->locationDropdown,
            "company_website" => $request->company_website,
            "latitude"=>$latitude,
            "longitude"=>$longitude,
        );

        if (isset($request->id)) { 
            user::where('id', $request->id)->update($data);
        }else {
            user::create($data);
        }
        
    }



    public function saveSocial(Request $request){
        // dd($request->all());
        $request->validate([
            'linkedin' => 'required',
            'facebook' => 'required',
            'youtube' => 'required',
            'instagram_1' => 'required',
        ],
        [
            'linkedin.required' => 'LinkedIn link Cannot be empty',
            'facebook.required' => 'facebook link Cannot be empty',
            'youtube.required' => 'youtube link Cannot be empty',
            'instagram_1.required' => 'instagram link Cannot be empty',
        ]);

        $data = array(
            "linkedin_link" => $request->linkedin,
            "facebook_link" => $request->facebook,
            "youtube_link" => $request->youtube,
            "instagram_link" => $request->instagram,
            // "status" =>$request->status,
        );
        // dd($data);
            socialMediaLinks::create($data);   
    }


    //Purchase
    public function subscriptionPlans() {

        //check if any payment gateway enabled
        $activeGateways = Gateways::where("is_active", 1)->get();
        if($activeGateways->count() > 0){
            $is_active_gateway = 1;
        }else{
            $is_active_gateway = 0;
        }

        //check if any subscription is active
        $userId=Auth::user()->id;
        // Get current active subscription
        $activeSub = SubscriptionsModel::where([['stripe_status', '=', 'active'], ['user_id', '=', $userId]])->orWhere([['stripe_status', '=', 'trialing'], ['user_id', '=', $userId]])->first();
        $activesubid = 0; //id can't be zero, so this will be easy to check
        if($activeSub != null){
            $activesubid = $activeSub->plan_id;
        }

        $plans = PaymentPlans::where('type', 'subscription')->where('active', 1)->get();
        $prepaidplans = PaymentPlans::where('type', 'prepaid')->where('active', 1)->get();
        return view('panel.user.payment.subscriptionPlans', compact('plans', 'prepaidplans', 'is_active_gateway', 'activeGateways', 'activesubid'));
    }




    //Invoice - Billing
    public function invoiceList(){
        $user = Auth::user();
        $list = $user->orders;
        return view('panel.user.orders.index', compact('list'));
    }

    public function invoiceSingle($order_id){
        $user = Auth::user();
        $invoice = UserOrder::where('order_id', $order_id)->firstOrFail();
        return view('panel.user.orders.invoice', compact('invoice'));
    }

    public function documentsAll(){
        $items = Auth::user()->openai()->orderBy('created_at', 'desc')->paginate(50);
        return view('panel.user.openai.documents', compact('items'));
    }

    public function documentsSingle($slug){
        $workbook = UserOpenai::where('slug', $slug)->first();
        $openai = $workbook->generator;
        return view('panel.user.openai.documents_workbook', compact('workbook', 'openai'));
    }

    public function documentsDelete($slug){
        $workbook = UserOpenai::where('slug', $slug)->first();
        $workbook->delete();
        return redirect()->route('dashboard.user.openai.documents.all')->with(['message' => 'Document deleted succesfuly', 'type' => 'success']);

    }

    public function documentsImageDelete($slug){
        $workbook = UserOpenai::where('slug', $slug)->first();
        $workbook->delete();
        return back()->with(['message' => 'Deleted succesfuly', 'type' => 'success']);

    }

    //Affiliates
    public function affiliatesList(){
        $user = Auth::user();
        $list = $user->affiliates;
        $list2 = $user->withdrawals;
        $totalEarnings = 0;
        foreach ($list as $affOrders){
            $totalEarnings += $affOrders->orders->sum('affiliate_earnings');
        }
        $totalWithdrawal = 0;
        foreach($list2 as $affWithdrawal){
            $totalWithdrawal += $affWithdrawal->amount;
        }
        return view('panel.user.affiliate.index', compact('list', 'list2', 'totalEarnings', 'totalWithdrawal'));
    }

    public function affiliatesListSendInvitation(Request $request){
        $user = Auth::user();

        $sendTo = $request->to_mail;

        dispatch(new SendInviteEmail($user, $sendTo));

        return response()->json([], 200);
    }

    public function affiliatesListSendRequest(Request $request){
        $user = Auth::user();
        $list = $user->affiliates;
        $list2 = $user->withdrawals;

        $totalEarnings = 0;
        foreach ($list as $affOrders){
            $totalEarnings += $affOrders->orders->sum('affiliate_earnings');
        }
        $totalWithdrawal = 0;
        foreach($list2 as $affWithdrawal){
            $totalWithdrawal += $affWithdrawal->amount;
        }
        if ($totalEarnings - $totalWithdrawal >= $request->amount){
            $user->affiliate_bank_account = $request->affiliate_bank_account;
            $user->save();
            $withdrawalReq = new UserAffiliate();
            $withdrawalReq->user_id = Auth::id();
            $withdrawalReq->amount = $request->amount;
            $withdrawalReq->save();

            createActivity($user->id, 'Sent', 'Affiliate Withdraw Request', route('dashboard.admin.affiliates.index'));

        }else{
            return response()->json(['error' => 'ERROR'], 411);
        }
    }

    public function saveServices(Request $request)
    {
        $userId=Auth::user()->id;
        userServices::where('user_id','=',$userId)->delete();

        $str = explode(',', $request->service_id);
        $userId=Auth::user()->id;

        for ($i = 0;$i<count($str);$i++){
            $data = array(
                "service_id" => $str[$i],
                "user_id" => $userId,
        );
            userServices::create($data);
            
        }

        // for ($i = 0;$i<count($str);$i++){
        //     userServices::get($request->service_id);
        // }
        
    
    }

    public function changePassword(){
        return view('panel.user.settings.changePassword');
    }

    public function updatePassword(Request $request){

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|string|min:8|different:old_password',
            'confirm_password' => 'required|string|min:8|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if the current password matches the user's password
        if (!Hash::check($request->input('old_password'), Auth::user()->password)) {
            return response()->json(["status" => false, "message" => "Current password is incorrect", "data" => '']);
        }


        //Update the user's password
        $user = User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->input('new_password'))
        ]);
        if($user){
            return response()->json(["status" => true, "message" => "Password chnaged successfully", "data" => '']);
        }else{
            return response()->json(["status" => false, "message" => "Something went wrong", "data" => '']);

        }
    }
}
