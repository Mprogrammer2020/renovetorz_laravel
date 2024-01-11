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

#progress-container {
      /* width: 50%; */
      margin: 50px auto;
      border: 1px solid #ccc;
      overflow: hidden;
    }

    #progress-bar {
      width: 0;
      height: 30px;
      background-color: #330582 !important;
      text-align: center;
      line-height: 30px;
      color: white;
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
                        Update information.
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body pt-6">
        <div class="container-xl">
			<div class="row">
				<div class="col-md-12 mx-auto">
					<form id="user_edit_form" action="" enctype="multipart/form-data">
          <input type="hidden" class="form-control" id="auth_type" name="auth_type" value="{{$user->type}}">
						<div class="row">
            <div class="col-12">
              <div class="mb-[20px] profile-upload-area">
                <label class="form-label">{{__('Profile Image')}}</label>
                <input type="file" class="form-control" id="image" name="image" value="">
                <div class="profile-bg" id="image-preview">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </div>
            </div>
            
              {{-- <div class="mb-[20px] profile-upload-area">
                                
                <label class="form-label">{{__('Profile Image')}}</label>
                <input type="file" class="form-control" id="image" name="image" value="">
                <div class="profile-bg">
                  <i class="fa fa-plus" aria-hidden="true"></i>
                </div>
              </div> --}}
            </div>
								{{-- <div class="mb-[20px] profile-upload-area">
										<label class="form-label">{{__('Profile Image')}}</label>
										<input type="file" class="form-control" id="image" name="image" value="" onchange="loadFile(event)">

                    <div class="profile-bg">
                        <img id="output" width="200" />
                    </div>
								</div>
						</div> --}}

							<div class="col-md-12 col-xl-12">
								{{-- <div class="w3-container"> --}}
									{{-- <h2>Progress Bar</h2>
									<div class="w3-light-grey">
									  <div class="w3-blue" style="height:24px;width:75%">Your profile is 80% complete</div>
									</div> --}}
                  @if(Auth::user()->role_id == '3')

                    <div id="progress-container">
                      <div id="progress-bar">0%</div>
                    </div>

                  @endif

									
								{{-- </div> --}}

								<div class="row">
									<input type="hidden" class="form-control" id="id" name="id" value="{{$user->id}}">

									<!-- <div class="col-12">
										<div class="mb-[20px]">
										<select>
      										<option>#232342</option>
      										<option>#ffd800</option>
      										<option>#ff1200</option>
    									</select>
										</div>
									</div> -->


								
									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Name')}}</label>
											<input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>
									
									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Last Name')}}</label>
											<input type="text" class="form-control" id="surname" name="surname" value="{{$user->surname}}">
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Email')}}</label>
											<input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Phone')}}</label>
											<input type="text" name="phone" id="phone" class="form-control"  autocomplete="off" value="{{$user->phone}}"/>
                      <div id="name-error" class="validation-error"></div>
                    </div>
									</div>

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Company Logo')}}</label>
											<input type="file" class="form-control" id="company_logo" name="company_logo" value="{{$user->company_logo}}" >
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Company Name')}}</label>
											<input type="text" class="form-control" id="company_name" name="company_name" value="{{$user->company_name}}">
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Company Email')}}</label>
											<input type="email" class="form-control" id="company_email" name="company_email" value="{{$user->company_email}}">
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Company Phone')}}</label>
                      <input type="text" name="company_phone" id="company_phone" pattern="\d{10}" maxlength="10" class="form-control" data-mask-visible="true" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="{{$user->company_phone}}"/>
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Company Website')}}</label>
											<input type="text" class="form-control" id="company_website" name="company_website" value="{{$user->company_website}}">
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>

									<!-- <div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Company Location')}}</label>
											<label for="locationDropdown">Select Location</label>
    										<input type="text" id="locationDropdown" placeholder="Enter a location">
										</div>
									</div> -->

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Company Strength')}}</label>
											<input type="number" class="form-control" id="company_strength" name="company_strength" value="{{$user->company_strength}}">
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Company Years')}}</label>
											<input type="text" class="form-control" id="company_years" name="company_years" value="{{$user->company_years}}">
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>
                                    
             

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Site Address')}}</label>
											<!-- <input type="text" class="form-control" id="address" name="address" value="{{$user->address}}"> -->
    									<input type="text" class="form-control" id="locationDropdown" name="address" placeholder="Enter a location" value="{{$user->address}}">
                      <div id="name-error" class="validation-error" ></div>
										</div>
									</div>

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('City')}}</label>
											<input type="text" class="form-control" id="city" name="city" value="{{$user->city}}">
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>

									<div class="col-6">
										<div class="mb-[20px]">
											<label class="form-label">{{__('Postal Code')}}</label>
											<input type="number" class="form-control" id="postal" name="postal" value="{{$user->postal}}">
                      <div id="name-error" class="validation-error"></div>
										</div>
									</div>
