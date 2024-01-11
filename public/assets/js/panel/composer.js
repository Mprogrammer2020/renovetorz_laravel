$(document).ready(function () {
    $("#composer_type_form").submit(function (event) {
        // Attach a function to the form's submit event
        event.preventDefault();

        var selectedValues = {};
        var atLeastOneChecked = false;

        $(":checkbox").each(function () {
            // Check if the checkbox is checked
            var checkboxName = $(this).attr("name");
            var checkboxValue = $(this).is(":checked") ? "1" : "0";

            // Check if the title is "Documents" and update the status
            if (checkboxName === "documents") {
                selectedValues[checkboxName] = "0"; // Set status to 0
            } else {
                selectedValues[checkboxName] = checkboxValue;

                if (checkboxValue === "1") {
                    atLeastOneChecked = true; 
                }
            }
        });

        // Check if at least one checkbox is checked
        if (!atLeastOneChecked) {
            alert("Please check at least one checkbox.");
            return; // Prevent the form submission
        }

        // Use AJAX to send the selectedValues array to your server
        $.ajax({
            type: "POST",
            url: "/dashboard/composer/type/check",
            data: { selectedValues: selectedValues },
            success: function (response) {
                // window.location.reload();
                toastr.success('Composer Saved Succesfully.');
                setTimeout(function () {
                    window.location.reload();
                }, 500);
            },
            error: function (error) {
                console.error("AJAX error:", error);
            }
        });
    });
});
