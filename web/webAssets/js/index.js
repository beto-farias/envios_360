$(document).ready(function() {

    $(".owl-carousel-banner").owlCarousel({
        items: 1,
        loop: true,
        margin: 0,
        nav: true,
        smartSpeed: 900,
        navText: [
            "<i class='ion ion-chevron-left'></i>",
            "<i class='ion ion-chevron-right'></i>"
        ]
    });

    var sync1 = $("#sync1");
    var sync2 = $("#owldos");
    var slidesPerPage = 4; //globaly define number of elements per page
    var syncedSecondary = true;

    $('.owl-carousel-dos').owlCarousel({
        loop: false,
        margin: 16,
        nav: true,
        smartSpeed: 200,
        slideSpeed : 500,
        slideBy: slidesPerPage,
        responsiveRefreshRate : 100,
        navText: [
            "<i class='ion ion-chevron-left'></i>",
            "<i class='ion ion-chevron-right'></i>"
        ],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        }
    })
    // }).on('changed.owl.carousel', syncPosition2);
        
});