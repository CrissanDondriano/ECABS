<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ECABS • Administrator</title>

    <link rel="icon" sizes="96x96" href="{!! url('assets/images/Icon.png') !!}">

    {{-- Font-Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">


    <!-- Tables -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link href="{!! url('assets/css/app.css') !!}" rel="stylesheet">

    <!-- Print CSS -->
    <link href="{{ url('assets/css/print.css') }}" rel="stylesheet">

    <!-- Alertify CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.12.0/build/css/themes/default.min.css" />

    {{-- Toaster CSS(for Notify) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <style>
        #sidebar-wrapper {
            display: none;
            transform: translateX(310px);
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

        .sidebar-close {
            display: block;
        }

        .borderless {
            border: none !important;
        }

        .sub-buttons {
            display: none;
        }

        .main-content {
            transition: all 0.3s ease;
            width: 100%;
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
            display: block;
            z-index: 3;
            transform: translateX(0);
        }

        #sidebar-wrapper.active~.main-content {
            margin-left: 0;
        }


        #sidebar-wrapper.slide-in {
            animation: slideIn 0.3s ease;
        }

        #sidebar-wrapper.slide-out {
            animation: slideOut 0.3s ease;
        }

        @keyframes slideIn {
            0% {
                transform: translateX(310px);
            }

            100% {
                transform: translateX(0);
            }
        }

        @keyframes slideOut {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(310px);
            }
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            border: none;
            position: relative;
            margin-bottom: 30px;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .l-bg-cherry {
            background: linear-gradient(to right, #493240, #f09) !important;
            color: #fff;
        }

        .l-bg-blue-dark {
            background: linear-gradient(to right, #373b44, #4286f4) !important;
            color: #fff;
        }

        .l-bg-green-dark {
            background: linear-gradient(to right, #0a504a, #38ef7d) !important;
            color: #fff;
        }

        .l-bg-orange-dark {
            background: linear-gradient(to right, #a86008, #ffba56) !important;
            color: #fff;
        }
        
        .card .card-statistic-3 .card-icon-large .fas,
        .card .card-statistic-3 .card-icon-large .far,
        .card .card-statistic-3 .card-icon-large .fab,
        .card .card-statistic-3 .card-icon-large .fal {
            font-size: 110px;
        }

        .card .card-statistic-3 .card-icon {
            text-align: center;
            line-height: 50px;
            margin-left: 15px;
            color: #000;
            position: absolute;
            right: -5px;
            top: 20px;
            opacity: 0.1;
        }

        .l-bg-cyan {
            background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
            color: #fff;
        }

        .l-bg-green {
            background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
            color: #fff;
        }

        .l-bg-orange {
            background: linear-gradient(to right, #f9900e, #ffba56) !important;
            color: #fff;
        }

        .l-bg-cyan {
            background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
            color: #fff;
        }

        .agenda-text {
            background: rgba(234, 110, 72, 1);
            background: -moz-linear-gradient(45deg, rgba(234, 110, 72, 1) 0%, rgba(188, 26, 99, 1) 100%);
            background: -webkit-gradient(left bottom, right top, color-stop(0%, rgba(234, 110, 72, 1)), color-stop(100%, rgba(188, 26, 99, 1)));
            background: -webkit-linear-gradient(45deg, rgba(234, 110, 72, 1) 0%, rgba(188, 26, 99, 1) 100%);
            background: -o-linear-gradient(45deg, rgba(234, 110, 72, 1) 0%, rgba(188, 26, 99, 1) 100%);
            background: -ms-linear-gradient(45deg, rgba(234, 110, 72, 1) 0%, rgba(188, 26, 99, 1) 100%);
            background: linear-gradient(45deg, rgba(234, 110, 72, 1) 0%, rgba(188, 26, 99, 1) 100%);
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .inventory-container,
        .payment-container,
        .report-container {
            background: linear-gradient(to bottom, #FFFFFF, #FFFFFF);
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .nav-tabs>li>a {
            padding: 16px 25px 12px;
            font-size: 14px;
            font-weight: 700;
            font-style: normal;
            text-transform: capitalize;
            color: #737c85;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            border: none !important;
            border-bottom: 4px solid transparent !important;
        }

        .nav-tabs>.nav-item>.nav-link.active,
        .nav-tabs>.nav-item>.nav-link:hover,
        .nav-tabs>.nav-item>.nav-link:focus {
            background-color: transparent;
            border-bottom: 4px solid #85d6de !important;
        }

        .nav-tabs>.nav-item.nav-item.text-start>.nav-link.active,
        .nav-tabs>.nav-item.nav-item.text-start>.nav-link:hover,
        .nav-tabs>.nav-item.nav-item.text-start>.nav-link:focus {
            background-color: transparent;
            border-bottom: 4px solid transparent !important;
        }

        .nav-tabs {
            margin: 0 auto;
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

        .view-head {
            background: linear-gradient(to right, #ffffff, #ffffff);
        }

        .logo-text {
            color: #e00c0c;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 1);
        }

        #reservationTable.table-bordered,
        #inventoryTable.table-bordered,
        #maintenanceTable.table-bordered,
        #paymentTable.table-bordered {
            border: 1px solid #333;
        }

        .head-color {
            background: #fff !important;

        }

        .no-resize {
            resize: none;
        }

        .control-label:after {
            color: #d00;
            content: "*";
            font-family: 'Glyphicons Halflings';
            font-weight: normal;
            font-size: 14px;
        }

        #exportTable.table-bordered {
            border: 1px solid #333;
        }

        table.dataTable tbody>tr>td.select-checkbox::before {
            transform: translate(10%, 40%);
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

        .green-border-focus .form-control:focus {
            border: 1px solid #8bc34a;
            box-shadow: 0 0 0 0.2rem rgba(139, 195, 74, .25);
        }

        @media screen and (max-width: 1024px) {

            /* #sidebar-wrapper {
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
            } */

            .navbar-expand-sm .navbar-nav .dropdown-menu {
                position: absolute;
            }

        }
    </style>
    @yield('style')

    {{-- For Notify --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('dd54a39b29a5be5f37b1', {
            cluster: 'ap1'
        });

        // For User Reservation
        var channel = pusher.subscribe('popup-channel');
        channel.bind('user-register', function(data) {
            var value = data.user; // Access the "user" property of the data object
            toastr.success(value); // Access the "user" value            toastr.success(value);
        });
        // For User Cancellation
        channel.bind('user-cancel', function(data) {
            var value = data.user; // Access the "user" property of the data object
            toastr.success(value); // Access the "user" value            toastr.success(value);
        });
    </script>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="d-flex" id="wrapper">
        <!-- Sidebar-->
        @include('layouts/admin-components.sidebar')
        <!-- Page content wrapper-->
        <div id="page-content-wrapper" class="main-content">
            <!-- Top navigation-->
            @include('layouts/admin-components.navigation')
            <!-- Page content-->
            @yield('content')
        </div>
    </div>
</body>

{{-- Jquery Plugin --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- OwlCarousel2 Plugin --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

{{-- Sweetalert Plugin --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Alertify Plugin -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

{{-- Toaster JS(for Notify) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{-- printThis Plugin --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js"></script>

{{-- DataTable --}}
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.3.2/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>

<script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>

<!-- Include the html2pdf.js library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

<!-- Include the html2canvas.js library -->
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

@yield('script')

<script>
    $(document).ready(function() {
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

        checkReservations();
        setInterval(checkReservations, 3600000); // 1 hour (in milliseconds)

        checkReservationPayment();
        setInterval(checkReservationPayment, 3600000); // 1 hour (in milliseconds)
    });


    var csrfToken = "{{ csrf_token() }}";

    // Function to handle sidebar toggle
    function toggleSidebar() {
        var sidebarWrapper = $('#sidebar-wrapper');
        var sidebarText = $('.sidebar-text');
        var accordion = $('.accordion-button');
        var navbar = $('.navbar');
        var mainContent = $('.main-content');

        sidebarWrapper.toggleClass('active');

        if (sidebarWrapper.hasClass('active')) {
            sidebarWrapper.removeClass('slide-out');
            sidebarWrapper.addClass('slide-in');
        } else {
            sidebarWrapper.removeClass('slide-in');
            sidebarWrapper.addClass('slide-out');
        }
    }

    $('#updateAdminProfile').click(function() {
        $.ajax({
            url: '/admin/profile/get',
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

                $('#updateAdminName').val(name);
                $('#updateAdminEmail').val(email);
                $('#updateAdminContact').val(contact);
                $('#updateAdminBirthdate').val(birthdate);
                $('#updateAdminAddress').val(address);
            },
            error: function(xhr) {
                swal({
                    title: 'Error',
                    text: 'Error Problem for Passing Profile Data: ' + xhr
                        .responseText,
                    icon: 'error'
                });

            }
        });
    });

    $('#updateAdminProfileBtn').click(function() {
        // Find the active tab-pane within updateProfileForms
        var activeTabPane = $('#updateProfileForms .tab-pane.active');
        // Get the ID of the active tab-pane
        var activeTabPaneId = activeTabPane.attr('id');
        // Now you can use activeTabPaneId to determine the currently active tab-pane
        console.log('Active Tab Pane ID:', activeTabPaneId);

        //User Info
        var newName = $('#updateAdminName').val();
        var newContact = $('#updateAdminContact').val();
        var newBday = $('#updateAdminBirthdate').val();
        var newAddress = $('#updateAdminAddress').val();

        //Email Info
        var newEmail = $('#updateAdminEmail').val();
        var userPass = $('#updateAdminPass').val();
        var confirmPass = $('#updateAdminConfirm').val();

        //Pass Info
        var oldPass = $('#updateAdminOldPass').val();
        var newPass = $('#updateAdminNewPass').val();
        var newConfirm = $('#updateAdminNewConfirm').val();

        $.ajax({
            url: '/admin/profile/update',
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
                    window.location.href = '/admin/profileView';
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

    $('#maintenanceToggleBtn').click(function() {
        $.ajax({
            url: '/admin/settings/toggleMaintenanceMode',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {},
            success: function(response) {
                swal({
                    title: 'Success',
                    text: response.message,
                    icon: 'success'
                }).then(function() {
                    window.location.href = '/admin/settingsView';
                });
            },
            error: function(xhr) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error Problem for Using Maintenance Mode:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    $("#updateSettingButton").click(function() {
        var $businessNoInput = $("#businessNo");
        var $businessEmailInput = $("#businessEmail");
        var toggleButton = $(this);
        if ($businessNoInput.prop("disabled")) {
            // Input is currently readonly, so make it editable
            $businessNoInput.prop("disabled", false);
            $businessEmailInput.prop("disabled", false);
            toggleButton.removeClass("btn-warning").addClass("btn-success");
            toggleButton.text("Save");
            // Call a custom function when making it editable

        } else {
            // Call a custom function when making it readonly
            $.ajax({
                url: '/admin/settings/update_contact',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    businessNumber: $businessNoInput.val(),
                    businessEmail: $businessEmailInput.val()
                },
                success: function(response) {
                    // Input is currently editable, so make it readonly
                    $businessNoInput.prop("disabled", true);
                    $businessEmailInput.prop("disabled", true);
                    toggleButton.removeClass("btn-success").addClass("btn-warning");
                    toggleButton.text("Update");

                    // Handle the success response
                    swal({
                        title: 'Success',
                        text: 'Number Updated Successfully!!',
                        icon: 'success'
                    });
                },
                error: function(xhr) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Updating setting:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        }
    });

    /** FUNCTION FOR INVENTORY MANAGEMENT **/

    // function for update item
    function updateItemList() {
        // Pass ListItem on Modal to update
        $('.updateListItem').click(function() {
            var itemId = $(this).data('id');
            var itemName = $(this).data('name');

            // Set the values in the new modal
            $('.requestListIdUpd').text(itemId);
            $('.requestListNameUpd').val(itemName);
            var tempItemName = $('.requestListIdUpd').text();

            var actionUrl = "{{ route('admin.inventory.updateItem', ':id') }}";
            var action = actionUrl.replace(':id', tempItemName);

            // Set the value as the action attribute of the form
            document.getElementById('listUpdateForm').action = action;
        });
    }

    // function for delete item
    // function deleteItemList() {
    // Pass ListItem on Modal to delete
    $('.deleteListItem').click(function() {
        var itemId = $(this).data('id');

        // Set the values in the new modal
        $('.requestListIdDel').text(itemId);
    });

    // Delete ListItem 
    $('#listItemDeleteBtn').click(function() {
        var itemId = $('.requestListIdDel').text();

        $.ajax({
            url: '/admin/inventory/deleteListItem/' + itemId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Handle the success response
                swal({
                    title: 'Success',
                    text: 'Item deleted successfully',
                    icon: 'success'
                }).then(function() {
                    window.location.href = '/admin/inventory/purchase';
                });
            },
            error: function(xhr) {
                // Handle the error response
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error deleting item:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });
    // }

    function addItemToRequestList() {
        // Retrieve the notification message from the cookie or local storage
        var notificationMessage = localStorage.getItem('notificationMessage');

        // Check if there is a notification message
        if (notificationMessage) {
            // Show Alertify notification
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(notificationMessage);

            // Clear the stored notification message
            localStorage.removeItem('notificationMessage');
        }

        $('.formAddRequestItem').on('submit', function(e) {
            e.preventDefault();


            // Perform AJAX request to submit the form data
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {

                    // Store the notification message in a cookie or local storage
                    localStorage.setItem('notificationMessage', 'Item Successfully Added');

                    window.location.href = '/admin/inventory/purchase';
                },
                error: function(xhr) {
                    if (xhr.status === 404) {
                        var message = xhr.responseJSON.message;

                        // Display SweetAlert error notification
                        swal({
                            icon: 'error',
                            title: 'Item already existed',
                            text: message
                        });
                    } else {
                        // Handle other error cases
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Adding Request Item:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }

                }
            });
        });
    }

    function deleteRequestList() {
        // Pass RequestItem on Modal to delete
        $('.deleteRequestItem').click(function() {
            var itemId = $(this).data('id');
            var itemId2 = $(this).data('itemid');

            // Set the values in the new modal
            $('.requestItemIdDel').text(itemId);
            $('.requestItemId2Del').text(itemId2);
        });

        // Delete RequestItem 
        $('#requestItemDeleteBtn').click(function() {
            var itemId = $('.requestItemIdDel').text();

            $.ajax({
                url: '/admin/inventory/deleteRequestItem/' + itemId,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // Handle the success response
                    swal({
                        title: 'Success',
                        text: 'Item deleted successfully',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/inventory/purchase';
                    });
                },
                error: function(xhr) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error deleting item:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });
    }

    function makePurchase() {
        //Pass RequestItem Data to Modal to Generate
        $('#makePurchase').click(function() {
            $('#modalTableBody').empty();

            var error = false;

            // Iterate over each row in the table
            $('.requestItemRow').each(function() {
                var itemId = $(this).find('td:nth-child(1)').text();
                var quantity = $(this).find('input[type="number"]').val();
                var unit = $(this).find('select option:selected').text();
                var name = $(this).find('input[type="text"]').val();
                var type = $(this).find('td:nth-child(5)').text();

                // Check if unit is selected
                if (unit === 'Select Unit' || quantity == 0) {
                    error = true;
                    return false; // Exit the loop
                }

                // Append a new row to the modal table body with the data
                $('#modalTableBody').append('<tr>' +
                    '<td>' + itemId + '</td>' +
                    '<td>' + quantity + '</td>' +
                    '<td>' + unit + '</td>' +
                    '<td>' + name + '</td>' +
                    '<td>' + type + '</td>' +
                    '</tr>');
            });

            // Show error message if unit is not selectedBtn
            if (error) {
                swal({
                    title: 'Warning',
                    text: 'Please select a unit or check the quantity of the items.',
                    icon: 'warning'
                }).then(function() {
                    $('#makepurchaseModal').modal('show');
                });
            } else {
                // Open the purchaseModal if validation passes
                $('#purchaseModal').modal('show');
            }

        });
    }

    function generateRequest() {
        // Make purchase request itself
        $('#generateRequestBtn').click(function() {
            var tableData = [];
            var purpose = $('#purpose').val();

            var purpose2 = $('#purpose2').val();

            // Check if purpose or purpose2 is empty
            if (purpose.trim() === '' || purpose2.trim() === '') {
                swal({
                    title: 'Warning',
                    text: 'Please provide a value for Purpose and Purpose 2',
                    icon: 'warning'
                });
                return;
            }

            $('#requestTable tbody tr').each(function() {
                var rowData = [];
                $(this).find('td').each(function() {
                    rowData.push($(this).text());
                });
                tableData.push(rowData);
            });

            // Send the table data to the controller via AJAX
            $.ajax({
                url: '/admin/inventory/generateRequest',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    purpose: purpose,
                    tableData: tableData,
                    purpose2: purpose2
                },
                success: function(response) {
                    // Handle the success response
                    swal({
                        title: 'Success',
                        text: 'Request generated successfully',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/inventory/purchase';
                    });
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error generating report:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });
    }

    var emailRequestID;
    // function for preview request
    function viewRequest() {
        //Pass Request Table Data to Modal to View
        $('.viewModalBtn').click(function() {
            var requestId = $(this).data('id');
            emailRequestID = requestId;
            $.ajax({
                url: '/admin/inventory/getItems',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    requestId: requestId
                },
                success: function(response) {
                    // Append the items to the table
                    var items = response.items;
                    var purpose = response.purpose;
                    var purpose2 = response.purpose2;

                    var tableBody = $('#itemsTable');
                    var tableMailBody = $('#itemsTableMail');

                    tableBody.empty(); // Clear any existing rows
                    tableMailBody.empty(); // Clear any existing rows

                    // Define a variable to store the increment value
                    var start = 1;

                    $.each(items, function(index, item) {
                        var row = $('<tr></tr>');

                        // Hide the item[0] value and display the start value in the same table cell
                        row.append('<td class="text-center">' + start +
                            '<span style="display: none;">' + item[0] +
                            '</span></td>');

                        // Increment the value for the next iteration
                        start++;
                        row.append('<td class="text-center">' + item[1] + '</td>');
                        row.append('<td class="text-center">' + item[2] + '</td>');
                        row.append('<td>' + item[3] + '</td>');
                        row.append('<td>' + "" + '</td>');
                        row.append('<td>' + "" + '</td>');

                        tableBody.append(row);
                        tableMailBody.append(row);
                    });

                    $('#purposeValue').text(purpose);
                    $('#purpose2Value').text(purpose2);

                    $('#purposeValueMail').text(purpose);
                    $('#purpose2ValueMail').text(purpose2);
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error on Getting the Items:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });
    }

    // Pass Request on Modal to delete
    $('.deleteRequest').click(function() {
        var itemId = $(this).data('id');

        // Set the values in the new modal
        $('.requestIdDel').text(itemId);
    });

    // Delete Request
    $('#requestDeleteBtn').click(function() {
        var itemId = $('.requestIdDel').text();

        $.ajax({
            url: '/admin/inventory/deleteRequest/' + itemId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Handle the success response
                swal({
                    title: 'Success',
                    text: 'Request deleted successfully',
                    icon: 'success'
                }).then(function() {
                    window.location.href = '/admin/inventory/purchase';
                });
            },
            error: function(xhr) {
                // Handle the error response
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error on deleting item:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });
    // }

    $('#sendEmailModal').on('show.bs.modal', function(event) {
        $('#sendEmailModal').find('#addRequestIdPlaceholder').text(emailRequestID);
    });

    $('#sentMailBtn').click(function() {
        var email = $("#send-email").val();

        var emailID = $('#addRequestIdPlaceholder').text();

        $.ajax({
            url: '/admin/inventory/send_letter',
            type: 'POST',
            data: {
                email: email,
                emailID: emailID,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Handle the success response
                swal({
                    title: 'Success',
                    text: 'Letter Request Sent Successfully',
                    icon: 'success'
                }).then(function() {
                    window.location.href = '/admin/inventory/manage';
                });
            },
            error: function(xhr) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error on Sending Letter Request:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    // function for approve request
    function approveRequest() {
        $('.approveRequest').click(function() {
            var requestId = $(this).data('id');

            // Set the ID in the approve modal
            $('#approveModalLabel').text('Received Item List No: ' + requestId);

            // Set the ID in the approve button of the modal
            $('#approveRequestBtn').data('request-id', requestId);

            $.ajax({
                url: '/admin/inventory/getItems',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    requestId: requestId
                },
                success: function(response) {
                    var items = response.itemTemp;

                    var modalBody = $('#approveModal .modal-body');
                    modalBody.empty();

                    var start = 1;

                    $.each(items, function(index, item) {
                        var itemHtml = 
                            '<div class="card mb-3">' +
                                '<div class="card-body p-3">' +
                                    '<div class="row d-flex justify-content-between align-items-center">' +
                                        '<div class="col-md-7 col-lg-7 col-xl-7">' +
                                            '<span class="requestItemId" style="display:none">' + item.itemId + '</span>' +
                                            '<p class="lead fw-bold mb-2"><span class="requestItemName">' +
                                                item.name + '</span></p>' +
                                            '<p>Remaining: ' + item.quantity + '</p>' +
                                            '</span><p><span class="text-muted">Unit: </span> <span class="requestItemUnit">' +
                                                item.unit +
                                            '</span> <span class="text-muted"> Type:</span> <span class="requestItemType">' +
                                                item.type +
                                            '</span></p>' +
                                        '</div>' +
                                        '<div class="col-md-5 col-lg-5 col-xl-5 d-flex">' +
                                            '<input class="requestItemQuantity" min="0" max="' +
                                            item.quantity +
                                            '" name="quantity" value="' +
                                            item.quantity +
                                            '" type="number" class="form-control form-control-sm "/>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>';

                        modalBody.append(itemHtml);
                    });

                },
                error: function(xhr, status, error) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error on Getting the Items:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });


        $('#approveRequestBtn').click(function() {
            var requestId = $(this).data('request-id');
            // Initialize an empty array to store the card data
            var cardDataArray = [];

            // Iterate through each card in the approveModalBody
            $('#approveModalBody .mb-3').each(function(index, card) {
                // Extract values from the current card
                var requestItemId = $(card).find('.requestItemId').text();
                var requestItemName = $(card).find('.requestItemName').text();
                var requestItemUnit = $(card).find('.requestItemUnit').text();
                var requestItemType = $(card).find('.requestItemType').text();
                var requestItemQuantity = $(card).find('.requestItemQuantity').val();

                var cardData = {
                    requestItemId: requestItemId,
                    requestItemName: requestItemName,
                    requestItemUnit: requestItemUnit,
                    requestItemType: requestItemType,
                    requestItemQuantity: requestItemQuantity
                };

                // Push the object to the array
                cardDataArray.push(cardData);
            });

            $.ajax({
                url: '/admin/inventory/approveRequest',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    requestId: requestId,
                    cardDataArray: cardDataArray
                },
                success: function(response) {
                    console.log(cardDataArray);

                    if (response.success) {
                        // Display approved items in a table

                        // var table = $('#manage-inventory');
                        // table.find('tbody').empty();

                        // $.each(response.items, function(index, item) {
                        //     var row = $('<tr>');
                        //     row.append($('<td>').text(item.id));
                        //     row.append($('<td>').text(item.name));
                        //     row.append($('<td>').text(item.quantity));
                        //     row.append($('<td>').text(item.unit));
                        //     row.append($('<td>').text(item.status));
                        //     table.find('tbody').append(row);
                        // });

                        swal({
                            title: 'Success',
                            text: 'Letter of Request has been Received successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '/admin/inventory/manage';
                        });
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 200) {
                        var message = xhr.responseJSON.message;

                        // Display SweetAlert error notification
                        swal({
                            icon: 'error',
                            title: 'Item already approved',
                            text: message
                        }).then(function() {
                            window.location.href = '/admin/inventory/manage';
                        });
                    } else {
                        // Handle other error cases
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error approving Request:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }
                }
            });
        });
    }

    function rejectRequest() {
        $('.rejectRequest').click(function() {
            var requestId = $(this).data('id');

            $('#rejectRequestBtn').data('request-id', requestId);
        });

        $('#rejectRequestBtn').click(function() {
            var requestId = $(this).data('request-id');

            $.ajax({
                url: '/admin/inventory/rejectRequest/' + requestId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    requestId: requestId
                },
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Letter of Request has been Rejected successfully',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/inventory/purchase';
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 200) {
                        var message = xhr.responseJSON.message;
                        swal({
                            icon: 'error',
                            title: 'Item already rejected',
                            text: message
                        }).then(function() {
                            window.location.href = '/admin/inventory/manage';
                        });
                    } else {
                        // Handle other error cases
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error rejecting Request:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }

                }
            });
        });
    }

    $('.btnQRView').click(function() {
        var inventoryQR = $(this).data('qr');
        $.ajax({
            url: '/admin/inventory/view_inventory_qr',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                qr: inventoryQR,
            },
            success: function(response) {

                $("#qrCodeImg").attr("src", "data:image/svg+xml;base64," + response.qrCodeData);
            },
            error: function(xhr, status, error) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'There is a problem from Viewing your QRCode:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });

            },
        });
    });

    function updateConsumable() {
        // Update inventory
        $('.consumableEditBtn').click(function() {
            var inventoryId = $(this).data('id');
            var inventoryName = $(this).data('name');
            var inventoryQuantity = $(this).data('quantity');
            var inventoryUnit = $(this).data('unit');
            var inventoryStatus = $(this).data('status');

            // Set the values in the new modal
            var updateUrl = "{{ route('admin.inventory.updateConsumable', ['id' => ':id']) }}";
            updateUrl = updateUrl.replace(':id', inventoryId);
            $('.inventoryEdit').attr('action', updateUrl);
            $('.inventoryEdit').attr('method', 'POST');

            $('.inventoryNameForm').val(inventoryName);
            $('.inventoryQuantityForm').val(inventoryQuantity);
            $('.inventoryUnitForm').val(inventoryUnit);
            $('#ConsumableStatusForm').text(inventoryStatus);

            $('#ConsumableStatusForm').removeClass('bg-success');
            $('#ConsumableStatusForm').removeClass('bg-warning');
            $('#ConsumableStatusForm').removeClass('bg-danger');

            if (inventoryStatus === 'In stock') {
                $('#ConsumableStatusForm').addClass('bg-success');
            } else if (inventoryStatus === 'Low stock') {
                $('#ConsumableStatusForm').addClass('bg-warning');
            } else {
                $('#ConsumableStatusForm').addClass('bg-danger');
            }

        });
    }

    function updateFurniture() {
        // Update inventory
        $('.inventoryEditBtn').click(function() {
            var inventoryId = $(this).data('id');
            var inventoryItemId = $(this).data('identity');
            var inventoryName = $(this).data('name');
            var inventoryQuantity = $(this).data('quantity');
            var inventoryStatus = $(this).data('status');

            var receivedUrl = "{{ route('admin.inventory.markReserved', ['id' => ':id']) }}";
            receivedUrl = receivedUrl.replace(':id', inventoryId);
            $('.inventoryMarkReceived').attr('action', receivedUrl);
            $('.inventoryMarkReceived').attr('method', 'POST');

            var availableUrl = "{{ route('admin.inventory.markAvailable', ['id' => ':id']) }}";
            availableUrl = availableUrl.replace(':id', inventoryId);
            $('.inventoryMarkAvailable').attr('action', availableUrl);
            $('.inventoryMarkAvailable').attr('method', 'POST');

            var damagedUrl = "{{ route('admin.inventory.markDamaged', ['id' => ':id']) }}";
            damagedUrl = damagedUrl.replace(':id', inventoryId);
            $('.inventoryMarkDamaged').attr('action', damagedUrl);
            $('.inventoryMarkDamaged').attr('method', 'POST');

            $('.inventoryNameForm').val(inventoryName);
            $('.inventoryQuantityForm').val(inventoryQuantity);
            $('.inventoryIdForm').val(inventoryItemId);
            $('#FurnitureStatusForm').text(inventoryStatus);
            $('#FurnitureIdForm').text(inventoryId);

            $('#FurnitureStatusForm').removeClass('bg-success');
            $('#FurnitureStatusForm').removeClass('bg-info');
            $('#FurnitureStatusForm').removeClass('bg-danger');

            if (inventoryStatus === 'Available') {
                $('#FurnitureStatusForm').addClass('bg-success');

            } else if (inventoryStatus === 'Reserved') {
                $('#FurnitureStatusForm').addClass('bg-info');

            } else {
                $('#FurnitureStatusForm').addClass('bg-danger');
            }

        });
    }

    function markReserved() {
        $('.inventoryMarkReceived').click(function() {
            var inventoryId = $(this).closest('.modal-content').find('#FurnitureIdForm').text();

            var button = $(this); // Assign the reference to another variable

            // Activate the specific equipment tab
            localStorage.setItem('activeTab', '#ex-with-icons-tab-2');

            // Send AJAX request to mark as received
            $.ajax({
                url: "{{ route('admin.inventory.markReserved', ['id' => ':id']) }}".replace(
                    ':id', inventoryId),
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Update the status in the modal
                    button.closest('.modal-content').find('#FurnitureStatusForm')
                        .removeClass('bg-success').removeClass('bg-danger').addClass(
                            'bg-info').text(
                            'Reserved');

                    // Reload the page
                    window.location.reload();

                },
                error: function(xhr) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Marking the item:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });

                }
            });
        });
    }

    function markAvailable() {
        $('.inventoryMarkAvailable').on('click', function() {
            var inventoryId = $(this).closest('.modal-content').find('#FurnitureIdForm').text();

            var button = $(this); // Assign the reference to another variable

            // Activate the specific equipment tab
            localStorage.setItem('activeTab', '#ex-with-icons-tab-2');

            // Send AJAX request to mark as received
            $.ajax({
                url: "{{ route('admin.inventory.markAvailable', ['id' => ':id']) }}".replace(
                    ':id', inventoryId),
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Update the status in the modal
                    button.closest('.modal-content').find('#FurnitureStatusForm')
                        .removeClass('bg-info').removeClass('bg-danger').addClass(
                            'bg-success').text(
                            'Available');


                    // Reload the page
                    window.location.reload();

                },
                error: function(xhr) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Marking the item:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });
    }

    function markDamaged() {
        $('.inventoryMarkDamaged').click(function() {
            var inventoryId = $(this).closest('.modal-content').find('#FurnitureIdForm').text();

            var button = $(this); // Assign the reference to another variable

            // Activate the specific equipment tab
            localStorage.setItem('activeTab', '#ex-with-icons-tab-3');


            // Send AJAX request to mark as damaged
            $.ajax({
                url: "{{ route('admin.inventory.markDamaged', ['id' => ':id']) }}".replace(
                    ':id', inventoryId),
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    // Update the status in the modal
                    button.closest('.modal-content').find('#FurnitureStatusForm')
                        .removeClass('bg-success').removeClass('bg-info')
                        .addClass('bg-danger').text(
                            'Damaged');

                    // Reload the page
                    window.location.reload();

                },
                error: function(xhr) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Marking the item:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });
    }

    /** FUNCTION FOR MAINTENANCE MANAGEMENT **/

    function updateFacility() {
        // // Update Facilities
        $('#facilitySelect').on('change', function() {
            var facilityId = $(this).val();
            var facilityName = $(this).find('option:selected').data('name');
            var facilityDescription = $(this).find('option:selected').data('description');
            var facilityImage = $(this).find('option:selected').data('image');

            $('#updateFacilityName').val(facilityName);
            $('#description').val(facilityDescription);
            $('#updateFacilityImage').attr('src', facilityImage);

            $('#updateFacility').click(function() {
                var updatedFacility = {
                    id: $('#facilitySelect').val(),
                    name: $('#updateFacilityName').val(),
                    description: $('#description').val(),
                    image: $('#formFile')[0].files[0],
                };

                var formData = new FormData();
                formData.append('id', updatedFacility.id);
                formData.append('name', updatedFacility.name);
                formData.append('description', updatedFacility.description);
                formData.append('image', updatedFacility.image);

                // Perform the AJAX request to update the facility
                $.ajax({
                    url: '/admin/maintenance/updateFacility/' + updatedFacility
                        .id, // Update with the correct route URL
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Ensure csrfToken is defined
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: 'Update Facility Information successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '/admin/maintenance/add';
                        });
                    },
                    error: function(xhr) {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Updating facility:<br>' +
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
    }

    function deleteFacility() {
        $('#deletefacilitySelect').on('change', function() {
            var facilityId = $(this).val();
            var selectedOption = $('option:selected', this);
            var facilityName = selectedOption.data('name'); // Change here

            $('#facilityDelete').click(function() {
                var facilityId = $('#deletefacilitySelect').val();

                $.ajax({
                    url: '/admin/maintenance/deleteFacility/' + facilityId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: 'Facility deleted successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '/admin/maintenance/add';
                        });
                    },
                    error: function(xhr) {
                        // Handle the error response
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error deleting facility:<br>' +
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
    }

    function addTask() {
        // Add Task
        $('#formAddtask').on('submit', function(e) {
            e.preventDefault();

            // Perform AJAX request to submit the form data
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Add Task successfully',
                        icon: 'success'
                    }).then(function() {
                        window.location.href =
                            '/admin/maintenance/scheduleTask';
                    });
                },
                error: function(xhr) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Adding Task:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });

                }
            });
        });
    }

    function updateTask() {
        $('.updateTaskBtn').click(function() {

            var taskId = $(this).data('id');
            var taskName = $(this).data('name');
            var taskDescription = $(this).data('description');

            $('#updateTaskName').val(taskName);
            $('#updateTaskDescription').val(taskDescription);

            $('#updateTask').click(function() {
                var updatedTask = {
                    id: $('#taskId').val(),
                    name: $('#updateTaskName').val(),
                    description: $('#updateTaskDescription').val(),
                };

                var formData = new FormData();
                formData.append('id', updatedTask.id);
                formData.append('name', updatedTask.name);
                formData.append('description', updatedTask.description);

                // Perform AJAX request to update the facility
                $.ajax({
                    url: '/admin/maintenance/updateTask/' +
                        taskId, // Update this with the correct route URL
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: 'Update Task Information successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href =
                                '/admin/maintenance/scheduleTask';
                        });
                    },
                    error: function(xhr) {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Updating Task:<br>' +
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
    }

    // function deleteTask() {
    // Delete Task
    $('.deleteTaskBtn').click(function() {
        var taskId = $(this).data('id');

        // Set the values in the new modal
        $('.taskIdDel').text(taskId);
    });

    // Delete Task Modal
    $('#taskDelete').click(function() {
        var taskId = $('.taskIdDel').text();

        $.ajax({
            url: '/admin/maintenance/deleteTask/' + taskId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Handle the success response
                swal({
                    title: 'Success',
                    text: 'Task deleted successfully',
                    icon: 'success'
                }).then(function() {
                    window.location.href = '/admin/maintenance/scheduleTask';
                });
            },
            error: function(xhr) {
                // Handle the error response
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error deleting Task:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    function addTaskLocation() {
        // Add Location
        $('#formLocation').on('submit', function(e) {
            e.preventDefault();

            // Perform AJAX request to submit the form data
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Add Location successfully',
                        icon: 'success'
                    }).then(function() {
                        window.location.href =
                            '/admin/maintenance/scheduleTask';
                    });
                },
                error: function(xhr) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Adding Location:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });

                }
            });
        });
    }

    function updateTaskLocation() {
        $('.updateLocation').click(function() {

            var locationId = $(this).data('id');
            var locationName = $(this).data('name')

            $('#updateLocationName').val(locationName);
            $('#updateLocation').data('id', locationId);

            $('#updateLocation').click(function() {
                var updatedLocation = {
                    id: $('#locationId').val(),
                    name: $('#updateLocationName').val(),
                };

                var formData = new FormData();
                formData.append('id', updatedLocation.id);
                formData.append('name', updatedLocation.name);

                // Perform AJAX request to update the facility
                $.ajax({
                    url: '/admin/maintenance/updateLocation/' +
                        locationId, // Update this with the correct route URL
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: 'Update Location successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href =
                                '/admin/maintenance/scheduleTask';
                        });
                    },
                    error: function(xhr) {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Updating Location:<br>' +
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
    }

    // function deleteTaskLocation() {
    // Delete Location
    $('.deleteLocationBtn').click(function() {
        var locationId = $(this).data('id');

        // Set the values in the new modal
        $('.locationIdDel').text(locationId);
    });

    // Delete Location Modal
    $('#locationDelete').click(function() {
        var locationId = $('.locationIdDel').text();

        $.ajax({
            url: '/admin/maintenance/deleteLocation/' + locationId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Handle the success response
                swal({
                    title: 'Success',
                    text: 'Location deleted successfully',
                    icon: 'success'
                }).then(function() {
                    window.location.href = '/admin/maintenance/scheduleTask';
                });
            },
            error: function(xhr) {
                // Handle the error response
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error deleting Location:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });
    // }

    //Temp Staff Array
    var assignedStaff = [];

    // Function to handle assigning staff
    function assignStaff(staffId, staffName) {
        // Find the index of the staff with the specified ID in the assignedStaff array
        const index = assignedStaff.findIndex(staff => staff.id === staffId);

        // If the staff is not in the assignedStaff array, add it
        if (index === -1) {
            assignedStaff.push({
                id: staffId,
                name: staffName,
                status: "Not Done"
            });
            $('.assignStaffBtn[data-id="' + staffId + '"]').text('Unassign').prop('disabled', true);
        } else {
            // Remove the staff from the array
            assignedStaff.splice(index, 1);
            $('.assignStaffBtn[data-id="' + staffId + '"]').text('Assign').prop('disabled', false);
        }

    }

    $('#createScheduleBtn').click(function() {
        assignedStaff = [];
    });

    $("#floatingInputDate").change(function() {
        var selectedDate = $(this).val();

        $.ajax({
            url: '/admin/maintenance/availableStaff',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                selectedDate: selectedDate,
            },
            success: function(response) {
                var staffList = response.availableStaff;
                var tbody = $('#availableSchedStaffList');

                // Clear existing content in the tbody
                tbody.empty();

                // Iterate through the available staff and update the HTML content
                $.each(staffList, function(index, staff) {
                    var staffRow = '<tr>' +
                        '<td>' +
                        staff.name +
                        '</td>' +
                        '<td>' +
                        '<button class="btn btn-primary assignStaffBtn" data-id="' + staff
                        .id + '" data-name="' + staff.name + '">Assign</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the staff row to the tbody
                    tbody.append(staffRow);
                });
            },
            error: function(xhr) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error Problem for Viewing Available Staff:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    function addScheduleTask() {
        // Schedule Maintenance Task
        $('#scheduleButton').on('click', function(e) {
            e.preventDefault();
            var taskData = new FormData($('#formScheduleTask')[0]); // Use the form element directly

            var assignedStaffData = [];
            assignedStaff.forEach(function(staff) {
                assignedStaffData.push([staff.id.toString(), staff.name, staff.status]);
            });

            // Add the assigned staff data to the task data
            taskData.append('assignedStaffData', JSON.stringify(assignedStaffData));
            // Perform AJAX request to submit the form data
            $.ajax({
                url: $('#formScheduleTask').attr('action'),
                type: 'POST',
                data: taskData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Extract staff data from the response, assuming the response contains staffId and staffName
                    var staffId = response.staffId;
                    var staffName = response.staffName;

                    // Call the assignStaff function with the extracted staff data
                    assignStaff(staffId, staffName);

                    // Check if the assigned staff has an assigned task
                    var assignedTaskInput = $('[data-staff-id="' + staffId + '"] .assigned-task');
                    var hasAssignedTask = assignedTaskInput.val() === '1';

                    // Check if the assigned staff is currently logged in
                    var loggedInStaffId = $('#logged-in-staff-id').val();

                    if (staffId === loggedInStaffId && hasAssignedTask) {
                        // Create the notification element
                        var notificationElement =
                            '<li><a class="dropdown-item" href="#">' +
                            staffName +
                            ' has been assigned a new task</a></li>';

                        // Append the notification to the dropdown menu
                        $('.dropdown-menu').prepend(notificationElement);
                    }


                    // Show a success message to the user
                    swal({
                        title: 'Success',
                        text: 'Add Schedule Task successfully',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/maintenance/scheduleTask';
                    });
                },
                error: function(xhr) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Adding Location:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });

                }
            });
        });
    }

    function approveScheduleTask() {
        $('.btnTaskApprove').click(function() {
            var scheduleTaskId = $(this).data('id');

            $('#approveScheduleTaskBtn').data('id', scheduleTaskId);
            $('#approveScheduleTaskModalLabel').text('Schedule Task ID: ' + scheduleTaskId);
        });

        $('#approveScheduleTaskBtn').click(function() {
            var scheduleTaskId = $(this).data('id');

            $.ajax({
                url: '/admin/maintenance/approveScheduleTask',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: scheduleTaskId,
                },
                success: function(response) {
                    // Handle the success response
                    swal({
                        title: 'Success',
                        text: 'Task Done Successfully!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/maintenance/scheduleTask';
                    });
                },
                error: function(xhr) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Problem for Marking Task:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });
    }

    function updateScheduleTexts() {
        // $('.assignStaffSBtn').each(function() {
        //     var staffId = $(this).data('id');

        //     const index = assignedStaff.findIndex(staff => staff.id === staffId);
        //     if (index == -1) {
        //         $(this).text('Assign');
        //     } else {
        //         $(this).text('Unassign');
        //     }
        // });

        $('#availableSchedUpdateStaffList .assignStaffSBtn').each(function() {
            var staffId = $(this).data('id');

            const index = assignedStaff.findIndex(staff => staff.id === staffId);
            if (index == -1) {
                $(this).text('Assign');
            } else {
                $(this).text('Unassign');
            }
        });
    }

    // Function to handle assigning staff
    function assignStaffS(staffId, staffName) {
        // Find the index of the staff with the specified ID in the assignedStaff array
        const index = assignedStaff.findIndex(staff => staff.id === staffId);

        // If the staff is not in the assignedStaff array, add it
        if (index === -1) {
            assignedStaff.push({
                id: staffId,
                name: staffName,
                status: "Not Done"
            });
            $('.assignStaffSBtn[data-id="' + staffId + '"]').text('Unassign');
        } else {
            // Remove the staff from the array
            assignedStaff.splice(index, 1);
            $('.assignStaffSBtn[data-id="' + staffId + '"]').text('Assign');
        }

    }

    // Event listeners
    // $('.assignStaffSBtn').click(function() {
    //     var staffId = $(this).data('id');
    //     var staffName = $(this).data('name');
    //     assignStaffS(staffId, staffName);
    // });

    $('#availableSchedUpdateStaffList').on('click', '.assignStaffSBtn', function() {
        var staffId = $(this).data('id');
        var staffName = $(this).data('name');
        assignStaffS(staffId, staffName);
    });

    function updateScheduleTask() {
        $('.updateScheduleBtn').click(function() {

            assignedStaff = [];
            var scheduleId = $(this).data('id');
            var scheduleName = $(this).data('name')
            var scheduleLocation = $(this).data('location')
            var scheduleDate = $(this).data('date')

            $('#updateScheduleName').val(scheduleName);
            $('#updateScheduleLocation').val(scheduleLocation);
            $('#updateScheduleDate').val(scheduleDate);
            $('#updateSchedule').data('id', scheduleId);

            $.ajax({
                url: '/admin/maintenance/assignView',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    requestId: scheduleId,
                },
                success: function(response) {

                    $.ajax({
                        url: '/admin/maintenance/availableStaff',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            selectedDate: scheduleDate,
                        },
                        success: function(response) {
                            var staffList = response.availableStaff;
                            var tbody = $('#availableSchedUpdateStaffList');

                            // Clear existing content in the tbody
                            tbody.empty();

                            // Iterate through the available staff and update the HTML content
                            $.each(staffList, function(index, staff) {
                                var staffRow = '<tr>' +
                                    '<td>' +
                                    staff.name +
                                    '</td>' +
                                    '<td>' +
                                    '<button class="btn btn-primary assignStaffSBtn" data-id="' +
                                    staff.id + '" data-name="' + staff.name +
                                    '">Assign</button>' +
                                    '</td>' +
                                    '</tr>';

                                // Append the staff row to the tbody
                                tbody.append(staffRow);
                            });

                            if (response.items) {
                                assignedStaff = response.items.map(item => ({
                                    id: parseInt(item[
                                        0
                                    ]), // The second argument (10) specifies the base for parsing (e.g., base 10 for decimal).
                                    name: item[1],
                                    status: item[2]
                                }));

                                updateScheduleTexts();
                            }
                        },
                        error: function(xhr) {
                            swal({
                                title: 'Error',
                                content: {
                                    element: 'div',
                                    attributes: {
                                        innerHTML: '<div style="text-align: left;">' +
                                            'Error Problem for Viewing Available Staff:<br>' +
                                            parseErrors(xhr.responseText) +
                                            '</div>',
                                    },
                                },
                                icon: 'error'
                            });
                        }
                    });
                },
                error: function(xhr, status, error) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error View Assign Staff:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });
    }

    $("#updateScheduleDate").change(function() {
        var selectedDate = $(this).val();

        $.ajax({
            url: '/admin/maintenance/availableStaff',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                selectedDate: selectedDate,
            },
            success: function(response) {
                var staffList = response.availableStaff;
                var tbody = $('#availableSchedUpdateStaffList');

                // Clear existing content in the tbody
                tbody.empty();

                // Iterate through the available staff and update the HTML content
                $.each(staffList, function(index, staff) {
                    var staffRow = '<tr>' +
                        '<td>' +
                        staff.name +
                        '</td>' +
                        '<td>' +
                        '<button class="btn btn-primary assignStaffSBtn" data-id="' + staff
                        .id + '" data-name="' + staff.name + '">Assign</button>' +
                        '</td>' +
                        '</tr>';

                    // Append the staff row to the tbody
                    tbody.append(staffRow);
                });
            },
            error: function(xhr) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error Problem for Viewing Available Staff:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    $('#updateSchedule').click(function() {

        var assignedStaffData = [];
        assignedStaff.forEach(function(staff) {
            assignedStaffData.push([staff.id.toString(), staff.name, staff.status]);
        });

        var scheduleId = $(this).data('id');

        var updatedScheduleTask = {
            id: scheduleId,
            name: $('#updateScheduleName').val(),
            location: $('#updateScheduleLocation').val(),
            date: $('#updateScheduleDate').val(),
        };

        var formData = new FormData();
        formData.append('id', updatedScheduleTask.id);
        formData.append('name', updatedScheduleTask.name);
        formData.append('location', updatedScheduleTask.location);
        formData.append('date', updatedScheduleTask.date);
        formData.append('assignedStaffData', JSON.stringify(assignedStaffData));

        // Perform AJAX request to update the facility
        $.ajax({
            url: '/admin/maintenance/updateScheduleTask/' +
                scheduleId, // Update this with the correct route URL
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Handle the success response
                swal({
                    title: 'Success',
                    text: 'Update Schedule successfully',
                    icon: 'success'
                }).then(function() {
                    window.location.href =
                        '/admin/maintenance/scheduleTask';
                });
            },
            error: function(xhr) {
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error Updating Schedule:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
            }
        });
    });

    // function deleteScheduleTask() {
    // Delete Schedule
    $('.deleteScheduleBtn').click(function() {
        var scheduleId = $(this).data('id');

        // Set the values in the new modal
        $('.scheduleIdDel').text(scheduleId);
    });

    // Delete Schedule Modal
    $('#scheduleDelete').click(function() {
        var scheduleId = $('.scheduleIdDel').text();

        $.ajax({
            url: '/admin/maintenance/deleteScheduleTask/' + scheduleId,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Handle the success response
                swal({
                    title: 'Success',
                    text: 'Schedule deleted successfully',
                    icon: 'success'
                }).then(function() {
                    window.location.href = '/admin/maintenance/scheduleTask';
                });
            },
            error: function(xhr) {
                // Handle the error response
                swal({
                    title: 'Error',
                    content: {
                        element: 'div',
                        attributes: {
                            innerHTML: '<div style="text-align: left;">' +
                                'Error deleting Schedule:<br>' +
                                parseErrors(xhr.responseText) +
                                '</div>',
                        },
                    },
                    icon: 'error'
                });
                console.log(xhr.responseText);
            }
        });
    });
    // }


    function updateRequestTable(checkbox) {
        var isChecked = checkbox.checked;

        if (isChecked) {
            addToRequestTable();
        } else {
            removeFromRequestTable();
        }
    }

    $(document).ready(function() {

        // Sidebar toggle event
        $('#sidebarToggle').on('click', toggleSidebar);

        $('.sidebar-close').on('click', toggleSidebar);


        const activityLogSwitch = $('#activityLog');
        const recentActivityTable = $('#recentActivityTable');

        activityLogSwitch.on('change', function() {
            if (activityLogSwitch.prop('checked')) {
                recentActivityTable.removeClass('hidden');
            } else {
                recentActivityTable.addClass('hidden');
            }
        });

        // Reservation
        $('#pending-reservation').DataTable({
            responsive: true,
            fixedheader: true,
            "order": [
                [0, "desc"]
            ]
        });

        $('#approve-reservation').DataTable({
            responsive: true,
            fixedheader: true,
            "order": [
                [0, "desc"]
            ],
            drawCallback: function(settings) {
                assignUpdateReservation();
            }
        });


        $('#cancel-reservation').DataTable({
            responsive: true,
            fixedheader: true,
            "order": [
                [0, "desc"]
            ]
        });

        var tablePrice = $('#priceFacility').DataTable({
            responsive: true,
            fixedHeader: true
        });

        function handleFilterChange(columnIndex, filterElement) {
            $(filterElement).on('change', function() {
                var filterValue = $(this).val();
                tablePrice.column(columnIndex).search(filterValue).draw();
            });
        }

        handleFilterChange(0, '#facility-filter');
        handleFilterChange(1, '#activity-filter');
        handleFilterChange(2, '#organization-filter');

        var isEditMode = false;

        function toggleTextarea() {
            $('.guideline-textarea').each(function() {
                var isDisabled = $(this).prop('disabled');
                $(this).prop('disabled', !isDisabled);
            });

            if (isEditMode) {
                setButtonState(false);
            } else {
                setButtonState(true);
            }

            isEditMode = !isEditMode;
        }

        function setButtonState(isReadOnly) {
            var $updateGuideButton = $('#updateGuideButton');
            if (isReadOnly) {
                $updateGuideButton.text('Saved');
                $updateGuideButton.removeClass('btn-warning').addClass('btn-primary');
            } else {
                $updateGuideButton.text('Update');
                $updateGuideButton.removeClass('btn-primary').addClass('btn-warning');
            }
        }

        $('#updateGuideButton').on('click', function() {
            if (isEditMode) {
                var updatedGuidelines = [];
                $('.guideline-textarea').each(function() {
                    var textarea = $(this);
                    var guidelineId = textarea.data('guideline-id');
                    var guidelineContent = textarea.val();

                    updatedGuidelines.push({
                        id: guidelineId,
                        content: guidelineContent
                    });
                });

                $.ajax({
                    url: '/admin/settings/update_guidelines',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        guidelines: updatedGuidelines
                    },
                    success: function(response) {
                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: 'Update Guidelines Successfully',
                            icon: 'success'
                        });
                        toggleTextarea(); // Change back to read-only mode
                    },
                    error: function(xhr) {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Updating Guidelines:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }
                });
            } else {
                toggleTextarea(); // Toggle between edit and read-only mode
            }
        });


        $('#view-reservation').DataTable({
            responsive: true,
            fixedheader: true,
            "order": [
                [0, 'desc']
            ]
        });

        /* INVENTORY DATATABLE */

        // Inventory Item List 
        $('#listItem').DataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                updateItemList();
                addItemToRequestList();
            }
        });

        // Form Request Item List
        $('#requestList').DataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                deleteRequestList();
                makePurchase();
            }
        });

        // Request Table List
        $('#requestTable').DataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                generateRequest();
            }
        });

        // Datatable Request List
        $('#requestStatus').DataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                approveRequest();
                rejectRequest();
                viewRequest();
            }
        });

        // Generate Letter PDF
        $('#exportButton').click(function() {
            $('.page').printThis({
                headers: false,
                footers: false,
                removeInline: false
            });
        });

        // Datatable Consumable Inventory
        $('#consumable-inventory').DataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                updateConsumable();
            }
        });

        // Datatable Furniture Inventory
        $('#equipment-inventory').DataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                updateFurniture();
                markReserved();
                markAvailable();
                markDamaged();
            }
        });

        // Datatable Damaged Inventory
        $('#damaged-inventory').DataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                updateFurniture();
                markReserved();
                markDamaged();
            }
        });

        $('#view-inventory').DataTable({
            responsive: true,
            fixedheader: true
        });

        /* OWL CAROUSEL */

        $('.owl-carousel').owlCarousel({
            items: 3,
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
        });

        /* MAINTENANCE DATATABLE */

        $('#update-facilities').dataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                updateFacility();
            }
        });

        updateFacility();
        deleteFacility();

        $('#schedule-task').dataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                addScheduleTask();
                approveScheduleTask();
                updateScheduleTask();
            }
        });

        // Event listeners
        // $('.assignStaffBtn').click(function() {
        //     var staffId = $(this).data('id');
        //     var staffName = $(this).data('name');
        //     assignStaff(staffId, staffName);
        // });

        $('#availableSchedStaffList').on('click', '.assignStaffBtn', function() {
            var staffId = $(this).data('id');
            var staffName = $(this).data('name');
            assignStaff(staffId, staffName);
        });

        $('#assign-task').dataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {


            }
        });

        $('#update-assign').dataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {


            }
        });

        $('#taskList').dataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                addTask();
                updateTask();
            }
        });

        $('#taskLocation').dataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                addTaskLocation();
                updateTaskLocation();
            }
        });

        $('#view-staff').dataTable({
            responsive: true,
            fixedheader: true
        });

        $('.enable-button').click(function() {
            var inputField = $(this).closest('.input-group').find('input.form-control');
            inputField.prop('disabled', !inputField.prop('disabled'));
        });

        var activeTab = localStorage.getItem('activeTab');

        if (activeTab) {
            $(activeTab).tab('show');
            localStorage.removeItem('activeTab');
        }

        // Add Facility
        $('#formAddFacility').on('submit', function(e) {
            e.preventDefault();


            // Perform AJAX request to submit the form data
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Add Facility successfully',
                        icon: 'success'
                    }).then(function() {
                        window.location.href =
                            '/admin/maintenance/add';
                    });
                },
                error: function(xhr) {
                    // Handle the error response
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Updating Guidelines:<br>' +
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
            var reviewEquipment = $(this).data('equipment');

            $.ajax({
                url: '/admin/reservation/view_reservation',
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

                    // $('#reservationEquipment').text(response.itemName);
                    // $('#reservationQuantity').text(response.reviewQuantity);
                    var $equipmentList = response.furnitureItems;

                    // Update equipment list in the Blade view
                    if ($equipmentList && $equipmentList[0] !== "none") {
                        var equipmentHtml = "";
                        $.each($equipmentList, function(index, item) {
                            equipmentHtml += '<span class="reservationEquipment">' +
                                item.name + '</span> ' +
                                '(x<span class="reservationQuantity">' + item
                                .value + '</span>)';
                            if (index !== $equipmentList.length - 1) {
                                equipmentHtml += '<br>';
                            }
                        });
                        $('#equipmentList .td-account').html('Equipment Needed: ' +
                            equipmentHtml);
                    } else {
                        $('#equipmentList .td-account').html(
                            'Equipment Needed: <span class="reservationEquipment">None</span>'
                        );
                    }

                    $('#reservationPaymentDescription').text(response.activity);
                    $('#reservationPrice').text(response.reservationPrice);
                    $('#reviewAttachment').data('attachment', response.reviewAttachments);
                    $('#reviewAttachment').show();

                    $('#orderOrganization').text(response.organization);
                    $('#orderName').text(response.reviewRecipient);
                    $('#orderLocation').text(response.reviewLocation);
                    $('#orderLocationReserve').text(response.reviewLocation);
                    $('#orderNameReserve').text(response.reviewRecipient);

                    if (response.eventType == "Small-Event") {
                        $('#reviewAttachment').hide();
                    }
                },
                error: function(xhr) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Problem for Reviewing Reservation:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });

        $('#reviewAttachment').click(function() {
            var attachmentData = $(this).data('attachment');

            var parts = attachmentData.split('/');

            // Get the last part of the array, which is the filename itself
            var trimmedFilename = parts[parts.length - 1];

            var showUrl = "{{ route('showAttachment', ['filename' => ':attachmentFilename']) }}";
            showUrl = showUrl.replace(':attachmentFilename', trimmedFilename);

            window.open(showUrl, '_blank');
        });

        $('.approveReservationBtn').click(function() {
            var reservationId = $('#reservationId').text();
            var reservationRecipientId = $('#reservationRecipientId').text();

            $.ajax({
                url: '/admin/reservation/approveReservation',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    reservationId: reservationId,
                    recipientId: reservationRecipientId,
                },
                success: function(response) {
                    $.ajax({
                        url: '/admin/maintenance/availableResStaff',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            reservationId: reservationId,
                        },
                        success: function(response) {
                            var staffList = response.availableStaff;
                            var tbody = $('#availableStaffList');

                            // Clear existing content in the tbody
                            tbody.empty();

                            // Iterate through the available staff and update the HTML content
                            $.each(staffList, function(index, staff) {
                                var staffRow = '<tr>' +
                                    '<td>' +
                                    '<h5 class="fw-bold mb-0">' + staff
                                    .name + '</h5>' +
                                    '<span class="text-muted badge bg-soft-secondary">Staff</span>' +
                                    '</td>' +
                                    '<td>' +
                                    '<a data-bs-toggle="modal" data-bs-target="#viewCalendar" data-id="' + staff.id +
                                    '" data-name="' + staff.name +
                                    '" class="text-decoration-none viewStaffOption" style="cursor: pointer;">View Schedule</a>' +
                                    '</td>' +
                                    '<td>' +
                                    '<button data-id="' + staff.id +
                                    '" data-name="' + staff.name +
                                    '" class="btn btn-primary rounded-0 assignRStaffBtn">Assign</button>' +
                                    '</td>' +
                                    '</tr>';

                                // Append the staff row to the tbody
                                tbody.append(staffRow);
                            });
                        },
                        error: function(xhr) {
                            swal({
                                title: 'Error',
                                content: {
                                    element: 'div',
                                    attributes: {
                                        innerHTML: '<div style="text-align: left;">' +
                                            'Error Problem for Viewing Available Staff:<br>' +
                                            parseErrors(xhr
                                                .responseText) +
                                            '</div>',
                                    },
                                },
                                icon: 'error'
                            });
                        }
                    });

                    alertify.success('Reservation has been Approved successfully');
                },
                error: function(xhr) {
                    console.log('Response Text:', xhr.responseText);

                    if (xhr.responseText ==
                        "The payment for this reservation has not paid yet!!") {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Problem for Approving Payment:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        }).then(function() {
                            window.location.href = '/admin/payment/manage';
                        });
                    } else {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Problem for Approving Payment:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        }).then(function() {
                            window.location.href = '/admin/payment/manage';
                            // window.location.href = '/admin/reservation/review';
                        });
                    }
                }
            });
        });

        var assignedRStaff = [];

        function assignUpdateReservation() {
            $('.adminReservationAssignUpdate').click(function() {
                var reviewId = $(this).data('id');
                $('#resId').text(reviewId);

                //Clear the temp list
                assignedRStaff = [];

                $.ajax({
                    url: '/admin/reservation/assignResView',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        requestId: reviewId
                    },
                    success: function(response) {
                        // if (response.items) {
                        //     assignedRStaff = response.items.map(item => ({
                        //         id: parseInt(item[
                        //             0
                        //         ]), // The second argument (10) specifies the base for parsing (e.g., base 10 for decimal).
                        //         name: item[1]
                        //     }));
                        // }

                        // updateButtonTexts();

                        $.ajax({
                            url: '/admin/maintenance/availableResStaff',
                            type: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                reservationId: reviewId,
                            },
                            success: function(response) {
                                var staffList = response.availableStaff;
                                var tbody = $('#availableStaffList');

                                // Clear existing content in the tbody
                                tbody.empty();

                                // Iterate through the available staff and update the HTML content
                                $.each(staffList, function(index, staff) {
                                    var staffRow = '<tr>' +
                                        '<td>' +
                                        '<h5 class="fw-bold mb-0">' + staff
                                        .name + '</h5>' +
                                        '<span class="text-muted badge bg-soft-secondary">Staff</span>' +
                                        '</td>' +
                                        '<td>' +
                                        '<a data-bs-toggle="modal" data-bs-target="#viewCalendar" data-id="' + staff.id +
                                        '" data-name="' + staff.name +
                                        '" class="text-decoration-none viewStaffOption" style="cursor: pointer;">View Schedule</a>' +
                                        '</td>' +
                                        '<td>' +
                                        '<button data-id="' + staff.id +
                                        '" data-name="' + staff.name +
                                        '" class="btn btn-primary rounded-0 assignRStaffBtn">Assign</button>' +
                                        '</td>' +
                                        '</tr>';

                                    // Append the staff row to the tbody
                                    tbody.append(staffRow);
                                });
                            },
                            error: function(xhr) {
                                swal({
                                    title: 'Error',
                                    content: {
                                        element: 'div',
                                        attributes: {
                                            innerHTML: '<div style="text-align: left;">' +
                                                'Error Problem for Viewing Available Staff:<br>' +
                                                parseErrors(xhr
                                                    .responseText) +
                                                '</div>',
                                        },
                                    },
                                    icon: 'error'
                                });
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle the error response
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error on Viewing Assign Staff:<br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }
                });
            });
        }

        function updateButtonTexts() {
            // $('.assignRStaffBtn').each(function() {
            //     var staffId = $(this).data('id');

            //     const index = assignedRStaff.findIndex(staff => staff.id === staffId);
            //     if (index == -1) {
            //         $(this).text('Assign');
            //     } else {
            //         $(this).text('Unassign');

            //     }
            // });

            $('#availableStaffList').on('click', '.assignRStaffBtn', function() {
                var staffId = $(this).data('id');

                const index = assignedRStaff.findIndex(staff => staff.id === staffId);
                if (index == -1) {
                    $(this).text('Assign');
                } else {
                    $(this).text('Unassign');

                }
            });
        }

        function assignRStaff(staffId, staffName, reservationId, data, clickedButton) {
            // Find the index of the staff with the specified ID in the assignedStaff array
            const index = assignedRStaff.findIndex(staff => staff.id === staffId);

            if (index == -1) {
                assignedRStaff.push({
                    id: staffId,
                    name: staffName
                });

                $.ajax({
                    url: '/admin/reservation/assignResStaff',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        staffDataId: staffId,
                        staffData: data,
                        requestId: reservationId
                    },
                    success: function(response) {
                        // Handle the success response
                        alertify.success('Staff Assigned in Reservation successfully');
                        clickedButton.text('Unassign');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 404) {
                            // Display a user-friendly message when the staff already exists
                            swal({
                                icon: 'error',
                                title: 'Staff already assigned',
                                text: 'The staff member is already assigned to this reservation.',
                            });
                        } else {
                            // Handle other error cases
                            swal({
                                title: 'Error',
                                content: {
                                    element: 'div',
                                    attributes: {
                                        innerHTML: '<div style="text-align: left;">' +
                                            'Error on Assigning Staff:<br>' +
                                            parseErrors(xhr.responseText) +
                                            '</div>',
                                    },
                                },
                                icon: 'error'
                            });
                        }
                        // Handle the error response

                    }
                });
            } else {
                // If the staff is already assigned, remove them from the array
                assignedRStaff.splice(index, 1);

                $.ajax({
                    url: '/admin/reservation/removeResStaff',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        staffDataId: staffId,
                        staffData: data,
                        requestId: reservationId
                    },
                    success: function(response) {
                        alertify.success('Staff Unassigned in Reservation successfully');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 404) {
                            // Display a user-friendly message when the staff is not found
                            swal({
                                icon: 'error',
                                title: 'Staff not found',
                                text: 'The staff member was not assigned to this reservation.',
                            });
                        } else {
                            // Handle other error cases
                            swal({
                                title: 'Error',
                                content: {
                                    element: 'div',
                                    attributes: {
                                        innerHTML: '<div style="text-align: left;">' +
                                            'Error on Unassigning Staff:<br>' +
                                            parseErrors(xhr.responseText) +
                                            '</div>',
                                    },
                                },
                                icon: 'error'
                            });
                        }
                    }
                });
            }

            updateButtonTexts();

        }

        // $('.assignRStaffBtn').click(function() {
        //     var staffId = $(this).data('id');
        //     var staffName = $(this).data('name');
        //     var reservationId = $('#resId').text();
        //     var data = [staffId, staffName];
        //     var clickedButton = $(this);

        //     assignRStaff(staffId, staffName, reservationId, data, clickedButton);
        // });

        $('#availableStaffList').on('click', '.assignRStaffBtn', function() {
            var staffId = $(this).data('id');
            var staffName = $(this).data('name');
            var reservationId = $('#resId').text();
            var data = [staffId, staffName];
            var clickedButton = $(this);

            assignRStaff(staffId, staffName, reservationId, data, clickedButton);
        });

        $('#staffResList').DataTable({
            responsive: true,
            fixedheader: true,
            drawCallback: function(settings) {
                assignUpdateReservation();
            }
        });

        $('.declineReservationBtn').click(function() {
            var reservationId = $('#reservationId').text();
            var reservationRecipientId = $('#reservationRecipientId').text();
            $('#confirmReservationId').val(reservationId);
            $('#confirmRecipientId').text(reservationRecipientId);
        });

        $('.btnReasonView').click(function() {
            var reason = $(this).data('reason');
            $('#reasonDetails').text(reason);
        });

        $('.adminReservationCancel').click(function() {
            var reservationId = $(this).data('id');
            var recipientId = $(this).data('recipient');
            $('#confirmReservationId').val(reservationId);
            $('#confirmRecipientId').text(recipientId);
        });

        $('#adminReservationCancelBtn').click(function() {
            var reservationId = $('#confirmReservationId').val();
            var recipientId = $('#confirmRecipientId').text();
            var reasonDetails = $('#reasonForm').val();

            $.ajax({
                url: '/admin/reservation/declineReservation',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    reservationId: reservationId,
                    recipientId: recipientId,
                    reasonDetails: reasonDetails,
                    type: 2,
                },
                success: function(response) {
                    // Handle the success response
                    swal({
                        title: 'Success',
                        text: 'Success Cancelled Reservation: ',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/reservation/review';
                    });
                },
                error: function(xhr) {

                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error on declining Reservation:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });

                }
            });
        });

        $('.updatePrice').click(function() {
            var priceId = $(this).data('id');
            var priceValue = $(this).data('price');
            $('#confirmPrizeId').text(priceId);
            $('#currentPriceLabel').text(priceValue);
            $('#newPriceInput').val(priceValue);
        });

        $('#updatePricesBtn').click(function() {
            var priceId = $('#confirmPrizeId').text();
            var priceValue = $('#newPriceInput').val();

            $.ajax({
                url: '/admin/reservation/price_update',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    priceId: priceId,
                    priceValue: priceValue
                },
                success: function(response) {
                    // Handle the success response
                    swal({
                        title: 'Success',
                        text: 'Price Value Update Successfully!!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/reservation/review';
                    });
                },
                error: function(xhr) {

                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error in Updating the Reservation Price:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });

                }
            });
        });

        $('.removeAdminNotifBtn').click(function() {
            // e.preventDefault();
            var notificationId = $(this).data('id');

            // Send an AJAX request to mark the notification as read
            $.ajax({
                url: '/adminNotifRead/' + notificationId,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    window.location.href =
                        '/admin/settingsView';

                },
                error: function(xhr, status, error) {
                    // Handle error response if needed

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

</html>
