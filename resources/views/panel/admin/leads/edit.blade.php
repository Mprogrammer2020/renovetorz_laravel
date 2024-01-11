@extends('panel.layout.app')
@section('title', 'My Account')

@section('content')
<style>
	#css-dropdown
{
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    width: 300px;
    height: 42px;
    margin: 100px auto 0 auto;
}

.select2-dropdown {
    z-index:999999 !important;
}
</style>

    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
					<a href="{{ LaravelLocalization::localizeUrl(route('dashboard.index')) }}" class="page-pretitle flex items-center">
						<svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
						</svg>
						{{__('Back to dashboard')}}
					</a>
                    <h2 class="page-title mb-2">
                        Edit Leads Information
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body pt-6">
        <div class="container-xl">
			<div class="row">
				<div class="col-md-12 mx-auto">
				    {{-- {{ dd($lead)}} --}}
					<form id="user_edit_form" action="" enctype="multipart/form-data">
						<div class="row">
                        <input type="hidden" class="form-control" id="lead_image_id" name="lead_image_id" value="{{$lead->lead_image_id}}">
						<input type="hidden" class="form-control" id="lead_id" name="lead_id" value="{{$lead->id}}">
							<div class="col-md-12 col-xl-12">

								<div class="row">

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Full Name')}}</label>
											<input type="text" class="form-control" id="name" name="name" value="{{$lead->full_name}}">
										</div>
									</div>
									<div class="col-6">
										<!-- <div class="mb-[20px]">
											<label class="form-label">{{__('Last Name')}}</label>
											<input type="text" class="form-control" id="surname" name="surname" value="">
										</div> -->

										<div class="mb-[20px]">
											<label class="form-label">{{__('Email')}}</label>
											<input type="email" class="form-control" id="email" name="email" value="{{$lead->email}}">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Phone')}}</label>
											<input type="text" name="phone" id="phone" class="form-control"  data-mask-visible="true"  autocomplete="off" value="{{$lead->phone_number}}" maxlength="12"/>
										</div>
									</div>
								

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Site Address')}}</label>
											<input type="email" class="form-control" id="address" name="address" value="{{$lead->site_address}}">
										</div>
									</div>
									<div class="col-6">
										<!-- <div class="mb-[20px]">
											<label class="form-label">{{__('Age of Home')}}</label>
											<input type="email" class="form-control" value="">
										</div> -->

										<div class="mb-[20px]">
											<label class="form-label">{{__('City')}}</label>
											<input type="text" class="form-control" id="city" name="city" value="{{$lead->city}}">
										</div>


									
									</div>
									<div class="col-6">
									<div class="mb-[20px]">
											<label class="form-label">{{__('Postal Code')}}</label>
											<input type="number" class="form-control" id="postal" name="postal" value="{{$lead->postal_code}}">
										</div>
									</div>
									<div class="col-6">
									<div class="mb-[20px]">
										<label class="form-label">{{__('What kind of work')}}</label>
										<select type="text" class="form-select" name="work" id="work">
											<option value="Bath" {{ $lead->type_of_work == 'Bath' ? 'selected' : '' }}>Bath</option>
											<option value="Kitchen" {{ $lead->type_of_work == 'Kitchen' ? 'selected' : '' }}>Kitchen</option>
											<option value="Basement" {{ $lead->type_of_work == 'Basement' ? 'selected' : '' }}>Basement</option>
											<option value="Home Renovation" {{ $lead->type_of_work == 'Home Renovation' ? 'selected' : '' }}>Home Renovation</option>
											<option value="Commercial Unit" {{ $lead->type_of_work == 'Commercial Unit' ? 'selected' : '' }}>Commercial Unit</option>
											<option value="Custom House" {{ $lead->type_of_work == 'Custom House' ? 'selected' : '' }}>Custom House</option>
										</select>
									</div>
								</div>

								
                                   <div class="col-6">
								   <div class="mb-[20px]">
									<label class="form-label">{{__('Property Type')}}</label>
									<select type="text" class="form-select" name="property" id="property">
									<option value="Detached" {{ $lead->type_of_property == 'Detached' ? 'selected' : '' }}>Detached</option>
									<option value="Semi-Detached" {{ $lead->type_of_property == 'Semi-Detached' ? 'selected' : '' }}>Semi-Detached</option>
									<option value="Bungalow" {{ $lead->type_of_property == 'Bungalow' ? 'selected' : '' }}>Bungalow</option>
									<option value="Townhouse" {{ $lead->type_of_property == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
								</select>

								</div>
								   </div>
								   <div class="col-6">
									<div class="mb-[20px]">
										<label class="form-label">{{__('Area of the Basement (sq feet)')}}</label>
										<input type="text" class="form-control" id="basement" name="basement" value="{{$lead->area_of_property}}">
									</div>
								</div>


								<div class="col-6">    
    								<label class="form-label">{{__('Permit')}}</label>
    								<input type="radio" id="permit_na" name="permit" value="NA" {{ $lead->permit == 'NA' ? 'checked' : '' }}> NA<br><br>
    								<input type="radio" id="permit_to_be_applied" name="permit" value="To Be Applied" {{ $lead->permit == 'To Be Applied' ? 'checked' : '' }}> To Be Applied<br><br>
    								<input type="radio" id="permit_applied" name="permit" value="Applied" {{ $lead->permit == 'Applied' ? 'checked' : '' }}> Applied<br>
								</div>


								<div class="col-6">
									<div class="mb-[20px]">
									<br>
										<label class="form-label">{{__('Age Of The Property')}}</label>
										<input type="number" class="form-control" id="age" name="age" value="{{$lead->age_of_property}}">
									</div>

								
								</div>

								<div class="col-6">
								<div class="mb-[20px]">
									<br>
										{{-- <label class="form-label">{{__('Prefer Time For First Meeting')}}</label>
										<input type="date" class="form-control" id="meeting" name="meeting" value="{{$lead->formatted_first_meeting}}"> --}}
										<label class="form-label">{{__('Prefer Time For First Meeting')}}</label>
										<input type="date" class="form-control" id="meeting" name="meeting" value="{{ $lead->formatted_first_meeting }}" min="<?php echo date("Y-m-d"); ?>">
									</div>
								</div>

								<div class="col-12">
                                        <div class="mb-[20px]">
                                            <label class="form-label">{{__('Budget')}}</label>
                                            <span class="input-symbol-euro doller-icon">
                                            <input type="number" class="form-control" name="budget" id="budget" value="{{$lead->budget}}">
                                            <div id="name-error" class="validation-error"></div>
                                        </div>
                                </div>


								<div class="col-6">
							      <div id="user_form_services" class="form-control border-none p-0 [&_.select2-selection--multiple]:!border-[--tblr-border-color] [&_.select2-selection--multiple]:!p-[1em_1.23em] [&_.select2-selection--multiple]:!rounded-[--tblr-border-radius]">
									<label class="form-label">
										{{__('Services')}}
										<x-info-tooltip text="{{__('Categories of the template. Useful for filtering in the templates list.')}}" />
									</label>
								<select  multiple="multiple" id="serviceDropdown1" class="form-control" style="width:100%">
                                	@foreach($services as $service)
                                <option value="{{ $service->id }}" @if($selected_services->contains('service_id', $service->id))
                        				selected
                    			@endif>{{ $service->name }}</option>
                                	@endforeach
								</select>
							    </div>
								</div>
								<div class="col-6">
                                        <div class="mb-[20px]">	
                                            <label class="form-label">{{ __('When Want To Start The Work') }}</label>
											<select type="text" class="form-select" name="start_up" id="start_up">
											<option value="Looking for the quote" {{ $lead->start_up == 'Looking for the quote' ? 'selected' : '' }}>Looking for the quote</option>
											<option value="ASAP" {{ $lead->start_up == 'ASAP' ? 'selected' : '' }}>ASAP</option>
											<option value="In One Month" {{ $lead->start_up == 'In One Month' ? 'selected' : '' }}>In One Month</option>
										</select>

                                            <div id="name-error" class="validation-error"></div>
                                        </div>
                                    </div>

								<!-- <div class="mb-[20px]">
									<label class="form-label">{{__('If Basement (Purpose)')}}</label>
									<select type="text" class="form-select" name="country" id="country">
										<option value="bath">Rental</option>
										<option value="bath">Personal</option>
									</select>
								</div>  -->

							<div class="col-6">
							<div class="mb-[20px]">
										<label class="form-label">{{__('How Soon Would You Like The Project To Begin?')}}</label>
										<input type="text" class="form-control" id="project_time" name="project_time" value="{{$lead->project_to_begin}}">
								</div>
								</div>


								<div class="col-6">
                                        <div class="mb-[20px]">
                                            <label
                                                class="form-label">{{ __('How Likely Are You To Make A Hiring Decision?') }}</label>
                                            <input type="text" class="form-control" id="hiring_decision"
                                                name="hiring_decision" value="{{$lead->hiring_decision}}">
                                                <div id="name-error" class="validation-error"></div>
                                        </div>
                                    </div>

							</div>

							
								<div class="col-6">
							   
								<div class="mb-[20px]">
										<label class="form-label">{{__('Additional Details')}}</label>
										<input type="text" class="form-control" id="details" name="details" value="{{$lead->additional_Details}}">
								</div>
							
								</div>

								<div class="col-6">
								<div class="mb-[20px]">
                                            <label class="form-label">{{ __('Choose Credits') }}</label>
                                            <select type="text" class="form-select" name="credit_option" id="credit_option" onchange="getSelectedValue()" disabled>
                                                <option value="global-value">Apply Global Credits</option>
                                                    <option value="lead-value">Set Credit Value</option>
                                            </select>
                                            <div id="name-error" class="validation-error"></div>
                                        </div>
								</div>
							
								<div class="col-6">
                                        <div class="mb-[20px]">
                                            <label class="form-label">{{ __('Credit Value') }}</label>
                                            <input type="number" class="form-control" id="credit_value" name="credit_value"
                                                value="{{$lead->credit_value}}" disabled>
                                                <div id="name-error" class="validation-error"></div>
                                        </div>
                                    </div>
							    </div>

					

								
						


						


								<div class="col-12">
										<!-- <div class="mb-[20px]">
											<label class="form-label">{{__('Upload Image')}}</label>
											<input type="file" class="form-control" id="image" name="image" value="">
										</div> -->
										<span class="btn btn-primary add-profile-btn" onclick="showPhotos()">Add Photos</span><br>
								</div><br>


								
								
								<div class="col-12" id="header">
									@if($lead->image)

									<div class="upload-image-area" style="width: 150px; height: 150px; position: relative;">
										<img id="lead_img" src="<?php echo "data:image/jpg;base64,$lead->image" ?>" alt="Image" style="width: 150px; height: 150px; object-fit: cover; margin-left: 0; margin-top: 0; min-height: 150px;"> <i class="fa fa-times" aria-hidden="true" style=" position: absolute; top: -10px;right: -8px;background: red;width: 30px;height: 30px;display: flex;justify-content: center;align-items: center;color: #fff;border-radius: 50%;font-size: 18px;" onclick="deleteImage(<?php echo $lead->lead_image_id ?>)"></i></div>

									@endif

    							</div><br>	

                                <!-- <div class="row">
                                    {{-- <div class="col-12">	
                                        <div class="mb-[20px]">
                                            <label class="form-label">{{__('Old Password')}}</label>
                                            <input type="password" name="old_password" id="old_password" class="form-control"autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-[20px]">
                                            <label class="form-label">{{__('New Password')}}</label>
                                            <input type="password" name="new_password" id="new_password" class="form-control"autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-[20px]">
                                            <label class="form-label">{{__('Confirm Your New Password')}}</label>
                                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" autocomplete="off"/>
                                        </div>
                                    </div> --}}
                                </div>

                                <div class="row">
									<div class="col-12">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Upload image')}}</label>
											<input type="file" class="form-control" id="avatar" name="avatar">
										</div>
									</div>
								</div> -->

                                @if(env('APP_STATUS') == 'Demo' and Auth::user()->type == 'admin')
                                    <a onclick="return toastr.info('Admin settings disabled on Demo version.')" class="btn btn-primary w-100">
                                        {{__('Save')}}
                                    </a>
                                @else
                                    <button type="button" form="user_edit_form" id="user_edit_button" class="btn btn-primary w-100" onclick="saveLeads()">
                                        {{__('Save')}}
                                    </button>
                                @endif
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>




<div class="modal" id="addFileModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Your Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="add_service">
          
          <input type="hidden" name="id" id="id">
          <div class="col-12">				
                <label for="name">Upload Your Images</label>
								<input type="file" class="form-control" id="image" name="image" value="">			
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="savePhoto()">Save</button>
      </div>
    </div>
  </div>
</div>


<script>

//   $(function(){
//     setTimeout(function(){
    $("#serviceDropdown1").select2({
      multiple : true,
      dropdownParent : $("#serviceDropdown1").parent()
    });
//   },0)
//   })

</script>
@endsection

@section('script')
    <script src="/assets/js/panel/leads.js"></script>
@endsection