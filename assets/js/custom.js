/* Write here your custom javascript codes */
function showMsgDiv(msg, error) {
    if (error) {
        $('.success_message').show();
        $('.error_message').hide();
        $('.success_message').html(msg);
    } else {
        $('.success_message').show();
        $('.error_message').hide();
        $('.success_message').html(msg);
    }
}

function hideMsgDiv() {
    $('.success_message').hide();
    $('.error_message').hide();
}

function showMsgModal(msgTitle, msgBody) {
    $('#messageModalTitle').html(msgTitle);
    $('#messageModalBody').html(msgBody);
    $('#messageModal').modal('show');
}


//$(document).ready(function(){
//    Ladda.bind( '.ladda-button');
//});

// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete;
var componentForm = {
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name'
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    console.log('sss');
    autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
    console.log(place.address_components);
    $('#lattitude').val(place.geometry.location.lat());
    $('#longitude').val(place.geometry.location.lng());

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
        });
    }
}

function subtractQty() {
    if (document.getElementById("quantity").value - 1 < 0)
        return;
    else
        document.getElementById("quantity").value--;
}

$('#indexPageLoading').hide();
function loading(show) {
    if (show) {
        $('#indexPageLoading').show();
    } else {
        $('#indexPageLoading').hide();
    }
}

$(document).ready(function () {
    $('#initialPageLoader').hide();
});



/**
 * Scroll to element
 * @param {type} selector
 * @param {type} time
 * @param {type} verticalOffset
 * @param {type} modal - scroll inside modal
 */
function scrollToElement(selector, time, verticalOffset, modal, modalFormName)
{
    time = typeof (time) != 'undefined' ? time : 1000;
    verticalOffset = typeof (verticalOffset) != 'undefined' ? verticalOffset : 0;
    element = $(selector);
    offset = element.offset();
    offsetTop = offset.top + verticalOffset;
    if (modal) {
        $('#' + modalFormName).animate({
            scrollTop: offsetTop
        }, time);
    } else {
        $('html, body').animate({
            scrollTop: offsetTop
        }, time);
    }

}

function scrollToTop() {
    $('html, body').animate({
        scrollTop: 0
    }, 600);
}


/*===========================================================*/
/*                  LOGIN WITH FACEBOOK                      */
/*===========================================================*/
$(document).ready(function () {
    window.fbAsyncInit = function () {
        FB.init({
            appId: '634050830083020',
            oauth: true,
            status: true, // check login status
            cookie: true, // enable cookies to allow the server to access the session
            xfbml: true // parse XFBML
        });

    };

    (function () {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
    }());
});