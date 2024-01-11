@extends('panel.layout.app')
@section('title', 'My Account')

@section('content')
<style>
	.caption-left{
		justify-content: left;
		padding-bottom: 8px;
		font-weight: 600;
		font-size: 25px;
		color: #330582;
	}
</style>


    <!--section starts-->
	<section class="dashboard-section-area load-request-area">
		<div class="container">
			<div class="row">
				<h3 class="caption-left"> My Responses </h3>
				<aside class="col-md-12">

					@if(count($leads) > 0)
						@foreach ($leads as $lead)
						<div class="table-top-box show-drp" onclick="leadsRequest({{$lead->id}})">
						<div class="row lead-request-content-box">
                        <div class="col-md-9">
                            <div class="lead-left-content-section">
                                <div class="lead-image-area">
                                                <img style="width:30%;cursor:zoom-in"
												onclick="document.getElementById('modal01').style.display='block'" src='<?php echo 'data:image/jpg;base64,' . $lead->lead_image; ?>'>

                                                {{-- <p class="call-text"><b><i class="fa fa-phone" aria-hidden="true"></i> {{ $lead->phone_number }}
												</b> </p> --}}
                                            </div>
                                           
                                            <div class="lead-mid-content-area">
                                                <h6 class="m-0 p-0 mb-2">{{ $lead->full_name }}</h6>
                                                <p class="m-0 p-0 mb-1">{{ $lead->site_address }} </p>
                                                <p class="m-0 p-0"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                    {{ $lead->city }} {{ $lead->postal_code }}</p>
                                 </div>
                                 <div class="lead-mid-box-content-area">
                                                <h6 class="m-0 p-0 mb-2">{{ $lead->full_name }}</h6>
                                                <p class="m-0 p-0 mb-1">{{ $lead->site_address }} </p>
                                                <p class="m-0 p-0"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                    {{ $lead->city }} {{ $lead->postal_code }}</p>
                                 </div>
                                 <div class="lead-mid-box-content-area">
                                                <h6 class="m-0 p-0 mb-2">{{ $lead->full_name }}</h6>
                                                <p class="m-0 p-0 mb-1">{{ $lead->site_address }} </p>
                                                <p class="m-0 p-0"><i class="fa fa-map-marker" aria-hidden="true"></i>
                                                    {{ $lead->city }} {{ $lead->postal_code }}</p>
                                 </div>
                                </div>
                         
                                            </div>
                           
                            <div class="col-md-3 lead-request-right-content-area">
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
                            <button class="status-bottom-btn">Status</button>
                            </div>
                        </div>
							<!-- <table class="table mb-0">
								<tbody>
									<tr>
										<td>
											<div>
												<h6>{{$lead->full_name}}</h6>
												<p>{{$lead->site_address}} </p>
												<p><i class="fa fa-map-marker" aria-hidden="true"></i> {{$lead->city}} {{$lead->postal_code}}</p>
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
											<div  class="lead-image-area">
												<img src='<?php echo 'data:image/jpg;base64,'. $lead->lead_image ?>'>
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
										<td><span class="green-txt">{{$result}}</span></td>
									</tr>
								</tbody>
							</table> -->
							{{-- <div class="down-icon down-icon-show" id="downIconShow-{{$lead->id}}">
								<img  src="/assets/img/triangle-icon.png" />
							</div> --}}
							
						</div>

						<div class="inner-content-area" id="leadsDetails-{{$lead->id}}" style="display: none;">
							<div class="row">
								<h6>Details</h6>
								<div class="col-md-4">
									
											<p>Phone</p>
											<h5> {{ $lead->phone_number }}</h5>
								</div>
								<div class="col-md-4">
											<p>Email</p>
											<h5> {{ $lead->email }}</h5>
								</div>
								<div class="col-md-4">
											<p>Work Type</p>
											<h5>{{ $lead->type_of_work }}</h5>
								</div>
								<div class="col-md-4">
											<p>Property Type</p>
											<h5>{{$lead->type_of_property}}</h5>
								</div>
								<div class="col-md-4">
											<p>Property Area</p>
											<h5>{{$lead->area_of_property}}</h5>
								</div>
								<div class="col-md-4">
											<p>Property Age</p>
											<h5>{{$lead->age_of_property}}</h5>
								</div>
								<div class="col-md-4">
											<p>How soon would you like the project to begin?</p>
											<h5>ASAPs</h5>
								</div>
								<div class="col-md-4">
											<p>How likely are you to make a hiring decision?</p>
											<h5>I'm ready to hire now</h5>
								</div>
								<div class="col-md-4">
											<p>Additional details</p>
											<h5>Brand new business</h5>
								</div>
								<div class="col-md-4">
								{{-- <button class="contatc-btn" variant="unset" onclick="contactToLead({{$lead->id}})" data-bs-toggle="modal" data-bs-target="#exampleModal">Contact {{$lead->full_name}}</button> --}}
								@if($lead->status == 'pending')
									<button class="contatc-btn" variant="unset">{{$lead->status}}</button>
								@endif
							</div>
							</div>
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
			  <button type="button" class="btn btn-primary">Save</button>
			</div>
		  </div>
		</div>
	  </div>
@endsection

@section('script')
    <script src="/assets/js/panel/leads-response.js"></script>
@endsection