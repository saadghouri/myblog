
// When the browser is ready...
$(function () {

    // Setup form validation on the #add_animal_form element
    $("#add_animal_form").submit(function (e) {
        e.preventDefault();
    }).validate({
        // Specify the validation rules
        rules: {
            operator: "required",
            type: "required",
            serialNumber: "required",
            birthday: "required",
            sex: "required",
            pregnant: "required",
            weight: "required",
            maturityDate: "required"
        },
        // Specify the validation error messages
        messages: {
            operator: "Please enter operator profile",
            type: "Please enter type",
            serialNumber: "Please enter serial number",
            birthday: "Please enter date of birth",
            sex: "Please enter sex",
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
                        window.location.href = baseUrl + "my-animal-stock";
                    }
                }
            });
        }
    });

});