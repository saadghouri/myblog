var MasterSliderShowcase2 = function () {

    return {
        //Master Slider
        initMasterSliderShowcase2: function () {
            var slider = new MasterSlider();

            slider.control('arrows', {autohide: false});
            slider.control('thumblist', {
                autohide: false,
                dir: 'h',
                arrows: false,
                align: 'bottom',
                width: 180,
                height: 170,
                margin: 5,
                space: 5
            });

            slider.setup('masterslider', {
                width: 550,
                height: 550,
                //space:5,
                view: 'fade'
            });
            
            
            slider.api.addEventListener(MSSliderEvent.CHANGE_START, function (event) {
                // dispatches when the slider's current slide change starts.
                
                var api = event.target;
                var currentSlide = api.index();
                var allSlide = api.count();
                // remove left arrow on first slide
                if (currentSlide == 0)
                {
                    jQuery('.ms-nav-prev').addClass("ms-prev-temp");
                    jQuery('.ms-nav-prev').removeClass("ms-nav-prev");
                } else {
                    jQuery('.ms-prev-temp').addClass("ms-nav-prev");
                }
                // remove right arrow on last slide
                if (allSlide == (currentSlide + 1))
                {
                    jQuery('.ms-nav-next').addClass("ms-next-temp");
                    jQuery('.ms-nav-next').removeClass("ms-nav-next");
                } else {
                    jQuery('.ms-next-temp').addClass("ms-nav-next");
                }
            });

            slider.api.addEventListener(MSSliderEvent.CHANGE_END, function (event) {
                // dispatches when the slider's current slide change ends.
                var api = event.target;
                var currentSlide = api.index();
                var allSlide = api.count();
                // remove left arrow on first slide
                if (currentSlide == 0)
                {
                    jQuery('.ms-nav-prev').addClass("ms-prev-temp");
                    jQuery('.ms-nav-prev').removeClass("ms-nav-prev");
                } else {
                    jQuery('.ms-prev-temp').addClass("ms-nav-prev");
                }
                // remove right arrow on last slide
                if (allSlide == (currentSlide + 1))
                {
                    jQuery('.ms-nav-next').addClass("ms-next-temp");
                    jQuery('.ms-nav-next').removeClass("ms-nav-next");
                } else {
                    jQuery('.ms-next-temp').addClass("ms-nav-next");
                }
            });
        }

    };

}();