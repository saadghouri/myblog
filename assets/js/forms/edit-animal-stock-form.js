
// When the browser is ready...
$(function () {

    // Setup form validation on the #add_animal_form element
    $("#edit_animal_info_form").submit(function (e) {
        e.preventDefault();
    }).validate({
        // Specify the validation rules
        rules: {
            operator: "required",
            pregnant: "required",
            weight: "required",
            maturityDate: "required"
        },
        // Specify the validation error messages
        messages: {
            operator: "Please enter operator profile",
            pregnant: "Please enter pregnant",
            weight: "Please enter weight",
            maturityDate: "Please enter maturity date"
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
                        showMsgModal('Message', response.success.message);
                    }
                }
            });
        }
    });

});