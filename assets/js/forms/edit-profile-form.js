
// When the browser is ready...
$(function () {

    // Setup form validation on the #edit_user_profile element
    $("#edit_user_profile").submit(function (e) {
        e.preventDefault();
    }).validate({
        // Specify the validation rules
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email: true
            }
        },
        // Specify the validation error messages
        messages: {
            first_name: "Please enter your first name",
            last_name: "Please enter your last name",
            email: "Please enter a valid email address"
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
                        window.location.href = baseUrl + "profile/" + response.success.data.userId;
                        //showMsgModal('Message', response.success.message);
                    }
                }
            });
        }
    });

});