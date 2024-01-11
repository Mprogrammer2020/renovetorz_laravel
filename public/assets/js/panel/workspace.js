
function showCreditModal(){
	$('#addCreditModal').modal('show');
}

var temp_data_type = '';
// $("#template_id li").click(function () {
//     const table = $('#table_id tbody');
//     temp_data_type = $(this).text();
//     $(this).toggleClass('active');
//     $("#template_id li").not(this).removeClass('active');
//     // Clear existing table rows
//     table.empty();
//     $.ajax({
//         type: "GET",
//         url: "/dashboard/get/openai/details/" + $(this).text(),
//         contentType: false,
//         processData: false,
//         success: function (data) {
//             if (Array.isArray(data.data)) {
//                 const table = $('#table_id tbody');
//                 data.data. forEach(item => {
//                     const newRow = $('<tr></tr>');
//                     const checkboxCell = `<td><input type="checkbox" name="name" id="${item.id}" value=""></td>`;
//                     const titleCell = `<td>${item.title}</td>`;

//                     newRow.append(checkboxCell);
//                     newRow.append(titleCell);

//                     table.append(newRow);
//                 });

//                 $('#exampleModal').modal('hide');
//                 $('#templateModal').modal('show');
//             } else {
//                 console.error("Data is not an array:", data);
//             }
//         },

//         error: function (data) {
//             var err = data.responseJSON.errors;
//             $.each(err, function (index, value) {
//                 toastr.error(value);
//             });
//         }
//     });
// });

// $('#add_category').click(function () {
//     var checkboxValues = [];
//     // console.log(temp_data);
//     var workspace_id = $('#workSpaceName').val();
//     $('#table_id tbody input[type="checkbox"]').each(function () {
//         // Check if the checkbox is checked
//         if ($(this).is(':checked')) {
//             // Get the ID of the checked checkbox
//             const checkboxId = $(this).attr('id');
//             checkboxValues.push(checkboxId);
//         }
//     });

//     if(checkboxValues == '') {
//         $('#error_message').html('Plase select template and check atleast one checkbox.');
//     } else {
        
//         const formData = new FormData();
    
//         formData.append('workspace_id', workspace_id);
//         formData.append('temp_data_type', temp_data_type);
//         formData.append('checkboxValues', checkboxValues);
    
//         $.ajax({
//             type: "post",
//             url: "/dashboard/add/work/space/group",
//             data: formData,
//             contentType: false,
//             processData: false,
//             success: function (data) {
//                 toastr.success(data.message);
//                 setTimeout(function () {
//                     location.href = '/dashboard/'
//                 }, 1000);
//                 // $('#exampleModal').modal('hide');
//                 $('#templateModal').modal('hide');
//             },
//             error: function (data) {
//                 var err = data.responseJSON.errors;
//                 $.each(err, function (index, value) {
//                     toastr.error(value);
//                 });
//             }
//         });
//     }

// });


function saveLocation(){
	showLoader();
	$('.validation-error').remove();


	var status = true;	
	
		
	if ($('#postal_code').val() === '') {
		$('#postal_code').after('<div id="name-error" class="validation-error">Postal code is required</div>');
		status = false;
	}

	if ($('#distance').val() === '') {
		$('#distance').after('<div id="name-error" class="validation-error">Distance is required</div>');
		status = false;
	}

	if(status == false){
		hideLoader();
	}

	else{
		var formData = new FormData();
		formData.append( 'postal_code', $( "#postal_code" ).val());
		formData.append( 'distance', $( "#distance" ).val());
		// formData.append( 'location', $( "#location" ).val());
		$.ajax( {
			type: "post",
			url: "/dashboard/location/save",
			data: formData,
			contentType: false,
			processData: false,
			success: function ( data ) {
				$('#addLocationModal').modal('hide'); 
				hideLoader();
				toastr.success( 'location saved succesfully.' );
				// document.getElementById( "user_edit_button" ).disabled = false;
				// document.getElementById( "user_edit_button" ).innerHTML = "Save";
				// window.location.href = '/dashboard/admin/users';/
			},
			error: function ( data ) {
				var err = data.responseJSON.errors;
				$.each( err, function ( index, value ) {
					hideLoader();	
					toastr.error( value );
				} );
				// document.getElementById( "user_edit_button" ).disabled = false;
				// document.getElementById( "user_edit_button" ).innerHTML = "Save";
			}
		} );
	}
	return false;
}

function saveService(){
	// alert("adfdf");
	showLoader();
	$('.validation-error').remove();
	var status=true;
	if (($('#serviceDropdown').val() === null || $('#serviceDropdown').val().length === 0)) {
		$('#user_form_services').after('<div id="name-error" class="validation-error">Services is required</div>');
		status = false;
	}

    

	// if (!service_ids || service_ids.length === 0) {
    //     toastr.error('Please select at least one service.');
    //     return false;
    // }

	if(status == false){
		hideLoader();
	}

	else{
		var formData = new FormData();
		var service_ids = $('#serviceDropdown').val();
		formData.append('service_id',service_ids);
	
		$.ajax( {
			type: "post",
			url: "/dashboard/user/settings/save_service",
			data: formData,
			contentType: false,
			processData: false,
			success: function ( data ) {
				hideLoader();
				toastr.success( 'Services saved succesfully.');
				document.getElementById( "user_edit_button" ).disabled = false;
				document.getElementById( "user_edit_button" ).innerHTML = "Save";
				$('#addServicesModal').modal('hide');
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

function saveGlobalCredits(){
	
    var formData = new FormData();

	if($('#credit_id').val()){
		var credit_id = $('#credit_id').val();
	}else{
		var credit_id = '';
	}
	var credit_value = $('#credit_value').val();
	formData.append('credit_value',credit_value);

	$.ajax( {
		type: "post",
		url: "/dashboard/admin/settings/save_global_credit",
		data: formData,
		contentType: false,
		processData: false,
		success: function ( data ) {
			console.log("data", data)
			toastr.success( data.message);
			$('#addCreditModal').modal('hide');
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
			$.each( err, function ( index, value ) {
				toastr.error( value );
			});
		}
	} );
	return false;
}



// console.log("active_tagactive_tag", localStorage.getItem("active_tag"))


  