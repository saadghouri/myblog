
// When the browser is ready...
$(function () {

    // Setup form validation on the #edit_operator_profile element
    $("#edit_operator_profile").submit(function (e) {
        e.preventDefault();
    }).validate({
        // Specify the validation rules
        rules: {
            company_name: "required",
            address: "required"
        },
        // Specify the validation error messages
        messages: {
            company_name: "Please enter company name",
            address: "Please enter address"
        },
        // Do not change code below
        errorPlacement: function (error, element)
        {
            error.insertAfter(element.parent());
        },
        submitHandler: function (form) {
            event.preventDefault();

            loading(true);
            $.ajax({
                url: form.action,
                type: "POST",
                data: $(form).serialize(),
                success: function (response) {
                    loading(false);
                    if (!response.success) {
                        showMsgModal('Message', response.errors.message);
                    } else {
                        window.location.href = baseUrl + "operator/" + response.success.data.operatorId;
                    }
                }
            });
        }
    });

});

$(document).ready(function () {
    initAutocomplete();
});