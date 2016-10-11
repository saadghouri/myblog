
// When the browser is ready...
$(function () {

    // Setup form validation on the #register-form element
    $("#forgot-password").submit(function (e) {
        e.preventDefault();
    }).validate({
        // Specify the validation rules
        rules: {
            email: {
                required: true,
                email: true
            }
        },
        // Specify the validation error messages
        messages: {
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
                        if (response.errors.inActiveEmail) {
                            $(form)[0].reset();
                        }
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