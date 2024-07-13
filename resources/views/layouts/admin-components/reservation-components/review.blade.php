@extends('layouts.admin-app')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.css">
    <style>
        .review-modal-font {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.75rem;
            margin: 0 0 1rem 0;
            color: #999;
        }


        .avatar-md {
            height: 5rem;
            width: 5rem;
        }

        .fs-19 {
            font-size: 19px;
        }

        .fs-14 {
            font-size: 14px;
        }

        .bg-soft-secondary {
            background-color: rgba(116, 120, 141, .15) !important;
            color: #74788d !important;
        }

        .th-account,
        .td-account {
            background: #fff !important;
        }

        .statement-card {
            border: #000000 !important;
        }

        .latest-item {
            background-color: #ffff99;
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
            background-color: #ef8354;
            border-radius: 50%;
            margin-right: 5px;
        }

        .dot1 {
            height: 10px;
            width: 10px;
            background-color: #1f7a8c;
            border-radius: 50%;
            margin-right: 5px;
        }

        .dot2 {
            height: 10px;
            width: 10px;
            background-color: blue;
            border-radius: 50%;
            margin-right: 5px;
        }
    </style>
    <div class="container-fluid content-wrapper">
        <div class="row m-1">
            <!-- Tabs navs -->
            <ul class="nav nav-tabs justify-content-between" id="ex-with-icons" role="tablist">
                <li class="nav-item text-start">
                    <a class="nav-link " style="color: rgb(255, 187, 0);">
                        <i class="fa-regular fa-calendar fa-fw fa-lg me-2"></i>Reservation
                    </a>
                </li>
                <ul class="nav  nav-tabs justify-content-end" style="flex-grow: 1;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="ex-with-icons-tab-1" data-bs-toggle="tab"
                            href="#ex-with-icons-tabs-1" role="tab" aria-controls="ex-with-icons-tabs-1"
                            aria-selected="true">Pending</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex-with-icons-tab-2" data-bs-toggle="tab" href="#ex-with-icons-tabs-2"
                            role="tab" aria-controls="ex-with-icons-tabs-2" aria-selected="false">Approved</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex-with-icons-tab-3" data-bs-toggle="tab" href="#ex-with-icons-tabs-3"
                            role="tab" aria-controls="ex-with-icons-tabs-3" aria-selected="false">Cancelled</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex-with-icons-tab-4" data-bs-toggle="tab" href="#ex-with-icons-tabs-4"
                            role="tab" aria-controls="ex-with-icons-tabs-4" aria-selected="false">Customization</a>
                    </li>
                </ul>
            </ul>


            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content" id="ex-with-icons-content">
                <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-1">
                    <h3 class=" fw-bold my-4">Pending Reservation</h3>
                    <div class="table-responsive">
                        <table id="pending-reservation" class="table table-hover nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Facility</th>
                                    <th>Date</th>
                                    <th>Time Category</th>
                                    <th>Event Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $latestItem = $addReviewItems->first();
                                @endphp

                                @foreach ($addReviewItems->sortByDesc('created_at') as $addReviewItem)
                                    <tr @if ($addReviewItem->id === $latestItem->id) class="latest-item" @endif>
                                        <td>{{ $addReviewItem->id }}</td>
                                        <td>{{ $addReviewItem->name }}</td>
                                        <td>{{ $addReviewItem->facility }}</td>
                                        <td>{{ $addReviewItem->date }}</td>
                                        <td>{{ $addReviewItem->event_type }}</td>
                                        <td>{{ $addReviewItem->time }}</td>
                                        <td>
                                            <button type="submit" class="btn btn-success reviewReservationBtn"
                                                data-id="{{ $addReviewItem->id }}"
                                                data-equipment="{{ $addReviewItem->equipment_needed }}"
                                                data-bs-toggle="modal" data-bs-target="#reviewModal">Review
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
                    <h3 class=" fw-bold my-4">Approved Reservation</h3>
                    <div class="table-responsive">
                        <table id="approve-reservation" class="table table-hover nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Facility</th>
                                    <th>Date</th>
                                    <th>Time Category</th>
                                    <th>Assign Staff</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($approvedReviewItems as $approvedReviewItem)
                                    <tr>
                                        <td>{{ $approvedReviewItem->name }}</td>
                                        <td>{{ $approvedReviewItem->facility }}</td>
                                        <td>{{ $approvedReviewItem->date }}</td>
                                        <td>{{ $approvedReviewItem->time }}</td>
                                        @php
                                            $staffData = json_decode($approvedReviewItem->staff, true);
                                            $name = isset($staffData[0][1]) ? $staffData[0][1] : '';
                                        @endphp

                                        <td>
                                            @if ($staffData)
                                            @foreach ($staffData as $staff)
                                                {{ $staff[1] }} <br>
                                            @endforeach
                                            @else
                                                No Staff Assigned
                                            @endif
                                        </td>

                                        <td>
                                            <button type="submit" class="btn btn-danger adminReservationCancel"
                                                data-bs-toggle="modal" data-id="{{ $approvedReviewItem->id }}"
                                                data-recipient="{{ $approvedReviewItem->recipientId }}"
                                                data-bs-target="#cancelModal">
                                                <i class="fa-solid fa-ban" style="color: #ffffff;"></i> Cancel
                                            </button>

                                            <button type="submit" class="btn btn-warning adminReservationAssignUpdate"
                                                data-bs-toggle="modal" data-id="{{ $approvedReviewItem->id }}"
                                                data-bs-target="#assignModal">
                                                <i class="fa-solid fa-pencil" style="color: #ffffff;"></i> Update
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="ex-with-icons-tabs-3" role="tabpanel" aria-labelledby="ex-with-icons-tab-3">
                    <h3 class=" fw-bold my-4">Cancelled Reservation</h3>
                    <div class="table-responsive">
                        <table id="cancel-reservation" class="table table-hover nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Reservation ID</th>
                                    <th>Name</th>
                                    <th>Facility</th>
                                    <th>Date</th>
                                    <th>Time Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($declinedReviewItems as $declinedReviewItem)
                                    <tr>
                                        <td>{{ $declinedReviewItem->id }}</td>
                                        <td>{{ $declinedReviewItem->name }}</td>
                                        <td>{{ $declinedReviewItem->facility }}</td>
                                        <td>{{ $declinedReviewItem->date }}</td>
                                        <td>{{ $declinedReviewItem->time }}</td>
                                        <td>
                                            <button type="submit" class="btn btn-success btnReasonView"
                                                data-bs-toggle="modal" data-reason="{{ $declinedReviewItem->reason }}"
                                                data-bs-target="#cancelDetailsModal">Details</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="ex-with-icons-tabs-4" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-4">
                    <h3 class=" fw-bold my-4">Reservation Customization</h3>
                    <div class="row">
                        <!-- Reservation Price -->
                        <div class="col-lg-6 col-md-6 col-12 pt-2">
                            <div class="card border-0 bg-light rounded shadow">
                                <div class="card-body p-4">
                                    <span class="badge rounded-pill bg-info float-md-end mb-3 mb-sm-0">Regular</span>
                                    <h5 class="text-muted fw-bold">Modify Reservation Price</h5>
                                    <div class="mt-3">
                                        <span class="text-muted d-block">Adjust the price for reservations</span>
                                    </div>

                                    <div class="mt-3">
                                        <a href="#" class="btn btn-info text-white" data-bs-toggle="modal"
                                            data-bs-target="#editPriceModal">Edit Price</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Guidelines -->
                        <div class="col-lg-6 col-md-6 col-12 pt-2">
                            <div class="card border-0 bg-light rounded shadow">
                                <div class="card-body p-4">
                                    <span class="badge rounded-pill bg-danger float-md-end mb-3 mb-sm-0">Contract</span>
                                    <h5 class="text-muted fw-bold">Manage Guidelines</h5>
                                    <div class="mt-3">
                                        <span class="text-muted d-block">Edit contract guidelines and terms</span>
                                    </div>

                                    <div class="mt-3">
                                        <a href="#" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#editGuidelinesModal">Edit Guidelines</a>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->

                        {{-- Business Number --}}
                        <div class="col-lg-6 col-md-6 col-12 pt-2">
                            <div class="card border-0 bg-light rounded shadow">
                                <div class="card-body p-4">
                                    <span class="badge rounded-pill bg-success float-md-end mb-3 mb-sm-0">Contacts</span>
                                    <h5 class="text-muted fw-bold">Modify Business Contacts</h5>
                                    <div class="mt-3">
                                        <span class="text-muted d-block">Change the Current Contacts for the Website</span>
                                    </div>

                                    <div class="mt-3">
                                        <a href="#" class="btn btn-success text-white" data-bs-toggle="modal"
                                            data-bs-target="#editBusinessNumberModal">Edit Contacts</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!--end row-->
                </div>
            </div>
            <!-- Tabs content -->
        </div>
    </div>

    <!-- Cancel Details Modal -->
    <div class="modal fade" id="cancelDetailsModal" tabindex="-1" aria-labelledby="cancelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="cancelModalLabel">Reason for Cancelled Reservation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="reasonDetails" class="my-2">
                        <!-- Reason Details Text -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="reviewModalLabel">Review Reservation </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Tabs content -->
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
                                        <div class="col-xl-11">
                                            <ul class="list-unstyled">
                                                <li class="text-uppercase lh-sm">CONTROL NO: </li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-1 text-start">
                                            <ul class="list-unstyled">
                                                <li class="text-uppercase lh-sm">
                                                    <span id="reservationId"></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <span style="display:none" id="reservationRecipientId"></span>
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
                                                    <td class="td-account">Full Name: <span
                                                            id="reservationRecipientName"></span></td>
                                                    <td class="td-account">Contact Number: <span
                                                            id="reservationContact"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Name of Organization: <span
                                                            id="reservationOrganization"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Address: <span
                                                            id="reservationAddress"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Name of Event: <span
                                                            id="reservationEvent"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Type of Activity: <span
                                                            id="reservationAct"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Facility to Reserve: <span
                                                            id="reservationLocation"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account">Reservation Date: <span
                                                            id="reservationDate"></span></td>
                                                    <td class="td-account">Time: <span id="reservationTime"></span></td>
                                                </tr>
                                                <tr id="equipmentList">
                                                    <td class="td-account" style="padding-bottom: 30px;" colspan="2">
                                                        Equipment Needed: <span class="reservationEquipment"></span>
                                                        (x<span class="reservationQuantity"></span>)
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center text-uppercase td-account fw-bold"
                                                        colspan="2">General Guidelines in the use of facilities</td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">
                                                        @foreach ($guidelines as $key => $guideline)
                                                            <p>{{ $key + 1 }} {{ $guideline->description }}</p>
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
                        <div class="subpage" id="page">
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
                                                    <th class="text-uppercase th-account">Reservation Date</th>
                                                    <th class="text-uppercase th-account">Description</th>
                                                    <th class="text-uppercase th-account">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="td-account text-center"><span id="reservationDate1"></span>
                                                    </td>
                                                    <td class="td-account text-center"><span
                                                            id="reservationPaymentDescription"></td>
                                                    <td class="td-account">NB: The amount to be paid <br> covers the usage
                                                        of their <br>rent from <span id="orderLocationReserve"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-uppercase td-account fw-bold">Total</td>
                                                    <td class="td-account"></td>
                                                    <td class="td-account fw-bold">Php <span id="reservationPrice"></span>
                                                    </td>
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
                </div>

                <div class="modal-footer">
                    <button type="button" id="reviewAttachment" class="btn btn-primary">Attachment</button>

                    <button type="button" class="btn btn-success approveReservationBtn" data-bs-toggle="modal"
                        data-bs-target="#assignModal">Approve</button>
                    <button type="button" class="btn btn-danger declineReservationBtn" data-bs-toggle="modal"
                        data-bs-target="#cancelModal">Decline</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Assign Modal -->
    <div class="modal fade" id="assignModal" data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="assignModalLabel">Assign Staff</h4>
                    <a href="{{ route('admin.reservation.review') }}">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="form-group row">
                            <p class="fw-bold text-muted">Reservation ID: <span id="resId"></span></p>
                        </div>
                        <div class="table-responsive staffResList">
                            <table id="staffResList" class="table table-hover nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Schedule</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="availableStaffList">
                                    {{-- @php
                                        
                                    @endphp
                                    @foreach ($addStaffs as $addStaff)
                                        <tr>
                                            <td>
                                                <h5 class="fw-bold mb-0">{{ $addStaff->name }}</h5>
                                                <span class="text-muted badge bg-soft-secondary">Staff</span>
                                            </td>
                                            <td>
                                                <button data-id="{{ $addStaff->id }}" data-name="{{ $addStaff->name }}"
                                                    class="btn btn-primary rounded-0 assignRStaffBtn">Assign</button>
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('admin.reservation.review') }}">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Modal -->
    <div class="modal fade" id="viewCalendar" tabindex="-1" aria-labelledby="viewCalendarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="staffModalLabel"><span id="staffName"></span> Schedule</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="pb-3">
                        <div class="legend">

                            <p class="legend-text px-4 fw-bold">Legend :</p>

                            <div class="legend-item">
                                <span class="dot"></span>
                                <p class="legend-text px-2">Maintenance Task</p>
                            </div>
                            <div class="legend-item">
                                <span class="dot1"></span>
                                <p class="legend-text">Reservation <span class="text-muted">(Big-Event)</span></p>
                            </div>

                            <div class="legend-item">
                                <span class="dot2"></span>
                                <p class="legend-text">Reservation <span class="text-muted">(Small-Event)</span></p>
                            </div>
                        </div>
                    </div>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="cancelModalLabel">Cancel Reservation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-2">
                        <label for="exampleFormControlTextarea1" class="form-label">Reason:</label>
                        <textarea class="form-control" id="reasonForm" rows="5"></textarea>
                        <input type="text" id="confirmReservationId" class="form-control" style="display:none"
                            placeholder=" " />
                        <h5 id="confirmRecipientId" style="display: none"></h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="adminReservationCancelBtn" type="button" class="btn btn-danger">Cancel
                        Reservation</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Price Modal -->
    <div class="modal fade" id="editPriceModal" tabindex="-1" aria-labelledby="editPriceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="editPriceModalLabel">Modify Price</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row pb-4">
                        <div class="col-md-4">
                            <label for="facility-filter">Filter by Facility:</label>
                            <select id="facility-filter" class="form-control">
                                <option value="">All</option>
                                <?php
                                $uniqueFacilities = $priceLists
                                    ->pluck('facility')
                                    ->unique()
                                    ->toArray();
                                foreach ($uniqueFacilities as $facility) {
                                    echo "<option value=\"$facility\">$facility</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="activity-filter">Filter by Activity:</label>
                            <select id="activity-filter" class="form-control">
                                <option value="">All</option>
                                <?php
                                $uniqueActivities = $priceLists
                                    ->pluck('activity')
                                    ->unique()
                                    ->toArray();
                                foreach ($uniqueActivities as $activity) {
                                    echo "<option value=\"$activity\">$activity</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="organization-filter">Filter by Organization:</label>
                            <select id="organization-filter" class="form-control">
                                <option value="">All</option>
                                <?php
                                $uniqueActivities = $priceLists
                                    ->pluck('organization')
                                    ->unique()
                                    ->toArray();
                                foreach ($uniqueActivities as $organization) {
                                    echo "<option value=\"$organization\">$organization</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    {{-- Add Price Modal --}}
                    <div class="text-end my-2">
                        <button type="submit" class="btn btn-primary text-white addPrice" data-bs-toggle="modal"
                            data-bs-target="#addPriceModal">Add Price</button>
                    </div>


                    <div class="table-responsive">
                        <table id="priceFacility" class="table table-sm table-hover nowrap " style="width:100%">
                            <thead>
                                <tr>
                                    <th>Facility Name</th>
                                    <th>Activity</th>
                                    <th>Organization</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($priceLists as $priceList)
                                    <tr>
                                        <td>{{ $priceList->facility }}</td>
                                        <td>{{ $priceList->activity }}</td>
                                        <td>{{ $priceList->organization }}</td>
                                        <td>₱ {{ $priceList->prices }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning text-white updatePrice"
                                                data-id="{{ $priceList->id }}" data-price="{{ $priceList->prices }}"
                                                data-bs-toggle="modal" data-bs-target="#updatePriceModal">Update</button>
                                            <button type="button" class="btn btn-danger text-white deletePrice"
                                                data-id="{{ $priceList->id }}" data-bs-toggle="modal"
                                                data-bs-target="#deletePriceModal">Delete</button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- add Price Modal -->
    <div class="modal fade" id="addPriceModal" tabindex="-1" aria-labelledby="addPriceModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="addPriceModalModalLabel">New Price Modal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-2">
                        <label for="exampleFormControlTextarea1" class="form-label">Facility Name:</label>
                        <input type="text" class="form-control" id="newPriceFacility" name="newPriceFacility"
                            rows="5" />
                    </div>
                </div>
                <div class="modal-body">
                    <div class="my-2">
                        <label for="exampleFormControlTextarea1" class="form-label">Facility Activtity:</label>
                        <input type="text" class="form-control" id="newPriceActivtity" name="newPriceActivtity"
                            rows="5" />
                    </div>
                </div>
                <div class="modal-body">
                    <div class="my-2">
                        <label for="exampleFormControlTextarea1" class="form-label">Organization:</label>
                        <input type="text" class="form-control" id="newPriceOrganization" name="newPriceAdd"
                            rows="5" />
                    </div>
                </div>
                <div class="modal-body">
                    <div class="my-2">
                        <label for="exampleFormControlTextarea1" class="form-label">Add Price Value:</label>
                        <input type="number" class="form-control" id="newPriceAdd" name="newPriceAdd"
                            rows="5" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="addPricesBtn" type="button" class="btn btn-success">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- update Price Modal -->
    <div class="modal fade" id="updatePriceModal" tabindex="-1" aria-labelledby="updatePriceModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="updatetPriceModalLabel">Price Modal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-2">
                        <label for="exampleFormControlTextarea1" class="form-label">Current Price:</label>
                        <p id="currentPriceLabel"></p>
                        <h5 id="confirmPrizeId" style="display: none"></h5>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="my-2">
                        <label for="exampleFormControlTextarea1" class="form-label">New Price:</label>
                        <input type="number" class="form-control" id="newPriceInput" name="newPriceInput"
                            rows="5" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="updatePricesBtn" type="button" class="btn btn-success">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete Price Modal -->
    <div class="modal fade" id="deletePriceModal" tabindex="-1" aria-labelledby="deletePriceModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deletePriceModalLabel">Price Modal</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="my-2">
                        <p>You sure you want to delete Price Id: <span id="deletePriceId"></span></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="deletePricesBtn" type="button" class="btn btn-success">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Guidelines Modal -->
    <div class="modal fade" id="editGuidelinesModal" tabindex="-1" aria-labelledby="editGuidelinesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="editGuidelinesModalLabel">Modify Guidelines</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="guideLineList" class="modal-body">
                    <table class="table table-sm table-hover nowrap " style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Guidelines</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($guidelines as $key => $guideline)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="form-group green-border-focus">
                                            <textarea class="form-control guideline-textarea" data-guideline-id="{{ $guideline->id }}" rows="5" disabled>{{ $guideline->description }}</textarea>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button id="updateGuideButton" class="btn btn-warning px-3 fw-bold">Edit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editBusinessNumberModal" tabindex="-1" aria-labelledby="editBusinessNumberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="editBusinessNumberModalLabel">Modify Contacts</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="businessNumDiv" class="modal-body">
                    <label class="form-label text-muted">Contact Number: </label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">+63</span>
                        <input id="businessNo" class="form-control" type="text" value="{{ $businessNum->value }}"
                            aria-describedby="basic-addon1" disabled>
                    </div>
                    <label class="form-label text-muted">Contact Email: </label>
                    <input id="businessEmail" class="form-control" type="text" value="{{ $businessEmail->value }}"
                        disabled>
                </div>
                <div class="modal-footer">
                    <button id="updateSettingButton" class="btn btn-warning px-3 fw-bold">Edit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.5.1/fullcalendar.min.js"></script>
    <script>
        function openAssignModal() {
            $('#assignModal').modal('show');
        }
        
        $(document).on('click', '.viewStaffOption', function() {
            var staffId = $(this).data("id");
            var staffName = $(this).data("name");
            $("#staffAvailId").text(staffId);
            $("#staffName").text(staffName);
            $('#viewCalendar').modal('show');

            $.ajax({
                
                url: '/admin/maintenance/staffLeaveList',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    staffId: staffId,
                },
                success: function(response) {
                    var events = response.events;

                    console.log(events);

                    $('#viewCalendar').on('shown.bs.modal', function(e) {

                        var calendarEl = document.getElementById('calendar');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'timeGridWeek',
                            slotMinTime: '7:00:00',
                            slotMaxTime: '23:00:00',
                            events: response.events,
                        });
                        calendar.render();
                    });

                    $('#viewCalendar').on('hidden.bs.modal', function() {
                        openAssignModal();
                        $('#viewCalendar').off('hidden.bs.modal');
                    });

                },
                error: function(xhr) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error Problem for Creating Staff Schedule:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });

        $('#addPricesBtn').click(function() {
            var facility = $('#newPriceFacility').val();
            var activity = $('#newPriceActivtity').val();
            var organization = $('#newPriceOrganization').val();
            var price = $('#newPriceAdd').val();

            $.ajax({
                url: '/admin/reservation/price_add',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    facility: facility,
                    activity: activity,
                    organization: organization,
                    price: price,
                },
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Price Added Successfully!!',
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
                                    'Error Adding Price:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });

        $('.deletePrice').click(function() {
            var priceId = $(this).data('id');
            console.log(priceId);
            $('#deletePriceId').text(priceId);
        });

        $('#deletePricesBtn').click(function() {
            var priceId = $('#deletePriceId').text();

            $.ajax({
                url: '/admin/reservation/price_delete',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    priceId: priceId
                },
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Price Deleted Successfully!!',
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
                                    'Error Deleting Price:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });
                }
            });
        });
    </script>
@endsection
