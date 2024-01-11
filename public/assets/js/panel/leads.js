

//Admin
document.addEventListener("DOMContentLoaded", function() {
    "use strict";
    const list = new List('table-default', {
        sortClass: 'table-sort',
        listClass: 'table-tbody',
        valueNames: [
            'sort-name',
            'sort-group',
            'sort-remaining-words',
            'sort-remaining-images',
            'sort-country',
            'sort-status',
            'sort-quantity',
            'sort-score',
            { attr: 'data-date', name: 'sort-date' },
        ],
        page: 25,
        pagination: {
            innerWindow: 1,
            left: 0,
            right: 0,
            paginationClass: "pagination",
        },
    });
})

function addleads() {
	window.location.href = '/dashboard/leads/addleads';
}

//User
function saveLeads() {
	// alert($( "#address" ).val());
	showLoader();

	$('.validation-error').remove();

    var status = true;
	var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

	if ($('#serviceDropdown1').val() === null || $('#serviceDropdown1').val().length === 0) {
		$('#user_form_services').after('<div id="name-error" class="validation-error">Services is required</div>');
		status = false;
	}

	if ($('#name').val() === '') {
		$('#name').after('<div id="name-error" class="validation-error">Full Name is required</div>');
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

	if ($('#address').val() === '') {
		$('#address').after('<div id="name-error" class="validation-error">Site address is required</div>');
		status = false;
	}

	if ($('#city').val() === '') {
		$('#city').after('<div id="name-error" class="validation-error">City name is required</div>');
		status = false;
	}

	if ($('#postal').val() === '') {
		$('#postal').after('<div id="name-error" class="validation-error">Postal code is required</div>');
		status = false;
	}

	if ($('#work').val() === '' || $('#work').val() === null) {
		$('#work').after('<div id="name-error" class="validation-error">This field is required</div>');
		status = false;
	}

	if ($('#property').val() === '' || $('#property').val() === null) {
		$('#property').after('<div id="name-error" class="validation-error">Property type is required</div>');
		status = false;
	}

	if ($('#basement').val() === '') {
		$('#basement').after('<div id="name-error" class="validation-error">Area of basement is required</div>');
		status = false;
	}

	if ($('#Permit').val() === '') {
		$('#Permit').after('<div id="name-error" class="validation-error">Permit is required</div>');
		status = false;
	}

	if ($('#age').val() === '') {
		$('#age').after('<div id="name-error" class="validation-error">Age of property is required</div>');
		status = false;
	}

	if ($('#meeting').val() === '') {
		$('#meeting').after('<div id="name-error" class="validation-error">Time for first meeting is required</div>');
		status = false;
	}

	if ($('#budget').val() === '') {
		$('#budget').after('<div id="name-error" class="validation-error">Budget is required</div>');
		status = false;
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
	}
	
	else{
		document.getElementById( "user_edit_button" ).disabled = true;
		document.getElementById( "user_edit_button" ).innerHTML = "Please Wait...";

		var formData = new FormData();
		
		if($( "#lead_id" ).val()){
			formData.append( 'lead_id', $( "#lead_id" ).val() );
		}

		if($( "#lead_image_id" ).val()){
			formData.append( 'lead_image_id', $( "#lead_image_id" ).val() );
		}

		formData.append('image', $('#image')[0].files[0]);
		formData.append( 'full_name', $( "#name" ).val() );
		formData.append( 'email', $( "#email" ).val() );
		formData.append( 'phone_number', $( "#phone" ).val() );
		formData.append( 'site_address', $( "#address" ).val() );
		formData.append( 'city', $( "#city" ).val() );
		formData.append( 'postal_code', $( "#postal" ).val() );
		formData.append( 'type_of_work', $( "#work" ).val() );
		formData.append( 'type_of_property', $( "#property" ).val() );
		formData.append( 'area_of_property', $( "#basement" ).val() );
		formData.append( 'permit', $("input[name='permit']:checked").val() );
		formData.append( 'age_of_property', $( "#age" ).val() );
		formData.append( 'first_meeting', $( "#meeting" ).val() );
		formData.append( 'budget', $( "#budget" ).val() );
		formData.append( 'start_up', $( "#start_up" ).val() );
		formData.append( 'project_to_begin', $( "#project_time" ).val() );
		formData.append( 'hiring_decision', $( "#hiring_decision" ).val() );
		formData.append( 'additional_details', $( "#details" ).val() );
		formData.append( 'serviceDropdown1', $( "#serviceDropdown1" ).val() );
		formData.append( 'credit_option', $( "#credit_option" ).val() );
		formData.append( 'credit_value', $("#user_edit_form").find( "#credit_value" ).val() );
		

		$.ajax( {
			type: "post",
			url: "/dashboard/leads/saveleads",
			data: formData,
			contentType: false,
			processData: false,
			success: function ( data ) {
				console.log(data);
				hideLoader();
				toastr.success( 'Lead saved succesfully.' );
				window.location.href = '/dashboard/leads';
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
	return false;
	}
}

function showPhotos(){
	$('#addFileModal').modal('show');
}

function showEditPhotos(){
	$('#add_Update_File_Modal').modal('show');
}

function savePhoto() {
    "use strict";
	showLoader();

    document.getElementById("user_edit_button").disabled = false;
    document.getElementById("user_edit_button").innerHTML = "Please Wait...";

    if (!$('#image')[0].files[0]) {
        toastr.error('Please select any image');
        document.getElementById("user_edit_button").disabled = false;
        document.getElementById("user_edit_button").innerHTML = "Save";
		hideLoader();
        return false; 
    }

    var formData = new FormData();

    if ($("#id").val()) {
        formData.append('id', $("#id").val());
    }

    formData.append('image', $('#image')[0].files[0]);
	$.ajax( {
		type: "post",
		url: "/dashboard/leads/save_image",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			var base64String = data.images;
			console.log(base64String);
	
			var src_string = "data:image/jpg;base64," + base64String;

			console.log("src_string:", src_string);
            console.log("data.id:", data.id);

			// document.addEventListener('DOMContentLoaded', function() {
			// 	// Your code here
			// 	document.getElementById("header").innerHTML = '<div class="upload-image-area" style="width: 150px; height: 150px; position: relative;"><img id="lead_img" src=' + src_string + ' alt="Image" style="width: 150px; height: 150px; object-fit: cover; margin-left: 0; margin-top: 0; min-height: 150px;"> <i class="fa fa-times" aria-hidden="true" style=" position: absolute; top: -10px;right: -8px;background: red;width: 30px;height: 30px;display: flex;justify-content: center;align-items: center;color: #fff;border-radius: 50%;font-size: 18px;" onclick="deleteImage(' + data.id + ')"></i></div>';
			// });

			document.getElementById("header").innerHTML = '<div class="upload-image-area" style="width: 150px; height: 150px; position: relative;"><img id="lead_img" src=' + src_string + ' alt="Image" style="width: 150px; height: 150px; object-fit: cover; margin-left: 0; margin-top: 0; min-height: 150px;"> <i class="fa fa-times" aria-hidden="true" style=" position: absolute; top: -10px;right: -8px;background: red;width: 30px;height: 30px;display: flex;justify-content: center;align-items: center;color: #fff;border-radius: 50%;font-size: 18px;" onclick="deleteImage(' + data.id + ')"></i></div>';
			//  <span onclick="deleteImage(' + data.id + ')">Button</span>';

			// console.log(data.id);
			hideLoader();
			toastr.success( 'Image saved succesfully.' );
			document.getElementById( "user_edit_button" ).disabled = false;
			document.getElementById( "user_edit_button" ).innerHTML = "Save";
			document.getElementById("lead_image_id" ).value = data.id;
			// window.location.href = '/dashboard/admin/leads';
			$('#addFileModal').modal('hide');
			// console.log(decodedString);

			// var img = new Image();	
			// document.getElementById("header").innerHTML = '<img id="lead_img" src="' + decodedString + 'data:image/jpeg;base64," alt="Image">';
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

	return false;
}

function deleteImage(id){
	// alert(id);
	showLoader();
	"use strict";
	console.log(id);
	document.getElementById( "user_edit_button" ).disabled = true;
	document.getElementById( "user_edit_button" ).innerHTML = "Please Wait...";

	var formData = new FormData();
	formData.append( 'id', $( "#id" ).val() );
	console.log( $( "#id" ).val());

	$.ajax( {
		type: "post",
		url: "/dashboard/leads/delete_image/"+id,
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			// console.log(data.id);
			hideLoader();
			toastr.success( 'Image delete succesfully.' );
			
			document.getElementById( "user_edit_button" ).disabled = false;
			document.getElementById( "user_edit_button" ).innerHTML = "Save";

			var image_x = document.getElementById('header');
			image_x.parentNode.removeChild(image_x)

			// var img = new Image();	
			
			// window.location.href = '/dashboard/admin/leads';
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


function getSelectedValue() {
    var selectBox = document.getElementById("credit_option");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
	var x = document.getElementById("credit_value_div");
	if(selectedValue == 'lead-value'){
        x.style.display = "block";
	}else{
		x.style.display = "none";
	}
}

function delete_leads(id){
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
                url: "/dashboard/admin/leads/delete/"+id,
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