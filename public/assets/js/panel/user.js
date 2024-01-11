getSelectedType();
//Admin

$( document ).ready( function () {
	"use strict";
	if ( $.fn.select2 ) {
		$( '.select2' ).select2( {
			tags: true
		} );
	};

} );

// if ( $.fn.select2 ) {
// 		$( '.select2' ).select2( {
// 			tags: true
// 		} );
// 	};

function addManager(){
	window.location.href = '/dashboard/admin/users/add';
}

function userSave() {
	// alert($('#password').val());
	"use strict";
	showLoader();
	$('.validation-error').remove();


	var status = true;	
	var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	
	if($('#type').val() == '3'){
		if ($('#serviceDropdown1').val() === null || $('#serviceDropdown1').val().length === 0) {
			$('#user_form_services').after('<div id="name-error" class="validation-error">Services is required</div>');
			status = false;
		}
	}


	if ($('#name').val() === '') {
		$('#name').after('<div id="name-error" class="validation-error">First name is required</div>');
		status = false;
	}

	if ($('#type').val() === '' || $('#type').val() == null) {
		$('#type').after('<div id="name-error" class="validation-error">Please Select User Type</div>');
		status = false;
	}

	if ($('#status').val() === '' || $('#type').val() == null) {
		$('#status').after('<div id="name-error" class="validation-error">Status is required</div>');
		status = false;
	}

	if ($('#surname').val() === '') {
		$('#surname').after('<div id="name-error" class="validation-error">Last name is required</div>');
		status = false;
	}

	if ($('#phone').val() === '') {
		$('#phone').after('<div id="name-error" class="validation-error">Phone number is required</div>');
		status = false;
	}
	
	else if (!/^\d{10}$/.test($('#phone').val())) {
		$('#phone').after('<div id="name-error" class="validation-error">Phone number must be exactly 10 digits</div>');
		status = false;
	}

	if($( "#id" ).val()==null){
		if ($('#password').val() === '') {
			$('#password').after('<div id="name-error" class="validation-error">Password is required</div>');
			status = false;
		}
	
		else if ($('#password').val().length < 8) {
			$('#password').after('<div id="name-error" class="validation-error">Password must be at least 8 characters long</div>');
			status = false;
		}
	}

	if ($('#email').val() === '') {
		$('#email').after('<div id="name-error" class="validation-error">Email is required</div>');
		status = false;
	}

	else if (!emailRegex.test($('#email').val())) {
		$('#email').after('<div id="name-error" class="validation-error">Enter a valid email address</div>');
		status = false;
	}
	
	if(status == false){
		hideLoader();
	}else{
		document.getElementById( "user_edit_button" ).disabled = true;
		document.getElementById( "user_edit_button" ).innerHTML = "Please Wait...";
	
		var formData = new FormData();
		formData.append( 'id', $( "#id" ).val() );
		formData.append( 'name', $( "#name" ).val() );
		formData.append( 'surname', $( "#surname" ).val() );
		formData.append( 'phone', $( "#phone" ).val() );
		formData.append( 'email', $( "#email" ).val() );
		// formData.append( 'country', $( "#country" ).val() );
		formData.append( 'type', $( "#type" ).val() );
		formData.append( 'status', $( "#status" ).val() );
		formData.append( 'password', $( "#password" ).val() );
		formData.append( 'serviceDropdown1', $( "#serviceDropdown1" ).val() );
		// formData.append( 'role_id', $( "#role_id" ).val() );
		// formData.append( 'remaining_words', $( "#remaining_words" ).val() );
		// formData.append( 'remaining_images', $( "#remaining_images" ).val() );
		$.ajax( {
			type: "post",
			url: "/dashboard/admin/users/save",
			data: formData,
			contentType: false,
			processData: false,
			success: function ( data ) {
				console.log(data);
				hideLoader();
				toastr.success( 'User saved succesfully.' );
				document.getElementById( "user_edit_button" ).disabled = false;
				document.getElementById( "user_edit_button" ).innerHTML = "Save";
				window.location.href = '/dashboard/admin/users/list';
			},
			error: function ( data ) {
				var err = data.responseJSON.errors;
				$.each( err, function ( index, value ) {
					hideLoader();
					toastr.error( value );
				} );
				document.getElementById( "user_edit_button" ).disabled = false;
				document.getElementById( "user_edit_button" ).innerHTML = "Save";

				console.log(err.email);
				if ('email' in err) {
					if (err.email[0] === 'The email has already been taken.') {
						$('#email').after('<div id="name-error" class="validation-error">Email has already been taken</div>');
					} else {
						$('#email').after('<div id="email-error" class="validation-error">' + err.email[0] + '</div>');
					}
			
					status = false;
				} 
			}
		} );
		return false;
	}
	
}

