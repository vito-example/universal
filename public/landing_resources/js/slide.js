jQuery(document).ready(function(){
    function createSlick(){
        $(".hero_slider").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            draggable: true,
            arrows: true,
            prevArrow: "#prev_heroslide",
            nextArrow: "#next_heroslide",
            dots: true,
            fade: true,
            speed: 900,
            infinite: true,
            cssEase: "cubic-bezier(0.7, 0, 0.3, 1)",
            touchThreshold: 100,
            autoplay: true,
            autoplaySpeed: 5000,
            pauseOnHover: false,
        });
        $(".projects_slider").slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            draggable: true,
            arrows: true,
            prevArrow: "#project_prev",
            nextArrow: "#project_next",
            dots: false,
            speed: 300,
            infinite: true,
            cssEase: "linear",
            touchThreshold: 100,
            autoplay: false,
            centerMode: true,
            responsive: [
                {
                    breakpoint: 1000,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 1,
                    },
                },
            ],
        });

        $(".slider_project_page").slick({
            slidesToShow: 5,
            slidesToScroll: 1,
            draggable: true,
            arrows: true,
            prevArrow: "#pps_prev",
            nextArrow: "#pps_next",
            dots: false,
            speed: 300,
            infinite: true,
            cssEase: "linear",
            touchThreshold: 100,
            autoplay: false,
            centerMode: true,
            responsive: [
                {
                    breakpoint: 1600,
                    settings: {
                        slidesToShow: 4,
                    },
                },
                {
                    breakpoint: 1400,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 1000,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 560,
                    settings: {
                        slidesToShow: 1,
                    },
                },
            ],
        });

        $(".blog_slider").slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            draggable: true,
            arrows: true,
            prevArrow: "#prev_blog",
            nextArrow: "#next_blog",
            dots: false,
            speed: 300,
            infinite: true,
            cssEase: "linear",
            touchThreshold: 100,
            autoplay: false,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 2,
                    },
                },
                {
                    breakpoint: 500,
                    settings: {
                        slidesToShow: 1,
                        centerMode: true,
                    },
                },
            ],
        });
    }
    createSlick();

    $(window).on( 'resize', createSlick());

});
