@extends('panel.layout.app')
@section('title', 'Edit User')

@section('content')
<style>
	#css-dropdown {
		position: absolute;
		top: 0;
		right: 0;
		left: 0;
		width: 300px;
		height: 42px;
		margin: 100px auto 0 auto;
	}

	.select2-dropdown {
		z-index: 999999 !important;
	}
</style>
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
                        {{__('Add User')}}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body pt-6">
        <div class="container-xl">
			<div class="row">
				<div class="col-md-12 mx-auto">
					<form id="user_edit_form" method="post" action="">
					<input type="hidden" id="id" name="id" value="">
						<div class="row">
							<div class="col-md-12 col-xl-12">
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">{{__('First Name')}}</label>
											<input type="text" class="form-control" id="name" name="name" value="" maxlength="60" onkeydown="return /[a-zA-Z]/i.test(event.key)">
											<div id="name-error" class="validation-error"></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">{{__('Last Name')}}</label>
											<input type="text" class="form-control" id="surname" name="surname" value="" maxlength="60" onkeydown="return /[a-zA-Z]/i.test(event.key)">
											<div id="name-error" class="validation-error"></div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">{{__('Email')}}</label>
											<input type="email" class="form-control" id="email" name="email" value="">
											<div id="name-error" class="validation-error"></div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">{{__('Password')}}</label>
											<input type="password" class="form-control" id="password" name="password" value="" maxlength="8">
											<div id="name-error" class="validation-error"></div>
										</div>
									</div>
								</div>

								{{-- <div class="mb-3">
									<label class="form-label">{{__('Country')}}</label>
									<select type="text" class="form-select" name="country" id="country">
										@include('panel.admin.users.countries')
									</select>
								</div> --}}

								<div class="row">
								<div class="col-md-6">
										<div class="mb-3">
											<div class="form-label">{{__('Type')}}</div>
											<select class="form-select" id="type" name="type" onchange="getSelectedType();">
											<option value="0" disabled selected>{{__('Choose User Type')}}</option>
												<option value="2">{{__('Manager')}}</option>
												<option value="3">{{__('Contractor')}}</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<div class="form-label">{{__('Status')}}</div>
											<select class="form-select" id="status" name="status">
											<option value="" disabled selected>{{__('Choose Status')}}</option>
												<option value="1">{{__('Active')}}</option>
												<option value="0">{{__('InActive')}}</option>
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									
									<div class="col-md-6">
										<div class="mb-3">
											<label class="form-label">{{__('Phone')}}</label>
											<input type="text" name="phone" id="phone" pattern="\d{10}" maxlength="10" class="form-control" data-mask-visible="true" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value=""/>

											<div id="name-error" class="validation-error"></div>
										</div>	
									</div>
									<div class="col-6" id="service_div" style="display:none";>
										<div id="user_form_services"
											class="form-control border-none p-0">
											<label class="form-label">
												{{ __('Services') }}
												<x-info-tooltip
													text="{{ __('Categories of the template. Useful for filtering in the templates list.') }}" />
											</label>
											<select multiple="multiple" id="serviceDropdown1" class="form-control services-select" style="width:100%">
												@foreach ($services as $service)
													<option value="{{ $service->id }}">{{ $service->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
	
								</div>

								
								{{-- <div class="col-6">
                                        <div
                                            class="form-control border-none p-0 [&_.select2-selection--multiple]:!border-[--tblr-border-color] [&_.select2-selection--multiple]:!p-[1em_1.23em] [&_.select2-selection--multiple]:!rounded-[--tblr-border-radius]">
                                            <label class="form-label">
                                                {{ __('Services') }}
                                                <x-info-tooltip		
                                                    text="{{ __('Categories of the template. Useful for filtering in the templates list.') }}" />
                                            </label>
                                            <select multiple="multiple" id="serviceDropdown1" class="form-control"
                                                style="width:100%">
                                                @foreach ($services as $service)
                                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}
								<button type="button" onclick="userSave()" form="user_edit_form" id="user_edit_button" class="btn btn-primary ">
									{{__('Save')}}
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>

	<script>
    $(function(){
		setTimeout(() => {
			$("#serviceDropdown1").select2({
            multiple: true,
            dropdownParent: $("#serviceDropdown1").parent()
        });
		}, 1);
     
	});    

    </script>
    <script src="/assets/js/panel/user.js"></script>

@endsection