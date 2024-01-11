showLoader();
var package_id = '';

if(leadId != "" && leadId != null){
	contactToLeadWithStaus(leadId)
}

document.getElementById("connect-to-stripe").disabled = true;

var divs = document.querySelectorAll('.top-up-content-inner');
divs.forEach(function(div) {
	div.addEventListener('click', function() {
		$('.top-up-content-inner').removeClass('active');
		$(this).addClass('active');
		document.getElementById("connect-to-stripe").disabled = false;
		package_id = this.getAttribute('data-id');
	});
	 

});



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

function contactToLead(id){
	$("#addLeadsModal").find("#connect-to-stripe").attr('data-id',id);
	$.ajax( {
		type: "get",
		url: "/dashboard/leads/credits/"+ id,
		contentType: false,	
		processData: false,
		success: function ( data ) {
			console.log(data);
			if(data.status){
				if (data.available){
					contactToLeadWithStaus(id);
				}else{
					$('#addLeadsModal').modal('show');
			
				}
			}else{
				toastr.error( 'error' );
			}
		},error: function ( data ) {
			var err = data.responseJSON.errors;
		}
	} );
}


$(document).ready(function () {      
	$('id').click(function (event) {

	});
});


function contactToStripe(){
	showLoader();
	var selected_lead_id = $("#addLeadsModal").find("#connect-to-stripe").data('id')
	$.ajax( {
		type: "get",
		url: "/dashboard/leads/stripe/"+ selected_lead_id + '/' + package_id,
		contentType: false,	
		processData: false,
		success: function ( data ) {
		console.log("dataaaa",data);
		if(data.status){
			hideLoader();
			window.location.href = data.data_url;
		}else{
			toastr.error( 'error' );
		}
	},
		error: function ( data ) {
			var err = data.responseJSON.errors;
		}
} );
}

//get leads information
function contactToLeadWithStaus(id){
	$.ajax( {
		type: "get",
		url: "/dashboard/leads/status/"+ id,
		contentType: false,
		processData: false,
		success: function ( data ) {
			// console.log("dataaaa",data.data.email);
			document.getElementById("new_credits").innerHTML = "Available Credits: "+ data.new_credits;
			document.getElementById("leads_phone").innerHTML = data.data.phone_number;
			document.getElementById("leads_email" ).innerHTML = data.data.email;
			toastr.success( data.message);
			setTimeout( function () {
				$('#leadsDetail').modal('show');
			}, 1000 );
			
		},
		error: function ( data ) {
			var err = data.responseJSON.errors;
		}
	} );
	
}

$("#myModal").on("hide.bs.modal", function(){
	alert("gertretre");
	console.log("hey! How dare to close me !");
	// your function after closing modal goes here
})

hideLoader();