//User
function userProfileSave() {
    "use strict";
	showLoader();
	$('.validation-error').remove();
	
	var authType = document.getElementById("auth_type").value;
	var status = true;	
	if ($('#name').val() === '') {
		$('#name').after('<div id="name-error" class="validation-error">First name is required</div>');
		status = false;
	}

	if ($('#surname').val() === '') {
		$('#surname').after('<div id="name-error" class="validation-error">Last name is required</div>');
		status = false;
	}

	if ($('#email').val() === '') {
		$('#email').after('<div id="name-error" class="validation-error">Email is required</div>');
		status = false;
	}

	if ($('#company_phone').val() === '') {
		$('#company_phone').after('<div id="name-error" class="validation-error">Phone number is required</div>');
		status = false;
	}
	
	else if (!/^\d{10}$/.test($('#company_phone').val())) {
		$('#company_phone').after('<div id="name-error" class="validation-error">Phone number must be exactly 10 digits</div>');
		status = false;
	}

	if ($('#locationDropdown').val() === '') {
		$('#locationDropdown').after('<div id="name-error" class="validation-error">Site address is required</div>');
		status = false;
	}

	if ($('#city').val() === '') {
		$('#city').after('<div id="name-error" class="validation-error">City is required</div>');
		status = false;
	}

	if ($('#postal').val() === '') {
		$('#postal').after('<div id="name-error" class="validation-error">Postal code is required</div>');
		status = false;
	}


	// if ($('#serviceDropdown').val() === null && $('#serviceDropdown').val().length === 0) {
	// 	$('#services_test').after('<div id="name-error" class="validation-error">Please select any one service</div>');
	// 	status = false;
	// }

	if(status == false){
		hideLoader();
	}
	else {
		if(authType == '3'){
			if($('#serviceDropdown').val() == "" || $('#serviceDropdown').val() == null){
				alert("dcadcadc");
				hideLoader();
				toastr.error("Please select atleast one service");
				return;
			}
		}
		
		document.getElementById("user_edit_button").disabled = true;
		document.getElementById("user_edit_button").innerHTML = "Please Wait...";
	
		var formData = new FormData();
	
		if ($("#id").val()) {
			formData.append('id', $('#id').val());
		}
	
		formData.append('image', $("#image").prop('files')[0]);
		formData.append('company_logo', $("#company_logo").prop('files')[0]);
		formData.append('name', $("#name").val());
		formData.append('surname', $("#surname").val());
		formData.append('email', $("#email").val());
		formData.append('phone', $("#phone").val());
		formData.append('address', $("#locationDropdown").val());
		formData.append('city', $("#city").val());
		formData.append('postal', $("#postal").val());
		formData.append('type_of_work', $("#work").val());
		formData.append('type_of_property', $("#property").val());
		formData.append('area_of_property', $("#basement").val());
		formData.append('permit', $("input[name='permit']:checked").val());
		formData.append('age_of_property', $("#age").val());
		formData.append('first_meeting', $("#meeting").val());
		formData.append('budget', $("#budget").val());
		formData.append('start_up', $("#start_up").val());
		formData.append('company_name', $("#company_name").val());
		formData.append('company_email', $("#company_email").val());
		formData.append('company_phone', $("#company_phone").val());
		formData.append('company_website', $("#company_website").val());
		formData.append('company_strength', $("#company_strength").val());
		formData.append('company_years', $("#company_years").val());
		formData.append('company_location', $("#locationDropdown").val());
	
		// if ($("#company_logo").prop('files')[0] === null) {
		// 	toastr.error("Please Select Any Logo");
		// 	// return false;
		// }
	
		console.log($("#name").val());
	
		$.ajax({
			type: "post",
			url: "/dashboard/user/settings/save",
			data: formData,
			contentType: false,
			processData: false,
			success: function (data) {
				console.log(data);
				hideLoader();
				toastr.success('User saved successfully.');
				document.getElementById("user_edit_button").disabled = false;
				document.getElementById("user_edit_button").innerHTML = "Save";
				window.location.href = '/dashboard/user/';
			},
			error: function (data) {
				var err = data.responseJSON.errors;
				$.each(err, function (index, value) {
					hideLoader();;
					toastr.error(value);
				});
				document.getElementById("user_edit_button").disabled = false;
				document.getElementById("user_edit_button").innerHTML = "Save";
			}
		});
	}
    return false;
}


function showServices() {
	// $.ajax({
	// 	url: "settings/get",
	// 	type: 'GET',
	// 	// dataType: 'json',
	// 	success: function (data) {
	// 		console.log("data---", data)
       
	// 		var dropdown = $('#serviceDropdown');
	// 		dropdown.empty();

	// 		$.each(data, function (index, service) {
	// 			dropdown.append($('<option>').text(service.name));
	// 		});

	// 		$('select').select2({
	// 			placeholder: 'Select services',
	// 			allowClear: true, 
	// 			width: '100%', 
	// 		  });

			return $('#addServicesModal').modal('show');
	// 	},
	// 	error: function (error) {
	// 		console.log('Error fetching data:', error);
	// 	}
	// });
}

$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});



function showLocation(){
    $('#addLocationModal').modal('show');
}

function showLinks(){
    $('#addSocialModal').modal('show');
}

