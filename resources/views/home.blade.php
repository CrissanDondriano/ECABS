@extends('layouts.user-app')

@section('content')
    @php
        date_default_timezone_set('Asia/Manila');
        $currentTime = date('H');
        $greeting = '';

        if ($currentTime >= 0 && $currentTime < 12) {
            $greeting = 'Good morning';
        } elseif ($currentTime >= 12 && $currentTime < 18) {
            $greeting = 'Good afternoon';
        } else {
            $greeting = 'Good day';
        }
    @endphp

    <style>
        .bg-image {
            background-image: url('assets/images/user-card1.jpg');
            background-size: cover;
            background-position: center;
        }

        .bg-image1 {
            background-image: url('assets/images/user-card2.jpg');
            background-size: cover;
            background-position: center;
        }

        .bg-image2 {
            background-image: url('assets/images/user-card3.jpg');
            background-size: cover;
            background-position: center;
        }

        .time-font {
            font-size: 50px;
        }

        .sm-font {
            font-size: 18px;
        }

        .med-font {
            font-size: 28px;
        }

        .large-font {
            font-size: 60px;
        }

        .activity-container {
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .card {
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0px 1px 5px #999;
            overflow: hidden;
        }

        .image {
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            position: center;
            background-repeat: no-repeat;
            min-height: 300px;
            transition: all 0.5s ease-in-out;
        }

        .image:hover,
        .image1:hover {
            transform: rotate(-3deg) scale(1.1);
            -webkit-transform: rotate(-3deg) scale(1.1);
        }

        .price {
            position: absolute;
            top: 0;
            right: 0;
            width: auto;
            color: #eee;
            padding: 20px;
            background-color: #333;
            background-color: rgba(76, 166, 255, 0.9);
            font-size: 24px;
            z-index: 10;
        }

        .price span {
            font-size: 0.6em;
        }

        .description {
            position: absolute;
            z-index: 10;
            bottom: 0;
            width: 100%;
            color: #eee;
            padding: 10px 20px 0px 20px;
            background-color: #333;
            background-color: rgba(0, 0, 0, 0.7);
        }
    </style>

    <div class="container-fluid content-wrapper">
        <div class="row mt-4 p-4">
            <div class="col-md-6 p-4 mt-4 mb-md-2">
                <h1 class="fw-bold">{{ $greeting }}, {{ Auth::user()->name }}</h1>
                <p class="text-muted mt-4">Track and manage your reservation easily and conveniently, and find the perfect
                    place to reserve our facilities</p>
                <a type="button" class="btn btn-dark rounded-pill p-2 px-4 fw-bold mt-4"
                    href="{{ route('viewReservation') }}" data-toggle="tooltip" title="View Reservation">View Reservation</a>
            </div>
            <div class="col-md-6">
                <div class="card font-weather activity-container
                    <?php
                    $currentTime = strtotime(date('H:i'));
                    $morningStart = strtotime('06:00');
                    $afternoonStart = strtotime('12:00');
                    $eveningStart = strtotime('18:00');
                    
                    if ($currentTime >= $eveningStart || $currentTime < $morningStart) {
                        echo 'bg-image';
                    } elseif ($currentTime >= $morningStart && $currentTime < $afternoonStart) {
                        echo 'bg-image1';
                    } else {
                        echo 'bg-image2';
                    }
                    ?> ">
                    <div class="card-body text-end text-white">
                        <h2 class="mt-3 mb-0">Cabuyao</h2>
                        <p class="mb-0 med-font">Partly Sunny</p>
                        <h1 class="large-font">32&#176;</h1>
                        <div class="text-start">
                            <p class="time-font mb-0"><?php echo date('h:i A'); ?></p>
                            <p class="mb-4"><?php echo date('l, d F Y'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row p-4">
            <div class="owl-carousel owl-theme">

                @foreach ($facilities as $facility)
                    <div class="item">
                        <div class="col-md-12">
                            <div class="card">
                                <a href="#">
                                    <div class="image" style="background-image: url('{{ asset('storage/images/' . $facility->image) }}');"></div>
                                    <div class="description">
                                        <div class="row">
                                            <div class="col-sm-12 py-3">
                                                <h4 class="fw-bold ">{{ $facility->name }}</h4>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="row p-4">
            <div class="col-md-12">
                <h3 class=" fw-bold mb-4">Recent Activities</h3>
                <table class="table table-bordered table-striped nowrap">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Time</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $latestUserReservations = $userReservations->sortByDesc('id')->take(5);
                        @endphp
                        @foreach ($latestUserReservations as $userReservation)
                            <tr>
                                <td>
                                    <p class="fw-bold mb-0">{{ $userReservation->activity }}</p>
                                    <p class="text-muted mb-0">{{ $userReservation->facility }}</p>
                                </td>
                                <td>
                                    <p class="text-muted mb-0">{{ $userReservation->time }}</p>
                                </td>
                                <td>
                                    <p class="text-muted mb-0">{{ $userReservation->date }}</p>
                                </td>
                                <td>
                                    <span
                                        @if ($userReservation->status == 'Approved') class="badge bg-success rounded-pill d-inline"
                                    @else
                                        class="badge bg-danger rounded-pill d-inline" @endif>{{ $userReservation->status }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection

@section('script')
    <script>
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
                        items: 2
                    }
                }
            });

            // var lazyImages = document.querySelectorAll('.image');

            // var observer = new IntersectionObserver(function(entries, observer) {
            //     entries.forEach(function(entry) {
            //         if (entry.isIntersecting) {
            //             var img = entry.target;
            //             var src = img.getAttribute('data-src');

            //             img.style.backgroundImage = 'url("' + src + '")';
            //             observer.unobserve(img);
            //         }
            //     });
            // }, { rootMargin: "0px 0px 50px 0px" });

            // lazyImages.forEach(function(img) {
            //     observer.observe(img);
            // });
        });
    </script>
@endsection