<div id="service_error " class="col-6 mb-3 add-links">
                    @if($user->role_id == '3')
										<span class="btn btn-primary add-profile-btn" onclick="showServices()">Add Services</span>
										<span class="btn btn-primary add-profile-btn" onclick="showLocation()">Add Distance</span>
                   @endif
										<span class="btn btn-primary add-profile-btn" onclick="showLinks()">Social Media Links</span>
										<!-- <span class="btn btn-primary add-profile-btn" onclick="showPhotos()">Add Photos</span> -->
									</div>
                  <div id="name-error" class="validation-error"></div>
								</div>

                                @if(env('APP_STATUS') == 'Demo' and Auth::user()->type == 'admin')
                                    <a onclick="return toastr.info('Admin settings disabled on Demo version.')" class="btn btn-primary w-100">
                                        {{__('Save')}}
                                    </a>
                                @else
                                    <button type="button" form="user_edit_form" id="user_edit_button" class="btn btn-primary w-100" onclick="userProfileSave()">
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



<div class="modal" id="addServicesModal" tabindex="-1">
  <div class="modal-dialog">    
    <div class="modal-content">
      	<div class="modal-header">
        <h5 class="modal-title">Add Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
	  <form action="" id="add_service">
    <input type="hidden" name="service_id[]" id="service_id" value="">

        <div class="form-control border-none p-0 mb-20 [&_.select2-selection--multiple]:!border-[--tblr-border-color] [&_.select2-selection--multiple]:!p-[1em_1.23em] [&_.select2-selection--multiple]:!rounded-[--tblr-border-radius]">
							<label class="form-label">
								{{__('Services')}}
								<x-info-tooltip text="{{__('Categories of the template. Useful for filtering in the templates list.')}}" />
							</label>
              <div id="user_form_services">
							    <select  multiple="multiple" id="serviceDropdown" class="form-control" style="width:100%">
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" @if($selected_services->contains('service_id', $service->id))
                        selected
                    @endif>{{ $service->name }}</option>
                                @endforeach
							    </select>
                  <div id="name-error" class="validation-error"></div>
              </div>
						</div>
	</form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="user_edit_button" onclick="saveService()">Save</button>
      </div>
    </div>
  </div>
</div>



<!-- ADD LOCATION MODAL!-->
<div class="modal" id="addLocationModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Location</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="add_service">
          <input type="hidden" name="id" id="service_id">
          <div>
             <label for="name">Postal Code</label>
             <input class="form-control" type="number" name="name" id="postal_code" maxlength="100"><br><br>
             <div id="name-error" class="validation-error"></div>

			 <label for="name">Distance</label>
             <input class="form-control" type="text" name="name" id="distance" maxlength="100"><br><br>
             <div id="name-error" class="validation-error"></div>

			 <!-- <label for="name">Location</label>
             <input type="text" name="name" id="location" maxlength="100"><br><br> -->
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveLocation()">Save</button>
      </div>
    </div>
  </div>
</div>




