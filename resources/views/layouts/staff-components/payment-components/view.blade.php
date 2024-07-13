@extends('layouts.staff-app')

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
        <div class="row mt-4 inventory-container m-2 p-3">
            <h3 class=" fw-bold mb-4">View Payment Record</h3>
            <div class="table-responsive">
                <table id="view-payment" class="table table-striped table-hover nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Renters Name</th>
                            <th>Payment Amount</th>
                            <th>Payment Status</th>
                            <th>Payment Date</th>
                            <th>Receipt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addPayment as $payment)
                            <tr>
                                <td class="fw-bold">CTL-{{ $payment->id }}</td>
                                <td>{{ $payment->name }}</td>
                                <td>₱ {{ $payment->amount }}</td>
                                <td><span
                                        class="badge rounded-pill d-inline-block
                                    @if ($payment->status === 'Unpaid') bg-warning
                                    @else
                                        bg-success @endif">
                                        {{ $payment->status }}
                                    </span>
                                </td>
                                <td>{{ $payment->date }}</td>
                                <td>
                                    <button type="submit" class="btn btn-info paymentView" data-bs-toggle="modal"
                                        data-id="{{ $payment->id }}" data-reservation="{{ $payment->reservationId }}"
                                        data-bs-target="#viewModal"><i class="fa-solid fa-receipt" style="color: #ffffff;"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.paymentView').click(function() {
                var paymentId = $(this).data('id');
                var paymentReservationId = $(this).data('reservation');

                console.log(paymentReservationId);

                $.ajax({
                    url: '/staff/payment/viewPayment',
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
                            text: 'Error Problem for Viewing Payment: ' + xhr
                                .responseText,
                            icon: 'error'
                        });
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
