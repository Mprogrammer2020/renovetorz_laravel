function showAddModal(){
 $('#addServiceModal').modal('show');
}


function saveService(){
 "use strict";
 $('.validation-error').remove();
	showLoader();

	var status = true;	
	if ($('#service_name').val() === '') {
		$('#service_name').after('<div id="name-error" class="validation-error">Service name is required</div>');
		status = false;
	}

    if(status == false){
		hideLoader();
	}

    else{
        var formdata = new FormData();
        var service_id = $('#service_id').val();
        var service_name = $('#service_name').val();
        formdata.append('id', service_id);
        formdata.append('name', service_name);
       
       
        $.ajax( {
           type: "post",
           url: "/dashboard/admin/services/save",
           data: formdata,
           contentType: false,
           processData: false,
           success: function ( data ) {
               // console.log(data);
               $('#addServiceModal').modal('hide');    
               console.log("data", data)
               if(data.status){
                   hideLoader();
                   toastr.success(data.success); 
                   location.reload();  
               }else{
                   hideLoader();
                   toastr.error(data.error); 
               }
               // document.getElementById( "user_edit_button" ).disabled = true;
           },
           error: function ( data ) {
               $('#addServiceModal').modal('hide');
               console.log("err",data)
       
               // var err = data.responseJSON.errors;
               // $.each( err, function ( index, value ) {
               //     toastr.error( value );
               // } );
               // document.getElementById( "user_edit_button" ).disabled = true;
           }
       } );
    }
 
}

function edit_services(service_id,service_name){
    $('.validation-error').remove();
    document.getElementById('service_id').value = service_id;
    document.getElementById('service_name').value = service_name;
    $('#addServiceModal').modal('show');
}

function delete_services(service_id){
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
                url: "/dashboard/admin/services/delete/"+service_id,
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