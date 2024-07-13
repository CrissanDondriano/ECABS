@extends('layouts.admin-app')

@section('style')
    <style>
        /* Style the scanner container */
        #reservationScannerContainer,
        #inventoryScannerContainer {
            position: relative;
        }

        /* Style the video element */
        #reservationPreview,
        #inventoryPreview {
            border: none;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row m-1 pt-4">

            <h3 class=" fw-bold mb-1">Scan Qr Code</h3>
            <span class="text-muted">Click Open Camera & Point the QR Code toward it.</span>

            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-start  mb-1">

                            <h3 class="fw-bold"> <i class="fa-solid fa-video fa-lg"></i> Webcam</h3>
                        </div>
                        <div id="reservationScannerContainer" class="border border-dark">
                            <video class="rounded-0" id="reservationPreview" width="100%" autoplay></video>
                        </div>
                        <div class="text-center p-2">
                            <button id="requestReservationPermissionBtn"
                                class="btn btn-outline-dark text-capitalize rounded-0 w-50 fs-3 fw-bold">Open
                                Camera</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-start  mb-1">

                            <h3 class="fw-bold"> <i class="fa-solid fa-qrcode fa-lg"></i> Scanned Data</h3>
                        </div>
                        <div class="d-flex justify-center">
                            <ul class="nav nav-tabs mb-3" id="ex-with-icons" role="tablist">
                                <li class="nav-item border rounded-0 px-2" role="presentation">
                                    <a class="nav-link active" id="ex-with-icons-tab-1" data-bs-toggle="tab"
                                        href="#ex-with-icons-tabs-1" role="tab" aria-controls="ex-with-icons-tabs-1"
                                        aria-selected="true">Reservation</a>
                                </li>
                                <li class="nav-item rounded border px-2" role="presentation">
                                    <a class="nav-link " id="ex-with-icons-tab-2" data-bs-toggle="tab"
                                        href="#ex-with-icons-tabs-2" role="tab" aria-controls="ex-with-icons-tabs-2"
                                        aria-selected="false">Inventory</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Tabs content -->
                        <div class="tab-content" id="ex-with-icons-content">
                            <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                                aria-labelledby="ex-with-icons-tab-1">
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h5 class="text-muted fw-bold">Message: </h5>
                                        <p class="mb-2 mt-2">Is the rental currently reserved? We'll check for you! </p>
                                    </div>
                                </div>

                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h5 class="text-muted fw-bold">Information: </h5>
                                        <h6 class="text-capitalize">Name: <span id="scannedName"></span></h6>
                                        <h6 class="text-capitalize">Time: <span id="scannedTime"></span></h6>
                                        <h6 class="text-capitalize">Status: <span id="status"></span></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel"
                                aria-labelledby="ex-with-icons-tab-2">
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h5 class="text-muted fw-bold pb-3">Item Information: </h5>
                                        <h6 class="text-capitalize">SKU: <span id="itemId"></span></h6>
                                        <h6 class="text-capitalize">Item Name: <span id="itemName"></span></h6>
                                        <h6 class="text-capitalize">Status: <span id="itemStatus"></span></h6>
                                        <h6 class="text-capitalize">Quantity: <span id="quantity"></span></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Warning Alert -->
            <div class="alert alert-primary alert-dismissible fade show mt-4">
                <strong>Attention!</strong> This section is intended for checking user reservations on the
                specified day.
                <p class="mb-2 mt-2">To streamline the process and provide a better user experience, please
                    ensure to scan
                    the QR Codes corresponding to the day of interest. Scanning the correct QR Code will display
                    the
                    relevant user reservations for the chosen day.</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var csrfToken = "{{ csrf_token() }}";

        let scanner;
        let cameras = [];
        let currentCameraIndex = 0;

        function isTorchSupported(track) {
            return track.getCapabilities && track.getCapabilities().torch === true;
        }

        function toggleFlashlight(videoId) {
            const videoElement = $('#' + videoId)[0];
            if (videoElement.srcObject && videoElement.srcObject.getVideoTracks().length > 0) {
                const track = videoElement.srcObject.getVideoTracks()[0];
                if (isTorchSupported(track)) {
                    const isTorchOn = !!(track.getSettings && track.getSettings().torch);
                    track.applyConstraints({
                        advanced: [{
                            torch: !isTorchOn
                        }]
                    }).catch((error) => {
                        console.error('Failed to toggle flashlight:', error);
                    });
                } else {
                    swal({
                        title: 'Warning',
                        text: 'Flash is not supported for this device.',
                        icon: 'warning'
                    });
                }
            } else {
                console.error('No video track found.');
            }
        }

        function showReservationScanner() {
            $('#reservationPermissionPrompt').hide();
            $('#reservationScannerContainer').show();

            scanner = new Instascan.Scanner({
                video: $('#reservationPreview')[0]
            });

            Instascan.Camera.getCameras().then(function(camerasList) {
                cameras = camerasList;
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    alert('No Cameras Found');
                }
            }).catch(function(e) {
                console.error(e);
            });

            scanner.addListener('scan', function(c) {
                try {
                    var parsedData = JSON.parse(c);

                    console.log(parsedData)

                    if (parsedData) {
                        var activeTab = $('.nav-tabs .nav-item .active').attr('id');
                        if (activeTab === 'ex-with-icons-tab-1') {
                            $.ajax({
                                url: '/admin/reservation/scanningQrCode',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                data: {
                                    reservationId: parsedData,
                                },
                                success: function(response) {
                                    var reservationName = response.name;
                                    var reservationTime = response.time;
                                    var status = response.status;

                                    $("#scannedName").text(reservationName);
                                    $("#scannedTime").text(reservationTime);
                                    $("#status").text(status);
                                },
                                error: function(xhr) {
                                    swal({
                                        title: 'Error',
                                        content: {
                                            element: 'div',
                                            attributes: {
                                                innerHTML: '<div style="text-align: left;">' +
                                                    'Error Scanning Item:<br>' +
                                                    parseErrors(xhr.responseText) +
                                                    '</div>',
                                            },
                                        },
                                        icon: 'error'
                                    });
                                }
                            });
                        } else if (activeTab === 'ex-with-icons-tab-2') {
                            $.ajax({
                                type: "POST",
                                url: "/admin/inventory/scanningInventoryQrCode",
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                data: {
                                    itemId: parsedData,
                                },
                                success: function(response) {
                                    var itemName = response.itemName;
                                    var status = response.status;
                                    var stock = response.stock;

                                    $("#itemId").text(parsedData);
                                    $("#itemName").text(itemName);
                                    $("#itemStatus").text(status);
                                    $("#quantity").text(stock);
                                },
                                error: function(xhr, status, error) {
                                    swal({
                                        title: 'Error',
                                        content: {
                                            element: 'div',
                                            attributes: {
                                                innerHTML: '<div style="text-align: left;">' +
                                                    'Error Scanning Item:<br>' +
                                                    parseErrors(xhr.responseText) +
                                                    '</div>',
                                            },
                                        },
                                        icon: 'error'
                                    });
                                }
                            });
                        }

                    } else {
                        console.error('Invalid QR code data. Missing required fields.');
                    }
                } catch (error) {
                    swal({
                        title: 'Warning',
                        text: 'Error parsing QR code data:' + error,
                        icon: 'warning'
                    });
                }
            });
        }

        $(document).ready(function() {
            $('#requestReservationPermissionBtn').on('click', function() {
                navigator.mediaDevices.getUserMedia({
                    video: true
                }).then(function() {
                    showReservationScanner();
                }).catch(function() {
                    alert('Camera access denied. Please allow camera access to use the scanner.');
                });
            });

            $('#hideReservationCameraBtn').on('click', function() {
                scanner.stop();
                $('#reservationScannerContainer').hide();
                $('#reservationPermissionPrompt').show();
            });

            $('#toggleReservationFlashBtn').on('click', function() {
                toggleFlashlight('reservationPreview');
            });

        });
    </script>
@endsection
