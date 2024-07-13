<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ECABS : Staff</title>

    <link rel="icon" sizes="96x96" href="{!! url('assets/images/Icon.png') !!}">

    {{-- Font-Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Tables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    {{-- Toaster CSS(for Notify) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">
    <style>
        #sidebar-wrapper {
            width: 250px;
            transition: all 0.3s ease;
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

        .main-content {
            transition: all 0.3s ease;
            margin-left: 250px;
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

        .logo-text {
            color: #e00c0c;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 1);
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


        .inventory-container,
        .payment-container {
            background: linear-gradient(to bottom, #FFFFFF, #F5F5F5);
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
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

        th {
            text-transform: uppercase;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        th,
        td {
            background: #FFFFFF !important;
        }

        table {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;
            border: #000 1px solid;
        }

        td.status span.approved {
            color: #FFFFFF;
            background-color: #00C455;
        }

        td.status span.decline {
            color: #FFFFFF;
            background-color: #F13426;
        }

        td.status span.pending {
            color: #132D4A;
            background-color: #f5f5eb;
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
        @include('layouts/staff-components.sidebar')
        <!-- Page content wrapper-->
        <div id="page-content-wrapper" class="main-content">
            <!-- Top navigation-->
            @include('layouts/staff-components.navigation')
            <!-- Page content-->
            @yield('content')
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>

{{-- Toaster JS(for Notify) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@yield('script')

<script>
    var csrfToken = "{{ csrf_token() }}";

    // Function to handle sidebar toggle
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

    $('#updateStaffProfile').click(function() {
        $.ajax({
            url: '/staff/profile/get',
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

                $('#updateStaffName').val(name);
                $('#updateStaffEmail').val(email);
                $('#updateStaffContact').val(contact);
                $('#updateStaffBirthdate').val(birthdate);
                $('#updateStaffAddress').val(address);
            },
            error: function(xhr) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error Problem for Passing Profile Data:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    $('#updateStaffProfileBtn').click(function() {
        // Find the active tab-pane within updateProfileForms
        var activeTabPane = $('#updateProfileForms .tab-pane.active');
        // Get the ID of the active tab-pane
        var activeTabPaneId = activeTabPane.attr('id');
        // Now you can use activeTabPaneId to determine the currently active tab-pane
        console.log('Active Tab Pane ID:', activeTabPaneId);

        //User Info
        var newName = $('#updateStaffName').val();
        var newContact = $('#updateStaffContact').val();
        var newBday = $('#updateStaffBirthdate').val();
        var newAddress = $('#updateStaffAddress').val();

        //Email Info
        var newEmail = $('#updateStaffEmail').val();
        var userPass = $('#updateStaffPass').val();
        var confirmPass = $('#updateStaffConfirm').val();

        //Pass Info
        var oldPass = $('#updateStaffOldPass').val();
        var newPass = $('#updateStaffNewPass').val();
        var newConfirm = $('#updateStaffNewConfirm').val();

        $.ajax({
            url: '/staff/profile/update',
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
                    window.location.href = '/staff/staffProfile';
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

    $('.removeStaffNotifBtn').click(function() {
        // e.preventDefault();
        var notificationId = $(this).data('id');

        $.ajax({
            url: '/staffNotifRead/' + notificationId,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                window.location.href =
                    '/staff/maintenance/viewTask';
            },
            error: function(xhr) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error Problem for Clearing Notifs:<br>' +
                                parseErrors(xhr
                                    .responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    $('.reservationView').click(function() {
        var reviewId = $(this).data('id');
        var reviewEquipment = $(this).data('equipment');

        $.ajax({
            url: '/staff/reservation/view_reservation',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                reviewId: reviewId,
                reviewEquipment: reviewEquipment,
            },
            success: function(response) {
                $('#reservationId').text(reviewId);
                $('#resId').text(reviewId);
                $('#reservationRecipientName').text(response.reviewRecipient);
                $('#reservationRecipientId').text(response.reviewRecipientId);
                $('#reservationOrganization').text(response.organization);
                $('#reservationContact').text(response.contactNumber);
                $('#reservationAddress').text(response.address);
                $('#reservationEvent').text(response.eventType);
                $('#reservationAct').text(response.activity);
                $('#reservationDate').text(response.reviewDate);
                $('#reservationDate1').text(response.reviewDate);
                $('#reservationTime').text(response.reviewTime);
                $('#reservationLocation').text(response.reviewLocation);
                $('#reservationStatus').text(response.reviewStatus);
                $('#reservationEquipment').text(response.itemName);
                $('#reservationQuantity').text(response.reviewQuantity);
                $('#reservationPaymentDescription').text(response.activity + " in " + response
                    .reviewLocation);
                $('#reservationPrice').text(response.reservationPrice);
                $('#reviewAttachment').data('attachment', response.reviewAttachments);

                if (eventType == "Small-Event") {
                    $('#reviewAttachment').hide();
                }



                // Clear the table body
                var tableBody = $('#assignItemsList'); // Replace with your table body ID
                tableBody.empty();

                // Loop through furnitureItems and add rows to the table
                response.furnitureItems.forEach(function(item) {
                    var row = '<tr>' +
                        '<td>' + item.itemId + '</td>' +
                        '<td>' + item.name + '</td>' +
                        '</tr>';

                    tableBody.append(row);
                });
            },
            error: function(xhr) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error Problem for Approving Payment:<br>' +
                                parseErrors(xhr
                                    .responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    $('.taskDoneBtn').click(function() {
        var scheduleId = $(this).data('id');


        $.ajax({
            url: '/staff/maintenance/done_task',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                requestId: scheduleId,
            },
            success: function(response) {
                // 
                swal({
                    title: 'Success',
                    text: 'Task has been marked as Done (Great Work for today!!)',
                    icon: 'success'
                }).then(function() {
                    window.location.href = '/staff/maintenance/viewTask';
                });
            },
            error: function(xhr, status, error) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error View Assign Staff:<br>' +
                                parseErrors(xhr
                                    .responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    $(document).ready(function() {
        // Sidebar toggle event
        $('#sidebarToggle').on('click', toggleSidebar);

        $('.sidebar-close').on('click', toggleSidebar);

        $('#view-reservation').DataTable({
            "order": [
                [0, "desc"]
            ]
        });

        $('#view-inventory').DataTable();

        $('#view-maintenance').DataTable({
            "order": [
                [0, "desc"]
            ]
        });

        $('#view-payment').DataTable({
            "order": [
                [0, "desc"]
            ]
        });

        // Function to check and update reservations
        function checkReservations() {
            var currentDateTime = new Date();

            // Send an AJAX request to update item status
            $.ajax({
                url: '/itemStatusUpdate',
                type: 'GET',
                success: function(response) {
                    // Handle the response if needed
                    console.log("Furniture Status Updating.. Done");
                },
                error: function(xhr) {
                    console.log("Error for Updating Furniture status: " + xhr.responseText);
                }
            });
        }

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
                    console.log("Error Payment status: " + xhr.responseText);
                }
            });
        }

        // Call the functions when the document is ready
        checkReservations();
        setInterval(checkReservations, 3600000); // 1 hour (in milliseconds)

        checkReservationPayment();
        setInterval(checkReservationPayment, 3600000); // 1 hour (in milliseconds)
    });

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
            channel.bind('admin-assign', function(data) {
                var value = data.activity; // Access the "user" property of the data object
                toastr.success(value); // Access the "user" value toastr.success(value);
            });
            channel.bind('admin-update-assign', function(data) {
                var value = data.activity; // Access the "user" property of the data object
                toastr.warning(value); // Access the "user" value toastr.success(value);
            });
            channel.bind('admin-unassign', function(data) {
                var value = data.activity; // Access the "user" property of the data object
                toastr.warning(value); // Access the "user" value toastr.success(value);
            });

        },
        error: function(xhr) {

        }
    });
</script>

</html>