<!-- ADD SOCIAL MEDIA MODAL!-->
<div class="modal" id="addSocialModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Social Media Links</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="add_social">
          <!-- <input type="hidden" name="id" id="service_id"> -->
          <div>
          <label for="name">Instagram</label>
             <input class="form-control" type="text" name="instagram_1" id="instagram_1" maxlength="100"><br><br>
             <div id="name-error" class="validation-error"></div> 

             <label for="name">LinkedIn</label>
             <input class="form-control" type="text" name="linkedin" id="linkedin" maxlength="100"><br><br>
             <div id="name-error" class="validation-error"></div>

			       <label for="name">Facebook</label>
             <input class="form-control" type="text" name="facebook" id="facebook" maxlength="100"><br><br>
             <div id="name-error" class="validation-error"></div>

             <label for="name">Youtube</label>
             <input class="form-control" type="text" name="youtube" id="youtube" maxlength="100"><br><br>
             <div id="name-error" class="validation-error"></div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="saveSocialMedia()">Save</button>
      </div>
    </div>
  </div>
</div>





<!-- ADD FILE MODAL!-->
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
        <button type="button" class="btn btn-primary"id="save_services_btn" onclick="savePhoto()">Save</button>
      </div>
    </div>
  </div>
</div>



<script>

  $(function(){
    setTimeout(function(){
    $("#serviceDropdown").select2({
      multiple : true,
      dropdownParent : $("#serviceDropdown").parent()
    });
  },0)
  })

</script>

<script>
	class MultiInput extends HTMLElement {
  constructor() {
    super();
    // This is a hack :^(.
    // ::slotted(input)::-webkit-calendar-picker-indicator doesn't work in any browser.
    // ::slotted() with ::after doesn't work in Safari.
    this.innerHTML +=
    `<style>
    multi-input input::-webkit-calendar-picker-indicator {
      display: none;
    }
    /* NB use of pointer-events to only allow events from the × icon */
    multi-input div.item::after {
      color: black;
      content: '×';
      cursor: pointer;
      font-size: 18px;
      pointer-events: auto;
      position: absolute;
      right: 5px;
      top: -1px;
    }

    </style>`;
    this._shadowRoot = this.attachShadow({mode: 'open'});
    this._shadowRoot.innerHTML =
    `<style>
    :host {
      border: var(--multi-input-border, 1px solid #ddd);
      display: block;
      overflow: hidden;
      padding: 5px;
    }
    /* NB use of pointer-events to only allow events from the × icon */
    ::slotted(div.item) {
      background-color: var(--multi-input-item-bg-color, #dedede);
      border: var(--multi-input-item-border, 1px solid #ccc);
      border-radius: 2px;
      color: #222;
      display: inline-block;
      font-size: var(--multi-input-item-font-size, 14px);
      margin: 5px;
      padding: 2px 25px 2px 5px;
      pointer-events: none;
      position: relative;
      top: -1px;
    }
    /* NB pointer-events: none above */
    ::slotted(div.item:hover) {
      background-color: #eee;
      color: black;
    }
    ::slotted(input) {
      border: none;
      font-size: var(--multi-input-input-font-size, 14px);
      outline: none;
      padding: 10px 10px 10px 5px; 
    }
    </style>
    <slot></slot>`;

    this._datalist = this.querySelector('datalist');
    this._allowedValues = [];
    for (const option of this._datalist.options) {
      this._allowedValues.push(option.value);
    }

    this._input = this.querySelector('input');
    this._input.onblur = this._handleBlur.bind(this);
    this._input.oninput = this._handleInput.bind(this);
    this._input.onkeydown = (event) => {
      this._handleKeydown(event);
    };

    this._allowDuplicates = this.hasAttribute('allow-duplicates');
  }

  // Called by _handleKeydown() when the value of the input is an allowed value.
  _addItem(value) {
    this._input.value = '';
    const item = document.createElement('div');
    item.classList.add('item');
    item.textContent = value;
    this.insertBefore(item, this._input);
    item.onclick = () => {
      this._deleteItem(item);
    };

    // Remove value from datalist options and from _allowedValues array.
    // Value is added back if an item is deleted (see _deleteItem()).
    if (!this._allowDuplicates) {
      for (const option of this._datalist.options) {
        if (option.value === value) {
          option.remove();const getButton = document.getElementById('get');
const multiInput = document.querySelector('multi-input'); 
const values = document.querySelector('#values'); 



getButton.onclick = () => {
  if (multiInput.getValues().length > 0) {
    values.textContent = `Got ${multiInput.getValues().join(' and ')}!`;
  } else {
    values.textContent = 'Got noone  :`^(.'; 
  }
}

document.querySelector('input').focus();
        };
      }
      this._allowedValues =
      this._allowedValues.filter((item) => item !== value);
    }
  }

  // Called when the × icon is tapped/clicked or
  // by _handleKeydown() when Backspace is entered.
  _deleteItem(item) {
    const value = item.textContent;
    item.remove();
    // If duplicates aren't allowed, value is removed (in _addItem())
    // as a datalist option and from the _allowedValues array.
    // So — need to add it back here.
    if (!this._allowDuplicates) {
      const option = document.createElement('option');
      option.value = value;
      // Insert as first option seems reasonable...
      this._datalist.insertBefore(option, this._datalist.firstChild);
      this._allowedValues.push(value);
    }
  }

  // Avoid stray text remaining in the input element that's not in a div.item.
  _handleBlur() {
    this._input.value = '';
  }

  // Called when input text changes,
  // either by entering text or selecting a datalist option.
  _handleInput() {
    // Add a div.item, but only if the current value
    // of the input is an allowed value
    const value = this._input.value;
    if (this._allowedValues.includes(value)) {
      this._addItem(value);
    }
  }

  // Called when text is entered or keys pressed in the input element.
  _handleKeydown(event) {
    const itemToDelete = event.target.previousElementSibling;
    const value = this._input.value;
    // On Backspace, delete the div.item to the left of the input
    if (value ==='' && event.key === 'Backspace' && itemToDelete) {
      this._deleteItem(itemToDelete);
    // Add a div.item, but only if the current value
    // of the input is an allowed value
    } else if (this._allowedValues.includes(value)) {
      this._addItem(value);
    }
  }

  // Public method for getting item values as an array.
  getValues() {
    const values = [];
    const items = this.querySelectorAll('.item');
    for (const item of items) {
      values.push(item.textContent);
    }
    return values;
  }
}