function showPhotos(){
	$('#addFileModal').modal('show');
}


function saveSocialMedia() {
	"use strict";
	showLoader();
	$('.validation-error').remove();


	var status = true;	
	
	if ($('#instagram_1').val() === '') {
		$('#instagram_1').after('<div id="name-error" class="validation-error">Instagram link is required</div>');
		status = false;
	}

	if ($('#linkedin').val() === '') {
		$('#linkedin').after('<div id="name-error" class="validation-error">Linkedin link is required</div>');
		status = false;
	}

	if ($('#facebook').val() === '') {
		$('#facebook').after('<div id="name-error" class="validation-error">Facebook link is required</div>');
		status = false;
	}

	if ($('#youtube').val() === '') {
		$('#youtube').after('<div id="name-error" class="validation-error">Youtube link is required</div>');
		status = false;
	}

	if(status == false){
		hideLoader();
	}

	else{
		document.getElementById( "user_edit_button" ).disabled = true;
		document.getElementById( "user_edit_button" ).innerHTML = "Please Wait...";
	
		var formData = new FormData();
	
		formData.append('linkedin', $("#linkedin").val());
		formData.append( 'facebook', $( "#facebook" ).val() );
		formData.append( 'youtube', $( "#youtube" ).val() );
		formData.append( 'instagram_1', $( "#instagram_1	" ).val() );
	
		$.ajax( {
			type: "post",
			url: "/dashboard/user/settings/save_link",
			data: formData,
			contentType: false,
			processData: false,
			success: function ( data ) {
				$('#addSocialModal').modal('hide'); 
				console.log(data);
				hideLoader();
				toastr.success( 'social media link successfully added' );
				document.getElementById( "user_edit_button" ).disabled = false;
				document.getElementById( "user_edit_button" ).innerHTML = "Save";
				// window.location.href = '/dashboard/user/';
			},
			error: function ( data ) {
				var err = data.responseJSON.errors;
				$.each( err, function ( index, value ) {
					hideLoader();
					toastr.error( value );
				} );
				document.getElementById( "user_edit_button" ).disabled = false;
				document.getElementById( "user_edit_button" ).innerHTML = "Save";
			}
		} );
	}
	return false;
}


function redirectToPage(userType) {
    window.location.href = '/dashboard/admin/users/list/'+userType;
}

function redirectToLeads() {
    window.location.href = '/dashboard/admin/leads/';
}

function getSelectedType() {
    var selectBox = document.getElementById("type");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	var x = document.getElementById("service_div");
	if(selectedValue == 3){
        x.style.display = "block";
	}else{
		x.style.display = "none";
	}

	
}

function ChangePassword() {
	showLoader();
    // Reset validation errors
    $(".validation-error").empty();

    // Get password values
    var oldPassword = $("#old_password").val();
    var newPassword = $("#new_password").val();
    var confirmPassword = $("#confirm_password").val();

    // Perform custom validation
	var status = true;
    if (oldPassword === "") {
        $("#old_password-error").text("Old Password is required");
        status = false;
    }

    if (newPassword === "") {
        $("#new_password-error").text("New Password is required");
        status = false;
    }

    if (confirmPassword === "") {
        $("#confirm_password-error").text("Confirm Password is required");
        status = false;
    }

    if (newPassword !== confirmPassword) {
        $("#confirm_password-error").text("Confirm Password does not match");
        status = false;
    }
	if(status == false){
		hideLoader();
		return false
	}else{
		
		var formData = new FormData();
	
		formData.append('old_password', $("#old_password").val());
		formData.append( 'new_password', $( "#new_password" ).val() );
		formData.append( 'confirm_password', $( "#confirm_password" ).val() );

		$.ajax( {
			type: "post",
			url: "/dashboard/user/settings/update_password",
			data: formData,
			contentType: false,
			processData: false,
			success: function ( data ) {
				console.log("successs",data);
				if(data.status == false){
					hideLoader();
					toastr.error( data.message );

				}else{
					hideLoader();
					toastr.success( data.message );
					document.getElementById( "user_edit_button" ).disabled = false;
					document.getElementById( "user_edit_button" ).innerHTML = "Save";
					window.location.href = '/dashboard/leads/request';
				}
			},
			error: function ( data ) {
				console.log("error",data);
				var err = data.responseJSON.errors;
				$.each( err, function ( index, value ) {
					hideLoader();
					toastr.error( value );
				} );
			}
		} );

	}

    return false;
}
	
function delete_users(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You want to delete this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax( {
                type: "get",
                url: "/dashboard/admin/users/delete/"+id,
                contentType: false,
                processData: false,
                success: function ( data ) {
                    console.log(data);
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your service has been deleted.",
                        icon: "success"
                      });
                      location.reload();
                },
                error: function ( data ) {
                    var err = data.responseJSON.errors;
                    $.each( err, function ( index, value ) {
                        toastr.error( value );
                    });
                }
            });
        }else{
            toastr.error("Deletion Cancelled"); 
        }
      });
	}