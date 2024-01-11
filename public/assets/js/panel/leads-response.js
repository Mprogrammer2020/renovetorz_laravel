
function leadsRequest($id) {
	var x = document.getElementById("leadsDetails-"+$id);
	var y = document.getElementById("downIconShow-"+$id);
	if (x.style.display === "block") {
		x.style.display = "none";
		y.style.display = "none";
	} else {
	  x.style.display = "block";
	  y.style.display = "block";
	}
}
//get leads information
// function contactToLead(id){
// 	$.ajax( {
// 		type: "get",
// 		url: "/dashboard/leads/status/"+ id,
// 		contentType: false,
// 		processData: false,
// 		success: function ( data ) {
// 			// console.log("dataaaa",data.data.email);
// 			document.getElementById("leads_phone").innerHTML = data.data.phone_number;
// 			document.getElementById("leads_email" ).innerHTML = data.data.email;
// 			toastr.success( data.message);
// 			setTimeout( function () {
// 				$('#leadsDetail').modal('show');
// 			}, 1000 );
			
// 		},
// 		error: function ( data ) {
// 			var err = data.responseJSON.errors;
// 			// $.each( err, function ( index, value ) {
// 			// 	toastr.error( value );
// 			// } );
// 			// submitBtn.disabled = false;
// 			// submitBtn.classList.remove( 'submitting' );
// 		}
// 	} );
	
// }