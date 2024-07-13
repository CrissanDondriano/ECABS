@extends('layouts.staff-app')

@section('style')
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
@endsection

@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row mt-4 inventory-container m-2 p-3">
            <h3 class=" fw-bold mb-4">Reservation List</h3>
            <div class="table-responsive">
                <table id="view-reservation" class="table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Recipient Name</th>
                            <th>Activity</th>
                            <th>Facility</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffReserveTasks as $staffReserveTask)
                            <tr>
                                <td>{{ $staffReserveTask->id }}</td>
                                <td>{{ $staffReserveTask->recipientName }}</td>
                                <td>{{ $staffReserveTask->activity }}</td>
                                <td>{{ $staffReserveTask->facility }}</td>
                                <td>{{ $staffReserveTask->date }}</td>
                                <td>{{ $staffReserveTask->time }}</td>
                                <td class="status">
                                    <span
                                        class="badge @if ($staffReserveTask->status === 'Decline') decline
                                        @elseif ($staffReserveTask->status === 'Cancelled') pending
                                        @else approved @endif">{{ $staffReserveTask->status }}</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary reservationView"
                                        data-id="{{ $staffReserveTask->id }}"
                                        data-equipment="{{ $staffReserveTask->equipment_needed }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewPaymentModal"><i class="fas fa-file-contract"
                                            style="color: #fff;"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="viewModalLabel">Requirement for Reservation</h4>
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
                                                <li class="text-uppercase lh-sm">CONTROL NO:</li>
                                            </ul>
                                        </div>
                                        <div class="col-xl-1 text-center">
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
                                                    <td class="td-account" colspan="2">Name of Organization:
                                                        <span id="reservationOrganization"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Address:
                                                        <span id="reservationAddress"></span>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Name of Event:
                                                        <span id="reservationEvent"></span>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Type of Activity:
                                                        <span id="reservationAct"></span>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="td-account" colspan="2">Facility to Reserve:
                                                        <span id="reservationLocation"></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="td-account">Reservation Date:
                                                        <span id="reservationDate"></span>
                                                    </td>
                                                    <td class="td-account">Time:
                                                        <span id="reservationTime"></span>
                                                    </td>
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
                                    <div class="row mx-1 justify-content-center">
                                        <table class="table table-bordered table-sm statement-card">
                                            <thead>
                                                <tr>
                                                    <th class="text-uppercase text-center th-account" colspan="2">
                                                        Reservation Item Needs
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="assignItemsList">
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                </tr>             
                                            </tbody>
                                        </table>
                                    </div>
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
@endsection
