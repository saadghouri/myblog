
// When the browser is ready...
$(function () {

    // Setup form validation on the #register-form element
    $("#login_form").submit(function (e) {
        e.preventDefault();
    }).validate({
        // Specify the validation rules
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        // Specify the validation error messages
        messages: {
            password: {
                required: "Please provide a password"
            },
            email: "Please enter a valid email address"
        },
        // Do not change code below
        errorPlacement: function (error, element)
        {
            error.insertAfter(element.parent());
        },
        submitHandler: function (form) {
            loading(true);
            $.ajax({
                url: form.action,
                type: "POST",
                data: $(form).serialize(),
                success: function (response) {
                    if (!response.success) {
                        showMsgModal('Message', response.errors.message);
                        if (response.errors.inActiveEmail) {
                            $(form)[0].reset();
                        }
                        loading(false);
                    } else {
                        if (response.success.data.isOperator == "true") {
                            window.location.href = baseUrl + 'profile/' + response.success.data.userId;
                        } else {
                            window.location.href = baseUrl + 'search';
                        }
                    }
                }

            });
            //form.submit();
        }
    });

});