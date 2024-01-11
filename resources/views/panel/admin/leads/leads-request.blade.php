@extends('panel.layout.app')
@section('title', 'My Account')

@section('content')

    <style>
        .caption-left {
            justify-content: left;
            padding-bottom: 8px;
            font-weight: 600;
            font-size: 25px;
            color: #330582;
        }
    </style>
    <script>
        var leadId = '{{ $leadId }}';
    </script>
    <!--section starts-->
    <section class="dashboard-section-area load-request-area">
        <div class="container">
            <div class="row">
                <h3 class="caption-left"> Leads Request</h3>
                <aside class="col-md-12">
                @if(count($leads) > 0)
                    @foreach ($leads as $lead)
                        <div class="table-top-box show-drp" onclick="leadsRequest({{ $lead->id }})">
                        <div class="row lead-request-content-box">
                        <div class="col-md-10">
                            <div class="lead-left-content-section">
                                <div class="lead-image-area">
                                                <img style="width:30%;cursor:zoom-in"
												onclick="document.getElementById('modal01').style.display='block'" src='<?php echo 'data:image/jpg;base64,' . $lead->lead_image; ?>'>
                                </div>
                                           
                                <div class="lead-mid-content-area">
                                                <h6 class="m-0 p-0 mb-2">{{ $lead->full_name }}</h6>
                                                <p class="m-0 p-0 mb-1">{{ $lead->site_address }} </p>
                                                <p class="m-0 p-0"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                    {{ $lead->city }} {{ $lead->postal_code }}</p>
                                </div>

                                <div class="lead-mid-box-content-area">
                                                <p class="m-0 p-0 mb-2"> Property Age : {{ $lead->age_of_property}}</p>
                                                <p class="m-0 p-0 mb-1">Property Type : {{ $lead->type_of_property}} </p>
                                                <p class="m-0 p-0 mb-1">Property Area : {{ $lead->area_of_property }} </p>
                                </div>
                                <div class="lead-mid-box-content-area">
                                                <h6 class="m-0 p-0 mb-2">Services</h6>
                                                <p class="m-0 p-0 mb-1">{{  ($lead->service_name) }}</p>
                                                
                                </div>
                            </div>
                         
                        </div>
                           
                            <div class="col-md-2 lead-request-right-content-area">
                            <h5>Credit Value : {{ $lead->credit_value }}</h5>
                            @php
                                            // Convert the input string to a Carbon instance
                                            $inputDate = \Carbon\Carbon::parse($lead->created_at);

                                            // Calculate the time difference in hours
                                            $hoursDifference = now()->diffInHours($inputDate);

                                            // Format the result
                                            if ($hoursDifference >= 24) {
                                                $daysDifference = now()->diffInDays($inputDate);
                                                $result = $daysDifference . ' ' . __('day', ['count' => $daysDifference]) . ' ' . __('ago');
                                            } elseif ($hoursDifference > 0) {
                                                $result = $hoursDifference . ' ' . __('hour', ['count' => $hoursDifference]) . ' ' . __('ago');
                                            } else {
                                                $minutesDifference = now()->diffInMinutes($inputDate);
                                                $result = $minutesDifference . ' ' . __('minute', ['count' => $minutesDifference]) . ' ' . __('ago');
                                            }
                                        @endphp
                            <p class="green-txt">{{ $result }}</p>
                                {{-- @if ($lead->status == 'pending') --}}
                                    <button class="contatc-btn" variant="unset"
                                        onclick="contactToLead({{ $lead->id }})">Contact
                                        {{ $lead->full_name }}</button>
                                {{-- @endif --}}
                            </div>
                        </div>
                            <!-- <table class="table mb-0">
                                <tbody>
                                    <tr>

                                        <td>
                                            <div>
                                                <h6 class="m-0 p-0 mb-2">{{ $lead->full_name }}</h6>
                                                <p class="m-0 p-0 mb-1">{{ $lead->site_address }} </p>
                                                <p class="m-0 p-0"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                    {{ $lead->city }} {{ $lead->postal_code }}</p>
                                            </div>
                                        </td>
                                        <td>
                                              <h5>Credit Value : {{ $lead->credit_value }}</h5>
                                            {{-- <div>
                                              
												<p><b>Work Type : </b> {{ $lead->type_of_work }}</p>
												<p><b>Property Type : </b> {{ $lead->type_of_property }}</p>
												<p><b>Area of the Property : </b> {{ $lead->area_of_property }}</p>
												
												{{-- <p>15 Credit</p> 
											</div> --}}
                                        </td>
                                        <td>
                                            <div class="lead-image-area">
                                                <img style="width:30%;cursor:zoom-in"
                                                
												onclick="document.getElementById('modal01').style.display='block'" src='<?php echo 'data:image/jpg;base64,' . $lead->lead_image; ?>'>

                                                {{-- <p class="call-text"><b><i class="fa fa-phone" aria-hidden="true"></i> {{ $lead->phone_number }}
												</b> </p> --}}
                                            </div>
                                        </td>
                                        @php
                                            // Convert the input string to a Carbon instance
                                            $inputDate = \Carbon\Carbon::parse($lead->created_at);

                                            // Calculate the time difference in hours
                                            $hoursDifference = now()->diffInHours($inputDate);

                                            // Format the result
                                            if ($hoursDifference >= 24) {
                                                $daysDifference = now()->diffInDays($inputDate);
                                                $result = $daysDifference . ' ' . __('day', ['count' => $daysDifference]) . ' ' . __('ago');
                                            } elseif ($hoursDifference > 0) {
                                                $result = $hoursDifference . ' ' . __('hour', ['count' => $hoursDifference]) . ' ' . __('ago');
                                            } else {
                                                $minutesDifference = now()->diffInMinutes($inputDate);
                                                $result = $minutesDifference . ' ' . __('minute', ['count' => $minutesDifference]) . ' ' . __('ago');
                                            }
                                        @endphp
                                        <td><span class="green-txt">{{ $result }}</span></td>
                                    </tr>
                                </tbody>
                            </table> -->
                            {{-- <div class="down-icon down-icon-show" id="downIconShow-{{$lead->id}}">
								<img  src="/assets/img/triangle-icon.png" />
							</div> --}}

                        </div>

                        <div class="inner-content-area" id="leadsDetails-{{ $lead->id }}" style="display: none;">
                            <div class="row">
                                <h6>Details</h6>
                                <div class="col-md-4">
                                    <p>Phone</p>
                                    <h5>
                                        @if ($lead->status == 'pending')
                                            <?php
                                            echo str_repeat('*', strlen("$lead->phone_number") - 5) . substr("$lead->phone_number", -5);
                                            ?>
                                        @else
                                            <?php
                                            echo $lead->phone_number;
                                            ?>
                                        @endif
                                    </h5>
                                </div>
                                <div class="col-md-4">
                                    <p>Email</p>
                                    <h5>

                                        @if ($lead->status == 'pending')
                                            <?php
                                            echo str_repeat('*', strlen("$lead->email") - 5) . substr("$lead->email", -5);
                                            ?>
                                        @else
                                            <?php
                                            echo $lead->email;
                                            ?>
                                        @endif



                                    </h5>
                                </div>

                                <div class="col-md-4">
                                    <p>Credit Value</p>
                                    <h5>
                                    <h5>{{ $lead->credit_value }}</h5>
                                    </h5>
                                </div>



                                <div class="col-md-4">
                                    <p>Work Type</p>
                                    <h5>{{ $lead->type_of_work }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <p>Property Type</p>
                                    <h5>{{ $lead->type_of_property }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <p>Property Area</p>
                                    <h5>{{ $lead->area_of_property }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <p>Property Age</p>
                                    <h5>{{ $lead->age_of_property }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <p>How soon would you like the project to begin?</p>
                                    <h5>{{ $lead->project_to_begin }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <p>How likely are you to make a hiring decision?</p>
                                    <h5>{{ $lead->hiring_decision }}</h5>
                                </div>
                                <div class="col-md-4">
                                    <p>Additional details</p>
                                    <h5>{{ $lead->additional_details }}</h5>
                                </div>
                            </div>
                            <!-- <div class="col-md-4 mb-0">
                                {{-- <button class="contatc-btn" variant="unset" onclick="contactToLead({{$lead->id}})" data-bs-toggle="modal" data-bs-target="#exampleModal">Contact {{$lead->full_name}}</button> --}}
                                @if ($lead->status == 'pending')
                                    <button class="contatc-btn" variant="unset"
                                        onclick="contactToLead({{ $lead->id }})">Contact
                                        {{ $lead->full_name }}</button>
                                @endif
                            </div> -->
                        </div>
						<div id="modal01" class="w3-modal" onclick="this.style.display='none'">
							<span class="w3-button w3-hover-red w3-xlarge w3-display-topright">&times;</span>
							<!-- <div class="w3-modal-content w3-animate-zoom">
								<img  src='<?php echo 'data:image/jpg;base64,' . $lead->lead_image; ?>'>
							</div> -->
						  </div>
            @endforeach

            @else
					<div class="no-record-area">
						<h2>No Records Found</h2>
						</div>
					@endif
            </aside>
        </div>
        </div>
    </section>
    <!--section ends-->

    <div class="modal top-up-box-area" id="addLeadsModal" tabindex="-1">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Top Up Required</h5>
        <p>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      @foreach($credits as $credit)
        <div id="selected" class="top-up-content-inner" data-id="{{$credit->id}}">
              <div class="top-up-contnent-left">
              <h6><td class="sort-name">About {{$credit->leads_count}} Responses</td></h6>
               <h6><td class="sort-user">{{$credit->credit_value}} Credits</td></h6>
              </div>
              <div class="top-up-contnent-right">
                <h6><td class="sort-email">C${{$credit->amount}}</td></h6>
                <?php $amt = $credit->amount / $credit->leads_count;
                ?>
                <p>C${{number_format($amt,2)}}/credit
                </div>
        </div>
        @endforeach
       </div>  
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="connect-to-stripe" class="btn btn-primary" onclick="contactToStripe()">Save</button>
      </div>
    </div>
  </div>
</div>

    <div class="modal fade" id="leadsDetail" tabindex="-1" aria-labelledby="leadsDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="leadsDetailLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="data-inner">
                        <h6>Phone Number</h6>
                        <span id="leads_phone"></span>
                    </div>
                    <div class="data-inner">
                        <h6>Email</h6>
                        <span id="leads_email"></span>
                    </div>
                    <div class="data-inner">
                        <h6>How soon would you like the project to begin?</h6>
                        <p>ASAPs</p>
                    </div>
                    <div class="data-inner">
                        <h6>How likely are you to make a hiring decision?</h6>
                        <p>I'm ready to hire now</p>
                    </div>
                    <div class="data-inner">
                        <h6>Additional details</h6>
                        <p>Brand new business</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="/assets/js/panel/leads-request.js"></script>
@endsection