window.customElements.define('multi-input', MultiInput);
</script>
<script>
	const getButton = document.getElementById('get');
const multiInput = document.querySelector('multi-input'); 
const values = document.querySelector('#values'); 

getButton.onclick = () => {
  if (multiInput.getValues().length > 0) {
    values.textContent = `Got ${multiInput.getValues().join(' and ')}!`;
  } else {
    values.textContent = 'Got noone  :`^(.'; 
  }
}

document.querySelector('input').focus();
</script>
<script>
  function initMap() {
    var autocomplete = new google.maps.places.Autocomplete(
      document.getElementById('locationDropdown')
    );
  }

</script>

<script async
    src="https://maps.googleapis.com/maps/api/js?key={{ env('API_KEY') }}&libraries=places&callback=initMap">
</script>
    <script src="/assets/js/panel/user.js"></script>
    <script src="/assets/js/panel/workspace.js"></script>

    <script>
      $(document).ready(function () {
          // Listen for changes in the file input
          $('#image').on('change', function () {
              // Get the selected file
              var file = this.files[0];
  
              // Check if a file is selected
              if (file) {
                  // Create a FileReader object
                  var reader = new FileReader();
  
                  // Set the image source when it's loaded
                  reader.onload = function (e) {
                      $('#image-preview').css('background-image', 'url(' + e.target.result + ')');
                      $('#image-preview').addClass('has-image'); // You may want to add a class for styling
                  };
  
                  // Read the image file as a data URL
                  reader.readAsDataURL(file);
              }
          });
      });

      function updateProgressBar() {
        var progressBar = document.getElementById('progress-bar');
        var width = 0;
        var interval = setInterval(function () {
          if (width >= 80) {
            clearInterval(interval);
          } else {
            width++;
            progressBar.style.width = width + '%';
            progressBar.innerHTML = width + '%';
          }
        }, 20);
      }

      // Call the function to start the progress bar
      updateProgressBar();
  </script>

	
@endsection

