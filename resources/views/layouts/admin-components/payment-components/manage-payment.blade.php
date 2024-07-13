@extends('layouts.admin-app')

@section('content')
    <style>
        .statement-card {
            border: #000000 !important;
        }


        .th-account,
        .td-account {
            background: #fff !important;
        }

        .custom-container {
            border: 1px solid black;
            border-radius: 10px;
            padding: 20px;
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
            height: 300mm;
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
    </style>
    <div class="container-fluid content-wrapper">
        <div class="row m-1">

            <!-- Tabs navs -->
            <ul class="nav nav-tabs justify-content-between" id="ex-with-icons" role="tablist">
                <li class="nav-item text-start">
                    <a class="nav-link " style="color: rgb(0, 255, 106);">
                        <i class="fa-solid fa-receipt fa-fw fa-lg me-2"></i>Manage Payment Record
                    </a>
                </li>
                <ul class="nav nav-tabs justify-content-end" style="flex-grow: 1;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="ex-with-icons-tab-1" data-bs-toggle="tab"
                            href="#ex-with-icons-tabs-1" role="tab" aria-controls="ex-with-icons-tabs-1"
                            aria-selected="true">Unpaid</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex-with-icons-tab-2" data-bs-toggle="tab" href="#ex-with-icons-tabs-2"
                            role="tab" aria-controls="ex-with-icons-tabs-2" aria-selected="false">Paid</a>
                    </li>
                </ul>
            </ul>
            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content" id="ex-with-icons-content">
                <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-1">
                    <div class="col mt-3">
                        <h3 class=" fw-bold mb-4">Manage Unpaid Payment</h3>
                        <div class="col text-end pb-3">
                            <button type="submit" class="btn btn-outline-success text-capitalize ms-1"
                                data-bs-toggle="modal" data-bs-target="#addModal"><i
                                    class="fa-regular fa-square-plus text-outline-success"
                                    style="padding-right: 8px;"></i>Add
                                Payment</button>
                        </div>
                        <div class="table-responsive">
                            <table id="manage-payment" class="table table-striped table-hover nowrap table-sm"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Control Number</th>
                                        <th>Renters Name</th>
                                        <th>Amount</th>
                                        <th>Payment Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($addPayment as $payment)
                                        <tr>
                                            <td class="fw-bold">{{ $payment->control_no }}</td>
                                            <td>{{ $payment->name }}</td>
                                            <td>₱ {{ $payment->amount }}</td>
                                            <td>{{ $payment->date }}</td>
                                            <td>
                                                @if ($payment->status === 'Unpaid')
                                                    <button type="submit" class="btn btn-success paymentPaid"
                                                        data-bs-toggle="modal" data-id="{{ $payment->id }}"
                                                        data-bs-target="#approveModal">
                                                        <i class="fa-regular fa-circle-check fa-lg"></i></button>
                                                @endif
                                                <button type="submit" class="btn btn-warning paymentUpdate"
                                                    data-bs-toggle="modal" data-id="{{ $payment->id }}"
                                                    data-name="{{ $payment->name }}" data-amount="{{ $payment->amount }}"
                                                    data-date="{{ $payment->date }}"
                                                    data-reservation="{{ $payment->reservationId }}"
                                                    data-bs-target="#updateModal"><i class="fas fa-pen"></i></button>
                                                <button type="submit" class="btn btn-info paymentView"
                                                    data-bs-toggle="modal" data-id="{{ $payment->id }}"
                                                    data-reservation="{{ $payment->reservationId }}"
                                                    data-bs-target="#viewModal"><i class="fas fa-eye"></i></button>
                                                <button type="submit" class="btn btn-danger paymentDelete"
                                                    data-bs-toggle="modal" data-id="{{ $payment->id }}"
                                                    data-bs-target="#deleteModal"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
                    <div class="col mt-3">
                        <h3 class="fw-bold mb-4">Paid Payment</h3>
                        <div class="table-responsive">
                            <table id="paid-payment" class="table table-striped table-hover nowrap table-sm"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Control Number</th>
                                        <th>Renters Name</th>
                                        <th>Amount</th>
                                        <th>Payment Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($addPaidPayment as $paidPayment)
                                        <tr>
                                            <td class="fw-bold">{{ $paidPayment->control_no }}</td>
                                            <td>{{ $paidPayment->name }}</td>
                                            <td>₱ {{ $paidPayment->amount }}</td>
                                            <td>{{ $paidPayment->date }}</td>
                                            <td>
                                                <button type="submit" class="btn btn-danger paymentDelete"
                                                    data-bs-toggle="modal" data-id="{{ $paidPayment->id }}"
                                                    data-bs-target="#deleteModal"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabs content -->

        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="viewModalLabel">View Pre-Receipt Payment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="page">
                        <div class="subpage">
                            <div class="container mb-5 mt-3">
                                <div class="d-flex justify-content-center">
                                    <div class="row">
                                        <div class="col-xl-3 col-md-3 col-sm-3">
                                            <img src="{!! url('assets/images/cabuyao-icon.png') !!}" alt="" width="110px">
                                        </div>
                                        <div class="col-xl-9 col-md-9 col-sm-9 text-center text-uppercase pt-2">
                                            <p class="lh-sm">Republic of the Philippines <br>
                                                <span class="fw-bold">City of Cabuyao</span><br>Province of
                                                Laguna<br><br><span class="fw-bold">Cabuyao Athletes Basic
                                                    School</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div class="container">

                                    <div class="row text-end">
                                        <div class="col-xl-10">
                                            <ul class="list-unstyled">
                                                <li class="text-uppercase lh-sm">CONTROL NO:</li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-2">
                                            <ul class="list-unstyled">
                                                <li class="text-uppercase lh-sm pt-3">
                                                    <div id="signature"></div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row mx-1 justify-content-center">
                                        <table class="table table-bordered table-sm statement-card">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-center th-account" colspan="2">
                                                        Rental Information
                                                    </th>
                                                </tr>

                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td class="td-account">Full Name: <span id="paymentNameModal"></span>
                                                    </td>
                                                    <td class="td-account">Contact Number: <span
                                                            id="paymentContactModal"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Name of Organization: <span
                                                            id="paymentOrganizationModal"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Address:</td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Name of Event: <span
                                                            id="paymentActivityModal"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Type of Activity: <span
                                                            id="paymentEventModal"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Facility to Reserve: <span
                                                            id="paymentFacilityModal"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account">Reservation Date: <span
                                                            id="paymentDateModal"></span></td>
                                                    <td class="td-account">Time: <span id="paymentTimeEventModal"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" style="padding-bottom: 30px;" colspan="2">
                                                        Equipment Needed: <span id="paymentEquipmentModal"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center text-uppercase td-account fw-bold"
                                                        colspan="2">General Guidelines in the use of facilities</td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">
                                                        @foreach ($guidelines as $guideline)
                                                            <p>{{ $guideline->description }}</p>
                                                        @endforeach
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 text-center">
                                            <p>I hereby read, understood and agree to faithfully comply with Cabuyao
                                                Athletes Basic School’s House Rules and any other existing policies
                                                implemented by the Cabuyao Athletes Basic School.</p>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-between mx-2">
                                        <div class="col-xl-5">
                                            <p class="mt-4">Conforme:</p>
                                            <div id="signature" class="mt-5"></div>
                                            <p class="text-center">Signature Over Printed Name
                                                <br>
                                                Renters
                                            </p>
                                        </div>
                                        <div class="col-xl-6">
                                            <ul class="list-unstyled">
                                                <li class="text-muted mt-4"><span class="text-black me-4">Approved by:
                                                </li>
                                                <li class="mt-5">
                                                    <div id="signature"></div>
                                                </li>
                                                <li class="text-muted text-center">
                                                    <span class="text-black ">Signature Over Printed Name
                                                    </span>
                                                    <br>
                                                    <span class="text-black">Cabs Facility Administrator</span>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="page">
                        <div class="subpage">
                            <div class="container mb-5 mt-3">
                                <div class="d-flex justify-content-center">
                                    <div class="row">
                                        <div class="col-xl-3 col-md-3 col-sm-3">
                                            <img src="{!! url('assets/images/cabuyao-icon.png') !!}" alt="" width="110px">
                                        </div>
                                        <div class="col-xl-9 col-md-9 col-sm-9 text-center text-uppercase pt-2">
                                            <p class="lh-sm">Republic of the Philippines <br>
                                                <span class="fw-bold">City of Cabuyao</span><br>Province of
                                                Laguna<br><br><span class="fw-bold">Cabuyao Athletes Basic School</span>
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
                                                <li class="text-uppercase lh-sm require-fill-up">Requested Facility:
                                                </li>
                                                <li class="text-uppercase lh-sm require-fill-up pb-3">Address:
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
                                                <li class="text-uppercase lh-sm require-fill-up pb-2">Bgy. Banay Banay,
                                                    City of Cabuyao
                                                    <div id="signature">
                                                </li>
                                                <li class="text-uppercase">
                                                    <span id="orderOrganization"></span>,
                                                    <span id="orderName"></span>
                                                    <div id="signature">
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="row mb-2 mx-1 justify-content-center">
                                        <table class="table table-bordered table-sm statement-card">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase th-account">Reservation Date</th>
                                                    <th class="text-uppercase th-account">Description</th>
                                                    <th class="text-uppercase th-account">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="td-account text-center"><span
                                                            id="paymentDateModalV"></span></td>
                                                    <td class="td-account"> <span id="paymentDescription"></td>
                                                    <td class="td-account">NB: The amount to be paid <br> covers the usage
                                                        of their <br>rent from <span id="orderLocationReserve"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-uppercase td-account fw-bold">Total</td>
                                                    <td class="td-account"> </td>
                                                    <td class="td-account fw-bold">Php <span
                                                            id="paymentPriceModal"></span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <p>Please make checks payable to : <span class="fw-bold text-uppercase">City
                                                    Treasure of Cabuyao</span></p>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-xl-5">
                                            <p class="mt-4">Prepared by:</p>
                                            <p class="mt-5"><span class="fw-bold text-uppercase">Ruben L. Morales</span>
                                                <br>
                                                OIC CABS
                                            </p>

                                            <p class="mt-5">Approved by:</p>
                                            <p class="mt-5"><span class="fw-bold text-uppercase">Mr. Librado DG.
                                                    Dimaunahan</span>
                                                <br>
                                                CITY ADMINISTRATOR
                                            </p>
                                        </div>
                                        <div class="col-xl-6">
                                            <ul class="list-unstyled mt-4">
                                                <li class="text-muted ms-3"><span class="text-black me-4">Conforme:
                                                </li>
                                                <li class="mt-5 text-center fw-bold" style="padding-left: 1rem">
                                                    <span id="orderNameReserve"></span>
                                                    <div id="signature">
                                                    </div>
                                                </li>
                                                <li class="text-muted" style="padding-left: 3rem">
                                                    <span class="text-black fw-bold text-uppercase">Clients Name and
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


                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <div class="px-2">
                            <strong>Attention!</strong> This is the details of the renters that reserve.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Generate Pre-receipt</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="addModalLabel">Add Payment List</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="renterName" class="form-label">Renter Name</label>
                        <input type="text" class="form-control" id="renterName">
                    </div>

                    <label for="paymentAmount" class="form-label">Amount</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">₱ </span>
                        <input type="number" class="form-control" id="paymentAmount" name="paymentAmount" required>
                    </div>

                    <div class="mb-3">
                        <label for="paymentDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="paymentDate" name="paymentDate">
                    </div>

                    <div class="mb-3 text-center text-uppercase">
                        <h5 class=" fw-bold">Reservation List</h5>
                    </div>
                    <div class="mb-3">
                        <div class="table-responsive">
                            <table id="table-facilities" class="table table-striped table-hover table-bordered"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Reservation ID</th>
                                        <th>Facility Reserve</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approvedReservations as $approvedReservation)
                                        <tr>
                                            <td>{{ $approvedReservation->id }}</td>
                                            <td>{{ $approvedReservation->facility }}</td>
                                            <td><button type="submit" class="btn btn-success selectReservation"
                                                    data-id="{{ $approvedReservation->id }}"
                                                    data-name="{{ $approvedReservation->name }}"><span
                                                        class="fw-bold">Select</span></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p>The reservation to pay: <span id="reservationIdToPay"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success addPaymentBtn">Add Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Payment Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="updateModalLabel">Update Payment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h3>Update Invoice No. <span id="paymentId"></span></h3>
                    <hr>

                    <div class="mb-3">
                        <label for="renterName" class="form-label">Renter Name</label>
                        <input type="text" class="form-control" id="updateRenterName" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="paymentAmount" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="updatePaymentAmount">
                    </div>
                    <div class="mb-3">
                        <label for="paymentDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="updatePaymentDate">
                    </div>

                    <div class="mb-3 text-center text-uppercase">
                        <h5 class=" fw-bold">Reservation List</h5>
                    </div>
                    <div class="mb-3">
                        <div class="table-responsive">
                            <table id="table-facilities" class="table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Reservation ID</th>
                                        <th>Facility Reserve</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approvedReservations as $approvedReservation)
                                        <tr>
                                            <td>{{ $approvedReservation->id }}</td>
                                            <td>{{ $approvedReservation->facility }}</td>
                                            <td><button type="submit" class="btn btn-success selectUpdateReservation"
                                                    data-id="{{ $approvedReservation->id }}"
                                                    data-name="{{ $approvedReservation->name }}"><span
                                                        class="fw-bold">Select</span></button></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p>Updated reservation to pay: <span id="updateReservationIdToPay"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning paymentUpdateBtn">Update Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Payment Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteModalLabel">Delete Payment</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this invoice no. <span id="deletePaymentId"></span>? </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="paymentDeleteBtn" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Request List Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="approvePaymentBtnModalLabel">Approve Request List</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Confirm Payment?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="approvePaymentBtn" class="btn btn-success">Approve</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function addPayment() {
            $('.addPaymentBtn').click(function() {
                var reservationId = $("#reservationIdToPay").text();
                var reservationName = $("#renterName").val();
                var paymentAmount = $("#paymentAmount").val();
                var paymentDate = $("#paymentDate").val();

                $.ajax({
                    url: '/admin/payment/addPayment',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        reservedId: reservationId,
                        reserveeName: reservationName,
                        amount: paymentAmount,
                        date: paymentDate,

                    },
                    success: function(response) {
                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: 'Add Payment Successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '/admin/payment/manage';
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Problem for Adding Payment: <br>' +
                                        parseErrors(xhr.responseText) +
                                        '</div>',
                                },
                            },
                            icon: 'error'
                        });
                    }
                });
            });

            $('.selectReservation').click(function() {
                var reservationId = $(this).data('id');
                var reservationName = $(this).data('name');

                $("#reservationIdToPay").text(reservationId);
                $("#renterName").val(reservationName);
            });
        }

        function updatePayment() {
            $('.paymentUpdate').click(function() {
                var paymentId = $(this).data('id');
                var reserveeName = $(this).data('name');
                var paymentAmount = $(this).data('amount');
                var paymentDate = $(this).data('date');
                var reservationId = $(this).data('reservation');

                $("#paymentId").text(paymentId);
                $("#updateRenterName").val(reserveeName);
                $("#updatePaymentAmount").val(paymentAmount);
                $("#updatePaymentDate").val(paymentDate);
                $("#updateReservationIdToPay").text(reservationId);
            });

            $('.selectUpdateReservation').click(function() {
                var reservationId = $(this).data('id');
                var reserveeName = $(this).data('name');

                $("#updateReservationIdToPay").text(reservationId);
                $("#updateRenterName").val(reserveeName);
            });

            $('.paymentUpdateBtn').click(function() {
                var paymentId = $("#paymentId").text();
                var reservationName = $("#updateRenterName").val();
                var paymentAmount = $("#updatePaymentAmount").val();
                var paymentDate = $("#updatePaymentDate").val();
                var reservationId = $("#updateReservationIdToPay").text();

                $.ajax({
                    url: '/admin/payment/updatePayment',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id: paymentId,
                        reservedId: reservationId,
                        reserveeName: reservationName,
                        amount: paymentAmount,
                        date: paymentDate,

                    },
                    success: function(response) {
                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: 'Payment Updated Successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href = '/admin/payment/manage';
                        });
                    },
                    error: function(xhr) {
                        swal({
                            title: 'Error',
                            content: {
                                element: 'div',
                                attributes: {
                                    innerHTML: '<div style="text-align: left;">' +
                                        'Error Problem for Updating Payment: <br>' +
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

        // function deletePayment() {
        $('.paymentDelete').click(function() {
            var reservationId = $(this).data('id');

            $("#deletePaymentId").text(reservationId);
        });

        $('#paymentDeleteBtn').click(function() {
            var paymentId = $("#deletePaymentId").text();

            $.ajax({
                url: '/admin/payment/deletePayment/' + paymentId,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // Handle the success response
                    swal({
                        title: 'Success',
                        text: 'Payment Deleted Successfully',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/payment/manage';
                    });
                },
                error: function(xhr) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Problem for Deleting Payment: <br>' +
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

        $('.paymentView').click(function() {
            var paymentId = $(this).data('id');
            var paymentReservationId = $(this).data('reservation');

            console.log(paymentReservationId);

            $.ajax({
                url: '/admin/payment/viewPayment',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    id: paymentId,
                    reservationId: paymentReservationId,
                },
                success: function(response) {
                    var recipientName = response.recipientName;
                    var recipientEmail = response.recipientEmail;
                    var recipientOrganization = response.recipientOrganization;
                    var recipientContact = response.recipientContact;
                    var reservationEventType = response.reservationEventType;
                    var reservationActivity = response.reservationActivity;
                    var reservationFacility = response.reservationFacility;
                    var reservationDate = response.reservationDate;
                    var reservationTime = response.reservationTime;
                    var reservationEquipment = response.reservationEquipment;
                    var payments = response.payment;

                    $('#paymentNameModal').text(recipientName);
                    $('#paymentEmailModal').text(recipientEmail);
                    $('#paymentOrganizationModal').text(recipientOrganization);
                    $('#paymentContactModal').text(recipientContact);

                    $('#paymentEventModal').text(reservationEventType);
                    $('#paymentActivityModal').text(reservationActivity);
                    $('#paymentFacilityModal').text(reservationFacility);
                    $('#paymentDateModal').text(reservationDate);
                    $('#paymentDateModalV').text(reservationDate);
                    $('#paymentTimeEventModal').text(reservationTime);
                    $('#paymentDescription').text(reservationActivity);
                    $('#paymentEquipmentModal').text(reservationEquipment);
                    $('#paymentPriceModal').text(payments['amount']);

                    $('#orderOrganization').text(recipientOrganization);
                    $('#orderName').text(recipientName);
                    $('#orderLocation').text(reservationFacility);
                    $('#orderLocationReserve').text(reservationFacility);
                    $('#orderNameReserve').text(recipientName);
                },
                error: function(xhr) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Problem for Viewing Payment: <br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });

        function approvePayment() {
            $('.paymentPaid').click(function() {
                var paymentId = $(this).data('id');

                $('#approvePaymentBtn').data('id', paymentId);
                $('#approvePaymentBtnModalLabel').text('Payment Id: ' + paymentId);
            });

            $('#approvePaymentBtn').click(function() {
                var paymentId = $(this).data('id');

                $.ajax({
                    url: '/admin/payment/approvePayment',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        id: paymentId,
                    },
                    success: function(response) {
                        var reservationId = response.reservationId;
                        // $.ajax({
                        //     url: '/admin/payment/approvePayment',
                        //     type: 'POST',
                        //     headers: {
                        //         'X-CSRF-TOKEN': csrfToken
                        //     },
                        //     data: {
                        //         id: paymentId,
                        //     },
                        //     success: function(response) {
                        //         var reservationId = response.reservationId;
                        //         var renterId = response.reservationId;
                        //         $.ajax({
                        //             url: '/admin/reservation/approveReservation',
                        //             type: 'POST',
                        //             headers: {
                        //                 'X-CSRF-TOKEN': csrfToken
                        //             },
                        //             data: {
                        //                 reservationId: reservationId,
                        //                 recipientId: renterId,
                        //             },
                        //             success: function(response) {
                        //                 alertify.success('Reservation has also been Approved successfully');
                        //             },
                        //             error: function(xhr) {
                        //                 swal({
                        //                     title: 'Error',
                        //                     content: {
                        //                         element: 'div',
                        //                         attributes: {
                        //                             innerHTML: '<div style="text-align: left;">' +
                        //                                 'Error Problem for Approving Payment:<br>' +
                        //                                 parseErrors(xhr.responseText) +
                        //                                 '</div>',
                        //                         },
                        //                     },
                        //                     icon: 'error'
                        //                 }).then(function() {
                        //                     window.location.href = '/admin/reservation/review';
                        //                 });
                        //             }
                        //         });

                        //         // Handle the success response
                        //         swal({
                        //             title: 'Success',
                        //             text: response.message,
                        //             icon: 'success'
                        //         }).then(function() {
                        //             window.location.href = '/admin/payment/manage';
                        //         });
                        //     },
                        //     error: function(xhr) {
                        //         swal({
                        //             title: 'Error',
                        //             content: {
                        //                 element: 'div',
                        //                 attributes: {
                        //                     innerHTML: '<div style="text-align: left;">' +
                        //                         'Error Problem for Approving Payment: <br>' +
                        //                         parseErrors(xhr.responseText) +
                        //                         '</div>',
                        //                 },
                        //             },
                        //             icon: 'error'
                        //         });
                        //     }
                        // });

                        // Handle the success response
                        swal({
                            title: 'Success',
                            text: response.message,
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
                                        'Error Problem for Approving Payment: <br>' +
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

        $(document).ready(function() {

            $('#manage-payment').dataTable({
                responsive: true,
                fixedheader: true,
                "order": [
                    [0, "desc"]
                ],
                drawCallback: function(settings) {
                    addPayment();
                    updatePayment();
                    approvePayment();
                }
            });

            $('#paid-payment').dataTable({
                responsive: true,
                fixedheader: true,
                "order": [
                    [0, "desc"]
                ]
            });


            $('#table-facilities').dataTable({
                responsive: true,
                fixedheader: true,
            });

        });
    </script>
@endsection
