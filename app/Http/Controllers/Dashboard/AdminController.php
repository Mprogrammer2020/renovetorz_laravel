<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PaymentController;
use App\Models\Activity;
use App\Models\Clients;
use App\Models\CustomSettings;
use App\Models\Faq;
use App\Models\FrontendForWho;
use App\Models\FrontendFuture;
use App\Models\FrontendGenerators;
use App\Models\FrontendSectionsStatusses;
use Illuminate\Validation\Rule; 
use App\Models\FrontendSetting;
use App\Models\FrontendTools;
use App\Models\Gateways;
use App\Models\GatewayProducts;
use App\Models\OpenAIGenerator;
use App\Models\OpenaiGeneratorChatCategory;
use App\Models\OpenaiGeneratorFilter;
use App\Models\PaymentPlans;
use App\Models\Setting;
use App\Models\Testimonials;
use App\Models\HowitWorks;
use App\Models\User;
use App\Models\userServices;
use App\Models\Service;
use App\Models\leads;
use App\Models\UserAffiliate;
use App\Models\UserOpenai;
use App\Models\UserOpenaiChat;
use App\Models\UserOpenaiChatMessage;
use App\Models\UserOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Subscription;
// use Auth;
use App\Models\ComposerType;
use App\Models\Workspace;
use App\Models\WorkspaceGroupType;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function index(){
        Cache::flush();

        if (
               !Cache::has('sales_this_week')
            or !Cache::has('sales_previous_week')
            or !Cache::has('words_this_week')
            or !Cache::has('words_previous_week')
            or !Cache::has('images_this_week')
            or !Cache::has('images_previous_week')
            or !Cache::has('users_this_week')
            or !Cache::has('users_previous_week')
            or !Cache::has('chat_tokens')
            or !Cache::has('daily_sales')
            or !Cache::has('daily_usages')
            or !Cache::has('top_countries')
            or !Cache::has('total_users')
            or !Cache::has('total_sales')
            or !Cache::has('total_usage')
        ) {
            //Sales this week
            $sales_this_week = UserOrder::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('price');
            Cache::put('sales_this_week', $sales_this_week, now()->addMinutes(360));
            //Sales previous week
            $sales_previous_week = UserOrder::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->sum('price');
            Cache::put('sales_previous_week', $sales_previous_week, now()->addMinutes(360));
            //Words this week
            $words_this_week = UserOpenai::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('credits', '!=', 1)->sum('credits');
            Cache::put('words_this_week', $words_this_week, now()->addMinutes(360));
            //Words previous week
            $words_previous_week = UserOpenai::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->where('credits', '!=', 1)->sum('credits');
            Cache::put('words_previous_week', $words_previous_week, now()->addMinutes(360));
            //Images this week
            $images_this_week = UserOpenai::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->where('credits', '=', 1)->sum('credits');
            Cache::put('images_this_week', $images_this_week, now()->addMinutes(360));
            //Images previous week
            $images_previous_week = UserOpenai::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->where('credits', '=', 1)->sum('credits');
            Cache::put('images_previous_week', $images_previous_week, now()->addMinutes(360));

            //user change
            $users_this_week = count(User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get());
            Cache::put('users_this_week', $users_this_week, now()->addMinutes(360));
            $users_previous_week = count(UserOpenai::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->get());
            Cache::put('users_previous_week', $users_previous_week, now()->addMinutes(360));

            //Chat tokens
            $chat_tokens = UserOpenaiChatMessage::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('credits');
            Cache::put('chat_tokens', $chat_tokens, now()->addMinutes(360));
            //Daily sales
            $daily_sales = UserOrder::select(
                DB::raw('sum(price) as sums'),
                DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as days")
            )
                ->groupBy('days')
                ->get();
            Cache::put('daily_sales', json_encode($daily_sales), now()->addMinutes(360));
            // $total_sales = UserOrder::all()->sum('price');
            $total_sales = UserOrder::where('status', 'Success')->sum('price');
            Cache::put('total_sales', $total_sales, now()->addMinutes(360));
            //Usages
            $daily_usages = UserOpenai::select(
                DB::raw('SUM(IF(credits=1,credits,0)) as sumsImage'),
                DB::raw('SUM(IF(credits>1,credits,0)) as sumsWord'),
                DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as days")
            )
                ->groupBy('days')
                ->get();
            Cache::put('daily_usages', json_encode($daily_usages), now()->addMinutes(360));
            $total_usage = UserOpenai::all()->sum('credits');
            Cache::put('total_usage', $total_usage, now()->addMinutes(360));
            //Top Countries
            $top_countries = User::select('country', DB::raw('count(*) as total'))
                ->groupBy('country')
                ->get();
            Cache::put('top_countries', json_encode($top_countries), now()->addMinutes(360));
            //Total Users
            Cache::put('total_users', count(User::all()), now()->addMinutes(360));
        }
        //Variables
        $activity = Activity::orderBy('created_at', 'desc')->get();
        $latestOrders = UserOrder::orderBy('created_at', 'desc')->take(10)->get();

        $gatewayError = false;
        $gateway = Gateways::where("mode", "sandbox")->first();
        // if($gateway != null){
        //     if(env('APP_ENV') != 'development'){
        //         error_log('Gateway is set to use sandbox. Please set mode to development!');
        //         $gatewayError = true;
        //     }
        // }

        $checkComposerType = ComposerType::where('user_id', Auth::user()->id)->get();;

        $users = User::where('type', '!=', 'admin')->paginate(10);
        $leads = leads::get()->count();
        $contractors = User::where('role_id', 3)->count();
        $managers = User::where('role_id', 2)->count();
        $responses = leads::where('status', 'accepted')->count();
        return view('panel.admin.index', compact('activity', 'latestOrders','gatewayError','checkComposerType','users','contractors','managers','leads','responses'));
    }

    //LEAD MANAGEMENT
    public function leads(){
        $users = User::all();
        return view('panel.user.settings.index', compact('users'));
    }


    //USER MANAGEMENT
    public function users($type = null)
    {
        if ($type != null) {
            if ($type == 'contractor') {
                $users = User::where('role_id', 3)->orderBy('created_at', 'desc')->paginate(10);
            } else if ($type == 'manager') {
                $users = User::where('role_id', 2)->orderBy('created_at', 'desc')->paginate(10);
            }
            return view('panel.admin.users.index', compact('users'));
        } else {
            $users = User::where('role_id', '!=', 1)->orderBy('created_at', 'desc')->paginate(10);
            return view('panel.admin.users.index', compact('users'));
        }
    }
    

    public function usersAdd(){
        $services = Service::select('name', 'id')->get();
        return view('panel.admin.users.add',compact('services'));
    }

    public function usersEdit($id){
        $user = User::whereId($id)->firstOrFail();
        $services = Service::select('name', 'id')->get();
        $selectedType = User::find($id)->type;
        $user_id = $id; 
        // dd($user_id);
        $selected_services = userServices::where('user_id', '=', $user_id)->get();  
        return view('panel.admin.users.edit', compact('user','services','selectedType','selected_services'));
    }

    public function usersDelete($id){
        $user = User::whereId($id)->firstOrFail();
        $user->delete();
        return back()->with(['message' => 'Deleted Successfully', 'type' => 'success']);
    }

    public function usersSave(Request $request){

        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($request->id),
            ],
            'password' => 'required',
            // 'country' => 'required',
            'type' => 'required',
            'status' => 'required',
            'phone' => 'required',
            'serviceDropdown1' => "required_if:type,==,3",
        ],
        [
            'name.required' => 'Name Cannot Be Empty',
            'surname.required' => 'Surname Cannot Be Empty',
            'email.required' => 'Email Cannot Be Empty',
            'email.email' => 'Email should be a valid email',
            'password.required' => 'Password Cannot Be Empty',
            // 'country.required' => 'Country Cannot Be Empty',
            'type.required' => 'Type Cannot Be Empty',
            'status.required' => 'Status Cannot Be Empty',
            'phone.required' => 'Phone Cannot Be Empty',
            'serviceDropdown1.required_if' => 'Services Cannot Be Empty',
        ]);
    
        $data = array(
            "name" => $request->name,
            "surname" => $request->surname,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "type" => $request->type,
            "status" => $request->status,
            "phone" => $request->phone,
            "email_confirmed" => 1,
            "role_id" => $request->type,
        );
    
        if (!isset($request->id)){ 
            $data2 = User::create($data);
            $user_id = $data2->id;

        }else{
            $update_user = User::where('id', $request->id)->update($data);
            $user_id = $request->id;
            if($update_user){
                userServices::where('user_id',$request->id)->delete();
            }else{
                return response()->json(['status'=> false, 'message' => 'Something went wrong']);
            }

        }
        if($request->type == '3'){
             $str = explode(',', $request->serviceDropdown1);
            foreach ($str as $string) {
                $service_data = array(
                "service_id" => $string,
                "user_id" => $user_id,
            );
            $services_data = userServices::create($service_data);
            }
            if($services_data){
                return response()->json(['status'=> true, 'message' => 'Details saved successfully']);

            }else{
                return response()->json(['status'=> false, 'message' => 'Something went wrong']);
            }
            
        }else{
            return response()->json(['status'=> true, 'message' => 'Details saved Successfully']);
        }
}
    
    

    //OPENAI MANAGEMENT
    public function openAIList(){
        $list = OpenAIGenerator::orderBy('title', 'asc')->get();
        return view('panel.admin.openai.list', compact('list'));
    }

    public function openAIListUpdateStatus(Request $request){
        $status = $request->status;
        $openai = OpenAIGenerator::whereId($request->entry_id)->first();
        if ($status  == 1 or $status == 0){
            $openai->active = $status;
            $openai->save();
        }else{
            return response()->json([], 403);
        }

    }

    //OPENAI CHAT CUSTOM TEMPLATES
    public function openAIChatList(){
        $list = OpenaiGeneratorChatCategory::orderBy('name', 'asc')->get();
        return view('panel.admin.openai.chat.list', compact('list'));
    }

    public function openAIChatAddOrUpdate($id = null){
        if ($id == null){
            $template = null;
        }else{
            $template = OpenaiGeneratorChatCategory::where('id', $id)->firstOrFail();
        }

        return view('panel.admin.openai.chat.form', compact('template'));
    }

    public function openAIChatDelete($id = null){
        $template = OpenaiGeneratorChatCategory::where('id', $id)->firstOrFail();
        $template->delete();
        return back()->with(['message' => 'Deleted Successfully', 'type' => 'success']);
    }

    public function openAIChatAddOrUpdateSave(Request $request){

        if ($request->template_id != 'undefined'){
            $template = OpenaiGeneratorChatCategory::where('id', $request->template_id)->firstOrFail();
        }else{
            $template = new OpenaiGeneratorChatCategory();
        }

        if ($request->hasFile('avatar')) {
            $path = 'upload/images/chatbot/';
            $image = $request->file('avatar');
            $image_name = Str::random(4) . '-' . Str::slug($request->name) . '-avatar.' . $image->getClientOriginalExtension();

            //Resim uzantı kontrolü
            $imageTypes = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
            if (!in_array(Str::lower($image->getClientOriginalExtension()), $imageTypes)) {
                $data = array(
                    'errors' => ['The file extension must be jpg, jpeg, png, webp or svg.'],
                );
                return response()->json($data, 419);
            }

            $image->move($path, $image_name);

            $template->image = $path . $image_name;
        }

        $template->name = $request->name;
        $template->slug = Str::slug($request->name).'-'.Str::random(5);
        $template->short_name = $request->short_name;
        $template->description = $request->description;
        $template->role = $request->role;
        $template->human_name = $request->human_name;
        $template->helps_with = $request->helps_with;
        $template->color = $request->color;
        $template->chat_completions = $request->chat_completions;
        $template->prompt_prefix = "As a ".$request->role.", ";
        $template->save();
    }

    //OPENAI CUSTOM TEMPLATES
    public function openAICustomList(){
        $list = OpenAIGenerator::orderBy('title', 'asc')->where('custom_template', 1)->get();
        return view('panel.admin.openai.custom.list', compact('list'));
    }

    public function openAICustomAddOrUpdate($id = null){
        if ($id == null){
            $template = null;
        }else{
            $template = OpenAIGenerator::where('id', $id)->firstOrFail();
        }
        $filters = OpenaiGeneratorFilter::orderBy('name', 'desc')->get();
        return view('panel.admin.openai.custom.form', compact('template', 'filters'));
    }

    public function openAICustomDelete($id = null){
        $template = OpenAIGenerator::where('id', $id)->firstOrFail();
        $template->delete();
        return back()->with(['message' => 'Deleted Successfully', 'type' => 'success']);
    }

    public function openAICustomAddOrUpdateSave(Request $request){

        if ($request->template_id != 'undefined'){
            $template = OpenAIGenerator::where('id', $request->template_id)->firstOrFail();
        }else{
            $template = new OpenAIGenerator();
        }

        $template->title = $request->title;
        $template->description = $request->description;
        $template->image = $request->image;
        $template->color = $request->color;
        $template->prompt = $request->prompt;

        $inputNames = explode( ',', $request->input_name);
        $inputDescriptions = explode( ',', $request->input_description);
        $inputTypes = explode( ',', $request->input_type);

        $i = 0;
        $array = [];
        foreach ($inputNames as $inputName){
            $array[$i]['name'] = Str::slug($inputName);
            $array[$i]['type'] = $inputTypes[$i];
            $array[$i]['question'] = $inputName;
            $array[$i]['description'] = $inputDescriptions[$i];
            $i++;
        }

        $questions = json_encode($array,JSON_UNESCAPED_SLASHES);
        $template->active = 1;
        $template->slug = Str::slug($request->title).'-'.Str::random(6);
        $template->questions = $questions;
        $template->type = 'text';
        $template->custom_template = 1;
        $template->filters = $request->filters;
        foreach (explode( ',', $request->filters) as $filter){
            if (OpenaiGeneratorFilter::where('name', $filter)->first() == null){
                $newFilter = new OpenaiGeneratorFilter();
                $newFilter->name = $filter;
                $newFilter->save();
            }
        }

        $template->save();
    }

    //Openai Categories
    public function openAICategoriesList(){
        $list = OpenaiGeneratorFilter::orderBy('name', 'asc')->get();
        return view('panel.admin.openai.categories.list', compact('list'));
    }

    public function openAICategoriesAddOrUpdate($id = null){
        if ($id == null){
            $item = null;
        }else{
            $item = OpenaiGeneratorFilter::where('id', $id)->firstOrFail();
        }
        return view('panel.admin.openai.categories.form', compact('item'));
    }

    public function openAICategoriesDelete($id = null){
        $item = OpenAIGenerator::where('id', $id)->firstOrFail();
        $item->delete();
        return back()->with(['message' => 'Deleted Successfully', 'type' => 'success']);
    }

    public function openAICategoriesAddOrUpdateSave(Request $request){

        if ($request->item_id != 'undefined'){
            $item = OpenaiGeneratorFilter::where('id', $request->item_id)->firstOrFail();
        }else{
            $item = new OpenaiGeneratorFilter();
        }
        $item->name = $request->name;
        $item->save();
    }

    //FINANCE

    //Payment

    public function paymentPlans(){

        $gatewayError = false;
        $gateway = Gateways::where("mode", "sandbox")->first();
        // if($gateway != null){
        //     if(env('APP_ENV') != 'development'){
        //         error_log('Gateway is set to use sandbox. Please set mode to development!');
        //         $gatewayError = true;
        //     }
        // }

        $plans = PaymentPlans::all();
        return view('panel.admin.finance.plans.index', compact('plans', 'gatewayError'));
    }

    public function paymentPlansSubscriptionNewOrEdit($id = null){

        $activeGateways = Gateways::where('is_active', 1)->get();
        if($activeGateways->count() > 0){
            $isActiveGateway = 1;
        }else{
            $isActiveGateway = 0;
        }

        $generatedData = null;
        if($id != null){
            $generatedData = GatewayProducts::where('plan_id', $id)->get();
        }

        if ($id == null){
            return view('panel.admin.finance.plans.SubscriptionNewOrEdit', compact('isActiveGateway'));
        }else{
            $subscription = PaymentPlans::where('id', $id)->first();
            return view('panel.admin.finance.plans.SubscriptionNewOrEdit', compact('subscription', 'isActiveGateway', 'generatedData'));
        }
    }

    public function paymentPlansDelete($id){
        return PaymentController::deletePaymentPlan($id);
    }

    public function paymentPlansPrepaidNewOrEdit($id = null){

        $activeGateways = Gateways::where('is_active', 1)->get();
        if($activeGateways->count() > 0){
            $isActiveGateway = 1;
        }else{
            $isActiveGateway = 0;
        }

        $generatedData = null;
        if($id != null){
            $generatedData = GatewayProducts::where('plan_id', $id)->get();
        }

        if ($id == null){
            return view('panel.admin.finance.plans.PrepaidNewOrEdit', compact('isActiveGateway'));
        }else{
            $subscription = PaymentPlans::where('id', $id)->first();
            return view('panel.admin.finance.plans.PrepaidNewOrEdit', compact('subscription', 'isActiveGateway', 'generatedData'));
        }
    }


    public function paymentPlansSave(Request $request){
        if ($request->plan_id != 'undefined'){
            $plan = PaymentPlans::where('id', $request->plan_id)->firstOrFail();
        }else{
            $plan = new PaymentPlans();
        }

        if ($request->type == 'subscription'){

            $plan->active = 1;
            $plan->name = $request->name;
            $plan->price = (double)$request->price;
            $plan->frequency = $request->frequency;
            $plan->is_featured = (int)$request->is_featured;
            $plan->stripe_product_id = $request->stripe_product_id;
            $plan->total_words = (int)$request->total_words;
            $plan->total_images = (int)$request->total_images;
            $plan->ai_name = $request->ai_name;
            $plan->max_tokens = (int)$request->max_tokens;
            $plan->can_create_ai_images = (int)$request->can_create_ai_images;
            $plan->plan_type = $request->plan_type;
            $plan->features = $request->features;
            $plan->trial_days = $request->trial_days;
            $plan->type = $request->type;
            $plan->save();

        }else{
            $plan->active = 1;
            $plan->name = $request->name;
            $plan->price = (double)$request->price;
            $plan->is_featured = (int)$request->is_featured;
            $plan->total_words = (int)$request->total_words;
            $plan->total_images = (int)$request->total_images;
            $plan->features = $request->features;
            $plan->type = $request->type;
            $plan->save();
        }

        try{
            $tmp = PaymentController::saveGatewayProducts($plan->id, $request->name, (double)$request->price, $request->frequency, $request->type);
        }catch(\Exception $ex){
            error_log("AdminController->paymentPlansSave()->PaymentController::saveGatewayProducts()\n".$ex->getMessage());
            return back()->with(['message' => $ex->getMessage(), 'type' => 'error']);
        }

    }

    // Testimonials

    /**
     * Index page of Testimonials in Admin
     */
    public function testimonials(){
        $testimonialList = Testimonials::all();
        return view('panel.admin.testimonials.index', compact('testimonialList'));
    }

    public function testimonialsNewOrEdit($id = null){
        if ($id == null){
            return view('panel.admin.testimonials.TestimonialNewOrEdit');
        }else{
            $testimonial = Testimonials::where('id', $id)->first();
            return view('panel.admin.testimonials.TestimonialNewOrEdit', compact('testimonial'));
        }
    }

    public function testimonialsDelete($id){
        $testimonial = Testimonials::where('id', $id)->first();
        $testimonial->delete();
        return back()->with(['message' => 'Testimonial is deleted.', 'type' => 'success']);
    }


    public function testimonialsSave(Request $request){
        if ($request->testimonial_id != 'undefined'){
            $testimonial = Testimonials::where('id', $request->testimonial_id)->firstOrFail();
        }else{
            $testimonial = new Testimonials();
        }

        if($request->file('avatar')){
            $file= $request->file('avatar');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('testimonialAvatar'), $filename);
            $testimonial->avatar = $filename;
        }

        $testimonial->full_name = $request->full_name;
        $testimonial->job_title = $request->job_title;
        $testimonial->words = $request->words;
        $testimonial->save();
    }


    // Testimonials End

    // How it Works

    public function howitWorksDefaults(){
        $values = json_decode('{"option": TRUE, "html": ""}');
        $default_html = 'Want to see? <a class="text-[#FCA7FF]" href="#" target="_blank">'.__('Join').' Magic</a>';

        //Check display bottom line
        $bottomline = CustomSettings::where('key', 'howitworks_bottomline')->first();
        if($bottomline != null){
            $values["option"] = $bottomline->value_int ?? 1;
            $values["html"] = $bottomline->value_html ?? $default_html;
        }else{
            $bottomline = new CustomSettings();
            $bottomline->key = 'howitworks_bottomline';
            $bottomline->title = 'Used in How it Works section bottom line. Controls visibility and HTML value of line.';
            $bottomline->value_int = 1;
            $bottomline->value_html = $default_html;
            $bottomline->save();
            $values["option"] = 1;
            $values["html"] = $default_html;
        }

        return $values;
    }

    /**
     * Index page of "How it Works" in Admin
     */
    public function howitWorks(){
        $howitWorksList = HowitWorks::all();
        $defaults = self::howitWorksDefaults();
        return view('panel.admin.howitworks.index', compact('howitWorksList', 'defaults'));
    }



    public function howitWorksNewOrEdit($id = null){
        if ($id == null){
            return view('panel.admin.howitworks.HowitWorksNewOrEdit');
        }else{
            $howitWorks = HowitWorks::where('id', $id)->first();
            return view('panel.admin.howitworks.HowitWorksNewOrEdit', compact('howitWorks'));
        }
    }

    public function howitWorksDelete($id){
        $howitWorks = HowitWorks::where('id', $id)->first();
        $howitWorks->delete();
        return back()->with(['message' => 'How it Works Step is deleted.', 'type' => 'success']);
    }


    public function howitWorksSave(Request $request){
        if ($request->howitWorks_id != 'undefined'){
            $howitWorks = HowitWorks::where('id', $request->howitWorks_id)->firstOrFail();
        }else{
            $howitWorks = new HowitWorks();
        }

        $howitWorks->order = (int)$request->order;
        $howitWorks->title = $request->title;
        $howitWorks->save();
    }

    public function howitWorksBottomLineSave(Request $request){

        $bottomline = CustomSettings::where('key', 'howitworks_bottomline')->first();
        if($bottomline != null){

            $save = 0;
            if($request->option != 'undefined' && $request->option != null){
                $bottomline->value_int = $request->option == 1 ? 1 : 0 ;
                $save=1;
            }

            if($request->text != 'undefined' && $request->text != null){
                $default_html = 'Want to see? <a class="text-[#FCA7FF]" href="#" target="_blank">'.__('Join').' Magic</a>';
                $bottomline->value_html = $request->text ?? $default_html ;
                $save=1;
            }

            if($save == 1){
                $bottomline->save();
            }

        }
    }

    // "How it Works" End

    // Clients => Bottom section of Testimonials

    /**
     * Index page of Clients in Admin
     */
    public function clients(){
        $clientList = Clients::all();
        return view('panel.admin.clients.index', compact('clientList'));
    }

    public function clientsNewOrEdit($id = null){
        if ($id == null){
            return view('panel.admin.clients.ClientNewOrEdit');
        }else{
            $client = Clients::where('id', $id)->first();
            return view('panel.admin.clients.ClientNewOrEdit', compact('client'));
        }
    }

    public function clientsDelete($id){
        $client = Clients::where('id', $id)->first();
        $client->delete();
        return back()->with(['message' => 'Client deleted.', 'type' => 'success']);
    }


    public function clientsSave(Request $request){
        if ($request->client_id != 'undefined'){
            $client = Clients::where('id', $request->client_id)->firstOrFail();
        }else{
            $client = new Clients();
        }

        if($request->file('avatar')){
            $file= $request->file('avatar');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('clientAvatar'), $filename);
            $client->avatar = $filename;
        }

        $client->alt = $request->alt;
        $client->title = $request->title;
        $client->save();
    }


    // Testimonials End


    //Affiliates
    public function affiliatesList(){
        $list = UserAffiliate::where('status', 'Waiting')->get();
        $list2 = UserAffiliate::whereNot('status', 'Waiting')->get();
        return view('panel.admin.affiliate.index', compact('list', 'list2'));
    }
    public function affiliatesListSent($id){
        $item = UserAffiliate::whereId($id)->firstOrFail();
        $item->status = 'Sent Succesfully';
        $item->save();
        return back();
    }
    //Frontend
    public function frontendSettings(){
        return view('panel.admin.frontend.settings');
    }
    public function frontendSettingsSave(Request $request){


        if (env('APP_STATUS') != 'Demo'){
            $settings = Setting::first();
            $settings->site_name = $request->site_name;
            $settings->site_url = $request->site_url;
            $settings->site_email = $request->site_email;
            $settings->frontend_pricing_section = $request->frontend_pricing_section;
            $settings->frontend_custom_templates_section = $request->frontend_custom_templates_section;
            $settings->frontend_additional_url = $request->frontend_additional_url;
            $settings->frontend_custom_css = $request->frontend_custom_css;
            $settings->frontend_custom_js = $request->frontend_custom_js;
            $settings->frontend_footer_facebook = $request->frontend_footer_facebook;
            $settings->frontend_footer_twitter = $request->frontend_footer_twitter;
            $settings->frontend_footer_instagram = $request->frontend_footer_instagram;
            $settings->frontend_code_before_head = $request->frontend_code_before_head;
            $settings->frontend_code_before_body = $request->frontend_code_before_body;
            $settings->save();

            $fSettings = FrontendSetting::first();
            $fSettings->header_title = $request->header_title;
            $fSettings->header_text = $request->header_text;

            $fSettings->sign_in = $request->sign_in;
            $fSettings->join_hub = $request->join_hub;

            $fSettings->hero_subtitle = $request->hero_subtitle;
            $fSettings->hero_title = $request->hero_title;
            $fSettings->hero_title_text_rotator = $request->hero_title_text_rotator;
            $fSettings->hero_description = $request->hero_description;
            $fSettings->hero_scroll_text = $request->hero_scroll_text;
            $fSettings->hero_button = $request->hero_button;
            $fSettings->hero_button_url = $request->hero_button_url;

            $fSettings->footer_header = $request->footer_header;
            $fSettings->footer_text_small = $request->footer_text_small;
            $fSettings->footer_text = $request->footer_text;
            $fSettings->footer_button_text = $request->footer_button_text;
            $fSettings->footer_button_url = $request->footer_button_url;
            $fSettings->footer_copyright = $request->footer_copyright;
            $fSettings->save();


            $logo_types = [
                'logo' => '',
                'logo_dark' => 'dark',
                'logo_sticky' => 'sticky',
                'logo_dashboard' => 'dashboard',
                'logo_dashboard_dark' => 'dashboard-dark',
                'logo_collapsed' => 'collapsed',
                'logo_collapsed_dark' => 'collapsed-dark',
                // retina
                'logo_2x' => '2x',
                'logo_dark_2x' => 'dark-2x',
                'logo_sticky_2x' => 'sticky-2x',
                'logo_dashboard_2x' => 'dashboard-2x',
                'logo_dashboard_dark_2x' => 'dashboard-dark-2x',
                'logo_collapsed_2x' => 'collapsed-2x',
                'logo_collapsed_dark_2x' => 'collapsed-dark-2x',
            ];

            foreach( $logo_types as $logo => $logo_prefix ) {

                if ($request->hasFile($logo)) {
                    $path = 'upload/images/logo/';
                    $image = $request->file($logo);
                    $image_name = Str::random(4) . '-'. $logo_prefix .'-' . Str::slug($settings->site_name) . '-logo.' . $image->getClientOriginalExtension();

                    //Resim uzantı kontrolü
                    $imageTypes = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
                    if (!in_array(Str::lower($image->getClientOriginalExtension()), $imageTypes)) {
                        $data = array(
                            'errors' => ['The file extension must be jpg, jpeg, png, webp or svg.'],
                        );
                        return response()->json($data, 419);
                    }

                    $image->move($path, $image_name);

                    $settings->{$logo.'_path'} = $path . $image_name;
                    $settings->{$logo} = $image_name;
                    $settings->save();
                }

            }

            if ($request->hasFile('favicon')){
                $path = 'upload/images/favicon/';
                $image = $request->file('favicon');
                $image_name = Str::random(4).'-'.Str::slug($settings->site_name).'-favicon.'.$image->getClientOriginalExtension();

                //Resim uzantı kontrolü
                $imageTypes = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
                if (!in_array(Str::lower($image->getClientOriginalExtension()), $imageTypes)){
                    $data = array(
                        'errors' => ['The file extension must be jpg, jpeg, png, webp or svg.'],
                    );
                    return response()->json($data, 419);
                }

                $image->move($path, $image_name);

                $settings->favicon_path = $path.$image_name;
                $settings->favicon = $image_name;
                $settings->save();
            }
        }

    }

    //Section Settings
    public function frontendSectionSettings(){
        return view('panel.admin.frontend.section_settings');
    }
    public function frontendSectionSettingsSave(Request $request){

        if (env('APP_STATUS') != 'Demo'){
            $settings = FrontendSectionsStatusses::first();
            $settings->features_active = $request->features_active;
            $settings->features_title = $request->features_title;
            $settings->features_description = $request->features_description;

            $settings->generators_active = $request->generators_active;

            $settings->who_is_for_active = $request->who_is_for_active;

            $settings->custom_templates_active = $request->custom_templates_active;
            $settings->custom_templates_subtitle_one = $request->custom_templates_subtitle_one;
            $settings->custom_templates_subtitle_two = $request->custom_templates_subtitle_two;
            $settings->custom_templates_title = $request->custom_templates_title;
            $settings->custom_templates_description = $request->custom_templates_description;


            $settings->tools_active = $request->tools_active;
            $settings->tools_title = $request->tools_title;
            $settings->tools_description = $request->tools_description;

            $settings->how_it_works_active = $request->how_it_works_active;
            $settings->how_it_works_title = $request->how_it_works_title;

            $settings->testimonials_active = $request->testimonials_active;
            $settings->testimonials_title = $request->testimonials_title;
            $settings->testimonials_subtitle_one = $request->testimonials_subtitle_one;
            $settings->testimonials_subtitle_two = $request->testimonials_subtitle_two;




            $settings->pricing_active = $request->pricing_active;
            $settings->pricing_title = $request->pricing_title;
            $settings->pricing_description = $request->pricing_description;
            $settings->pricing_save_percent = $request->pricing_save_percent;

            $settings->faq_active = $request->faq_active;
            $settings->faq_title = $request->faq_title;
            $settings->faq_subtitle = $request->faq_subtitle;
            $settings->faq_text_one = $request->faq_text_one;
            $settings->faq_text_two = $request->faq_text_two;


            $settings->save();


        }

    }

    //Menu
    public function menuSettings(){
        return view('panel.admin.frontend.menu');
    }

    public function menuSettingsSave(Request $request){

        if (env('APP_STATUS') != 'Demo'){
            $settings = Setting::first();
            $settings->menu_options = $request->menu_options;
            $settings->save();
        }

    }

    //Frontend Frequently asked questions, FAQ
    public function frontendFaq(){
        $faq = Faq::orderBy('created_at', 'desc')->get();
        return view('panel.admin.frontend.faq.index', compact('faq'));
    }


    public function frontendFaqcreateOrUpdate($id = null){
        if ($id == null){
            $faq = null;
        }else{
            $faq = Faq::where('id', $id)->firstOrFail();
        }
        return view('panel.admin.frontend.faq.form', compact('faq'));
    }

    public function frontendFaqcreateOrUpdateSave(Request $request){
        if ($request->faq_id != 'undefined'){
            $faq = Faq::where('id', $request->faq_id)->firstOrFail();
        }else{
            $faq = new Faq();
        }

        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();
    }

    public function frontendFaqDelete($id){
        $faq = Faq::where('id', $id)->firstOrFail();
        $faq->delete();

        return back()->with(['message' => 'Faq deleted succesfully', 'type' => 'success']);
    }



    //Frontend Tools Section

    public function frontendTools(){
        $items = FrontendTools::orderBy('created_at', 'desc')->get();
        return view('panel.admin.frontend.tools.index', compact('items'));
    }


    public function frontendToolscreateOrUpdate($id = null){
        if ($id == null){
            $item = null;
        }else{
            $item = FrontendTools::where('id', $id)->firstOrFail();
        }
        return view('panel.admin.frontend.tools.form', compact('item'));
    }

    public function frontendToolscreateOrUpdateSave(Request $request){
        if ($request->item_id != 'undefined'){
            $item = FrontendTools::where('id', $request->item_id)->firstOrFail();
        }else{
            $item = new FrontendTools();
        }
        $item->title = $request->title;
        $item->description = $request->description;

        if ($request->hasFile('image')) {
            $path = 'upload/images/frontent/tools/';
            $image = $request->file('image');
            $image_name = Str::random(4) . '-' . Str::slug($request->title) . '.' . $image->getClientOriginalExtension();

            //Resim uzantı kontrolü
            $imageTypes = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
            if (!in_array(Str::lower($image->getClientOriginalExtension()), $imageTypes)) {
                $data = array(
                    'errors' => ['The file extension must be jpg, jpeg, png, webp or svg.'],
                );
                return response()->json($data, 419);
            }

            $image->move($path, $image_name);

            $item->image = $path . $image_name;
        }

        $item->save();
    }

    public function frontendToolsDelete($id){
        $item = FrontendTools::where('id', $id)->firstOrFail();
        $item->delete();
        return back()->with(['message' => 'Item deleted succesfully', 'type' => 'success']);
    }







    //Future of ai section
    public function frontendFuture(){
        $items = FrontendFuture::orderBy('created_at', 'desc')->get();
        return view('panel.admin.frontend.future.index', compact('items'));
    }


    public function frontendFuturecreateOrUpdate($id = null){
        if ($id == null){
            $item = null;
        }else{
            $item = FrontendFuture::where('id', $id)->firstOrFail();
        }
        return view('panel.admin.frontend.future.form', compact('item'));
    }

    public function frontendFuturecreateOrUpdateSave(Request $request){
        if ($request->item_id != 'undefined'){
            $item = FrontendFuture::where('id', $request->item_id)->firstOrFail();
        }else{
            $item = new FrontendFuture();
        }
        $item->title = $request->title;
        $item->description = $request->description;
        $item->image = $request->image;
        $item->save();
    }

    public function frontendFutureDelete($id){
        $item = FrontendFuture::where('id', $id)->firstOrFail();
        $item->delete();
        return back()->with(['message' => 'Item deleted succesfully', 'type' => 'success']);
    }






    //Who is for section
    public function frontendWhois(){
        $items = FrontendForWho::orderBy('created_at', 'desc')->get();
        return view('panel.admin.frontend.who_is_for.index', compact('items'));
    }


    public function frontendWhoiscreateOrUpdate($id = null){
        if ($id == null){
            $item = null;
        }else{
            $item = FrontendForWho::where('id', $id)->firstOrFail();
        }
        return view('panel.admin.frontend.who_is_for.form', compact('item'));
    }

    public function frontendWhoiscreateOrUpdateSave(Request $request){
        if ($request->item_id != 'undefined'){
            $item = FrontendForWho::where('id', $request->item_id)->firstOrFail();
        }else{
            $item = new FrontendForWho();
        }
        $item->title = $request->title;
        $item->color = $request->color;
        $item->save();
    }

    public function frontendWhoisDelete($id){
        $item = FrontendForWho::where('id', $id)->firstOrFail();
        $item->delete();
        return back()->with(['message' => 'Item deleted succesfully', 'type' => 'success']);
    }


    //Generator list


    public function frontendGeneratorlist(){
        $items = FrontendGenerators::orderBy('created_at', 'desc')->get();
        return view('panel.admin.frontend.generators_list.index', compact('items'));
    }


    public function frontendGeneratorlistcreateOrUpdate($id = null){
        if ($id == null){
            $item = null;
        }else{
            $item = FrontendGenerators::where('id', $id)->firstOrFail();
        }
        return view('panel.admin.frontend.generators_list.form', compact('item'));
    }

    public function frontendGeneratorlistcreateOrUpdateSave(Request $request){
        if ($request->item_id != 'undefined'){
            $item = FrontendGenerators::where('id', $request->item_id)->firstOrFail();
        }else{
            $item = new FrontendGenerators();
        }

        if ($request->hasFile('image')){
            $path = 'upload/images/generatorlist/';
            $image = $request->file('image');
            $image_name = Str::random(4).'-'.Str::slug($request->title).'-image.'.$image->getClientOriginalExtension();

            //Resim uzantı kontrolü
            $imageTypes = ['jpg', 'jpeg', 'png', 'svg', 'webp'];
            if (!in_array(Str::lower($image->getClientOriginalExtension()), $imageTypes)){
                $data = array(
                    'errors' => ['The file extension must be jpg, jpeg, png, webp or svg.'],
                );
                return response()->json($data, 419);
            }

            $image->move($path, $image_name);

            $item->image = $path.$image_name;
        }




        $item->menu_title = $request->menu_title;
        $item->subtitle_one = $request->subtitle_one;
        $item->subtitle_two = $request->subtitle_two;
        $item->title = $request->title;
        $item->text = $request->text;
        $item->image_title = $request->image_title;
        $item->image_subtitle = $request->image_subtitle;
        $item->color = $request->color;
        $item->save();
    }

    public function frontendGeneratorlistDelete($id){
        $item = FrontendGenerators::where('id', $id)->firstOrFail();
        $item->delete();
        return back()->with(['message' => 'Item deleted succesfully', 'type' => 'success']);
    }


      public function composer()
    {
        $getComposerData = ComposerType::where('user_id', Auth::user()->id)->get();

        return view('panel.admin.composer.composer',compact('getComposerData'));
    }

    public function composerTypeCheck(Request $request)
    {
        $user_id = Auth::user()->id;
        $requestData = $request->input('selectedValues'); // Assuming the array is under 'selectedValues' key.

        // Update the status for matching titles
        foreach($requestData as $key => $value){
            switch($key){
                case "Documents":
                    $result = ComposerType::where('user_id', $user_id)->where('title', 'Documents')->update(['status' => $value]);
                break;
                 case "AI Writer":
                    $result = ComposerType::where('user_id', $user_id)->where('title', 'AI Writer')->update(['status' => $value]);
                break;
                 case "AI Image":
                    $result = ComposerType::where('user_id', $user_id)->where('title', 'AI Image')->update(['status' => $value]);
                break;
                 case "AI Chat":
                    $result = ComposerType::where('user_id', $user_id)->where('title', 'AI Chat')->update(['status' => $value]);
                break;
                 case "AI Code":
                    $result = ComposerType::where('user_id', $user_id)->where('title', 'AI Code')->update(['status' => $value]);
                break;
                 case "AI Speech to Text":
                    $result = ComposerType::where('user_id', $user_id)->where('title', 'AI Speech to Text')->update(['status' => $value]);
                break;
                 default:
                  $result = 'Something went wrong';
                break;
            }
        }
        if ($result) {
            return response()->json(['status' => true, 'data' => $result, 'message' => 'Status updated successfully.']);
        } else {
            return response()->json(['status' => false, 'message' => 'Something went wrong.']);
        }
    }

    public function addNewWorkSpace(Request $request)
    {
        
        $data = new Workspace();

        // $checkWorkspaceNameExist = Workspace::where('name_space',$request->name);
        // if($checkWorkspaceNameExist){
        //     return response()->json(['status' => false,'message' => 'The workspace name already exist.']);
        // }

        $data->user_id = Auth::user()->id;
        $data->name_space = $request->name;

        $data->save();

        if($data){
            return response()->json(['status' => true, 'data' => $data, 'message' => 'Name space add successfully.']);
        }else{
            return response()->json(['status' => false,'message' => 'Something went wrong.']);
        }
    }


    public function getOpenaiDetails($type){

        $getOpenaiDetail = OpenAIGenerator::select('id','title')->where('filters',$type)->get();

        return response()->json(['status' => true, 'data' => $getOpenaiDetail, 'message' => 'Get AI data successfully.']);
    }

    public function addWorkSpaceGroup(Request $request)
    {
        // dd($request->all());

        $requestData = new WorkspaceGroupType();

        $requestData->workspace_id = $request->workspace_id;
        $requestData->workspace_temp_type = $request->temp_data_type;
        $requestData->workspace_item = json_encode($request->checkboxValues);

        $requestData->save();

        if($requestData){
            return response()->json(['status' => true, 'data' => $requestData, 'message' => 'Save data successfully.']);
        }else{
            return response()->json(['status' => false, 'message' => 'Something went wrong.']);
        }
    }

    public function workspaceDelete($id){
        $deleteData = WorkspaceGroupType::find($id)->delete();
         if($deleteData){
             return back()->with('message', 'Data deleted successfully.');
        }else{
            return back()->with('error', 'Something went wrong.');
        }
    }


}

