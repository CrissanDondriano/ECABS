<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ECABS</title>

    {{-- Font-Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap core CSS -->
    <link href="{!! url('assets/bootstrap/css/bootstrap.min.css') !!}" rel="stylesheet">

    {{-- Icon --}}
    <link rel="icon" sizes="96x96" href="{!! url('assets/images/Icon.png') !!}">

    {{-- Lib CSS files --}}
    <link rel="stylesheet" href="{!! url('assets/lib/animate.css/animate.min.css') !!}">
    <link rel="stylesheet" href="{!! url('assets/lib/aos/aos.css') !!}">
    <link rel="stylesheet" href="{!! url('assets/lib/swiper/swiper-bundle.min.css') !!}">

    <!-- Owl Carousel CSS and JavaScript via CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" defer></script>

    <!-- Custom styles for this template -->
    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">

</head>

<body>

    <header class="pt-3 bg-white">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between">

                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                    <img class="" src="{!! url('assets/images/CABS.png') !!}" alt="" width="50" height="50"
                        loading="lazy">
                    <span class="h2 fw-bold mt-2 px-1 logo-name"
                        style="color: #e00c0c;
                        text-shadow: 1px 1px 1px rgba(0, 0, 0, 1);">eCABS</span>
                </a>

                <!-- Hamburger menu for small screens -->
                <button id="navbar-toggler" class="navbar-toggler d-lg-none bg-white" type="button">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <ul id="navbar-list" class="nav d-none d-lg-flex col-12 col-lg-auto ms-lg-auto mb-2 mb-md-0">
                    <li><a href="#hero" class="nav-link px-2 text-dark nav-style nav-hover" data-toggle="tooltip"
                            title="Home">Home</a></li>
                    <li><a href="#main" class="nav-link px-2 text-dark nav-style nav-hover" data-toggle="tooltip"
                            title="About">About</a></li>
                    <li><a href="#events" class="nav-link px-2 text-dark nav-style nav-hover" data-toggle="tooltip"
                            title="Schedule">Schedule</a></li>
                    <li><a href="#popular-courses" class="nav-link px-2 text-dark nav-style nav-hover"
                            data-toggle="tooltip" title="Facilities">Facilities</a>
                    </li>
                    <li><a href="#contact" class="nav-link px-2 text-dark nav-style nav-hover" data-toggle="tooltip"
                            title="Contact">Contact</a></li>
                    <li>
                        <div class="collapse px-2 pt-1" id="searchCollapse">
                            <form>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search" aria-label="Search">
                                </div>
                            </form>
                        </div>
                    </li>
                    <li><a class=" nav-link px-3 text-dark nav-style nav-hover" data-bs-toggle="collapse"
                            href="#searchCollapse" role="button" aria-expanded="false" aria-controls="searchCollapse"
                            data-toggle="tooltip" title="Search">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </a>
                    </li>


                    @if (Route::has('login'))
                        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                            @auth
                                @php
                                    $userType = auth()->user()->type;
                                @endphp

                                @if ($userType == 'admin')
                                    <a href="{{ url('/admin/home') }}" class="btn btn-color nav-style" data-toggle="tooltip"
                                        title="Dashboard">Dashboard</a>
                                @elseif($userType == 'staff')
                                    <a href="{{ url('/staff/home') }}" class="btn btn-color nav-style" data-toggle="tooltip"
                                        title="Dashboard">Dashboard</a>
                                @else
                                    <a href="{{ url('/home') }}" class="btn btn-color nav-style" data-toggle="tooltip"
                                        title="Dashboard">Dashboard</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="nav-style btn btn-outline-dark me-2"
                                    data-toggle="tooltip" title="Login">Sign In</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="nav-style btn btn-color"
                                        data-toggle="tooltip" title="Register">Sign Up</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </ul>
            </div>
        </div>
    </header>

    <main class="mt-2">
        <div>
            <!-- ======= Hero Section ======= -->
            <section id="hero" class="d-flex justify-content-center align-items-center">
                <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
                    <h1>Sports Excellence at Your Service</h1>
                    <h2>Delivering excellence on-demand, our facilities are here to serve your sporting aspirations.
                    </h2>
                    <a href="@if (Route::has('login')) @auth
                            @if (auth()->user()->type == 'user')
                                {{ route('makeReservation') }}
                            @elseif (auth()->user()->type == 'admin')
                                {{ route('admin.reservation.view-calendar') }}
                            @else
                                {{ route('schedule') }} @endif
@else
{{ route('schedule') }}
                        @endauth @endif"
                        class="btn-get-started" data-toggle="tooltip" title="Schedule">Schedule Now</a>
                </div>
            </section>
            <!-- ======= End Hero Section ======= -->

            <div id="main">

                <!-- ======= About Section ======= -->
                <div class="breadcrumbs" data-aos="fade-in">
                    <div class="container">
                        <h2>About Us</h2>
                        <p>Welcome to CABS (Cabuyao Athletes Basic School), your one-stop destination for athlete
                            reservation, comprehensive training programs, and a wealth of information tailored to
                            enhance your athletic journey.</p>
                    </div>
                </div>
                <!-- End Breadcrumbs -->

                <!-- ======= About Section ======= -->
                <section id="about" class="about">
                    <div class="container" data-aos="fade-up">

                        <div class="row">
                            <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
                                <img src="{!! url('assets/images/Login Side.jpg') !!}" class="img-fluid" alt="">
                            </div>
                            <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
                                <h3 class="py-4">Cabuyao Athletes Basic School: Nurturing Excellence, Inspiring
                                    Dreams.</h3>
                                <p class="fst-italic" style="text-indent: 50px;">
                                    The City of Cabuyao inaugurated the "Cabuyao Athletes Basic School" located in Brgy.
                                    Banay-Banay, City of Cabuyao, as part of its program for the overall development of
                                    the city and its residents. This state-of-the-art facility consists of Gym1, Gym2,
                                    Multi-Sports Hall, Aquatic Center, dormitories, division office, and a spacious
                                    parking area.
                                </p>
                                <p class="fst-italic" style="text-indent: 50px;">The establishment of Cabuyao Athletes
                                    Basic School reflects the city's dedication to promoting social, cultural, sports,
                                    and athletic activities while providing athletes, students, and event organizers
                                    with exceptional resources and a supportive environment for their pursuits. It has
                                    become a cherished destination for sports enthusiasts and the local community,
                                    fostering a spirit of athleticism and holistic growth in Cabuyao.</p>
                            </div>
                        </div>

                    </div>
                </section>
                <!-- End About Section -->

                <!-- ======= Counts Section ======= -->
                <section id="counts" class="counts section-bg">
                    <div class="container">

                        <div class="row counters">

                            <div class="col-lg-3 col-6 text-center">
                                <span data-purecounter-start="0"
                                    data-purecounter-end="
                                @php
$length = 0;
                                    $length = count($facilities); @endphp

                                {{ $length }}
                                "
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Facilities</p>
                            </div>

                            <div class="col-lg-3 col-6 text-center">
                                <span data-purecounter-start="0"
                                    data-purecounter-end="
                                @php
$length = 0;
                                    $length = count($reservations); @endphp

                                {{ $length }}
                                "
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Reservation</p>
                            </div>

                            <div class="col-lg-3 col-6 text-center">
                                <span data-purecounter-start="0"
                                    data-purecounter-end="
                                @php
$length = 0;
                                    $length = count($renters); @endphp

                                {{ $length }}
                                "
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Renters</p>
                            </div>

                            <div class="col-lg-3 col-6 text-center">
                                <span data-purecounter-start="0"
                                    data-purecounter-end="
                                @php
$length = 0;
                                    $length = count($staffs); @endphp

                                {{ $length }}
                                "
                                    data-purecounter-duration="1" class="purecounter"></span>
                                <p>Staff</p>
                            </div>

                        </div>

                    </div>
                </section>
                <!-- End Counts Section -->

                <!-- ======= Facilitator Section ======= -->
                <section id="why-us" class="why-us">
                    <div class="container" data-aos="fade-up">

                        <div class="row">
                            <div class="col-lg-4 d-flex align-items-stretch">
                                <div class="content">
                                    <h3>Why Choose CABS?</h3>
                                    <p>
                                        CABS is a multi-sports facility business based in Cabuyao, Laguna, dedicated to
                                        providing athletes and sports enthusiasts with an exceptional sporting
                                        experience. With state-of-the-art facilities and a commitment to excellence,
                                        CABS is the go-to destination for anyone looking to elevate their sports
                                        endeavors.
                                    </p>
                                    <div class="text-center">
                                        <a href="" class="more-btn">Learn More <i
                                                class="bx bx-chevron-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                                <div class="icon-boxes d-flex flex-column justify-content-center">
                                    <div class="row">
                                        <div class="col-xl-4 d-flex align-items-stretch">
                                            <div class="icon-box mt-4 mt-xl-0">
                                                <h4>Top-Notch Facilities</h4>
                                                <p> CABS provides top-notch facilities for a wide range of sports and
                                                    activities, empowering athletes with access to swimming, basketball,
                                                    volleyball, martial arts, and more, enabling them to excel in their
                                                    chosen disciplines.</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 d-flex align-items-stretch">
                                            <div class="icon-box mt-4 mt-xl-0">
                                                <h4>Exceptional Services and Support</h4>
                                                <p>At CABS, our dedicated and knowledgeable staff goes above and beyond
                                                    to provide exceptional services, support, and assistance,
                                                    guaranteeing a seamless and enjoyable experience for athletes and
                                                    event organizers alike.</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 d-flex align-items-stretch">
                                            <div class="icon-box mt-4 mt-xl-0">
                                                <h4>Convenient Location and Accessibility</h4>
                                                <p>Conveniently situated in Cabuyao, Laguna, CABS provides easy access
                                                    to athletes, teams, and event attendees with its proximity to major
                                                    transportation routes and ample parking, ensuring a hassle-free
                                                    experience for everyone.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End .content-->
                            </div>
                        </div>

                    </div>
                </section>
                <!-- End Facilitator Section -->

                <!-- ======= Event Breadcrumbs ======= -->
                <div id="events" class="breadcrumbs" data-aos="fade-in">
                    <div class="container">
                        <h2>Upcoming Events</h2>
                    </div>
                </div>
                <!-- ======= Event Section ======= -->
                <section id="events" class="events section-bg" style="padding: 0;">
                    <div class="owl-carousel owl-theme">
                        @if ($currentEvents->isEmpty())
                            <div class="item">
                                <img src="{!! url('assets/images/CABSSS.png') !!}" class="img-fluid" alt="" loading="lazy">
                                <div class="cover">
                                    <div class="container">
                                        <div class="header-content">
                                            <div class="line animated bounceInLeft"></div>
                                            <h1>No Events Available</h1>
                                            <h4>Please Wait for further announcement</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach ($currentEvents as $event)
                                <div class="item">
                                    <img src="{{ asset('storage/eventImages/' . $event->image) }}" class="img-fluid"
                                        alt="" loading="lazy">
                                    <div class="cover">
                                        <div class="container">
                                            <div class="header-content">
                                                <div class="line animated bounceInLeft"></div>
                                                <h2>{{ $event->title }}</h2>
                                                <h1>{{ $event->description }}</h1>
                                                <h4>Date:
                                                    {{ \Carbon\Carbon::parse($event->start_date)->format('F j, Y') }} -
                                                    {{ \Carbon\Carbon::parse($event->end_date)->format('F j, Y') }}
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </section>
                <!-- End Event Section -->

                <!-- ======= Facilities Section ======= -->
                <section id="popular-courses" class="courses">
                    <div class="container" data-aos="fade-up">

                        <div class="section-title">
                            <h2>Facilities</h2>
                            <p>CABS Facilities</p>
                        </div>

                        <div id="events" class="events">
                            <div class="container" data-aos="fade-up">

                                <div class="row">
                                    @foreach ($facilities as $facility)
                                        <div class="col-md-6 d-flex align-items-stretch">
                                            <div class="card">
                                                <div class="card-img">
                                                    <img src="{{ asset('storage/images/' . $facility->image) }}"
                                                        alt="...">
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title"><a
                                                            style="text-decoration:none";>{{ $facility->name }}</a>
                                                    </h5>
                                                    <p class="card-text">{{ $facility->description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- End Facilities Section -->

                <!-- ======= Breadcrumbs ======= -->
                <div id="contact" class="breadcrumbs" data-aos="fade-in">
                    <div class="container">
                        <h2>Contact Us</h2>
                        <p>For any inquiries, assistance, or collaboration opportunities, feel free to reach out to CABS
                            (Cabuyao Athletes Basic School) through our Contact Us section, where our friendly team is
                            ready to help and provide you with the information you need.</p>
                    </div>
                </div>
                <!-- End Breadcrumbs -->

                <!-- ======= Contact Section ======= -->
                <section class="contact">
                    <div data-aos="fade-up">
                        <iframe style="border:0; width: 100%; height: 350px;"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3866.9552900450317!2d121.13603151530963!3d14.255829889253267!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd639fb8c4cc03%3A0x844827f7bddb9e85!2sCABS%20Cabuyao%20Athletes%20Basic%20School!5e0!3m2!1sen!2sph!4v1680864432652!5m2!1sen!2sph"
                            frameborder="0" allowfullscreen></iframe>
                    </div>

                    <div class="container" data-aos="fade-up">

                        <div class="row mt-5">

                            <div class="col-lg-4">
                                <div class="info">
                                    <div class="address">
                                        <i class="fa-solid fa-location-dot"></i>
                                        <h4>Location:</h4>
                                        <p>744Q 87H, Cabuyao, Laguna</p>
                                    </div>

                                    <div class="email">
                                        <i class="fa-solid fa-envelope"></i>
                                        <h4>Email:</h4>
                                        <p>{{ $currentEmail }}</p>
                                    </div>

                                    <div class="phone">
                                        <i class="fa-solid fa-phone"></i>
                                        <h4>Call:</h4>
                                        <p>
                                            @php
                                                $formattedNumber = '+63 ' . substr($currentNumber, 0, 3) . ' ' . substr($currentNumber, 3, 3) . ' ' . substr($currentNumber, 6);
                                            @endphp
                                            {{ $formattedNumber }}
                                        </p>
                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-8 mt-5 mt-lg-0">

                                <form class="php-email-form">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <input type="text" name="sendName" class="form-control" id="sendName"
                                                placeholder="Your Name" required>
                                        </div>
                                        <div class="col-md-6 form-group mt-3 mt-md-0">
                                            <input type="email" class="form-control" name="sendEmail" id="sendEmail"
                                                placeholder="Your Email" required>
                                        </div>
                                    </div>
                                    <div class="form-group mt-3">
                                        <input type="text" class="form-control" name="sendSubject" id="sendSubject"
                                            placeholder="Subject" required>
                                    </div>
                                    <div class="form-group mt-3">
                                        <textarea class="form-control" name="sendMessage" rows="5" placeholder="sendMessage" required></textarea>
                                    </div>
                                    <div class="my-3">
                                        <div class="loading">Loading</div>
                                        <div class="error-message"></div>
                                        <div class="sent-message">Your message has been sent. Thank you!</div>
                                    </div>
                                    <div class="text-center"><button type="submit">Send Message</button></div>
                                </form>

                            </div>

                        </div>

                    </div>
                </section>
                <!-- ======= End Contact Section ======= -->
            </div>
        </div>
    </main>

    <!-- Site footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-5">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                        <img class="" src="{!! url('assets/images/CABS.png') !!}" alt="" width="60"
                            height="60" loading="lazy">
                        <span class="h1  mt-2 px-1 logo-name text-white">eCABS</span>
                    </a>
                </div>

                <div class="col-xs-6 col-md-4">
                    <ul class="footer-links">
                        <h6>Details</h6>
                        <li><i class="fa-solid fa-location-dot"></i> 744Q 87H, Cabuyao, Laguna</span></li>
                        <li><i class="fa-solid fa-envelope"></i><a href="mailto:{{ $currentEmail }}"
                                class="text-decoration-none">{{ $currentEmail }}</a></li>
                    </ul>
                </div>

                <div class="col-xs-6 col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="#hero">Home</a></li>
                        <li><a href="#main">About</a></li>
                        <li><a href="#events">Schedule</a></li>
                        <li><a href="#popular-courses">Facilities</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <p class="copyright-text">Copyright &copy; 2023 All Rights Reserved by
                        <a href="#">Group eCABS</a>.
                    </p>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <ul class="social-icons">
                        <li><a class="facebook" href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a class="twitter" href="#"><i class="fa-brands fa-twitter"></i></a></li>
                        <li><a class="dribbble" href="#"><i class="fa-brands fa-instagram"></i></a></li>
                        <li><a class="linkedin" href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="{!! url('assets/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! url('assets/lib/purecounter/purecounter_vanilla.js') !!}"></script>
    <script src="{!! url('assets/lib/aos/aos.js') !!}"></script>
    <script src="{!! url('assets/lib/swiper/swiper-bundle.min.js') !!}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Sweetalert Plugin --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script src="{!! url('assets/js/script.js') !!}"></script>

    <script>
        var csrfToken = "{{ csrf_token() }}";
        $(document).ready(function() {

            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                dots: false,
                nav: true,
                mouseDrag: false,
                autoplay: true,
                animateOut: 'fadeOut',
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });

            $("#navbar-toggler").on("click", function() {
                // Toggle the visibility of the navbar list
                $("#navbar-list").toggleClass("d-none");

                // Add additional styles when navbar is shown
                if (!$("#navbar-list").hasClass("d-none")) {
                    // Center the navbar
                    $("#navbar-list").addClass("show-navbar");

                    // Add a gray overlay to the rest of the page
                    $("<div class='overlay'></div>").insertBefore("#navbar-list");

                    $("#navbar-list a").removeClass("text-dark").addClass("text-white");
                    $("#navbar-list a").removeClass("btn-outline-dark").addClass("btn-outline-light");

                    // Add hover styles for anchor elements
                    $("#navbar-list a").hover(function() {
                        // Set the hover styles for the anchor elements
                        $(this).addClass("text-dark");
                        $(this).removeClass("text-white");
                    }, function() {
                        // Remove the hover styles when the mouse leaves the anchor elements
                        $(this).addClass("text-white");
                        $(this).removeClass("text-dark");
                    });

                    $("#navbar-toggler").css({
                        "position": "relative",
                        "z-index": "10001"
                    });
                } else {
                    // Remove the centering and gray overlay styles when hiding the navbar
                    $("#navbar-list").removeClass("show-navbar");
                    $(".overlay").remove();

                    $("#navbar-list a").removeClass("text-white").addClass("text-dark");
                    $("#navbar-list a").removeClass("btn-outline-light").addClass("btn-outline-dark");
                }
            });


            $("#emailSent").click(function() {
                var name = $("#sendName").val();
                var email = $("#sendEmail").val();
                var subject = $("#sendSubject").val();
                var message = $("#sendMessage").val();

                $.ajax({
                    url: '/sentEmail',
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        name: name,
                        email: email,
                        subject: subject,
                        message: message,
                    },
                    success: function(response) {
                        swal({
                            title: 'Success',
                            text: "The email successfully sent",
                            icon: 'success'
                        });
                    },
                    error: function(xhr) {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Problem for Sending the Message:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }
                });
            });
        });

        function parseErrors(responseText) {
            try {
                // Try to parse the responseText as JSON
                const errorObject = JSON.parse(responseText);

                let errorMessage = '';

                // Check if the parsed object has an 'error' property
                if (errorObject && errorObject.error) {
                    errorMessage += `&bullet; ${errorObject.error}<br>`;
                }

                // Check if the parsed object has an 'errors' property
                if (errorObject && errorObject.errors) {
                    // If 'errors' property exists, format multiple field errors as a bullet-point list
                    const errorList = Object.entries(errorObject.errors).map(([key, value]) => {
                        const messages = value.map(msg => `${key}: ${msg}`).join('<br>');
                        return `&bullet; ${messages}`;
                    }).join('<br>');
                    errorMessage += errorList;
                }

                // Check if the parsed object has a 'message' property
                if (errorObject && errorObject.message) {
                    // Check if the error message includes the specific file format error
                    if (errorObject.message.includes("Invalid file format. Only PDF and document files are allowed.")) {
                        errorMessage += `&bullet; ${errorObject.message}<br>`;
                    }

                    // Check if the error message includes SQL error information
                    if (errorObject.message.includes("SQLSTATE")) {
                        errorMessage += `&bullet; SQL Error: ${errorObject.message}<br>`;
                    }

                    // Add other conditions as needed for different types of errors
                    // ...

                    // If none of the specific error conditions match, include the generic error message
                    errorMessage += `&bullet; ${errorObject.message}<br>`;
                }

                return errorMessage;
            } catch (e) {
                // If parsing fails, return the original responseText
                return responseText;
            }
        }
    </script>

</body>

</html>
