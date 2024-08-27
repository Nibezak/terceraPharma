<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>
        Tercera | Affordable Prices for your medicine
    </title>
    {{-- <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind.css') }}" />
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <script type="text/javascript" src="https://cdn.emailjs.com/sdk/2.3.2/email.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- ==== WOW JS ==== -->
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>

    <script>
        new WOW().init();
    </script>
</head>

<style>
    body {
        overflow-x: hidden;
        /* Prevent horizontal overflow */
    }

    .container {
        max-width: 100vw;
        /* Restrict container width to viewport */
        margin: 0 auto;
        /* Center content */
        padding: 0 15px;
        /* Add padding for mobile devices */
        box-sizing: border-box;
    }

    .facebook-sticky {
        position: fixed;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        background-color: #1561d3;
        /* WhatsApp green */
        color: white;
        padding: 10px 20px;
        border-radius: 0 5px 5px 0;
        text-align: center;
        z-index: 1000;
        cursor: pointer;
    }

    .whatsapp-sticky {
        position: fixed;
        top: 58%;
        left: 0;
        transform: translateY(-50%);
        background-color: #25D366;
        /* WhatsApp green */
        color: white;
        padding: 10px 20px;
        border-radius: 0 5px 5px 0;
        text-align: center;
        z-index: 1000;
        cursor: pointer;
    }

    .instagram-sticky {
        position: fixed;
        top: 66%;
        left: 0;
        transform: translateY(-50%);
        background-color: #e00949;
        /* WhatsApp green */
        color: white;
        padding: 10px 20px;
        border-radius: 0 5px 5px 0;
        text-align: center;
        z-index: 1000;
        cursor: pointer;
    }
</style>

<head>
    @yield('seo')

    <!-- Google Font -->


    <link rel="stylesheet" href="{{ asset('frontend/css/all.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}" />
    <link href="{{ asset('frontend/fontawesome/css/all.css') }}" rel="stylesheet">
    {{-- @endif --}}
    @yield('css')

    <!-- Global site tag (gtag.js) - Google Analytics -->
    @if ($shareSettings->google_analytics != null)
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $shareSettings->google_analytics }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '{{ $shareSettings->google_analytics }}');
        </script>
    @endif

</head>

<body style="background-color:#2563EB'">



    <livewire:nav-bar>
        <!-- Header section end -->
        <div style="margin-top: 8rem;">
            <header class="header-section ">

                <div class="header-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-2 text-center text-lg-left">
                                <!-- logo -->
                                @if ($shareSettings != null)
                                    <a href="/" class="site-logo">
                                        <img src="/storage/{{ $shareSettings->logo }}" alt="">
                                    </a>
                                @endif
                            </div>
                            <!-- search area -->
                            <livewire:search-dropdown>
                                <div class="col-xl-4 col-lg-5">
                                    <div class="user-panel">
                                        <div class="up-item">
                                            <div class="shopping-card">
                                                <i class="flaticon-heart"></i>
                                                @if (Cart::instance('wishlist')->count() != 0)
                                                    <span>{{ Cart::instance('wishlist')->count() }}</span>
                                                @endif
                                            </div>
                                            <a href="{{ route('wishlist.index') }}">Wishlist</a>
                                        </div>
                                        <div class="up-item">
                                            <div class="shopping-card">
                                                <i class="flaticon-bag"></i>
                                                <span>{{ Cart::instance('default')->count() }}</span>
                                            </div>
                                            <a href="{{ route('cart.index') }}">Shopping Cart</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>


            </header>
            <div>
                <a href="https://www.facebook.com/p/Tercera-pharmacy-100083108173408/?locale=it_IT"
                    class="facebook-sticky" target="_blank"><i class="fa-brands fa-facebook"></i></span>
                    <a href="https://wa.me/250788700806" class="whatsapp-sticky" target="_blank">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="https://www.instagram.com/tercerapharmacy/" target="_blank" class="instagram-sticky"><i
                            class="fa-brands fa-instagram"></i></a>

                    @yield('content')
            </div>
        </div>
        <!-- Footer section -->
        <livewire:footer-detail>
            <!-- Footer section end -->



            <!--====== Javascripts & Jquery ======-->
            <livewire:scripts />
            <script src="{{ asset('frontend/js/all.js') }}"></script>

            <script src="{{ asset('js/toastr.js') }}"></script>
            <script>
                @if (Session::has('success'))
                    toastr.success("{{ Session::get('success') }}")
                @endif
            </script>

            <script>
                @if (Session::has('error'))
                    toastr.error("{{ Session::get('error') }}")
                @endif
            </script>

            @yield('scripts')

</body>

<script src="assets/js/swiper-bundle.min.js"></script>
<script src="assets/js/main.js"></script>
<script>
    // ==== for menu scroll
    const pageLink = document.querySelectorAll(".ud-menu-scroll");

    pageLink.forEach((elem) => {
        elem.addEventListener("click", (e) => {
            e.preventDefault();
            document.querySelector(elem.getAttribute("href")).scrollIntoView({
                behavior: "smooth",
                offsetTop: 1 - 60,
            });
        });
    });

    // section menu active
    function onScroll(event) {
        const sections = document.querySelectorAll(".ud-menu-scroll");
        const scrollPos =
            window.pageYOffset ||
            document.documentElement.scrollTop ||
            document.body.scrollTop;

        for (let i = 0; i < sections.length; i++) {
            const currLink = sections[i];
            const val = currLink.getAttribute("href");
            const refElement = document.querySelector(val);
            const scrollTopMinus = scrollPos + 73;
            if (
                refElement.offsetTop <= scrollTopMinus &&
                refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
            ) {
                document
                    .querySelector(".ud-menu-scroll")
                    .classList.remove("active");
                currLink.classList.add("active");
            } else {
                currLink.classList.remove("active");
            }
        }
    }

    window.document.addEventListener("scroll", onScroll);

    // Testimonial
    const testimonialSwiper = new Swiper(".testimonial-carousel", {
        slidesPerView: 1,
        spaceBetween: 30,

        // Navigation arrows
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },

        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
            1280: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });
</script>

</html>
