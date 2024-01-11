@extends('panel.layout.app')
@section('title', 'Edit User')

@section('content')
    <div class="page-header">
        <div class="container-xl">
            <div class="row g-2 items-center">
                <div class="col">
					<a href="{{ LaravelLocalization::localizeUrl( route('dashboard.index') ) }}" class="page-pretitle flex items-center">
						<svg class="!me-2 rtl:-scale-x-100" width="8" height="10" viewBox="0 0 6 10" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
							<path d="M4.45536 9.45539C4.52679 9.45539 4.60714 9.41968 4.66071 9.36611L5.10714 8.91968C5.16071 8.86611 5.19643 8.78575 5.19643 8.71432C5.19643 8.64289 5.16071 8.56254 5.10714 8.50896L1.59821 5.00004L5.10714 1.49111C5.16071 1.43753 5.19643 1.35718 5.19643 1.28575C5.19643 1.20539 5.16071 1.13396 5.10714 1.08039L4.66071 0.633963C4.60714 0.580392 4.52679 0.544678 4.45536 0.544678C4.38393 0.544678 4.30357 0.580392 4.25 0.633963L0.0892856 4.79468C0.0357141 4.84825 0 4.92861 0 5.00004C0 5.07146 0.0357141 5.15182 0.0892856 5.20539L4.25 9.36611C4.30357 9.41968 4.38393 9.45539 4.45536 9.45539Z"/>
						</svg>
						{{__('Back to dashboard')}}
					</a>
                    <h2 class="page-title mb-2">
                        {{__('Credits Management')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
			<div class="row" id="testcontainer">
				<div class="col-md-5 mx-auto">
				<div id="cloned-forms-container">

					@if($credits->count() == 0)
						<form id="user_edit_form" onsubmit="return credits_Save();" action="">
							<input type="hidden" id="id" name="id" value="">
							<div class="row">
								<div class="col-md-12 col-xl-12">	
									<div class="row">
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">{{__('Number Of Leads')}}</label>
												<input type="number" class="form-control" id="leads" name="leads" value="">
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">{{__('Credit Value')}}</label>
												<input type="number" class="form-control" id="credit_value" name="credit_value" value="">
											</div>
										</div>
										<div class="col-md-6">
											<div class="mb-3">
												<label class="form-label">{{__('Amount')}}</label>  
												<input type="number" class="form-control" id="amount" name="amount" value="">
											</div>
										</div>
									</div>

								</div>
							</div>
						</form>
					@else
						@foreach($credits as $credits)
							<form id="user_edit_form" onsubmit="return credits_Save();" action="">
								<input type="hidden" id="id" name="id" value="{{$credits->id}}">
								<div class="row">
									<div class="col-md-12 col-xl-12">	
										<div class="row">
											<div class="col-md-6">
												<div class="mb-3">
													<label class="form-label">{{__('Number Of Leads')}}</label>
													<input type="number" class="form-control" id="leads" name="leads" value="{{$credits->leads_count}}" maxlength="6">
													<div id="name-error" class="validation-error"></div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="mb-3">
													<label class="form-label">{{__('Credit Value')}}</label>
													<input type="number" class="form-control" id="credit_value" name="credit_value" value="{{$credits->credit_value}}" maxlength="6">
													<div id="name-error" class="validation-error"></div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="mb-3">
													<label class="form-label">{{__('Amount')}}</label>  
													<span class="input-symbol-euro doller-icon">
													<input type="number" class="form-control" id="amount" name="amount" value="{{$credits->amount}}" maxlength="6">
													</span>
													
													<div id="name-error" class="validation-error"></div>
												</div>
											</div>
										</div>

									</div>
								</div>
							</form>
							<button type="button" class="btn btn-danger w-100 add-more-btn" onclick="deleteCredit({{$credits->id}})">{{__('Delete')}}</button>
						@endforeach
					@endif


					
				</div>
				
				{{-- <button form="user_edit_form" id="user_edit_button" ></button> --}}
			
				<button type="button" class="btn btn-primary w-100 add-more-btn" onclick="cloneForm()">{{__('+ Add More')}}</button>
				<button type="button" class="btn btn-primary w-100" onclick="submitAllForms()">{{__('Save')}}</button>
			
				

				
				{{-- <form id="original-form">
					<!-- Your form fields go here -->
					<label for="field1">Field data</label>
					<input type="text" name="field1" id="field1">
					<input type="text" name="field2" id="field2">
					<!-- ... -->
				</form>
				
				<div id="cloned-forms-container"></div> --}}
				
				{{-- <button type="button" onclick="cloneForm()">Clone Form</button>
				<button type="button" onclick="submitAllForms()">Submit Forms</button> --}}

				

				</div>  
			</div>
        </div>
    </div>
@endsection
@section('script')
    <script src="/assets/js/panel/settings.js"></script>
@endsection
