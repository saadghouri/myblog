
// When the browser is ready...
$(function () {
    // Setup form validation on the #register-form element
    $("#reset-password").submit(function (e) {
        e.preventDefault();
    }).validate({
        // Specify the validation rules
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            confirm_password: {
                minlength: 5,
                equalTo: "#password"
            }
        },
        // Specify the validation error messages
        messages: {
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: "Password doesn't match"
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
                        $(form)[0].reset();
                    }
                }

            });
            //form.submit();
        }
    });

});