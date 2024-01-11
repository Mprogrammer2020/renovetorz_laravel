<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeadsRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;

    /**
     * Create a new job instance.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $leads_data = $this->details;
        
        $leads_services = Service::leftJoin('lead_services','lead_services.service_id', '=', 'services.id')
                                    ->where('lead_services.lead_id',$leads_data->id)
                                    ->get();
                                    
        $services = [];
        foreach($leads_services as $leads_service){
            array_push($services, $leads_service->name);
        }

        $contractors = User::select('users.*','user_services.service_id', DB::raw('GROUP_CONCAT(services.name) as service_name'))
                            ->leftJoin('user_services','user_services.user_id', '=', 'users.id')
                            ->leftJoin('services', 'services.id', '=', 'user_services.service_id')
                            ->whereIn('services.name', $services)    
                            ->where('role_id',3)
                            ->get();

        $new_services = implode(", ", $services);
        
        foreach($contractors as $contractor){
            
            $test = Mail::send('mail.leads-request', [
                'contractor_name' => $contractor->name,
                'lead_name' => $leads_data->full_name,
                'site_address' => $leads_data->site_address,
                'city' => $leads_data->city,
                'postal_code' => $leads_data->postal_code,
                'services' => $new_services 

            ], function ($message) use ($contractor) {
                $message->to($contractor->email);
                $message->subject('New Leads Request is coming.');
            });
        }
    }
}
