<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ECABS : Renters</title>

    <link rel="icon" sizes="96x96" href="{!! url('assets/images/Icon.png') !!}">

    {{-- Font-Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css">

    <!-- Tables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" defer></script>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Toaster CSS(for Notify) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">

    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">

    <style>
        #sidebar-wrapper {
            width: 250px;
            transition: all 1s ease;
            overflow: hidden;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .navbar {
            top: 0;
            z-index: 2;
        }

        .sidebar-heading {
            padding: 15px;
        }

        .sidebar-button {
            text-decoration: none;
            color: #000;
        }

        .logo-text {
            color: #e00c0c;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 1);
        }

        .main-content {
            transition: all 0.3s ease;
            margin-left: 250px;
        }

        .accordion-item {
            border: none;
        }

        .accordion-button {
            border: none;
            text-decoration: none;
        }

        #page-content-wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .navbar-fixed {
            flex: 0 0 auto;
        }

        .content-wrapper {
            flex: 1;
            overflow-y: auto;
        }

        #sidebar-wrapper.active {
            max-width: 80px;
        }

        #sidebar-wrapper.active~.main-content {
            margin-left: 80px;
        }

        #sidebar-wrapper.active .sidebar-text,
        #sidebar-wrapper.active .accordion {
            display: none;
        }

        .reservation-container {
            background: linear-gradient(to bottom, #FFFFFF, #F5F5F5);
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .fc-unthemed .fc-content,
        .fc-unthemed .fc-divider,
        .fc-unthemed .fc-list-heading td,
        .fc-unthemed .fc-list-view,
        .fc-unthemed .fc-popover,
        .fc-unthemed .fc-row,
        .fc-unthemed tbody,
        .fc-unthemed td,
        .fc-unthemed th,
        .fc-unthemed thead {
            border-color: #000;
        }

        .notification-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .notification-item {
            background-color: #f5f5f5;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
            transition: background-color 0.3s;
        }

        .notification-item:hover {
            background-color: #ffffff;
        }

        .reservation-container {
            background: linear-gradient(to bottom, #FFFFFF, #F5F5F5);
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .form-group.required .control-label:after {
            color: #d00;
            content: "*";
            font-family: 'Glyphicons Halflings';
            font-weight: normal;
            font-size: 14px;
        }

        .sidebar-close {
            display: none;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .animate-dropdown {
            transition: transform 0.3s;
        }

        .animate-dropdown:hover {
            transform: translateY(-2px);
        }

        .animate-dropdown-menu {
            animation-duration: 0.3s;
            animation-name: slideIn;
            animation-fill-mode: forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon {
            animation: notification 2s infinite;
        }

        @keyframes notification {

            5% {
                transform: rotate(10deg);
            }

            10% {
                transform: rotate(-10deg);
            }

            15% {
                transform: rotate(10deg);
            }

            20% {
                transform: rotate(0deg);
            }


        }

        .notify-drop {
            min-width: 330px;
            background-color: #fff;
            min-height: 360px;
            max-height: 360px;
        }

        .notify-drop-title {
            border-bottom: 1px solid #e2e2e2;
            padding: 5px 15px 10px 15px;
        }

        .drop-content {
            min-height: 280px;
            max-height: 280px;
            overflow-y: scroll;
        }

        .drop-content::-webkit-scrollbar-track {
            background-color: #F5F5F5;
        }

        .drop-content::-webkit-scrollbar {
            width: 8px;
            background-color: #F5F5F5;
        }

        .drop-content::-webkit-scrollbar-thumb {
            background-color: #ccc;
        }

        .drop-content>li {
            border-bottom: 1px solid #e2e2e2;
            padding: 10px 0px 5px 0px;
        }

        .notify-drop-footer {
            border-top: 1px solid #e2e2e2;
            padding: 0.3rem 0;
        }

        .notify-drop-footer a {
            color: #777;
            text-decoration: none;
        }

        .notify-drop-footer a:hover {
            color: #333;
        }

        .italic {
            font-style: italic;
            text-align: justify;
        }

        @media screen and (max-width: 1024px) {

            #sidebar-wrapper {
                display: none;
                transition: width 1s ease;
            }

            #sidebar-wrapper.active~.main-content {
                margin-left: 0;
            }

            #sidebar-wrapper.active-mobile {
                display: block;
                z-index: 3;
            }

            .sidebar-close {
                display: block;
            }

            .main-content {
                margin-left: 0;
            }

            .navbar {
                margin-left: 0;
                left: 0;
                width: 100%;
                z-index: 2;
            }

            .navbar-expand-sm .navbar-nav .dropdown-menu {
                position: absolute;
            }
        }
    </style>

    @yield('style')
</head>

<body class="font-sans text-gray-900 antialiased">
    <div id="wrapper">
        <!-- Sidebar-->
        @include('layouts/user-components.sidebar')
        <!-- Page content wrapper-->
        <div id="page-content-wrapper" class="main-content">
            <!-- Top navigation-->
            @include('layouts/user-components.navigation')
            <!-- Page content-->
            @yield('content')
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

{{-- Sweetalert Plugin --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Include the html2pdf.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<!-- Include the html2canvas.js library -->
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

{{-- Toaster JS(for Notify) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@yield('script')

<script>
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    function toggleSidebar() {
        var sidebarWrapper = $('#sidebar-wrapper');
        var sidebarText = $('.sidebar-text');
        var accordion = $('.accordion-button');
        var navbar = $('.navbar');
        var mainContent = $('.main-content');

        if ($(window).width() > 1024) {

            sidebarWrapper.toggleClass('active');

        } else {
            sidebarWrapper.toggleClass('active-mobile');
        }
    }

    $('#updateUserProfile').click(function() {
        $.ajax({
            url: '/user/profile/get',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                var name = response.name;
                var email = response.email;
                var contact = response.contact;
                var birthdate = response.birthdate;
                var address = response.address;

                $('#updateUserName').val(name);
                $('#updateUserEmail').val(email);
                $('#updateUserContact').val(contact);
                $('#updateUserBirthdate').val(birthdate);
                $('#updateUserAddress').val(address);
            },
            error: function(xhr) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error on Getting the Profile Data:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    $('#updateUserProfileBtn').click(function() {
        // Find the active tab-pane within updateProfileForms
        var activeTabPane = $('#updateProfileForms .tab-pane.active');
        // Get the ID of the active tab-pane
        var activeTabPaneId = activeTabPane.attr('id');
        // Now you can use activeTabPaneId to determine the currently active tab-pane
        console.log('Active Tab Pane ID:', activeTabPaneId);

        //User Info
        var newName = $('#updateUserName').val();
        var newContact = $('#updateUserContact').val();
        var newBday = $('#updateUserBirthdate').val();
        var newAddress = $('#updateUserAddress').val();

        //Email Info
        var newEmail = $('#updateUserEmail').val();
        var userPass = $('#updateUserPass').val();
        var confirmPass = $('#updateUserConfirm').val();

        //Pass Info
        var oldPass = $('#updateUserOldPass').val();
        var newPass = $('#updateUserNewPass').val();
        var newConfirm = $('#updateUserNewConfirm').val();

        $.ajax({
            url: '/user/profile/update',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                tabActive: activeTabPaneId,
                //
                name: newName,
                contact: newContact,
                birthdate: newBday,
                address: newAddress,
                //
                email: newEmail,
                userPass: userPass,
                confirmPass: confirmPass,
                //
                oldPass: oldPass,
                pass: newPass,
                confirm: newConfirm,
            },
            success: function(response) {
                swal({
                    title: 'Success',
                    text: response.message,
                    icon: 'success'
                }).then(function() {
                    window.location.href = '/userProfile';
                });
            },
            error: function(xhr) {
                //New Error
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error Problem for Updating Profile:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    // Function to text animation
    function applyTextAnimation(className) {
        var wrapper = $("." + className).eq(0);
        wrapper.css("opacity", "1");
        wrapper.html(wrapper.text().replace(/./g, "<span>$&</span>"));

        var spans = wrapper.find("span");

        spans.each(function(i) {
            $(this).css("animation-delay", i * 80 + "ms");
        });
    }


    function cancelReservation() {
        $('#userReservationCancelBtn').click(function() {
            var reservationId = $('#confirmReservationId').val();
            var reservationName = $('#confirmReservationName').val();
            var reasonDetails = $('#reasonForm').val();

            $.ajax({
                url: '/modify-reservation/cancel',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: reservationId,
                    name: reservationName,
                    reason: reasonDetails,
                },
                success: function(response) {
                    // Handle the success response
                    swal({
                        title: 'Success',
                        text: 'Your Reservation has been Cancelled Successfully!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/modify-reservation';
                    });

                },
                error: function(xhr, status, error) {

                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'There is a problem from Cancelling your Reservation:<br>' +
                                    parseErrors(xhr
                                        .responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });

                },
            });
        });
    }

    function reasonView() {
        $('.btnReasonView').click(function() {
            var reason = $(this).data('reason');
            $('#reasonDetails').text(reason);
        });
    }

    function viewQrCode() {
        $('.btnQRView').click(function() {
            var reservationQR = $(this).data('qr');
            $.ajax({
                url: '/modify-reservation/view',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    qr: reservationQR,
                },
                success: function(response) {

                    $("#qrCode").attr("src", "data:image/svg+xml;base64," + response
                        .qrCodeData);
                },
                error: function(xhr, status, error) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'There is a problem from Viewing your QRCode:<br>' +
                                    parseErrors(xhr
                                        .responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                },
            });
        });
    }

    // Function to generate and download the QR code as a bigger JPG image
    function downloadQRCodeAsJPG() {
        const content = document.querySelector('.content'); // Select the content to be converted

        // Convert the content to an image using html2canvas
        html2canvas(content).then(function(canvas) {
            const padding = 20; // Adjust the padding value as needed

            // Create a new canvas with padded dimensions
            const paddedCanvas = document.createElement('canvas');
            paddedCanvas.width = canvas.width + 2 * padding;
            paddedCanvas.height = canvas.height + 2 * padding;
            const ctx = paddedCanvas.getContext('2d');

            // Fill the padded canvas with white color
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, paddedCanvas.width, paddedCanvas.height);

            // Draw the original canvas content onto the padded canvas
            ctx.drawImage(canvas, padding, padding, canvas.width, canvas.height);

            // Convert the padded canvas to an image data URL
            const imgData = paddedCanvas.toDataURL('image/jpeg');

            // Create a download link for the image
            const link = document.createElement('a');
            link.href = imgData;
            link.download = 'qrcode_reservation.jpg'; // You can change the image format and name here
            link.click();
        });
    }


    // Calendar
    $(document).ready(function() {
        // Sidebar toggle event
        $('#sidebarToggle').on('click', toggleSidebar);

        $('.sidebar-close').on('click', toggleSidebar)

        $("#downloadQRCode").on("click", function() {
            downloadQRCodeAsJPG();
        });

        $('#view-reservation').DataTable({
            responsive: true,
            fixedheader: true,
            "order": [
                [0, "desc"]
            ]
        });

        $('#modify-reservation').dataTable({
            responsive: true,
            fixedheader: true,
            "order": [
                [0, "desc"]
            ],
            drawCallback: function(settings) {
                viewQrCode();
                reasonView();
                cancelReservation();
            }
        });

        applyTextAnimation("text-animation");
        applyTextAnimation("text-animation1");

        // Function to check and update reservations
        function checkReservationPayment() {
            // Send an AJAX request to update item status
            $.ajax({
                url: '/reservationPaymentStatusUpdate',
                type: 'GET',
                success: function(response) {
                    // Handle the response if needed
                    console.log("Payment Status Updating.. Done");
                },
                error: function(xhr) {
                    //Nothing
                }
            });
        }

        checkReservationPayment();
        setInterval(checkReservationPayment, 3600000); // 1 hour (in milliseconds)

        $('#openReservationModal').click(function() {
            var storedData = localStorage.getItem('termsAgreed');

            if (storedData) {
                var parsedData = JSON.parse(storedData);
                var termsAgreed = parsedData.value;
                var expirationTime = parsedData.expirationTime;

                if (termsAgreed === 'true' && expirationTime && Date.now() < expirationTime) {
                    window.location.href = '{{ route('makeReservation') }}';
                    return;
                }
            }

            $('#reservationModal').modal('show');
        });


        $('#agreeCheckbox').change(function() {
            if ($(this).prop('checked')) {
                var expirationTime = Date.now() + 5 * 60 * 60 * 1000;

                localStorage.setItem('termsAgreed', JSON.stringify({
                    value: 'true',
                    expirationTime: expirationTime
                }));

                window.location.href = '{{ route('makeReservation') }}';

                setTimeout(function() {
                    localStorage.removeItem('termsAgreed');
                }, 24 * 60 * 60 * 1000);
            }
        });


        $('.userReservationUpdate').click(function() {
            var reservationId = $(this).data('id');
            var reserveeName = $(this).data('name');
            var reservationDate = $(this).data('date');
            var reservationTime = $(this).data('time');

            $('#reservationId').val(reservationId);
            $('#reserveeName').val(reserveeName);
            $('#reservationDate').val(reservationDate);
            $('#reservationTime').val(reservationTime);
        });

        $("#userReservationUpdateBtn").click(function() {
            var reservationId = $('#reservationId').val();
            var reservationName = $('#reserveeName').val();
            var reservationDate = $('#reservationDate').val();
            var reservationTime = $('#reservationTime').val();

            $.ajax({
                url: '/modify-reservation/update',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: reservationId,
                    name: reservationName,
                    date: reservationDate,
                    time: reservationTime,
                },
                success: function(response) {
                    // Handle the success response
                    swal({
                        title: 'Success',
                        text: 'Your Reservation has been Updated Successfully!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/modify-reservation';
                    });

                },
                error: function(xhr, status, error) {
                    if (xhr.status === 404) {
                        var message = xhr.responseJSON.message;
                        // Display SweetAlert error notification
                        swal({
                            icon: 'error',
                            title: 'Time already Booked',
                            text: message
                        });
                    } else {

                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'There is a problem from Updating your Reservation:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }

                },
            });
        });

        $('.userReservationCancel').click(function() {
            var reservationId = $(this).data('id');
            var reservationName = $(this).data('name');

            $('#confirmReservationId').val(reservationId);
            $('#confirmReservationName').val(reservationName);
        });

        $('.removeUserNotifBtn').click(function() {
            var notificationId = $(this).data('id');

            $.ajax({
                url: '/userNotifRead/' + notificationId,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    window.location.href =
                        '/modify-reservation';
                },
                error: function(xhr) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Problem for Clearing Notifs:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });

                }
            });
        });

        $('.reviewReservationBtn').click(function() {
            var reviewId = $(this).data('id');
            var reviewRecipient = $(this).data('addressee');
            var reviewRecipientId = $(this).data('identifier');
            var organization = $(this).data('organization');
            var contactNumber = $(this).data('contact');
            var address = $(this).data('address');
            var activity = $(this).data('activity');
            var reviewDate = $(this).data('date');
            var reviewTime = $(this).data('time');
            var reviewLocation = $(this).data('location');
            var reviewStatus = $(this).data('status');
            var reviewEquipment = $(this).data('equipment');
            var reviewQuantity = $(this).data('quantity');
            var reviewAttachments = $(this).data('attachment');
            var eventType = $(this).data('type');

            $.ajax({
                url: '/user/reservation/view_reservation',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    reviewId: reviewId,
                    reviewEquipment: reviewEquipment,
                },
                success: function(response) {
                    $('#resId').text(reviewId);
                    $('#reservationRecipientName').text(reviewRecipient);
                    $('#reservationRecipientId').text(reviewRecipientId);
                    $('#reservationOrganization').text(organization);
                    $('#reservationContact').text(contactNumber);
                    $('#reservationAddress').text(address);
                    $('#reservationEvent').text(eventType);
                    $('#reservationAct').text(activity);
                    $('#reservationDateV').text(reviewDate);
                    $('#reservationDateV1').text(reviewDate);
                    $('#reservationTimeV').text(reviewTime);
                    $('#reservationLocation').text(reviewLocation);
                    $('#reservationStatus').text(reviewStatus);
                    $('#reservationEquipment').text(response.itemName);
                    $('#reservationQuantity').text(reviewQuantity);
                    $('#reservationPaymentDescription').text(activity);
                    $('#reservationPrice').text(response.reservationPrice);
                    $('#reviewAttachment').data('attachment', reviewAttachments);

                    $('#orderOrganization').text(organization);
                    $('#orderName').text(reviewRecipient);
                    $('#orderLocation').text(reviewLocation);
                    $('#orderLocationReserve').text(reviewLocation);
                    $('#orderNameReserve').text(reviewRecipient);
                    if (eventType == "Small-Event") {
                        $('#reviewAttachment').hide();
                    }
                },
                error: function(xhr) {
                    swal({
                        title: 'Error',
                        text: 'Error Problem for Viewing Reservation: ' + xhr
                            .responseText,
                        icon: 'error'
                    });
                }
            });
        });

        function generateAndDownloadPDF(content, fileName) {
            const options = {
                margin: 10,
                filename: fileName,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf().from(content).set(options).save();
        }

        $('#exportButton').click(function() {
            const fileName = 'Requirement.pdf';
            const content = document.querySelector('.subpage');

            generateAndDownloadPDF(content, fileName);
        });

    });

    //Parse Error v1.4 (Add new error for specific file input)
    // function parseErrors(responseText) {
    //     try {
    //         // Try to parse the responseText as JSON
    //         const errorObject = JSON.parse(responseText);

    //         let errorMessage = '';

    //         // Check if the parsed object has an 'error' property
    //         if (errorObject && errorObject.error) {
    //             errorMessage += `&bullet; ${errorObject.error}<br>`;
    //         }

    //         // Check if the parsed object has an 'errors' property
    //         if (errorObject && errorObject.errors) {
    //             // If 'errors' property exists, format multiple field errors as a bullet-point list
    //             const errorList = Object.entries(errorObject.errors).map(([key, value]) => {
    //                 const messages = value.map(msg => `${key}: ${msg}`).join('<br>');
    //                 return `&bullet; ${messages}`;
    //             }).join('<br>');
    //             errorMessage += errorList;
    //         }

    //         // Check if the parsed object has a 'message' property
    //         if (errorObject && errorObject.message) {
    //             // Check if the error message includes the specific file format error
    //             if (errorObject.message.includes("Invalid file format. Only PDF and document files are allowed.")) {
    //                 errorMessage += `&bullet; ${errorObject.message}<br>`;
    //             }

    //             // Check if the error message includes SQL error information
    //             if (errorObject.message.includes("SQLSTATE")) {
    //                 errorMessage += `&bullet; SQL Error: ${errorObject.message}<br>`;
    //             }

    //             // Add other conditions as needed for different types of errors

    //             // If none of the specific error conditions match, include the generic error message
    //             errorMessage += `&bullet; ${errorObject.message}<br>`;
    //         }

    //         return errorMessage;
    //     } catch (e) {
    //         // If parsing fails, return the original responseText
    //         return responseText;
    //     }
    // }

    //ParseError v1.5 (remove the double error|| WaRning: Experimental[1.4 on user-app in case SHTZ Happen -Rances])
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
            if (errorObject && errorObject.message && !errorObject.errors) {
                // Check if the error message includes the specific file format error
                if (errorObject.message.includes("Invalid file format. Only PDF and document files are allowed.")) {
                    errorMessage += `&bullet; ${errorObject.message}<br>`;
                }

                // Check if the error message includes SQL error information
                if (errorObject.message.includes("SQLSTATE")) {
                    errorMessage += `&bullet; SQL Error: ${errorObject.message}<br>`;
                }

                // Add other conditions as needed for different types of errors

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

{{-- For Notify --}}
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: '/getUserId',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            var user_id = response.userId;

            // Enable pusher logging - don't include this in production
            Pusher.logToConsole = true;

            var pusher = new Pusher('dd54a39b29a5be5f37b1', {
                cluster: 'ap1'
            });

            var userChannel = 'popup-channel-' + user_id; // Use the specific user's ID
            var channel = pusher.subscribe(userChannel);
            channel.bind('admin-approve', function(data) {
                var value = data.activity; // Access the "activity" property of the data object
                toastr.success(value);
            });
            channel.bind('admin-decline', function(data) {
                var value = data.activity; // Access the "activity" property of the data object
                toastr.warning(value);
            });


        },
        error: function(xhr) {

        }
    });
</script>

</html>
