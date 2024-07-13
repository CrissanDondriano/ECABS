@extends('layouts.user-app')

@section('content')
    <style>
        .modal-content {
            background-color: white;
        }

        .box {
            border: 2px solid #ddd;
            padding: 10px 20px
        }

        .inputbox {
            border: none;
            outline: none
        }

        .h-blue {
            color: #777a7c;
            margin-bottom: 5px;
            padding-left: 4px;
            font-size: 14px;
            font-weight: 500
        }

        .form-control {
            background-color: white !important;
        }

        .textmuted {
            color: #ddd
        }

        .radio {
            display: inline-block;
            margin-left: 13px;
            cursor: pointer;
            font-weight: 500
        }

        .btn.radio-btn {
            position: relative
        }

        .radio input[type="radio"] {
            display: none
        }

        .radio span {
            height: 20px;
            width: 20px;
            border: 2px solid #ddd;
            border-radius: 50%;
            display: block;
            position: absolute;
            top: 8px;
            left: 0
        }

        .radio span::after {
            content: "";
            height: 10px;
            width: 10px;
            background-color: #00c3ff;
            display: block;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) scale(0);
            border-radius: 50%;
            transition: 300ms ease-in-out 0s
        }

        .radio input[type="radio"]:checked~span::after {
            transform: translate(-50%, -50%) scale(1)
        }


        .custom-checkbox {
            display: inline-block;
            position: relative;
            padding-left: 30px;
            cursor: pointer;
        }

        .custom-checkbox input[type="checkbox"] {
            display: none;
        }

        .custom-checkbox .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 20px;
            width: 20px;
            background-color: white;
            border: 1px solid #838383;
        }

        .custom-checkbox input[type="checkbox"]:checked+.checkmark {
            background-color: #00c3ff;
        }

        .custom-checkbox .checkmark::after {
            content: "";
            position: absolute;
            display: none;
            left: 7px;
            top: 3px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .custom-checkbox input[type="checkbox"]:checked+.checkmark::after {
            display: block;
        }

        .outline-none {
            outline: none
        }

        .control-label:after {
            color: #d00;
            content: "*";
            font-weight: normal;
            font-size: 14px;
        }

        .legend {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .legend-text {
            margin: 0;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .dot {
            height: 10px;
            width: 10px;
            background-color: #d1ffe6;
            border-radius: 50%;
            margin-right: 5px;
        }

        .dot1 {
            height: 10px;
            width: 10px;
            background-color: #fff1f8;
            border-radius: 50%;
            margin-right: 5px;
        }

        .step-container {
            position: relative;
            text-align: center;
            transform: translateY(-43%);
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #007bff;
            line-height: 30px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .step-line {
            position: absolute;
            top: 16px;
            left: 50px;
            width: calc(100% - 100px);
            height: 2px;
            background-color: #007bff;
            z-index: -1;
        }

        #multi-step-form {
            overflow-x: hidden;
        }

        .th-account,
        .td-account {
            background: #fff !important;
        }

        .statement-card {
            border: #000000 !important;
        }

        #signature {
            width: 100%;
            border-bottom: 1px solid black;
        }

        .page {
            max-width: 21cm;
            min-height: 29.7cm;
            padding: 1cm;
            margin: 1cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            font-family:
        }

        .subpage {
            border: 2px black solid;
            height: 270mm;
        }


        @page {
            size: A4;
            margin: 0;
        }

        @media print {

            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }

        @media (max-width: 768px) {
            .container {
                max-width: 100%;
            }
        }

        /* Media query for mobile phones */
        @media (max-width: 576px) {
            .container {
                max-width: 100%;
            }
        }
    </style>
    <div class="container-fluid content-wrapper">
        <div class="row mt-3 reservation-container m-2 p-3">
            <h3 class="fw-bold my-3">Make Reservation</h3>
            <hr>
            <!-- Reminder Alert -->
            <div class="alert alert-primary alert-dismissible fade show">
                <strong>🌟 Friendly Reminder!</strong>
                Ready for a great time? Click on your preferred day to secure your spot! Wishing you fantastic days ahead!
            </div>
            <div class=" pb-3">
                <div class="legend">
                    <p class="legend-text px-4 fw-bold">Legend :</p>

                    <div class="legend-item">
                        <span class="dot"></span>
                        <p class="legend-text px-2">Available</p>
                    </div>
                    <div class="legend-item">
                        <span class="dot1"></span>
                        <p class="legend-text">Not Available</p>
                    </div>
                </div>
            </div>
            <div id="calendar"></div>
        </div>
    </div>


    <div class="modal fade" id="initialModal" tabindex="-1" aria-labelledby="initialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div id="reservationForm">
                    {{-- @csrf --}}
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="initialModalLabel">Reservation Form</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="progress px-1 mt-4" style="height: 3px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="step-container d-flex justify-content-between">
                            <div class="step-circle" onclick="displayStep(1)">1</div>
                            <div class="step-circle" onclick="displayStep(2)">2</div>
                            <div class="step-circle" onclick="displayStep(3)">3</div>
                        </div>

                        <div id="multi-step-form">
                            <div class="step step-1">
                                <h3 class="fw-bold">Step 1: Select Facility & Time</h3>
                                <div class="row mt-3">
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <p class="h-blue">RESERVATION DATE</p>
                                                <div class="form-control">
                                                    <input type='text' class="inputbox" id='reservationDate'
                                                        name='reservationDate' disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-12 mb-4">
                                                <p class="h-blue control-label">AVAILABLE FACILITIES</p>
                                                <select class="form-select" id="facilitySelect" name="facilitySelect"
                                                    aria-label="Default select example">
                                                    <option value="" data-image="" data-name="" data-description=""
                                                        selected>Select an Facility</option>
                                                    @foreach ($facilities as $facility)
                                                        <option value="{{ $facility->name }}"
                                                            data-image="{{ asset('storage/images/' . $facility->image) }}"
                                                            data-name="{{ $facility->name }}"
                                                            data-description="{{ $facility->description }}">
                                                            {{ $facility->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 col-12 mb-4">
                                                <p class="h-blue control-label">TYPE OF EVENT ( SMALL OR BIG EVENT )</p>
                                                <select class="form-select" id="eventSelect" name="eventSelect"
                                                    aria-label="Default select example">
                                                    <option value="">Select Event Type</option>
                                                    <option value="Small Event" class="small-event" style="display: none">
                                                        Small Event</option>
                                                    <option value="Big Event" class="big-event" style="display: none">Big
                                                        Event</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="timeSelectContainer" class="row">
                                            <div class="col-md-12 mb-4">
                                                <p class="h-blue control-label">TIME</p>
                                                <select class="form-select" id="timeSelect" name="timeSelect">
                                                    <option value="">Select Time For Your Reservation</option>
                                                    <option value="7:00AM-12:00PM" data-total-slots="3">7:00 AM - 12:00 PM
                                                    </option>
                                                    <option value="1:00PM-5:00PM" data-total-slots="3">1:00 PM - 5:00 PM
                                                    </option>
                                                    <option value="6:00PM-10:00PM" data-total-slots="3">6:00 PM - 10:00 PM
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <p class="h-blue control-label">ORGANIZATION CATEGORY</p>
                                                <select class="form-select" id="categorySelect" name="categorySelect">
                                                    <option value="">Select Organization Type</option>
                                                    <option value="Commercial">Commercial</option>
                                                    <option value="Private Companies">Private Companies</option>
                                                    <option value="LGU Government">LGU Government </option>
                                                    <option value="Private Schools">Private School </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <p class="h-blue control-label">ACTIVITIES</p> <select class="form-select"
                                                    id="activitySelect" name="activitySelect">
                                                    <option value="" selected>Select Activities</option>
                                                    <option value="Training">Training</option>
                                                    <option value="Sportfest">Sportfest</option>
                                                    <option value="Concert">Concert</option>
                                                    <option value="Graduation">Graduation</option>
                                                    <option value="Convention">Convention</option>
                                                    <option value="Religious">Religious Activity</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-4" id="equipmentNeeded" style="display: none;">
                                                <p class="h-blue">EQUIPMENT NEEDED</p>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon3">No. of Air
                                                            conditioner needed: </span>
                                                    </div>
                                                    <input type="number" max="8" min="0"
                                                        class="form-control" id="quantityAirconNumber">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon3">No. of Chairs
                                                            needed:</span>
                                                    </div>
                                                    <input type="number" max="200" min="0"
                                                        class="form-control" id="quantityChairNumber">
                                                </div>

                                            </div>
                                        </div>

                                        {{-- Equipment Needed Menu --}}
                                        {{-- <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <p class="h-blue control-label">EQUIPMENT NEEDED</p>
                                                <div class="input-group mb-3">
                                                    <div class="form-control">
                                                        <input type="number" id="quantityNum" class="inputbox"
                                                            name="quantityNum" placeholder="How Many?">
                                                    </div>
                                                    <select class="form-select" id="equipmentSelect"
                                                        name="equipmentSelect">
                                                        <option value="None">Select Equipment</option>
                                                        @foreach ($availFurnitures as $availFurniture)
                                                            <option value="{{ $availFurniture->id }}">
                                                                {{ $availFurniture->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div> --}}

                                        <div class="row">
                                            <div class="col-md-12 col-12 mb-4" style="display: none;" id="fileContainer">
                                                <div id="fileRequestContainer" name="fileRequestContainer">
                                                    <p class="h-blue control-label">ATTACHMENT</p>
                                                    <input type="file" class="inputbox" id="attachmentSelect"
                                                        name="attachmentSelect">
                                                </div>
                                            </div>
                                        </div>
                                        @foreach ($currentUsers as $currentUser)
                                            <div class="form-floating my-3" style="display:none">
                                                <input type="hidden" id="rentersId" name="rentersId"
                                                    value="{{ $currentUser->id }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-md-7">
                                        <div class=" my-2 text-center">
                                            <img class="img mb-2 border border-dark" style="width: 50%; height: 50%;"
                                                id="reservationFacilityImage" src="" alt="">
                                        </div>
                                        <div class="my-2 text-center">
                                            <h2 class="fw-bold text-capitalize" id="reservationFacilityName"></h2>
                                        </div>
                                        <div class="my-2 text-center">
                                            <span class="italic" id="reservationFacilityDescription"></span>
                                        </div>
                                        <div class="my-3 text-start">
                                            <h5 class="fw-bold" id="labelEquipment" style="">Inclusive of:
                                            </h5>
                                            <span class="mt-1" id="reservationFacilityEquipment">

                                            </span>
                                        </div>
                                        <div class="my-3 text-start">
                                            <h3 class="fw-bold">Price: <span id="reservationPrice"
                                                    name="reservationPrice"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="button" class="btn btn-primary next-step">Next</button>
                                </div>
                            </div>

                            <div class="step step-2">
                                <h3 class="fw-bold">Step 2: Additional Information</h3>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <p class="h-blue control-label">RENTER'S FULLNAME</p>
                                                <div class="form-control">
                                                    <input class="inputbox" placeholder="Ex. John Doe" id="rentersName"
                                                        name="rentersName" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <p class="h-blue control-label">CONTACT NUMBER</p>
                                                <div class="form-control">
                                                    <input class="inputbox" id="contactNumber" name="contactNumber"
                                                        type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <p class="h-blue control-label">ADDRESS</p>
                                                <div class="form-control">
                                                    <input class="inputbox" id="address" name="address"
                                                        placeholder="Ex. Cabuyao, Laguna" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12 mb-3">
                                                <p class="h-blue control-label">NAME OF ORGANIZATION</p>
                                                <div class="form-control">
                                                    <input class="inputbox" id="organization" name="organization"
                                                        placeholder="Ex. Philippine Red Cross" type="text">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-primary prev-step">Previous</button>
                                    <button type="button" class="btn btn-primary next-step"
                                        id="previewReservationNext">Next</button>
                                </div>
                            </div>

                            <div class="step step-3">
                                <h3 class="fw-bold">Step 3: Preview of your Reservation</h3>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="page">
                                            <div class="subpage" id="page">
                                                <div class="container mb-5 mt-3">
                                                    <div class="d-flex justify-content-center">
                                                        <div class="row">
                                                            <div class="col-xl-3 col-md-3 col-sm-3">
                                                                <img src="{!! url('assets/images/cabuyao-icon.png') !!}" alt=""
                                                                    width="110px">
                                                            </div>
                                                            <div
                                                                class="col-xl-9 col-md-9 col-sm-9 text-center text-uppercase pt-2">
                                                                <p class="lh-sm">Republic of the Philippines <br>
                                                                    <span class="fw-bold">City of
                                                                        Cabuyao</span><br>Province of
                                                                    Laguna<br><br><span class="fw-bold">Cabuyao Athletes
                                                                        Basic School</span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="text-center">
                                                        <h4 class="fw-bold text-uppercase">ORDER OF PAYMENT</h4>
                                                        <h5 class="fw-bold">(Base on CITY ORDINANCE No. 220-660)</h5>
                                                    </div>
                                                    <div class="container pt-4">

                                                        <div class="row">
                                                            <div class="col-xl-4">
                                                                <ul class="list-unstyled">
                                                                    <li class="text-uppercase lh-sm">Date Issued:</li>
                                                                    <li class="text-uppercase lh-sm require-fill-up">
                                                                        Requested Facility:
                                                                    </li>
                                                                    <li class="text-uppercase lh-sm require-fill-up pb-3">
                                                                        Address:
                                                                    </li>
                                                                    <li class="text-uppercase pb-3">Bill To:</li>
                                                                    <li class="text-uppercase">Account Activity:</li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <ul class="list-unstyled">
                                                                    <li class="text-uppercase lh-sm pt-3">
                                                                        <div id="signature"></div>
                                                                    </li>
                                                                    <li class="text-uppercase lh-sm require-fill-up">
                                                                        <span id="orderLocation"></span>
                                                                        <div id="signature"></div>
                                                                    </li>
                                                                    <li class="text-uppercase lh-sm require-fill-up pb-2">
                                                                        Bgy. Banay Banay,
                                                                        City of Cabuyao
                                                                        <div id="signature"></div>
                                                                    </li>
                                                                    <li class="text-uppercase">
                                                                        <span id="orderOrganization"></span>,
                                                                        <span id="orderName"></span>
                                                                        <div id="signature">
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-2 mx-1 justify-content-center">
                                                            <table class="table table-bordered table-sm statement-card">
                                                                <thead>
                                                                    <tr>
                                                                        <th class="text-uppercase th-account">Reservation
                                                                            Date</th>
                                                                        <th class="text-uppercase th-account">Description
                                                                        </th>
                                                                        <th class="text-uppercase th-account">Amount</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td class="td-account text-center"><span
                                                                                id="reservationDateV1"></span></td>
                                                                        <td class="td-account text-center"><span
                                                                                id="reservationPaymentDescription"></td>
                                                                        <td class="td-account">NB: The amount to be paid
                                                                            <br> covers the usage
                                                                            of their <br>rent from <span
                                                                                id="orderLocationReserve"></span>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="text-uppercase td-account fw-bold">Total
                                                                        </td>
                                                                        <td class="td-account"></td>
                                                                        <td class="td-account fw-bold">Php <span
                                                                                id="reservationTotalPrice"></span>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xl-12">
                                                                <p>Please make checks payable to : <span
                                                                        class="fw-bold text-uppercase">City
                                                                        Treasure of Cabuyao</span></p>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-xl-5">
                                                                <p class="mt-4">Prepared by:</p>
                                                                <p class="mt-5"><span
                                                                        class="fw-bold text-uppercase">Ruben L.
                                                                        Morales</span>
                                                                    <br>
                                                                    OIC CABS
                                                                </p>

                                                                <p class="mt-5">Approved by:</p>
                                                                <p class="mt-5"><span class="fw-bold text-uppercase">Mr.
                                                                        Librado DG.
                                                                        Dimaunahan</span>
                                                                    <br>
                                                                    CITY ADMINISTRATOR
                                                                </p>
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <ul class="list-unstyled mt-4">
                                                                    <li class="text-muted ms-3"><span
                                                                            class="text-black me-4">Conforme:
                                                                    </li>
                                                                    <li class="mt-5 text-center fw-bold"
                                                                        style="padding-left: 1rem">
                                                                        <span id="orderNameReserve"></span>
                                                                        <div id="signature">
                                                                        </div>
                                                                    </li>
                                                                    <li class="text-muted" style="padding-left: 3rem">
                                                                        <span
                                                                            class="text-black fw-bold text-uppercase">Clients
                                                                            Name and
                                                                            Signature
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-primary prev-step">Previous</button>
                                    <button type="submit" id="createReservationBtn"
                                        class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const form = document.getElementById('reservationForm');

        form.addEventListener('input', function(event) {
            const formData = new FormData(form);

            const formObject = {};
            formData.forEach((value, key) => {
                formObject[key] = value;
            });

            localStorage.setItem('reservationFormData', JSON.stringify(formObject));
        });

        window.addEventListener('DOMContentLoaded', function() {
            const storedFormData = localStorage.getItem('reservationFormData');

            if (storedFormData) {
                const parsedFormData = JSON.parse(storedFormData);

                Object.keys(parsedFormData).forEach(key => {
                    const field = form.querySelector(`[name="${key}"]`);
                    if (field) {
                        if (field.type === 'checkbox') {
                            field.checked = parsedFormData[key] === field.value;
                        } else if (field.type !== 'file') {
                            field.value = parsedFormData[key];
                        }
                    }
                });
            }
        });

        form.addEventListener('submit', function() {
            localStorage.removeItem('reservationFormData');
        });

        var currentStep = 1;
        var updateProgressBar;

        function displayStep(stepNumber) {
            if (stepNumber >= 1 && stepNumber <= 3) {
                $(".step-" + currentStep).hide();
                $(".step-" + stepNumber).show();
                currentStep = stepNumber;
                updateProgressBar();
            }
        }

        function validateForm(stepClass, callback) {

            var isValid = true;
            var firstErrorField = null;

            var reserveDate = $('#reservationDate').val();
            var reserveFacility = $('#facilitySelect').val();
            var reserveEvent = $('#eventSelect').val();
            var reserveTime = $('#timeSelect').val();
            var reserveCategory = $('#categorySelect').val();
            var reserveActivity = $('#activitySelect').val();
            var reserveEquipment = $('#equipmentSelect').val();

            var reserveRenter = $('#rentersName').val();
            var reserveContact = $('#contactNumber').val();
            var reserveAddress = $('#address').val();
            var reserveOrganization = $('#organization').val();

            $.ajax({
                url: '/make-reservation/validateReservation',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    class: stepClass,
                    date: reserveDate,
                    facility: reserveFacility,
                    event: reserveEvent,
                    time: reserveTime,
                    category: reserveCategory,
                    activity: reserveActivity,
                    equipment: reserveEquipment,
                    renter: reserveRenter,
                    contact: reserveContact,
                    address: reserveAddress,
                    organization: reserveOrganization,
                },
                success: function(response) {
                    var contact = response.userContact;
                    
                    if(contact){
                        $('#contactNumber').val(contact);
                    }
                    
                    callback(true);
                },
                error: function(xhr, status, error) {
                    callback(false);
                    swal({
                        title: 'Validation Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Here are the followings:<br>' +
                                    parseErrors(xhr
                                        .responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                },
            });
        }

        $(document).ready(function() {
            $('#multi-step-form').find('.step').slice(1).hide();

            $(".next-step").click(function() {
                // Find the closest parent div with a class containing "step-"
                var parentStepDiv = $(this).closest("[class*='step-']");
                // Get the class of the found parent div
                var stepClass = parentStepDiv.attr("class").split(' ').find(cls => cls.startsWith('step-'));
                // Log or use the stepClass as needed
                console.log(stepClass);

                validateForm(stepClass, function(isValid) {
                    if (!isValid) {
                        return;
                    }
                    if (currentStep < 3) {
                        $(".step-" + currentStep).addClass(
                            "animate__animated animate__fadeOutLeft");
                        currentStep++;
                        setTimeout(function() {
                            $(".step").removeClass("animate__animated animate__fadeOutLeft")
                                .hide();
                            $(".step-" + currentStep).show().addClass(
                                "animate__animated animate__fadeInRight");
                            updateProgressBar();
                        }, 500);
                    }
                });
            });

            $(".prev-step").click(function() {
                if (currentStep > 1) {
                    $(".step-" + currentStep).addClass("animate__animated animate__fadeOutRight");
                    currentStep--;
                    setTimeout(function() {
                        $(".step").removeClass("animate__animated animate__fadeOutRight").hide();
                        $(".step-" + currentStep).show().addClass(
                            "animate__animated animate__fadeInLeft");
                        updateProgressBar();
                    }, 500);
                }
            });

            updateProgressBar = function() {
                var progressPercentage = ((currentStep - 1) / 2) * 100;
                $(".progress-bar").css("width", progressPercentage + "%");
            }


            // function addButtonToCalendarDay(element, date, selectedFacility) {
            //     element.css('background-color', 'transparent');
            //     element.css('border', 'none');

            //     var button = $('<button>').text('Slot Available');
            //     button.addClass('btn btn-success position-relative fs-6');

            //     var badge = $('<span>').addClass(
            //         'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger'
            //     );

            //     var loadingSpinner = $('<span>').addClass('spinner-border spinner-border-sm');
            //     badge.append(loadingSpinner);

            //     // Get the select element by its ID
            //     var timeSelect = $('#timeSelect');

            //     // Get the number of options in the select element
            //     var totalSlots = timeSelect.children('option').length;

            //     // Function to update the badge content based on the server response
            //     function updateBadgeContent(availableSlots) {
            //         badge.empty();
            //         if (availableSlots > 0) {
            //             badge.text(availableSlots);
            //         } else {
            //             button.text('Not Available');
            //             button.removeClass('btn-success');
            //             button.addClass('btn-dark');
            //             button.prop('disabled', true);
            //         }
            //     }
            //     button.prop('disabled', true);

            //     badge.append(loadingSpinner);

            //First Count for dates
            // $.ajax({
            //     url: '/get-reservation-count',
            //     method: 'GET',
            //     data: {
            //         date: date,
            //         facilitySelect: selectedFacility,
            //     },
            //     success: function(response) {
            //         var count = response.count;
            //         var availableSlots = totalSlots - count;
            //         updateBadgeContent(availableSlots);

            //         if (availableSlots > 0) {
            //             button.prop('disabled', false); // Enable the button if slots are available
            //         }

            // Disable options that have no available slots
            // timeSelect.children('option').each(function() {
            //     var option = $(this);
            //     var optionSlots = parseInt(option.data('total-slots'));
            //     option.prop('disabled', optionSlots <= count);
            // });
            //         },
            //         error: function(xhr) {
            //             console.log(xhr);
            //             console.log(status);
            //             console.log(error);
            //             badge.empty();
            //             badge.text('Error loading slots');
            //         },
            //     });


            //     button.append(badge);

            //     var wrapperDiv = $('<div>').addClass('d-flex justify-content-center align-items-center');
            //     wrapperDiv.append(button);


            //     button.on('click', function() {
            //         $('#reservationDate').val(date);
            //         $('#tempReservationDate').text(date);
            //         var initialFacility = $('#facilitySelect').val();
            //         var contactNumber = $('#tempNumber').val();
            //         $('#reservationFacility').val(initialFacility);
            //         $('#tempReservationFacility').text(initialFacility);
            //         $('#contactNumber').val(contactNumber);
            //         $('#eventModal').modal('show');
            //     });


            //     element.append(wrapperDiv);
            // }

            // //Multi-purpose hall
            // function getEventsForCurrentAndFollowingDates() {
            //     var currentDateInManila = getCurrentDateInManila();
            //     var currentDate = new Date(currentDateInManila);
            //     var year = currentDate.getFullYear();
            //     var month = currentDate.getMonth();
            //     var lastDate = new Date(year, month + 1, 0).getDate();

            //     var eventsArray = [];

            //     eventsArray.push({
            //         start: currentDate
            //     });

            //     // Add events for the following dates in the same month
            //     for (var i = currentDate.getDate() + 1; i <= lastDate; i++) {
            //         var date = new Date(year, month, i);
            //         eventsArray.push({
            //             start: date
            //         });
            //     }

            //     return eventsArray;
            // }

            // function updateActivitySelect(valuesToShow) {
            //     $("#activitySelect option").hide();

            //     if (Array.isArray(valuesToShow)) {
            //         valuesToShow.forEach(function(value) {
            //             $("#activitySelect option[value='" + value + "']").show();
            //         });
            //     }

            //     $("#activitySelect").val(valuesToShow[0]);
            // }

            // $('#facilitySelect').on('change', function() {
            //     var selectedFacility = $(this).val();
            // var selectedDate = $('#reservationDate').val();

            // $('#calendar').fullCalendar('removeEvents');

            // $('#smallEvent').prop('checked', false);
            // $('#bigEvent').prop('checked', false);
            // $("#fileContainer").hide();
            // updateActivitySelect(["0"]);

            //Second Count for Time
            //     $.ajax({
            //         url: '/get-reservation-count',
            //         method: 'GET',
            //         data: {
            //             date: selectedDate,
            //             facilitySelect: selectedFacility,
            //         },
            //         success: function(response) {
            //             console.log(response.timeList);

            //             //Facility Ifs
            //             if (selectedFacility === 'Multi-Sports Hall') {
            //                 var eventsArray = getEventsForCurrentAndFollowingDates();
            //                 $('#calendar').fullCalendar('addEventSource', eventsArray);

            //                 $("#eventSelect").change(function() {
            //                     var valuesToShow;

            //                     if ($(this).val() != "") {
            //                         if ($(this).val() === "Small Event") {
            //                             valuesToShow = [
            //                                 "",
            //                                 "Training"
            //                             ];
            //                             $("#timeSelect").show();
            //                             $("#fileContainer").hide();
            //                         } else {
            //                             valuesToShow = [
            //                                 "",
            //                                 "Sportfest",
            //                                 "Concert",
            //                                 "Graduation",
            //                                 "Convention",
            //                                 "Religious"
            //                             ];
            //                             $("#timeSelect").hide();
            //                             $("#fileContainer").show();
            //                         }

            //                         updateActivitySelect(valuesToShow);
            //                     }
            //                 });
            //             } else if (selectedFacility === 'Aquatic Center') {
            //                 var eventsArray = getEventsForCurrentAndFollowingDates();
            //                 $('#calendar').fullCalendar('addEventSource', eventsArray);

            //                 $("#eventSelect").change(function() {
            //                     var valuesToShow;

            //                     if ($(this).val() != "") {
            //                         if ($(this).val() === "Small Event") {
            //                             valuesToShow = [
            //                                 "",
            //                                 "Training"
            //                             ];
            //                             $("#timeSelect").show();
            //                             $("#fileContainer").hide();
            //                         } else {
            //                             valuesToShow = [
            //                                 "",
            //                                 "Sportfest"
            //                             ];
            //                             $("#timeSelect").hide();
            //                             $("#fileContainer").show();
            //                         }

            //                         updateActivitySelect(valuesToShow);
            //                     }
            //                 });
            //             } else if (selectedFacility === '') {

            //             } else {
            //                 var eventsArray = getEventsForCurrentAndFollowingDates();
            //                 $('#calendar').fullCalendar('addEventSource', eventsArray);
            //                 $("#eventSelect").change(function() {
            //                     var valuesToShow;

            //                     if ($(this).val() != "") {
            //                         if ($(this).val() === "Small Event") {
            //                             valuesToShow = [
            //                                 "",
            //                                 "Training"
            //                             ];
            //                             $("#timeSelect").show();
            //                             $("#fileContainer").hide();
            //                         } else {
            //                             valuesToShow = [
            //                                 "",
            //                                 "Sportfest",
            //                                 "Concert",
            //                                 "Graduation",
            //                                 "Convention",
            //                                 "Religious"
            //                             ];
            //                             $("#timeSelect").hide();
            //                             $("#fileContainer").show();
            //                         }

            //                         updateActivitySelect(valuesToShow);
            //                     }
            //                 });
            //             }
            //         },
            //         error: function(xhr) {
            //             console.log(xhr);
            //             console.log(status);
            //             console.log(error);
            //             badge.empty();
            //             badge.text('Error loading slots');
            //         },
            //     });
            // });

            // $('#facilitySelect').on('change', function() {

            //     var selectedFacility = $(this).val();

            //     $('#facilitySelect').val(selectedFacility);
            // });

            // function addEventTitle(cell, title) {
            //     $('<div>')
            //         .text(title)
            //         .css({
            //             'color': '#fff ',
            //             'background-color': '#009688',
            //             'font-weight': 'bold',
            //             'padding': '5px 1.4rem',
            //             'border-radius': '5px',
            //             'position': 'absolute',
            //             'top': '50%',
            //             'left': '50%',
            //             'transform': 'translate(-50%, -50%)',
            //             'font-size': 'clamp(0.8rem, 1vw, 0.7rem)',
            //             'white-space': 'nowrap',
            //         })
            //         .appendTo(cell);

            //     window.matchMedia('(min-width: 601px)').addEventListener('change', (e) => {
            //         const displayValue = e.matches ? 'block' : 'none';
            //         cell.find('div').css('display', displayValue);
            //     });
            // }

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

            // Handle reservation form submission
            $('#createReservationBtn').on('click', function(event) {

                // Perform an AJAX request to check availability
                var selectedTime = $('#timeSelect').val();
                var reservationDate = $('#reservationDate').val();
                var facilitySelect = $('#facilitySelect').val();
                var rentersId = $('#rentersId').val();
                var eventSelect = $('#eventSelect').val();
                var categorySelect = $('#categorySelect').val();
                var activitySelect = $('#activitySelect').val();

                // Your existing variables

                var quantityAirconNumber = $('#quantityAirconNumber').val();
                var quantityChairNumber = $('#quantityChairNumber').val();

                var equipmentArray = [{
                        name: "Aircon",
                        value: quantityAirconNumber + " Units"
                    },
                    {
                        name: "Chair",
                        value: quantityChairNumber + " pcs"
                    }
                ];

                //new
                // var equipmentList = [];
                // // Extracting values from the HTML content
                // var itemsList = $('#reservationFacilityEquipment li');
                // if (itemsList.length > 0 && !itemsList.text().includes('No Available Item')) {
                //     itemsList.each(function() {
                //         var itemText = $(this).text();
                //         var itemName = itemText.split(' - ')[
                //             0]; // Assuming the format is "ItemName - ItemValue"
                //         var itemValue = itemText.split(' - ')[1];

                //         console.log("Item:", itemName.trim());
                //         console.log("Value:", itemValue.trim());

                //         // Creating an object with item name and value
                //         var equipmentItem = {
                //             name: itemName,
                //             value: itemValue, 
                //         };

                //         // Adding the object to the equipmentList array
                //         equipmentList.push(equipmentItem);
                //     });
                // } else {
                //     console.log("No items found");
                // }

                // var attachmentSelect = $('#attachmentSelect').val();
                var attachmentSelect = $('#attachmentSelect')[0].files[0];

                var rentersName = $('#rentersName').val();
                var contactNumber = $('#contactNumber').val();
                var address = $('#address').val();
                var organization = $('#organization').val();

                //Form Data
                // Create a FormData object
                var formData = new FormData();

                // Append simple key-value pairs
                formData.append('timeSelect', selectedTime);
                formData.append('reservationDate', reservationDate);
                formData.append('facilitySelect', facilitySelect);
                formData.append('rentersId', rentersId);
                formData.append('eventSelect', eventSelect);
                formData.append('categorySelect', categorySelect);
                formData.append('activitySelect', activitySelect);

                // Append the equipmentList array as JSON string
                // formData.append('equipmentList', equipmentList);
                formData.append('equipmentSelect', JSON.stringify(equipmentArray));

                // Append the file input
                formData.append('attachmentSelect', attachmentSelect);

                formData.append('rentersName', rentersName);
                formData.append('contactNumber', contactNumber);
                formData.append('address', address);
                formData.append('organization', organization);

                console.log(formData);

                $.ajax({
                    url: '/make-reservation/checkAvailability',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        rentersId: rentersId,
                        reservationDate: reservationDate,
                        timeSelect: selectedTime,
                        facilitySelect: facilitySelect,
                        eventSelect: eventSelect
                    },
                    success: function(response) {
                        if (response.is_available) {

                            $.ajax({
                                url: '/make-reservation/createReservation',
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                contentType: false,
                                processData: false,
                                data: formData,
                                
                                // {
                                //     rentersId: rentersId,
                                //     facilitySelect: facilitySelect,
                                //     eventSelect: eventSelect,
                                //     reservationDate: reservationDate,
                                //     categorySelect: categorySelect,
                                //     activitySelect: activitySelect,

                                //     //equipment
                                //     // equipmentSelect: equipmentSelect,
                                //     // quantityNum: quantityNum,
                                //     //equipment

                                //     equipmentList: equipmentList,

                                //     attachmentSelect: attachmentSelect,
                                //     timeSelect: selectedTime,

                                //     rentersName: rentersName,
                                //     contactNumber: contactNumber,
                                //     address: address,
                                //     organization: organization,

                                // },

                                success: function(response) {
                                    const fileName = 'OrderOfPayment.pdf';
                                    const content = document.querySelector(
                                        '.subpage');
                                    generateAndDownloadPDF(content, fileName);

                                    swal({
                                        title: 'Success',
                                        text: response.message,
                                        icon: 'success'
                                    }).then(function() {
                                        $('#eventModal').modal('hide');
                                        window.location.href =
                                            '/make-reservation';
                                    });
                                },
                                error: function(xhr) {
                                    if (xhr.status === 410) {
                                        var message = xhr.responseJSON.message;
                                        // Display SweetAlert error notification
                                        swal({
                                            icon: 'error',
                                            title: 'Not enough Available Inventory',
                                            text: message
                                        });
                                    } else {
                                        swal({
                                            title: 'Reservation Problem',
                                            content: {
                                                element: 'div',
                                                attributes: {
                                                    innerHTML: '<div style="text-align: left;">' +
                                                        'Error Creating Reservation:<br>' +
                                                        parseErrors(xhr
                                                            .responseText) +
                                                        '</div>',
                                                },
                                            },
                                            icon: 'error'
                                        });
                                        console.log(xhr.responseText);
                                    }
                                }
                            });
                        } else {
                            swal({
                                title: 'Warning',
                                text: response.message,
                                icon: 'warning'
                            });
                        }
                    },
                    error: function(xhr, error) {
                        if (xhr.status === 404) {
                            var message = xhr.responseJSON.message;
                            // Display SweetAlert error notification
                            swal({
                                icon: 'error',
                                title: 'Reservation in cooldown',
                                text: message
                            });
                        } else {
                            swal({
                                title: 'Error',
                                text: 'Failed to check availability. Please try again!!',
                                icon: 'error'
                            });
                        }

                    }
                });
            });

            /* NEW CODE FOR FULL CALENDAR */
            $('#previewReservationNext').on('click', function(event) {
                var reservationDate = $('#reservationDate').val();
                var rentersName = $('#rentersName').val();
                var address = $('#address').val();
                var selectedTime = $('#timeSelect').val();
                var organization = $('#organization').val();
                var facilitySelect = $('#facilitySelect').val();

                $('#orderLocation').text(address);
                $('#orderOrganization').text(organization);
                $('#orderName').text(rentersName);
                $('#reservationDateV1').text(reservationDate);
                $('#reservationPaymentDescription').text(selectedTime);
                $('#orderLocationReserve').text(facilitySelect);
                $('#orderNameReserve').text(rentersName);
            });

            $("#activitySelect, #categorySelect, #facilitySelect").on("change", function() {
                var categorySelect = $('#categorySelect').val();
                var activitySelect = $('#activitySelect').val();
                var facilitySelect = $('#facilitySelect').val();

                $.ajax({
                    url: '/make-reservation/labelPriceUpdate',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        categorySelect: categorySelect,
                        activitySelect: activitySelect,
                        facilitySelect: facilitySelect
                    },
                    success: function(response) {
                        var priceValue = parseFloat(response.priceLabel);
                        var priceText = !isNaN(priceValue) ?
                            priceValue.toLocaleString('en-PH', {
                                style: 'currency',
                                currency: 'PHP',
                                minimumFractionDigits: 2
                            }) :
                            'Price unavailable.';

                        $('#reservationPrice').text(priceText);
                        $('#reservationTotalPrice').text(priceText);
                    },
                    error: function(xhr, status, error) {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'There is a problem from Changing the Price Label:<br>' +
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

            function updateActivitySelect(valuesToShow) {
                $("#activitySelect option").hide();

                if (Array.isArray(valuesToShow)) {
                    valuesToShow.forEach(function(value) {
                        $("#activitySelect option[value='" + value + "']").show();
                    });
                }

            }

            function timeSelection(timeToShow) {
                $("#timeSelect option").hide();

                if (Array.isArray(timeToShow)) {
                    timeToShow.forEach(function(value) {
                        $("#timeSelect option[value='" + value + "']").show();
                    });
                }

            }

            timeSelection([""]);
            updateActivitySelect([""]);

            $('#facilitySelect').on('change', function() {
                var selectedFacility = $(this).val();
                var facilityName = $(this).find('option:selected').data('name');
                var facilityDescription = $(this).find('option:selected').data('description');
                var facilityImage = $(this).find('option:selected').data('image');

                $('#reservationFacilityName').text(facilityName);
                $('#reservationFacilityDescription').text(facilityDescription);
                $('#reservationFacilityImage').attr('src', facilityImage);

                $("#fileContainer").hide();

                if (selectedFacility === 'Multi-Sports Hall') {
                    var reserveDate = $('#reservationDate').val();

                    $(".small-event").show();
                    $(".big-event").show();
                    $("#equipmentNeeded").show();
                    $("#eventSelect").val("");
                    $("#timeSelect").val("");
                    $("#activitySelect").val("");
                    timeSelection([""]);
                    updateActivitySelect([""]);

                    $('#reservationFacilityEquipment').html(
                        "<ul><li><span>Aircon</span> - 8 Units </li><li>Chair - 200 pcs</li></ul>");

                    $.ajax({
                        url: '/timeMenuChanger',
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        data: {
                            reserveDate: reserveDate,
                            requestFacility: selectedFacility,
                        },
                        success: function(response) {

                            var updatedTimeOptions = response.updatedTimeOptions;
                            console.log(updatedTimeOptions);

                            var count = updatedTimeOptions.length;

                            if(count <= 3){
                                $('#eventSelect .big-event').hide();
                            }else{
                                $('#eventSelect .big-event').show();
                            }

                            $("#eventSelect").off("change").on("change", function() {
                                var selectedEvent = $(this).val();
                                var valuesToShow;
                                var timeToShow;

                                if (selectedEvent === "Small Event") {
                                    valuesToShow = [
                                        "",
                                        "Training"
                                    ];

                                    timeToShow = updatedTimeOptions;

                                    $("#timeSelectContainer").show();
                                    $("#fileContainer").hide();
                                } else {
                                    valuesToShow = [
                                        "",
                                        "Sportfest",
                                        "Concert",
                                        "Graduation",
                                        "Convention",
                                        "Religious"
                                    ];

                                    $("#timeSelectContainer").hide();
                                    $("#fileContainer").show();
                                }

                                if (selectedEvent === "") {
                                    valuesToShow = [
                                        ""
                                    ];
                                    timeToShow = [
                                        ""
                                    ];
                                    $("#fileContainer").hide();
                                }

                                $("#timeSelect").show();
                                timeSelection(timeToShow);
                                updateActivitySelect(valuesToShow);

                            });

                        },
                        error: function(xhr, status, error) {
                            swal({
                                title: 'Error',
                                content: {
                                    element: 'div',
                                    attributes: {
                                        innerHTML: '<div style="text-align: left;">' +
                                            'There is a problem from Changing the Time Menu:<br>' +
                                            parseErrors(xhr.responseText) +
                                            '</div>',
                                    },
                                },
                                icon: 'error'
                            });
                        },
                    });

                } else if (selectedFacility === 'Aquatic Center') {
                    var reserveDate = $('#reservationDate').val();

                    $(".small-event").show();
                    $(".big-event").show();
                    $("#equipmentNeeded").hide();
                    $("#eventSelect").val("");
                    $("#timeSelect").val("");
                    $("#activitySelect").val("");
                    timeSelection([""]);
                    updateActivitySelect([""]);

                    $('#reservationFacilityEquipment').html("<ul><li>No Available Item </li></ul>");

                    $.ajax({
                        url: '/timeMenuChanger',
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        data: {
                            reserveDate: reserveDate,
                            requestFacility: selectedFacility,
                        },
                        success: function(response) {
                            var updatedTimeOptions = response.updatedTimeOptions;
                            console.log(updatedTimeOptions);

                            var count = updatedTimeOptions.length;

                            if(count <= 3){
                                $('#eventSelect .big-event').hide();
                            }else{
                                $('#eventSelect .big-event').show();
                            }

                            $("#eventSelect").off("change").on("change", function() {
                                var selectedEvent = $(this).val();
                                var valuesToShow;
                                var timeToShow;

                                if (selectedEvent === "Small Event") {
                                    valuesToShow = [
                                        "",
                                        "Training"
                                    ];

                                    timeToShow = updatedTimeOptions;

                                    $("#timeSelectContainer").show();
                                    $("#fileContainer").hide();
                                } else {
                                    valuesToShow = [
                                        "",
                                        "Sportfest"
                                    ];

                                    $("#timeSelectContainer").hide();
                                    $("#fileContainer").show();
                                }

                                if (selectedEvent === "") {
                                    valuesToShow = [
                                        ""
                                    ];
                                    timeToShow = [
                                        ""
                                    ];
                                    $("#fileContainer").hide();
                                }

                                $("#timeSelect").show();
                                timeSelection(timeToShow);
                                updateActivitySelect(valuesToShow);

                            });
                            
                        },
                        error: function(xhr, status, error) {
                            swal({
                                title: 'Error',
                                content: {
                                    element: 'div',
                                    attributes: {
                                        innerHTML: '<div style="text-align: left;">' +
                                            'There is a problem from Changing the Time Menu:<br>' +
                                            parseErrors(xhr.responseText) +
                                            '</div>',
                                    },
                                },
                                icon: 'error'
                            });
                        },
                    });

                } else if (selectedFacility === '') {
                    $("#timeSelectContainer").show();
                    $("#equipmentNeeded").hide();
                    $("#fileContainer").hide();
                    $(".small-event").hide();
                    $(".big-event").hide();

                    $('#reservationFacilityEquipment').text("");
                }
            });

            // Function to get the date in the 'Asia/Manila' time zone
            function getCurrentDateInManila() {
                return new Date().toLocaleString('en-US', {
                    timeZone: 'Asia/Manila'
                }).split(',')[0];
            }

            function isDateInRange(date) {
                var currentDateInManila = getCurrentDateInManila();
                var currentDate = moment(currentDateInManila);
                var year = currentDate.year();
                var month = currentDate.month();
                var lastDate = moment(new Date(year, month + 1, 0)).date();

                return (
                    date.isSameOrAfter(currentDate) &&
                    currentDate.date() <= lastDate &&
                    date.month() === month
                );
            }

            function addEventTitle(cell, title) {
                if(title == "Not Available"){
                    $('<div>')
                    .text(title)
                    .css({
                        'color': '#fff ',
                        'background-color': 'red',
                        'font-weight': 'bold',
                        'padding': '5px 1.4rem',
                        'border-radius': '5px',
                        'position': 'absolute',
                        'top': '50%',
                        'left': '50%',
                        'transform': 'translate(-50%, -50%)',
                        'font-size': 'clamp(0.8rem, 1vw, 0.7rem)',
                        'white-space': 'nowrap',
                    })
                    .appendTo(cell);
                }else{
                    $('<div>')
                    .text(title)
                    .css({
                        'color': '#fff ',
                        'background-color': '#009688',
                        'font-weight': 'bold',
                        'padding': '5px 1.4rem',
                        'border-radius': '5px',
                        'position': 'absolute',
                        'top': '50%',
                        'left': '50%',
                        'transform': 'translate(-50%, -50%)',
                        'font-size': 'clamp(0.8rem, 1vw, 0.7rem)',
                        'white-space': 'nowrap',
                    })
                    .appendTo(cell);
                }
                

                window.matchMedia('(min-width: 601px)').addEventListener('change', (e) => {
                    const displayValue = e.matches ? 'block' : 'none';
                    cell.find('div').css('display', displayValue);
                });
            }

            function initialForm(date) {
                $('#reservationDate').val(date.format('MMMM D, YYYY'));

                $('#initialModal').modal('show');
            }

            function getEventTitle(cell) {
                return cell.find('.fc-event-title').text().trim();
            }


            var calendar = $('#calendar').fullCalendar({
                header: {
                    left: 'prev',
                    center: 'title',
                    right: 'next'
                },
                timeZone: 'Asia/Manila',
                editable: false,
                displayEventTime: true,

                selectable: true,
                selectHelper: true,

                // eventRender: function(event, element, view) {
                //     var date = event.start.format(
                //         'YYYY-MM-DD'); // Get the date of the event in 'YYYY-MM-DD' format
                //     var selectedFacility = $('#facilitySelect').val(); // Get the selected facility

                //     addButtonToCalendarDay(element, date, selectedFacility);
                // },

                // dayClick: function(date, jsEvent, view) {
                //     // return false; //Fasle Click
                //     if (isDateInRange(date)) {
                //         initialForm(date);
                //     }
                // },

                dayClick: function(date, jsEvent, view) {
                    var cell = $(this); // The clicked day cell
                    var eventTitle = getEventTitle(cell);

                    if (eventTitle === 'Not Available') {
                        // Prevent the action for "Not Available" days
                        return false;
                    }

                    // Your logic for available days
                    if (isDateInRange(date)) {
                        initialForm(date);
                    }
                },
                dayRender: function(date, cell) {
                    if (isDateInRange(date)) {
                        var jsDate = date._d;

                        // Rest of your code...
                        console.log(jsDate);

                        $.ajax({
                            url: '/get-reservation-count',
                            method: 'GET',
                            data: {
                                date: jsDate.toISOString(),
                            },
                            success: function(response) {
                                var totalSlots = 6;
                                var count = response.count;
                                var availableSlots = totalSlots - count;

                                if (availableSlots > 0) {
                                    cell.css({
                                        'background-color': '#d1ffe6',
                                        'cursor': 'pointer',
                                        'text-align': 'center',
                                        'position': 'relative'
                                    });

                                    addEventTitle(cell, 'Available');
                                    isDateClickable = true;
                                }else{
                                    cell.css({
                                        'background-color': '#fff1f8',
                                        'cursor': 'pointer',
                                        'text-align': 'center',
                                        'position': 'relative',
                                        'opacity': '0.5'
                                    });

                                    addEventTitle(cell, 'Not Available');
                                    isDateClickable = false;
                                }
                            },
                            error: function(xhr, status, error) {
                                // console.log(xhr);
                                // console.log(status);
                                // console.log(error);
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
                            },
                        });
                        
                        // cell.css({
                        //     'background-color': '#d1ffe6',
                        //     'cursor': 'pointer',
                        //     'text-align': 'center',
                        //     'position': 'relative'
                        // });

                        // addEventTitle(cell, 'Available');
                        // isDateClickable = true;
                    } else {
                        cell.css('background-color', '#fff1f8');
                        isDateClickable = false;
                    }
                }
            });
        });
    </script>
@endsection
