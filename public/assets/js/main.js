/* =====================================================
Template Name   : Clasad
Description     : Classified Ads and Listing HTML5 Template
Author          : Themesland
Version         : 1.1
=======================================================*/

(function ($) {
    "use strict";

    // multi level dropdown menu
    $(".dropdown-menu a.dropdown-toggle").on("click", function (e) {
        if (!$(this).next().hasClass("show")) {
            $(this)
                .parents(".dropdown-menu")
                .first()
                .find(".show")
                .removeClass("show");
        }
        var $subMenu = $(this).next(".dropdown-menu");
        $subMenu.toggleClass("show");

        $(this)
            .parents("li.nav-item.dropdown.show")
            .on("hidden.bs.dropdown", function (e) {
                $(".dropdown-submenu .show").removeClass("show");
            });
        return false;
    });

    // data-background
    $(document).on("ready", function () {
        $("[data-background]").each(function () {
            $(this).css(
                "background-image",
                "url(" + $(this).attr("data-background") + ")"
            );
        });
    });

    // wow init
    new WOW().init();

    // hero slider
    $(".hero-slider").owlCarousel({
        loop: true,
        nav: true,
        dots: false,
        margin: 0,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 5000,
        items: 1,
        navText: [
            "<i class='far fa-long-arrow-left'></i>",
            "<i class='far fa-long-arrow-right'></i>",
        ],

        onInitialized: function (event) {
            var $firstAnimatingElements = $(".owl-item")
                .eq(event.item.index)
                .find("[data-animation]");
            doAnimations($firstAnimatingElements);
        },

        onChanged: function (event) {
            var $firstAnimatingElements = $(".owl-item")
                .eq(event.item.index)
                .find("[data-animation]");
            doAnimations($firstAnimatingElements);
        },
    });

    //hero slider do animations
    function doAnimations(elements) {
        var animationEndEvents =
            "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend";
        elements.each(function () {
            var $this = $(this);
            var $animationDelay = $this.data("delay");
            var $animationDuration = $this.data("duration");
            var $animationType = "animated " + $this.data("animation");
            $this.css({
                "animation-delay": $animationDelay,
                "-webkit-animation-delay": $animationDelay,
                "animation-duration": $animationDuration,
                "-webkit-animation-duration": $animationDuration,
            });
            $this.addClass($animationType).one(animationEndEvents, function () {
                $this.removeClass($animationType);
            });
        });
    }

    // category-slider
    $(".category-slider").owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        navText: [
            "<i class='fal fa-long-arrow-left'></i>",
            "<i class='fal fa-long-arrow-right'></i>",
        ],
        autoplay: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            },
        },
    });

    // product-slider
    $(".product-slider").owlCarousel({
        loop: true,
        margin: 10,
        nav: false,
        dots: true,
        navText: [
            "<i class='fal fa-long-arrow-left'></i>",
            "<i class='fal fa-long-arrow-right'></i>",
        ],
        autoplay: false,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            },
        },
    });

    // location-slider
    $(".location-slider").owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        navText: [
            "<i class='fal fa-long-arrow-left'></i>",
            "<i class='fal fa-long-arrow-right'></i>",
        ],
        autoplay: false,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 4,
            },
        },
    });

    // testimonial-slider
    $(".testimonial-slider").owlCarousel({
        loop: true,
        margin: 30,
        nav: false,
        dots: true,
        autoplay: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 2,
            },
            1000: {
                items: 3,
            },
        },
    });

    // partner-slider
    $(".partner-slider").owlCarousel({
        loop: true,
        margin: 50,
        nav: false,
        dots: false,
        autoplay: true,
        responsive: {
            0: {
                items: 2,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 6,
            },
        },
    });

    // preloader
    $(window).on("load", function () {
        $(".preloader").fadeOut("slow");
    });

    // fun fact counter
    $(".counter").countTo();
    $(".counter-box").appear(
        function () {
            $(".counter").countTo();
        },
        {
            accY: -100,
        }
    );

    // progress bar
    $(document).ready(function () {
        var progressBar = $(".progress");
        if (progressBar.length) {
            progressBar.each(function () {
                var Self = $(this);
                Self.appear(function () {
                    var progressValue = Self.data("value");
                    Self.find(".progress-bar").animate(
                        {
                            width: progressValue + "%",
                        },
                        1000
                    );
                });
            });
        }
    });

    // magnific popup init
    $(".popup-gallery").magnificPopup({
        delegate: ".popup-img",
        type: "image",
        gallery: {
            enabled: true,
        },
    });

    $(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
    });

    // scroll to top
    $(window).scroll(function () {
        if (
            document.body.scrollTop > 100 ||
            document.documentElement.scrollTop > 100
        ) {
            $("#scroll-top").fadeIn("slow");
        } else {
            $("#scroll-top").fadeOut("slow");
        }
    });

    $("#scroll-top").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1500);
        return false;
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $(".navbar").addClass("fixed-top");
        } else {
            $(".navbar").removeClass("fixed-top");
        }
    });

    // countdown
    if ($("#countdown").length) {
        $("#countdown").countdown("2028/01/30", function (event) {
            $(this).html(
                event.strftime(
                    "" +
                        '<div class="row">' +
                        '<div class="col countdown-single">' +
                        '<h2 class="mb-0">%-D</h2>' +
                        '<h5 class="mb-0">Day%!d</h5>' +
                        "</div>" +
                        '<div class="col countdown-single">' +
                        '<h2 class="mb-0">%H</h2>' +
                        '<h5 class="mb-0">Hours</h5>' +
                        "</div>" +
                        '<div class="col countdown-single">' +
                        '<h2 class="mb-0">%M</h2>' +
                        '<h5 class="mb-0">Minutes</h5>' +
                        "</div>" +
                        '<div class="col countdown-single">' +
                        '<h2 class="mb-0">%S</h2>' +
                        '<h5 class="mb-0">Seconds</h5>' +
                        "</div>" +
                        "</div>"
                )
            );
        });
    }

    // project filter
    $(window).on("load", function () {
        if ($(".filter-box").children().length > 0) {
            $(".filter-box").isotope({
                itemSelector: ".filter-item",
                masonry: {
                    columnWidth: 1,
                },
            });

            $(".filter-btns").on("click", "li", function () {
                var filterValue = $(this).attr("data-filter");
                $(".filter-box").isotope({ filter: filterValue });
            });

            $(".filter-btns li").each(function () {
                $(this).on("click", function () {
                    $(this).siblings("li.active").removeClass("active");
                    $(this).addClass("active");
                });
            });
        }
    });

    //flexslider;
    if ($(".flexslider-thumbnails").length) {
        $(".flexslider-thumbnails").flexslider({
            animation: "slide",
            controlNav: "thumbnails",
        });
    }

    // bootstrap tooltip enable
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // phone number reveal
    $(".product-single-author-phone").click(function () {
        $(".author-number").hide();
        $(".author-reveal-number").show();
    });

    // copywrite date
    let date = new Date().getFullYear();
    $("#date").html(date);

    // nice select
    $(document).ready(function () {
        $(".select").niceSelect();
    });

    // price slider
    $(function () {
        // var priceRange = $(".price-range");
        var minInput = $("#minPrice");
        var maxInput = $("#maxPrice");
        $(".price-range").slider({
            step: 500,
            range: true,
            min: 0,
            max: 100000,
            values: [1, 50000],
            slide: function (event, ui) {
                $(".priceRange").val(
                    ui.values[0].toLocaleString() +
                        " DT - " +
                        ui.values[1].toLocaleString() +
                        " DT"
                );
                minInput.val(ui.values[0]);
                maxInput.val(ui.values[1]);
            },
        });
        $(".priceRange").val(
            $(".price-range").slider("values", 0).toLocaleString() +
                " DT - " +
                $(".price-range").slider("values", 1).toLocaleString() +
                " DT"
        );
    });

    // profile image btn
    $(".profile-img-btn").click(function () {
        $(".profile-img-file").click();
    });

    // product images upload
    // $(".product-img-upload").click(function () {
    //     $(".product-img-file").click();
    // });

    // store images upload
    $(".store-upload").click(function (e) {
        $(e.target).closest(".form-group").find(".store-file").click();
    });

    // message bottom scroll
    if ($(".message-content-info").length) {
        $(function () {
            var chatbox = $(".message-content-info");
            var chatheight = chatbox[0].scrollHeight;
            chatbox.scrollTop(chatheight);
        });
    }
})(jQuery);
