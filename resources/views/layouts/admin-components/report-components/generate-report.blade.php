@extends('layouts.admin-app')

@section('content')
    <style>
        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 2cm;
            margin: 1cm auto;
            border: 1px #D3D3D3 solid;
            border-radius: 5px;
            background: white;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>
    <div class="container-fluid content-wrapper">
        <div class="row mt-3 m-1 ">

            <h3 class="fw-bold pt-2 mb-4">Report List</h3>

            <div class="col text-end pb-3">
                <button type="submit" class="btn btn-outline-primary text-capitalize ms-1" data-bs-toggle="modal"
                    data-bs-target="#generateModal"><i class="fa-regular fa-square-plus text-outline-primary"
                        style="padding-right: 8px;"></i>Generate new report</button>
                <button type="submit" class="btn btn-outline-danger text-capitalize ms-1" data-bs-toggle="modal"
                    data-bs-target="#deleteModal">
                    <i class="fa-solid fa-trash text-outline-danger" style="padding-right: 8px;"></i>Delete Selected
                </button>
            </div>

            <div>

            </div>

            <div class="table-responsive">
                <table id="view-report" class="table table-striped table-hover nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Report Type</th>
                            <th>Report Category</th>
                            <th>Date Range</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addReports as $addReport)
                            <tr id="{{ $addReport->id }}">
                                <td></td>
                                <td class="text-capitalize fw-bold">{{ $addReport->type }}</td>
                                <td class="text-capitalize fw-bold">{{ $addReport->category }}</td>
                                <td>{{ $addReport->dateRange }}</td>
                                <td>
                                    <div class="text-center">
                                        <a class="px-1 text-decoration-none csvButton" data-toggle="tooltip"
                                            data-file="{{ $addReport->file }}" data-report-id="{{ $addReport->id }}"
                                            data-placement="top" title="CSV">
                                            <i class="fas fa-file-csv text-success fa-lg"></i>
                                        </a>
                                        <a class="px-1 text-decoration-none copyButton" data-toggle="tooltip"
                                            data-file="{{ $addReport->file }}" data-report-id="{{ $addReport->id }}"
                                            data-placement="top" title="Copy">
                                            <i class="fas fa-copy text-info fa-lg"></i>
                                        </a>
                                        <a class="px-1 text-decoration-none printButton" data-toggle="tooltip"
                                            data-file="{{ $addReport->file }}" data-report-id="{{ $addReport->id }}"
                                            data-placement="top" title="Print">
                                            <i class="fas fa-print text-primary fa-lg"></i>
                                        </a>
                                        <a class="px-1 text-decoration-none export" data-toggle="tooltip"
                                            data-file="{{ $addReport->file }}" data-report-id="{{ $addReport->id }}"
                                            data-placement="top" title="Export">
                                            <i class="far fa-file-pdf text-danger fa-lg"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="modal fade" id="generateModal" tabindex="-1" aria-labelledby="generateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="generateModalLabel">Generate Report</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4" id="reportDate">
                        <div class="col-md-6">
                            <label for="startDate" class="form-label fw-bold">Period From</label>
                            <input type="date" class="form-control" id="startDateReport" aria-describedby="dateHelp">
                        </div>
                        <div class="col-md-6">
                            <label for="endDate" class="form-label fw-bold">To</label>
                            <input type="date" class="form-control" id="endDateReport" aria-describedby="dateHelp">
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="reportCategory" class="form-label fw-bold">Category</label>
                        <select id="reportCategory" class="form-select" aria-label="Default select example">
                            <option value="" selected>Select Report Category</option>
                            <option value="1">Reservation</option>
                            <option value="2">Inventory</option>
                            <option value="3">Maintenance</option>
                            <option value="4">Payment</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-4">
                        <label for="reportType" class="form-label fw-bold">Type</label>
                        <div id="reservationReportType" style="display: none;">
                            <select id="reservationReportTypeVal" class="form-select" aria-label="Default select example">
                                <option value="" selected>Select Reservation Report Type</option>
                                <option value="1">Reservation Summary Report</option>
                                <option value="2">Reservation Cancelled Report</option>
                                <option value="3">Overall Reservation Report</option>
                            </select>
                        </div>
                        <div id="inventoryReportType" style="display: none;">
                            <select id="inventoryReportTypeVal" class="form-select" aria-label="Default select example">
                                <option value="" selected>Select Inventory Report Type</option>
                                <option value="1">Inventory Stock Summary Report</option>
                                <option value="2">Stock Movement Report</option>
                                <option value="3">Overall Inventory Report</option>
                            </select>
                        </div>
                        <div id="maintenanceReportType" style="display: none;">
                            <select id="maintenanceReportTypeVal" class="form-select"
                                aria-label="Default select example">
                                <option value="" selected>Select Maintenance Report Type</option>
                                <option value="1">Task Summary Report</option>
                                <option value="2">Maintenance Request Report</option>
                                <option value="3">Overall Maintenance Report</option>
                            </select>
                        </div>
                        <div id="paymentReportType" style="display: none;">
                            <select id="paymentReportTypeVal" class="form-select" aria-label="Default select example">
                                <option value="" selected>Select Payment Record Report Type</option>
                                <option value="1">Payment Summary Report</option>
                                <option value="2">Payment History Report</option>
                                <option value="3">Overall Payment Record Report</option>
                            </select>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-capitalize border border-secondary"
                        data-bs-dismiss="modal"><i class="fas fa-circle-xmark text-secondary"></i> Close</button>
                    <button id="generateReportButton" class="btn btn-light text-capitalize border border-primary"
                        data-bs-toggle="modal" data-bs-target="#previewModal"><i
                            class="fas fa-paperclip text-primary"></i>
                        Generate Report</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Generate Report Modal -->
    <div class="modal fade" id="previewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="staticBackdropLabel">Generate Report</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!-- Tabs content -->
                    <div id="reservationCard" style="display: none">
                        <div id="reservation" class="page">
                            <div class="d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <img src="{!! url('assets/images/cabuyao-icon.png') !!}" alt="" width="110px">
                                    </div>
                                    <div class="col-xl-8 text-center text-uppercase">
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

                                <div class="row">
                                    <div class="col-xl-12">
                                        <ul class="list-unstyled">
                                            <li class="my-4 pb-4">{{ date('F j, Y') }}</li>
                                            <li class="fw-bold">Hon. Dennis Felipe C. Hain</li>
                                            <li>City Mayor</li>
                                            <li class="mb-4">Cabuyao City, Laguna</li>
                                            <li class="my-4 pt-4">Dear Mayor,</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row my-2 mx-1 justify-content-center">
                                    <table id="reservationTable" class="table table-bordered table-sm"
                                        style="display: none;">

                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5">
                                        <p class="mt-4">Very truly yours,</p>
                                        <p class="mt-4"><span class="fw-bold">Ruben L. Morales</span>
                                            <br>
                                            OIC CABS
                                        </p>
                                    </div>
                                    <div class="col-xl-5">
                                        <ul class="list-unstyled" style="margin-top: 9rem">
                                            <li class="text-muted ms-3"><span class="text-black me-4">Noted:
                                            </li>
                                            <li class="text-muted ms-3 mt-3" style="padding-left: 3rem">
                                                <span class="text-black me-4 fw-bold">Herberto Jose D.
                                                    Miranda,
                                                    CESO VI
                                                </span>
                                                <br>
                                                <span class="text-black">Schools Division
                                                    Superintendent</span>
                                            </li>

                                        </ul>
                                        <ul class="list-unstyled" style="margin-top: 3rem">
                                            <li class="text-muted ms-3"><span class="text-black me-4">Approved:
                                            </li>
                                            <li class="text-muted ms-3 mt-3" style="padding-left: 3rem">
                                                <span class="text-black me-4 fw-bold">Hon. Dennis Felipe C.
                                                    Hain
                                                </span>
                                                <br>
                                                <span class="text-black">City Mayor</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div id="inventoryCard" style="display: none">
                        <div id="inventory" class="page">
                            <div class="d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <img src="{!! url('assets/images/cabuyao-icon.png') !!}" alt="" width="110px">
                                    </div>
                                    <div class="col-xl-8 text-center text-uppercase">
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

                                <div class="row">
                                    <div class="col-xl-12">
                                        <ul class="list-unstyled">
                                            <li class="my-4 pb-4">Inventory 26, 2023</li>
                                            <li class="fw-bold">Hon. Dennis Felipe C. Hain</li>
                                            <li>City Mayor</li>
                                            <li class="mb-4">Cabuyao City, Laguna</li>
                                            <li class="my-4 pt-4">Dear Mayor,</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row my-2 mx-1 justify-content-center">
                                    <table id="inventoryTable" class="table table-bordered table-sm"
                                        style="display: none">

                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5">
                                        <p class="mt-4">Very truly yours,</p>
                                        <p class="mt-4"><span class="fw-bold">Ruben L. Morales</span> <br>
                                            OIC CABS</p>
                                    </div>
                                    <div class="col-xl-5">
                                        <ul class="list-unstyled" style="margin-top: 9rem">
                                            <li class="text-muted ms-3"><span class="text-black me-4">Noted:
                                            </li>
                                            <li class="text-muted ms-3 mt-3" style="padding-left: 3rem">
                                                <span class="text-black me-4 fw-bold">Herberto Jose D. Miranda,
                                                    CESO VI
                                                </span>
                                                <br>
                                                <span class="text-black">Schools Division Superintendent</span>
                                            </li>

                                        </ul>
                                        <ul class="list-unstyled" style="margin-top: 3rem">
                                            <li class="text-muted ms-3"><span class="text-black me-4">Approved:
                                            </li>
                                            <li class="text-muted ms-3 mt-3" style="padding-left: 3rem">
                                                <span class="text-black me-4 fw-bold">Hon. Dennis Felipe C.
                                                    Hain
                                                </span>
                                                <br>
                                                <span class="text-black">City Mayor</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="maintenanceCard" style="display: none">
                        <div id="maintenance" class="page">
                            <div class="d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <img src="{!! url('assets/images/cabuyao-icon.png') !!}" alt="" width="110px">
                                    </div>
                                    <div class="col-xl-8 text-center text-uppercase">
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

                                <div class="row">
                                    <div class="col-xl-12">
                                        <ul class="list-unstyled">
                                            <li class="my-4 pb-4">Maintenance 26, 2023</li>
                                            <li class="fw-bold">Hon. Dennis Felipe C. Hain</li>
                                            <li>City Mayor</li>
                                            <li class="mb-4">Cabuyao City, Laguna</li>
                                            <li class="my-4 pt-4">Dear Mayor,</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row my-2 mx-1 justify-content-center">
                                    <table id="maintenanceTable" class="table table-bordered table-sm"
                                        style="display: none">

                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5">
                                        <p class="mt-4">Very truly yours,</p>
                                        <p class="mt-4"><span class="fw-bold">Ruben L. Morales</span> <br>
                                            OIC CABS</p>
                                    </div>
                                    <div class="col-xl-5">
                                        <ul class="list-unstyled" style="margin-top: 9rem">
                                            <li class="text-muted ms-3"><span class="text-black me-4">Noted:
                                            </li>
                                            <li class="text-muted ms-3 mt-3" style="padding-left: 3rem">
                                                <span class="text-black me-4 fw-bold">Herberto Jose D. Miranda,
                                                    CESO VI
                                                </span>
                                                <br>
                                                <span class="text-black">Schools Division Superintendent</span>
                                            </li>

                                        </ul>
                                        <ul class="list-unstyled" style="margin-top: 3rem">
                                            <li class="text-muted ms-3"><span class="text-black me-4">Approved:
                                            </li>
                                            <li class="text-muted ms-3 mt-3" style="padding-left: 3rem">
                                                <span class="text-black me-4 fw-bold">Hon. Dennis Felipe C.
                                                    Hain
                                                </span>
                                                <br>
                                                <span class="text-black">City Mayor</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div id="paymentCard" style="display: none">
                        <div id="payment" class="page">
                            <div class="d-flex justify-content-center">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <img src="{!! url('assets/images/cabuyao-icon.png') !!}" alt="" width="110px">
                                    </div>
                                    <div class="col-xl-8 text-center text-uppercase">
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

                                <div class="row">
                                    <div class="col-xl-12">
                                        <ul class="list-unstyled">
                                            <li class="my-4 pb-4">January 26, 2023</li>
                                            <li class="fw-bold">Hon. Dennis Felipe C. Hain</li>
                                            <li>City Mayor</li>
                                            <li class="mb-4">Cabuyao City, Laguna</li>
                                            <li class="my-4 pt-4">Dear Mayor,</li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row my-2 mx-1 justify-content-center">
                                    <table id="paymentTable" class="table table-bordered table-sm" style="display: none">

                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-xl-5">
                                        <p class="mt-4">Very truly yours,</p>
                                        <p class="mt-4"><span class="fw-bold">Ruben L. Morales</span> <br>
                                            OIC CABS</p>
                                    </div>
                                    <div class="col-xl-5">
                                        <ul class="list-unstyled" style="margin-top: 9rem">
                                            <li class="text-muted ms-3"><span class="text-black me-4">Noted:
                                            </li>
                                            <li class="text-muted ms-3 mt-3" style="padding-left: 3rem">
                                                <span class="text-black me-4 fw-bold">Herberto Jose D. Miranda,
                                                    CESO VI
                                                </span>
                                                <br>
                                                <span class="text-black">Schools Division Superintendent</span>
                                            </li>

                                        </ul>
                                        <ul class="list-unstyled" style="margin-top: 3rem">
                                            <li class="text-muted ms-3"><span class="text-black me-4">Approved:
                                            </li>
                                            <li class="text-muted ms-3 mt-3" style="padding-left: 3rem">
                                                <span class="text-black me-4 fw-bold">Hon. Dennis Felipe C.
                                                    Hain
                                                </span>
                                                <br>
                                                <span class="text-black">City Mayor</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tabs content -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light text-capitalize border border-secondary"
                        data-bs-dismiss="modal"><i class="fas fa-circle-xmark text-secondary"></i> Close</button>
                    <button id="saveReport" class="btn btn-light text-capitalize border border-success">
                        <i class="fas fa-file text-success"></i> Save Report
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- View Report Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="viewModalLabel">View Report</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="page">
                            <div class="card-body">
                                <div class="container mb-5 mt-3">
                                    <div class="d-flex justify-content-center">
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <img src="{!! url('assets/images/cabuyao-icon.png') !!}" alt="" width="110px">
                                            </div>
                                            <div class="col-xl-9 text-center text-uppercase">
                                                <h5 class="lh-sm">Republic of the Philippines <br>
                                                    <span class="fw-bold">City of Cabuyao</span><br>Province of
                                                    Laguna<br><br><span class="fw-bold">Cabuyao Athletes Basic
                                                        School</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="container">

                                        <div class="row">
                                            <div class="col-xl-12">
                                                <ul class="list-unstyled">
                                                    <li class="my-4 pb-4">January 26, 2023</li>
                                                    <li class="fw-bold">Hon. Dennis Felipe C. Hain</li>
                                                    <li>City Mayor</li>
                                                    <li class="mb-4">Cabuyao City, Laguna</li>
                                                    <li class="my-4 pt-4">Dear Mayor,</li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="row my-2 mx-1 justify-content-center">
                                            <table class="table table-striped table-borderless">
                                                <thead style="background-color:#84B0CA ;" class="text-white">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Description</th>
                                                        <th scope="col">Qty</th>
                                                        <th scope="col">Unit Price</th>
                                                        <th scope="col">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">1</th>
                                                        <td>Pro Package</td>
                                                        <td>4</td>
                                                        <td>$200</td>
                                                        <td>$800</td>
                                                    </tr>
                                                </tbody>

                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-5">
                                                <p class="mt-4">Very truly yours,</p>
                                                <p class="mt-4"><span class="fw-bold">Ruben L. Morales</span> <br>
                                                    OIC CABS</p>
                                            </div>
                                            <div class="col-xl-5">
                                                <ul class="list-unstyled" style="margin-top: 9rem">
                                                    <li class="text-muted ms-3"><span class="text-black me-4">Noted:
                                                    </li>
                                                    <li class="text-muted ms-3 mt-3" style="padding-left: 3rem">
                                                        <span class="text-black me-4 fw-bold">Herberto Jose D. Miranda,
                                                            CESO VI
                                                        </span>
                                                        <br>
                                                        <span class="text-black">Schools Division Superintendent</span>
                                                    </li>

                                                </ul>
                                                <ul class="list-unstyled" style="margin-top: 3rem">
                                                    <li class="text-muted ms-3"><span class="text-black me-4">Approved:
                                                    </li>
                                                    <li class="text-muted ms-3 mt-3" style="padding-left: 3rem">
                                                        <span class="text-black me-4 fw-bold">Hon. Dennis Felipe C.
                                                            Hain
                                                        </span>
                                                        <br>
                                                        <span class="text-black">City Mayor</span>
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
                <div class="modal-footer">
                    <button type="button" id="closeModalButton" class="btn btn-secondary"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Report Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteModalLabel">Delete Report</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this report?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="deleteReportBtn" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var csrfToken = "{{ csrf_token() }}";

        function handleReportCategoryChange() {
            var selectedValue = $('#reportCategory').val();

            $('#reservationReportType').hide();
            $('#inventoryReportType').hide();
            $('#maintenanceReportType').hide();
            $('#paymentReportType').hide();

            if (selectedValue === '1') {
                $('#reservationReportType').show();
            } else if (selectedValue === '2') {
                $('#inventoryReportType').show();
            } else if (selectedValue === '3') {
                $('#maintenanceReportType').show();
            } else if (selectedValue === '4') {
                $('#paymentReportType').show();
            }
        }

        function validateFields() {
            var startDate = $("#startDateReport").val();
            var endDate = $("#endDateReport").val();
            var category = $("#reportCategory").val();
            var type = $(
                "#reservationReportTypeVal, #inventoryReportTypeVal, #maintenanceReportTypeVal, #paymentReportTypeVal"
            ).filter(":visible").val();

            if (!startDate || !endDate || !category || !type) {
                return false;
            }
            return true;
        }

        function loadReport(url, tableId) {
            var table = $(tableId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    table.html(response).show();
                },
                error: function() {
                    table.empty().hide();
                }
            });
        }

        function handleReportTypeChange(reportType, reportRoutes, cardId, tableId) {
            var selectedValue = reportType.val();
            var table = $(tableId);

            $('#reservationCard, #maintenanceCard, #inventoryCard, #paymentCard').hide();

            if (selectedValue !== '') {
                $('#' + cardId).show();

                if (selectedValue in reportRoutes) {
                    loadReport(reportRoutes[selectedValue], tableId);
                } else {
                    table.empty().hide();
                }
            } else {
                $('#' + cardId).hide();
                table.empty().hide();
            }
        }

        function getActiveCardId() {

            if ($("#reservation").is(":visible")) {
                return "reservation";
            } else if ($("#inventory").is(":visible")) {
                return "inventory";
            } else if ($("#maintenance").is(":visible")) {
                return "maintenance";
            } else if ($("#payment").is(":visible")) {
                return "payment";
            }
            return null;
        }

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
                    format: 'a3',
                    orientation: 'portrait'
                }
            };

            html2pdf().from(content).set(options).save();
        }

        function copyToClipboard(text) {
            // You can use a clipboard library or a simple method like this
            var textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
        }

        function formatTableAsText(tableData) {
            var formattedText = "";

            // Add the headers to the formatted text
            formattedText += tableData.headers.join("\t") + "\n";

            // Add the data rows to the formatted text
            tableData.data.forEach(function(row) {
                formattedText += row.join("\t") + "\n";
            });

            return formattedText;
        }

        function extractTableData(htmlContent) {
            // Create a temporary div element to parse the HTML
            var tempDiv = document.createElement('div');
            tempDiv.innerHTML = htmlContent;

            // Find the table you want to extract by its ID, class, or structure
            var table = tempDiv.querySelector('table');

            if (table) {
                var tableHeaders = [];
                var tableRows = table.querySelectorAll('tr');

                // Extract table headers
                tableRows[0].querySelectorAll('th').forEach(function(th) {
                    tableHeaders.push(th.textContent.trim());
                });

                // Extract table data
                var tableData = [];
                for (var i = 1; i < tableRows.length; i++) {
                    var rowData = [];
                    tableRows[i].querySelectorAll('td').forEach(function(td) {
                        rowData.push(td.textContent.trim());
                    });
                    tableData.push(rowData);
                }

                return {
                    headers: tableHeaders,
                    data: tableData
                };
            } else {
                return null;
            }
        }

        function exportToCSV(tableData, fileName) {
            var csvContent = "data:text/csv;charset=utf-8,";

            // Add the headers to the CSV content
            csvContent += tableData.headers.join(",") + "\r\n";

            // Add the data rows to the CSV content
            tableData.data.forEach(function(row) {
                csvContent += row.join(",") + "\r\n";
            });

            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", fileName);
            document.body.appendChild(link);
            link.click();
        }

        $(document).ready(function() {

            var table = new DataTable('#view-report', {
                responsive: true,
                fixedHeader: true,
                lengthChange: false,
                columnDefs: [{
                    orderable: false,
                    className: 'select-checkbox',
                    targets: 0
                }],
                select: {
                    style: 'os',
                    selector: 'td:first-child'
                },
                order: [
                    [1, 'asc']
                ]
            });

            $('#deleteReportBtn').on('click', function() {
                var selectedRows = table.rows({
                    selected: true
                }).nodes();
                for (var i = 0; i < selectedRows.length; i++) {
                    var rowNode = selectedRows[i];
                    var rowId = rowNode.id; // Get the id attribute of the row

                    // Perform AJAX request to submit the form data
                    $.ajax({
                        url: '/admin/report/generate/deleteReportData',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            reportId: rowId,
                        },
                        success: function(response) {
                            swal({
                                title: 'Success',
                                text: 'Removed Report successfully',
                                icon: 'success'
                            }).then(function() {
                                window.location.href =
                                    '/admin/report/generate';
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
                                            'Error Removing Report:<br>' +
                                            parseErrors(xhr.responseText) +
                                            '</div>',
                                    },
                                },
                                icon: 'error'
                            });
                        }
                    });
                    console.log(rowId);
                }
            });

            $('[data-toggle="tooltip"]').tooltip();

            $('#reportCategory').change(handleReportCategoryChange);

            $("#previewModal").on("show.bs.modal", function(event) {
                if (!validateFields()) {
                    event.preventDefault();
                    swal({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please fill in all required fields before generating the report!',
                        confirmButtonText: 'OK'
                    });
                }
            });

            $('#reservationReportTypeVal').on('change', function() {
                var startDateReservation = $('#startDateReport').val();
                var endDateReservation = $('#endDateReport').val();

                handleReportTypeChange(
                    $(this), {
                        '1': '{{ route('admin.report.reservation.summary') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation,
                        '2': '{{ route('admin.report.reservation.cancelled') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation,
                        '3': '{{ route('admin.report.reservation.overall') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation
                    },
                    'reservationCard',
                    '#reservationTable'
                );
            });

            $('#inventoryReportTypeVal').on('change', function() {
                var startDateReservation = $('#startDateReport').val();
                var endDateReservation = $('#endDateReport').val();

                handleReportTypeChange(
                    $(this), {
                        '1': '{{ route('admin.report.inventory.stock') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation,
                        '2': '{{ route('admin.report.inventory.movement') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation,
                        '3': '{{ route('admin.report.inventory.overall') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation
                    },
                    'inventoryCard',
                    '#inventoryTable'
                );
            });

            $('#maintenanceReportTypeVal').on('change', function() {
                var startDateReservation = $('#startDateReport').val();
                var endDateReservation = $('#endDateReport').val();

                handleReportTypeChange(
                    $(this), {
                        '1': '{{ route('admin.report.maintenance.summary') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation,
                        '2': '{{ route('admin.report.maintenance.request') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation,
                        '3': '{{ route('admin.report.maintenance.overall') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation
                    },
                    'maintenanceCard',
                    '#maintenanceTable'
                );
            });

            $('#paymentReportTypeVal').on('change', function() {
                var startDateReservation = $('#startDateReport').val();
                var endDateReservation = $('#endDateReport').val();

                handleReportTypeChange(
                    $(this), {
                        '1': '{{ route('admin.report.payment.summary') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation,
                        '2': '{{ route('admin.report.payment.history') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation,
                        '3': '{{ route('admin.report.payment.overall') }}' + '?startDate=' +
                            startDateReservation + '&endDate=' + endDateReservation
                    },
                    'paymentCard',
                    '#paymentTable'
                );
            });

            $("#saveReport").click(function() {
                var activeCardId = getActiveCardId();
                var selectedType;
                var selectedCategory;
                var category = $('#reportCategory').val();
                var startDateReservation = $('#startDateReport').val();
                var endDateReservation = $('#endDateReport').val();

                if (category === '1') {
                    selectedCategory = 'reservation';
                    selectedType = $('#reservationReportTypeVal').val();
                } else if (category === '2') {
                    selectedCategory = 'inventory';
                    selectedType = $('#inventoryReportTypeVal').val();
                } else if (category === '3') {
                    selectedCategory = 'maintenance';
                    selectedType = $('#maintenanceReportTypeVal').val();
                } else if (category === '4') {
                    selectedCategory = 'payment';
                    selectedType = $('#paymentReportTypeVal').val();
                }

                // Get the HTML content of the active card
                var printableContent = $("#" + activeCardId).html();

                // Send data via AJAX
                $.ajax({
                    url: '/admin/report/generate/saveReportData',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        reportContent: printableContent,
                        category: selectedCategory,
                        type: selectedType,
                        startDate: startDateReservation,
                        endDate: endDateReservation
                    },
                    success: function(response) {
                        swal({
                            title: 'Success',
                            text: 'Report saved successfully',
                            icon: 'success'
                        }).then(function() {
                            window.location.href =
                                '/admin/report/generate';
                        });
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

            $('.export').click(function() {
                const reportId = $(this).data('report-id');
                const fileName = 'ECABS_Report.pdf';

                $.ajax({
                    url: `/admin/report/fetchReportContent/${reportId}`,
                    type: 'GET',
                    success: function(content) {
                        generateAndDownloadPDF(content, fileName);
                    },
                    error: function(xhr, status, error) {
                        // Handle error response if needed
                        console.error('Error fetching report content:', error);
                    }
                });
            });

            $('.printButton').click(function() {
                const reportId = $(this).data('report-id');

                $.ajax({
                    url: `/admin/report/fetchReportContent/${reportId}`,
                    type: 'GET',
                    success: function(content) {
                        console.log(content);
                        $(content).printThis({
                            removeInline: false,
                            headers: false,
                            footers: false,
                        });
                    },
                    error: function(xhr, status, error) {
                        // Handle error response if needed
                        console.error('Error fetching report content:', error);
                    }
                });
            });

            $('.copyButton').click(function() {
                const reportId = $(this).data('report-id');

                // Fetch the HTML content based on the report ID
                $.ajax({
                    url: `/admin/report/fetchCopyReportContent/${reportId}`,
                    type: 'GET',
                    success: function(htmlContent) {
                        // Extract the table data from the HTML content
                        var tableData = extractTableData(htmlContent);

                        if (tableData) {
                            // Copy the table data to the clipboard (you can use a clipboard library for this)
                            copyToClipboard(formatTableAsText(tableData));

                            // Display a success message or perform other actions as needed
                            swal({
                                title: 'Success',
                                text: 'Table data copied to clipboard!',
                                icon: 'success'
                            });
                        } else {
                            // Handle the case where the table couldn't be found
                            console.error('Table not found in the HTML content.');
                            swal({
                                title: 'Error',
                                text: 'Table not found in the HTML content.',
                                icon: 'error'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response if needed
                        console.error('Error fetching report content:', error);
                    }
                });
            });

            $('.csvButton').click(function() {
                const reportId = $(this).data('report-id');

                $.ajax({
                    url: `/admin/report/fetchReportContent/${reportId}`,
                    type: 'GET',
                    success: function(htmlContent) {
                        // Extract the table data from the HTML content
                        var tableData = extractTableData(htmlContent);

                        if (tableData) {
                            exportToCSV(tableData, 'ECABS_Report.csv');
                        } else {
                            console.error('Table not found in the HTML content.');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response if needed
                        console.error('Error fetching report content:', error);
                    }
                });
            });

            $('#previewModal').on('hidden.bs.modal', function() {
                location.reload();
            });

        });
    </script>
@endsection
