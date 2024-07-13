@extends('layouts.user-app')

@section('content')
    <style>
        .th-account,
        .td-account {
            background: #fff !important;
        }

        .statement-card {
            border: #000000 !important;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            border: none;
            position: relative;
            margin-bottom: 30px;
            box-shadow: 0 0.46875rem 2.1875rem rgba(90, 97, 105, 0.1), 0 0.9375rem 1.40625rem rgba(90, 97, 105, 0.1), 0 0.25rem 0.53125rem rgba(90, 97, 105, 0.12), 0 0.125rem 0.1875rem rgba(90, 97, 105, 0.1);
        }

        .card-qr {
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            width: 300px;
            height: 300px;
            padding: 1rem 1rem 1rem;
            background-color: #ffffff;
            border-radius: 15px;
            text-align: center;
        }

        .content {
            width: 330px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: auto;
            padding: 1rem 1rem;
            background-color: #0396FF;
            border-radius: 20px;
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
        <div class="row mt-4 reservation-container m-2 p-3">
            <h3 class=" fw-bold mb-4">Modify Reservation</h3>
            <div class="table-responsive">
                <table id="modify-reservation" class="table table-striped table-hover nowrap table-bordered"
                    style="width:100%">
                    <thead>
                        <tr>
                            <th>Reservation ID</th>
                            <th>Name</th>
                            <th>Facility</th>
                            <th>Date</th>
                            <th>Time Category</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $reservation)
                            <tr>
                                <td>{{ $reservation->id }}</td>
                                <td>{{ $reservation->name }}</td>
                                <td>{{ $reservation->facility }}</td>
                                <td>{{ $reservation->date }}</td>
                                <td>{{ $reservation->time }}</td>
                                <td><span
                                        class="badge rounded-pill d-inline-block
                                @if ($reservation->status === 'Cancelled') bg-danger
                                @elseif ($reservation->status === 'Pending') bg-warning
                                @else
                                    bg-success @endif">
                                        {{ $reservation->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if ($reservation->status == 'Pending')
                                        <button type="submit" class="btn btn-warning userReservationUpdate"
                                            data-bs-toggle="modal" data-id="{{ $reservation->id }}"
                                            data-name="{{ $reservation->name }}" data-date="{{ $reservation->date }}"
                                            data-time="{{ $reservation->time }}" data-bs-target="#updateModal" title="Update Reservation"><i
                                                class="fas fa-pen" style="color: #ffffff;"></i></button>
                                        <button type="submit" class="btn btn-danger userReservationCancel"
                                            data-id="{{ $reservation->id }}" data-name="{{ $reservation->name }}"
                                            data-bs-toggle="modal" data-bs-target="#cancelModal" title="Cancel Reservation"><i class="fa-solid fa-ban"
                                                style="color: #ffffff;"></i></button>
                                    @endif

                                    @if ($reservation->status == 'Approved')
                                        <button type="submit" class="btn btn-danger btn-radius userReservationCancel"
                                            data-id="{{ $reservation->id }}" data-name="{{ $reservation->name }}"
                                            data-bs-toggle="modal" data-bs-target="#cancelModal" title="Cancel Reservation"><i class="fa-solid fa-ban"
                                                style="color: #ffffff;"></i></button>
                                        <button type="submit" class="btn btn-info btnQRView"
                                            data-qr="{{ $reservation->qrcode }}" data-bs-toggle="modal"
                                            data-bs-target="#viewModal" title="Qr Code"><i class="fas fa-qrcode fa-lg"
                                                style="color: #ffffff"></i></button>

                                        <button type="submit" class="btn btn-primary reviewReservationBtn"
                                            data-id="{{ $reservation->id }}" data-name="{{ $reservation->name }}"
                                            data-identifier="{{ $reservation->recipientId }}"
                                            data-addressee="{{ $reservation->recipientName }}"
                                            data-organization="{{ $reservation->organization }}"
                                            data-contact="{{ $reservation->contact_number }}"
                                            data-address="{{ $reservation->address }}"
                                            data-date="{{ $reservation->date }}" data-time="{{ $reservation->time }}"
                                            data-activity="{{ $reservation->activity }}"
                                            data-location="{{ $reservation->facility }}"
                                            data-status="{{ $reservation->status }}"
                                            data-attachment="{{ $reservation->attachment }}"
                                            data-equipment="{{ $reservation->equipment_needed }}"
                                            data-quantity="{{ $reservation->quantity }}"
                                            data-type="{{ $reservation->event_type }}" data-bs-toggle="modal"
                                            data-bs-target="#viewPaymentModal"
                                            title="Receipt Requirement">
                                            <i class="fas fa-receipt fa-lg"></i></button>

                                        <button type="submit" class="btn btn-primary reviewReservationBtn"
                                            data-id="{{ $reservation->id }}" data-name="{{ $reservation->name }}"
                                            data-identifier="{{ $reservation->recipientId }}"
                                            data-addressee="{{ $reservation->recipientName }}"
                                            data-organization="{{ $reservation->organization }}"
                                            data-contact="{{ $reservation->contact_number }}"
                                            data-address="{{ $reservation->address }}"
                                            data-date="{{ $reservation->date }}" data-time="{{ $reservation->time }}"
                                            data-activity="{{ $reservation->activity }}"
                                            data-location="{{ $reservation->facility }}"
                                            data-status="{{ $reservation->status }}"
                                            data-attachment="{{ $reservation->attachment }}"
                                            data-equipment="{{ $reservation->equipment_needed }}"
                                            data-quantity="{{ $reservation->quantity }}"
                                            data-type="{{ $reservation->event_type }}" data-bs-toggle="modal"
                                            data-bs-target="#viewContractModal"
                                            title="Preview Contract & Information">
                                            <i class="fas fa-file-contract fa-lg"></i></button>
                                    @endif

                                    @if ($reservation->status == 'Cancelled')
                                        <button type="submit" class="btn btn-success btnReasonView" data-bs-toggle="modal"
                                            data-reason="{{ $reservation->reason }}"
                                            data-bs-target="#cancelDetailsModal" title="Reason for Cancellation">Details</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="updateModalLabel">Update Reservation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Reservation Details:</p>
                    <div class="form-floating my-3">
                        <input type="text" id="reservationId" class="form-control" style="display:none"
                            placeholder=" " />
                        <input type="text" id="reserveeName" class="form-control" placeholder=" " />
                        <label for="reserveeName">Renters Name</label>
                    </div>
                    <div class="form-floating my-3">
                        <input type="date" id="reservationDate" class="form-control" placeholder=" " />
                        <label for="form12">Change Date</label>
                    </div>
                    <select id="reservationTime" class="form-select my-3" aria-label="Default select example">
                        <option selected>Modify Time for Reservation</option>
                        <option value="7:00AM-12:00PM">7:00-12:00</option>
                        <option value="1:00PM-5:00PM">13:00-17:00</option>
                        <option value="6:00PM-11:00PM">18:00-23:00</option>
                    </select>
                    <p>Status: <span class="badge bg-warning rounded-pill d-inline-block">Pending</span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="userReservationUpdateBtn" class="btn btn-warning">Update
                        Reservation</button>
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
                        <input type="text" id="confirmReservationName" class="form-control" style="display:none"
                            placeholder=" " />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="userReservationCancelBtn" type="button" class="btn btn-warning">Cancel
                        Reservation</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View QR Code Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="viewModalLabel">QR Code</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <div class="card-qr">
                            <img id="qrCode" src=""
                                onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/h8AAwAB/6X2gVEAAAAASUVORK5CYII=';"
                                width="100%">
                        </div>
                        <div class="card-text pt-3">
                            <h1 class="text-uppercase fw-bold text-white">Scan me</h1>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="downloadQRCode">Download
                        QR Code</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Requirement Modal -->
    <div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="viewModalLabel">Requirement for Reservation</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <div class="px-2">
                            <strong><i class="fa-solid fa-circle-exclamation" style="color: #005eff;"></i> Important Instructions: </strong> Please follow these simple steps to ensure your reservation is successfully paid for:
                            <ul class="pt-3">
                                <li>Visit the Cashier at the Cabuyao Municipal Hall to complete the payment for your rental fees.</li>
                                <li>Once your rental fees are settled, go to the office of the Facility Administrator at the Cabuyao Athletes Basic School. Don't forget to bring your payment receipt as proof of payment.</li>
                            </ul>
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
                                                    <td class="td-account text-center"><span
                                                            id="reservationDateV1"></span></td>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="exportButton">Generate Pre-receipt</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewContractModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="viewModalLabel">Information & Contract</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <div class="px-2">
                            <strong><i class="fa-solid fa-circle-exclamation" style="color: #e66c1b;"></i> Important Notice:</strong> After completing your payment at the City Treasurer's Office in Cabuyao Municipal Hall, please finalize your reservation by completing a reservation contract. The Cabuyao Athletes Basic School Administrator will provide you with this contract to secure your reservation. Follow their guidance for a smooth completion of the reservation process.
                        </div>
                    </div>
                    <!-- Tabs content -->
                    <div class="page">
                        <div class="subpage">
                            <div class="container mb-5 mt-3" id="page">
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
                                        <div class="col-xl-10 col-md-10">
                                            <ul class="list-unstyled">
                                                <li class="text-uppercase lh-sm ">CONTROL NO:</li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-2 col-md-2">
                                            <ul class="list-unstyled">
                                                <li class="text-uppercase lh-sm text-start">
                                                    <span id="resId"></span>
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
                                                            id="reservationDateV"></span></td>
                                                    <td class="td-account">Time: <span id="reservationTimeV"></span></td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" style="padding-bottom: 30px;" colspan="2">
                                                        Equipment Needed: <span id="reservationEquipment"></span> (x<span
                                                            id="reservationQuantity"></span>)</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center text-uppercase td-account fw-bold"
                                                        colspan="2">General Guidelines in the use of facilities</td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">
                                                        @foreach ($guidelines as $key => $guideline)
                                                            <p>{{ $key + 1 }}) {{ $guideline->description }}</p>
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
                        <div class="container mb-5 mt-3">
                            <div class="text-center">
                                <h4 class="fw-bold text-uppercase">Lease Agreement</h4>
                            </div>
                            <div class="container pt-4">
                                <p class="fw-bold">This Lease Agreement is made and entered into, by and between:</p>
                                <p style="text-indent: 50px;">The <span class="fw-bold">CITY GOVERNMENT OF CABUYAO,</span>
                                    a local government unit duly organized and existing under and by the virtues of the laws
                                    of the Republic of the Philippines, with office address at the Cabuyao City Hall, F.B.
                                    Bailon St., Cabuyao City, Laguna, Philippines, and represented in this act by its City
                                    Mayor <span class="fw-bold">Hon. Dennis Felipe C. Hain</span>, hereinafter referred to
                                    as the <span class="fw-bold">“LESSOR”</span>.</p>
                                <p class="text-center">--and--</p>
                                <p><div id="signature"></div></p>
                                <p>
                                <div id="signature"></div> hereinafter referred to as the <span
                                    class="fw-bold">“LESSEE”</span></p>
                                <h5 class="fw-bold text-center">WITNESSETH:</h5>
                                <p class="fw-bold">that -</p>
                                <p><span class="fw-bold">WHEREAS</span>, the LESSEE desire to use and lease to a space for
                                </p>
                               
                                <div id="signature"></div>  <p>in the City Of Cabuyao for the purpose of   </p>
                                <div id="signature"></div>
                             
                                <p class="pt-4"><span class="fw-bold">WHEREAS</span>, the LESSOR allows the use of CABS for
                                    community-school programs for civic and educational purposes as provided in Section 15,
                                    Chapter 2 Unit VIII - Educational Facilities of DECS Service Manual 2000;</p>
                                <p><span class="fw-bold">WHEREAS</span>, the LESSOR charges for the use of the
                                    abovementioned facilities in accordance with the rates prescribed by the <span
                                        class="fw-bold">CITY ORDINANCE No. 2020-660;</span></p>
                                <p><span class="fw-bold">WHEREAS</span>, the LESSEE is willing to pay the associate fees
                                    for the use and lease of the premises;</p>
                                <p><span class="fw-bold">WHEREAS</span>, the LESSEE undertakes to use the premises to be
                                    leased only for the declared purpose of this Lease Agreement;</p>
                                <p><span class="fw-bold">NOW, THEREFORE</span>, for and in consideration of the foregoing
                                    premises and the covenants hereinafter stipulated, the parties hereby agrees as follows:
                                </p>
                                <p>1. The LESSOR hereby agrees to LEASE the following CABS facility/ies to the LESSEE:</p>
                                <p><span class="text-muted">(please check the applicable item/s)</span></p>

                            </div>
                        </div>
                    </div>

                    <div class="page">
                        <div class="container mb-5 mt-3">
                            <p class="fw-bold">Lessee Type:</p>
                            <p class="fw-bold"><input type="checkbox"> COMMERCIAL / PRIVATE ENTITIES</p>
                            <p class="fw-bold"><input type="checkbox"> LGU/GOVT. INSTITUTION/PRIVATE SCHOOL</p>
                            <p class="fw-bold">Facility to be leased:</p>
                            <p class="fw-bold"><input type="checkbox"> MULTI SPORTS HALL</p>
                            <table class="table table-bordered table-sm statement-card">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-center th-account">
                                            Purpose
                                        </th>
                                        <th class="text-uppercase text-center th-account" colspan="2">
                                            Rates
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="td-account"></td>
                                        <td class="td-account text-center">Commercial/Private Entities</td>
                                        <td class="td-account text-center">LGU/Govt. Institution/ private Schools</td>
                                    </tr>
                                    <tr>
                                        <td class="td-account">
                                            <p class="fw-bold"><input type="checkbox"> CONCERT</p>
                                        </td>
                                        <td class="td-account">P 50,000.00 - 8hrs ( P10,000.00 - additional per hour)</td>
                                        <td class="td-account">P 30,000.00 - 8 hrs. (P6,000.00 additional per hour)</td>
                                    </tr>
                                    <tr>
                                        <td class="td-account">
                                            <p class="fw-bold"><input type="checkbox"> GRADUATION/</p>
                                            <p class="fw-bold"><input type="checkbox"> CONVENTION/</p>
                                            <p class="fw-bold"><input type="checkbox"> RELIGIOUS ACTIVITY</p>
                                        </td>
                                        <td class="td-account">P 40,000.00 - 8 hrs. ( P8,000.00 add'l per hr )</td>
                                        <td class="td-account">P25,000.00 - 8 hrs. (P 5,000.00 add'l. per hr.)</td>
                                    </tr>
                                    <tr>
                                        <td class="td-account">
                                            <p class="fw-bold"><input type="checkbox"> SPORTSFEST</p>
                                        </td>
                                        <td class="td-account">P 40,000.00 - 8 hrs.( P6,000.00 add'l per hr )</td>
                                        <td class="td-account">P20,000.00 - 8 hrs.(P 4,000.00 add'l. per hr.)</td>
                                    </tr>
                                    <tr>
                                        <td class="td-account">
                                            <p class="fw-bold"><input type="checkbox"> PRACTICE/TRAINING</p>
                                        </td>
                                        <td class="td-account">P 3,000.00 - 3 hrs.( P 600.00 add'l per hr )</td>
                                        <td class="td-account">P 2,000.00 - 3 hrs.(P 400.00 add'l. per hr.)</td>
                                    </tr>
                                    <tr>
                                        <td class="td-account">
                                            <p class="fw-bold"><input type="checkbox"> OTHERS, PLS. SPECIFY</p>
                                        </td>
                                        <td class="td-account"></td>
                                        <td class="td-account"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="fw-bold"><input type="checkbox"> AQUATIC CENTER</p>
                            <table class="table table-bordered table-sm statement-card">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-center th-account">
                                            Purpose
                                        </th>
                                        <th class="text-uppercase text-center th-account" colspan="2">
                                            Rates
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="td-account"></td>
                                        <td class="td-account text-center">Commercial/Private Entities</td>
                                        <td class="td-account text-center">LGU/Govt. Institution/ private Schools</td>
                                    </tr>
                                    <tr>
                                        <td class="td-account">
                                            <p class="fw-bold"><input type="checkbox"> SPORTSFEST</p>
                                        </td>
                                        <td class="td-account">P 5,000.00 - 2 hrs. ( P1,000.00 add'l.per hr)</td>
                                        <td class="td-account">P 4,000.00 - 8 hrs. (P 4,000.00 add'l. per hr.)</td>
                                    </tr>
                                    <tr>
                                        <td class="td-account">
                                            <p class="fw-bold"><input type="checkbox"> OTHERS, PLS. SPECIFY</p>
                                        </td>
                                        <td class="td-account"></td>
                                        <td class="td-account"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="fw-bold"><input type="checkbox"> GYMNASIUM & OTHER INDIVIDUAL EVENTS</p>
                            <table class="table table-bordered table-sm statement-card">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-center th-account">
                                            Purpose
                                        </th>
                                        <th class="text-uppercase text-center th-account" colspan="2">
                                            Rates
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="td-account"></td>
                                        <td class="td-account text-center">Commercial/Private Entities</td>
                                        <td class="td-account text-center">LGU/Govt. Institution/ private Schools</td>
                                    </tr>
                                    <tr>
                                        <td class="td-account">
                                            <p class="fw-bold"><input type="checkbox"> SPORTSFEST</p>
                                        </td>
                                        <td class="td-account">P 4,000.00 - whole day P 2,000.00 - half-day</td>
                                        <td class="td-account">P 2,000.00 - 3hrs. (P 400.00 add'l. per hr.)</td>
                                    </tr>
                                    <tr>
                                        <td class="td-account">
                                            <p class="fw-bold"><input type="checkbox"> OTHERS, PLS. SPECIFY</p>
                                        </td>
                                        <td class="td-account"></td>
                                        <td class="td-account"></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="page">
                        <div class="container mb-5 mt-3">
                            <p class="fw-bold"><input type="checkbox"> DORMITORIES</p>
                            <table class="table table-bordered table-sm statement-card">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-center th-account">
                                            Purpose
                                        </th>
                                        <th class="text-uppercase text-center th-account" colspan="2">
                                            Rates
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="td-account"></td>
                                        <td class="td-account text-center">Commercial/Private Entities</td>
                                        <td class="td-account text-center">LGU/Govt. Institution/ private Schools</td>
                                    </tr>
                                    <tr>
                                        <td class="td-account">
                                            <p class="fw-bold"><input type="checkbox"> DORMITORY LEASE/USE</p>
                                        </td>
                                        <td class="td-account">P 1,500.00 - whole day P 800.00 - half-day</td>
                                        <td class="td-account">P 1,000.00 - whole day (P 400.00 - half-day</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>2. The LESSOR hereby agrees to lease the chosen premises to LESSEE from</p>
                            <p>_______________________ until ________________________;</p>
                            <p><span class="px-5">(date and time)</span><span class="px-5">(date and time)</span></p>
                            <p>3. The lessor hereby agrees to furnish any necessary documents for the application of the
                                LESSSEE within a reasonable but not later than fifteen (15) working days prior to the event;
                            </p>
                            <p>4. The LESSEE hereby agrees to furnish the accomplished documents including the reservation
                                confirmation, for the application for the lease to the LESSOR not later than seven (7)
                                working days prior to the event;</p>
                            <p>5. The LESSEE hereby agrees to pay the lease rates as indicated above, including any
                                additional fees for the hours used in excess, as well as other administrative fees;</p>
                            <p>6. The LESSEE hereby agrees to deposit FIFTY PERCENT (50%) of the total fees calculated with
                                the event to the LESSOR’s within three (3) days of notification of the LESSOR’s approval of
                                the lease;</p>
                            <p>7. The LESSOR hereby undertakes to give the LESSEE sole and exclusive rights to access and
                                use the leased facilities for the period agreed upon by the parties to the exclusion of all
                                other parties, EXCEPT: a) for violations of the Rules and Regulations on CABS Facility use,
                                b) for violation of the House Rules, c) revocation or withdrawal or facility use priveleges
                                by the LESSOR for anyanalogous causes to the one mentioned above;</p>
                            <p>8. The LESSEE hereby undertakes to inform the LESSOR. Should the need arise, of the
                                cancellation of the event at-least seventy-two (72) hours from the start of the event. The
                                LESSOR in such case hereby undertakes to give a FULL REFUND of the LESSEE’s fees minus any
                                related expenses incurred by the LESSOR; Should the LESSEE inform of the cancellation of the
                                event less than seventy-two (72) hours from the start thereof, he shall be entitled to only
                                a HALF REFUND of the fees minus the non-refundable administrative fees and ay related
                                expenses.</p>
                            <p>9. The LESSEE hereby undertakes to use only the facilities indicated in this Memorandum of
                                Agreement to the exclusion of all others within CABS unless otherwise provided for by the
                                LESSOR; </p>
                            <p>10. The LESSEE hereby undertakes to use the leased facilities only for the declared purpose
                                    for which they were leased to the exclusion of all others;</p>
                        </div>
                    </div>

                    <div class="page">
                        <div class="container mb-5 mt-3">
                            
                            <p>11. The LESSEE shall NOT allow third parties to use the leased facilities, nor conduct any
                                commercial activities that promote commercial gain without the express and the written
                                consent of the LESSOR;</p>
                            <p>12. The LESSEE shall NOT use the lease premises for activities promoting political gain or
                                for events of a political nature; </p>
                            <p>13. The LESSEE shall NOT conduct games of chance, lotteries, or any activities classified as
                                gambling within the leased premises;</p>
                            <p>15. The LESSEE may bring food and beverages into the leased premises and in such quantities
                                as the scheduled event requires, provided that the LESSOR be duly informed of such. The
                                LESSEE shall also inform the LESSOR of any mess or kitchen equipment necessary for this
                                purpose and seeks its approval thereof. Food and beverages for personal and individual use
                                need not be declared by the LESSEE;</p>
                            <p>16. The LESSEE shall see to it that any and all equipment forming part of the leased premises
                                be used and kept in working order and shall report any loss or damage of the same to the
                                LESSOR as soon as possible. Equipment such as lighting, audio-visual equipment, and stage
                                rigging must be operated by individuals approved by the LESSOR or his authorized
                                representative;</p>
                            <p>17. The LESSOR shall see to it that personnel and officers in charge of the facilities such
                                as but not limited to technical staff, lifeguards, security guards, and CABS officials,
                                among others are available to assist the LESSEE should any need arise from the lease of the
                                premises herein></p>
                            <p>18. The LESSOR in case of increment weather, any natural or man-made calamity, or any
                                unexpected cause requiring the cancellation of the scheduled event of the LESSEE, shall
                                inform the same and exert every effort to reschedule the event at a mutually-agreeable date
                                and time. Should this option be impossible, the LESSOR shall give a FULL REFUND to the
                                LESSEE;</p>
                            <p>19. The LESSOR and the LESSEE herein agree that any request for changes, alteration, or
                                amendments to this Lease Agreement shall be done in writing, with written notice to the
                                party fifteen (15) days prior to the effectivity of such change, alteration or amendment.
                                Should the LESSOR and LESSEE mutually-agree on such changes to this Lease Agreement, they
                                shall execute an Amended Lease Agreement to this effect, otherwise they have the option to
                                revert to the terms and condition of this Lease Agreement or to rescind the same;</p>
                            <p>20. In case of any dispute arising in connection with this Lease Agreement, the LESSOR and
                                the LESSEE hereby agree that the venue for the settlement of any and all disputes shall fall
                                exclusively within the jurisdiction of the proper courts in the City of Cabuyao, Laguna,
                                Philippines.</p>
                            <p><span class="fw-bold">IN WITNESS WHEREOF</span>, the parties have set their hand and affixed
                                their signature this ________ day</p>
                            <p> of ____________________2023 in the City of Cabuyao, Laguna, Philippines.</p>
                            <div class="row">

                                <div class="col-xl-5">
                                    <ul class="list-unstyled mt-4">
                                        <li class="mt-5 text-center fw-bold" style="padding-left: 1rem">
                                            <span id="orderNameReserve"></span>
                                            <div id="signature">
                                            </div>
                                        </li>
                                        <li class="text-center">
                                            <span class="fw-bold text-uppercase">Hon. DENNIS FELIPE C. HAIN </span>
                                            <br>
                                            City Mayor
                                            <br>
                                            City Government of Cabuyao
                                            <br>
                                            LESSOR
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-xl-6">
                                    <ul class="list-unstyled mt-4">
                                        <li class="mt-5 text-center fw-bold" style="padding-left: 1rem">
                                            <span id="orderNameReserve"></span>
                                            <div id="signature">
                                            </div>
                                        </li>
                                        <li class="text-muted text-center">
                                            <span class="text-black fw-bold text-uppercase">LESSEE
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
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
@endsection
