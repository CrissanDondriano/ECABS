let scanner;
let cameras = [];
let currentCameraIndex = 0;

function isTorchSupported(track) {
    return track.getCapabilities && track.getCapabilities().torch === true;
}

function toggleFlashlight(videoId) {
    const videoElement = document.getElementById(videoId);
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
            alert('Flash is not supported for this device.');
        }
    } else {
        console.error('No video track found.');
    }
}

function switchCamera() {
    if (scanner && cameras.length > 1) {
        currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
        scanner.stop().then(() => {
            scanner.start(cameras[currentCameraIndex]);
        }).catch((e) => {
            console.error(e);
            alert('Failed to switch camera.');
        });
    } else {
        alert('No other cameras found.');
    }
}

function showReservationScanner() {
    document.getElementById('reservationPermissionPrompt').style.display = 'none';
    document.getElementById('reservationScannerContainer').style.display = 'block';

    scanner = new Instascan.Scanner({
        video: document.getElementById('reservationPreview')
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

            console.log(parsedData);

            if (parsedData) {
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
                        var reservationTime = response.time;
                        document.getElementById('scannedTime').textContent = reservationTime;
                        $('#viewQrReservationModal').modal('show');
                    },
                    error: function(xhr) {
                        alert('Error Decline Reservation: ' + xhr.responseText);
                        console.log(xhr.responseText);
                    }
                });
            } else {
                console.error('Invalid QR code data. Missing required fields.');
            }
        } catch (error) {
            alert('Error parsing QR code data: ' + error);
        }
    });
}

document.getElementById('requestReservationPermissionBtn').addEventListener('click', function() {
    navigator.mediaDevices.getUserMedia({
        video: true
    }).then(function() {
        showReservationScanner();
    }).catch(function() {
        alert('Camera access denied. Please allow camera access to use the scanner.');
    });
});

document.getElementById('hideReservationCameraBtn').addEventListener('click', function() {
    scanner.stop();
    document.getElementById('reservationScannerContainer').style.display = 'none';
    document.getElementById('reservationPermissionPrompt').style.display = 'block';
});

document.getElementById('switchReservationCameraBtn').addEventListener('click', function() {
    switchCamera();
});

document.getElementById('toggleReservationFlashBtn').addEventListener('click', function() {
    toggleFlashlight('reservationPreview');
});