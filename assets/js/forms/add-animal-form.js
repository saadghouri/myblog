
// When the browser is ready...
$(function () {

    // Setup form validation on the #add_animal_form element
    $("#add_animal_form").submit(function (e) {
        e.preventDefault();
    }).validate({
        // Specify the validation rules
        rules: {
            type: "required",
            age: "required",
            sex: "required",
            pregnant: "required",
            weightMin: "required",
            weightMax: "required",
            maturity: "required",
            price: {
                required : true,
                min: 0
            }
        },
        // Specify the validation error messages
        messages: {
            type: "Please enter type",
            age: "Please enter age",
            sex: "Please enter sex",
            pregnant: "Please enter pregnant",
            weightMin: "Please enter minimum weight",
            weightMax: "Please enter max weight",
            maturity: "Please enter maturity",
            price: "Please enter valid price"
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
                    loading(false);
                    if (!response.success) {
                        showMsgModal('Message', response.errors.message);
                    } else {
                        window.location.href = baseUrl + "my-animal";
                    }
                }
            });
        }
    });

});