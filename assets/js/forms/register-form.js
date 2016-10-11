
// When the browser is ready...
$(function () {

    // Setup form validation on the #register-form element
    $("#registration_formsss").submit(function (e) {
        e.preventDefault();
    }).validate({
        // Specify the validation rules
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            },
            agree: "required"
        },
        // Specify the validation error messages
        messages: {
            first_name: "Please enter your first name",
            last_name: "Please enter your last name",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            email: "Please enter a valid email address",
            agree: "Please accept our policy"
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
                        showMsgModal('Registration Successfull', response.success.message);
                        $(form)[0].reset();
                    }
                }
            });
        }
    });

});

/*===========================================================*/
/*                  LOGIN WITH FACEBOOK                      */
/*===========================================================*/
function fb_login() {
    FB.login(function (response) {

        if (response.authResponse) {
            //console.log(response); // dump complete info
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID

            FB.api('/' + user_id + '?fields=id,email,first_name,middle_name,last_name', function (response) {
                var user_email = response.email; //get user email
                var user_firstName = response.first_name; //get first name
                var user_middleName = response.middle_name; //get middle name
                var user_lastName = response.last_name; //get last name
                // you can store this data into your database

                $('#email').val(user_email);
                $('#first_name').val(user_firstName);
                $('#last_name').val(user_lastName);

                scrollToTop();
            });

        } else {
            //user hit cancel button
            console.log('User cancelled login or did not fully authorize.');

        }
    }, {
        scope: 'email'
    });
}

/*===========================================================*/
/*                  LOGIN WITH GOOGLE                        */
/*===========================================================*/
function onSuccess(googleUser) {
    var profile = googleUser.getBasicProfile();
    var first_name = profile.getGivenName();
    var last_name = profile.getFamilyName();
    var email = profile.getEmail();
    
    $('#email').val(email);
    $('#first_name').val(first_name);
    $('#last_name').val(last_name);
    
    scrollToTop();
}
function onFailure(error) {
    console.log(error);
}

function renderButton() {
    gapi.signin2.render('my-signin2', {
        'scope': 'profile email',
        'width': 'standard',
        'longtitle': true,
        'theme': 'dark',
        'onsuccess': onSuccess,
        'onfailure': onFailure
    });
}