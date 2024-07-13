<div class="bg-white border-end" id="sidebar-wrapper" style="overflow: auto;">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{route('admin.home')}}" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none sidebar-heading">
            <img class="" src="{!! url('assets/images/CABS.png') !!}" alt="" width="45" height="45">
            <span class="h2 fw-bold mt-2 px-1 logo-name sidebar-text logo-text">eCABS</span>
        </a>
        <a class="sidebar-close p-4 fw-bold" style="cursor: pointer"><i class="fa-solid fa-x fa-lg" style="color: #000000;"></i></a>
    </div>
    <div class="list-group list-group-flush px-2">
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('admin.home')}}" data-toggle="tooltip" title="Overview">
                <img class="" src="{!! url('assets/icons/overview.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Overview</span>
            </a>
        </div>
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('admin.manageUsersView')}}" data-toggle="tooltip" title="Manage a User">
                <img class="" src="{!! url('assets/icons/management.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">User Accounts</span>
            </a>
        </div>
        <div class="accordion mt-2" id="reservationAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="manageReservationHeading">
                    <a class="accordion-button bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#manageReservationCollapse" aria-expanded="false" aria-controls="manageReservationCollapse">
                        <img class="icon-reservation" src="{!! url('assets/icons/booking.png') !!}" alt="" width="25" height="25">
                        <span class="sidebar-text px-2">Manage Reservation</span>
                    </a>
                </h2>
                <div id="manageReservationCollapse" class="accordion-collapse collapse" aria-labelledby="manageReservationHeading" data-bs-parent="#reservationAccordion">
                    <div class="accordion-body">
                        <a class="dropdown-item p-2" href="{{route('admin.reservation.review')}}" data-toggle="tooltip" title="Approve, Cancel or Customize your Reservation">Review Reservation</a>
                        <a class="dropdown-item p-2" href="{{route('admin.reservation.manage')}}" data-toggle="tooltip" title="Manage an Event">Manage Event</a>
                        <a class="dropdown-item p-2" href="{{route('admin.reservation.audit')}}" data-toggle="tooltip" title="Check your Reservation Audit">Reservation Log</a>
                        <a class="dropdown-item p-2" href="{{route('admin.reservation.view')}}" data-toggle="tooltip" title="View Reservation List">View Reservation Details</a>
                        <a class="dropdown-item p-2" href="{{route('admin.reservation.view-calendar')}}" data-toggle="tooltip" title="Check your Calendar">View Reservation Calendar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion" id="paymentAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="managePaymentHeading">
                    <a class="accordion-button bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#managePaymentCollapse" aria-expanded="false" aria-controls="managePaymentCollapse">
                        <img class="" src="{!! url('assets/icons/money.png') !!}" alt="" width="25" height="25">
                        <span class="sidebar-text px-2">Manage Payment</span>
                    </a>
                </h2>
                <div id="managePaymentCollapse" class="accordion-collapse collapse" aria-labelledby="managePaymentHeading" data-bs-parent="#paymentAccordion">
                    <div class="accordion-body">
                        <a class="dropdown-item p-2" href="{{route('admin.payment.manage')}}" data-toggle="tooltip" title="Manage your Payment">Manage Payment</a>
                        <a class="dropdown-item p-2" href="{{route('admin.payment.audit')}}" data-toggle="tooltip" title="Check your Audit Log">Payment Log</a>
                        <a class="dropdown-item p-2" href="{{route('admin.payment.view')}}" data-toggle="tooltip" title="View you List of Payment">View Payment Details</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion" id="inventoryAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="manageInventoryHeading">
                    <a class="accordion-button bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#manageInventoryCollapse" aria-expanded="false" aria-controls="manageInventoryCollapse">
                        <img class="" src="{!! url('assets/icons/inventory.png') !!}" alt="" width="25" height="25">
                        <span class="sidebar-text px-2">Manage Inventory</span>
                    </a>
                </h2>
                <div id="manageInventoryCollapse" class="accordion-collapse collapse" aria-labelledby="manageInventoryHeading" data-bs-parent="#inventoryAccordion">
                    <div class="accordion-body">
                        <a class="dropdown-item p-2" href="{{route('admin.inventory.purchase')}}" data-toggle="tooltip" title="Purchase your Request">Purchase Request</a>
                        <a class="dropdown-item p-2" href="{{route('admin.inventory.manage')}}" data-toggle="tooltip" title="Manage your Inventory">Manage Inventory</a>
                        <a class="dropdown-item p-2" href="{{route('admin.inventory.audit')}}" data-toggle="tooltip" title="Check your Audit Log">Inventory Log</a>
                        <a class="dropdown-item p-2" href="{{route('admin.inventory.view')}}" data-toggle="tooltip" title="View an Inventory">View Inventory</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion" id="maintenanceAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="manageMaintenanceHeading">
                    <a class="accordion-button bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#manageMaintenanceCollapse" aria-expanded="false" aria-controls="manageMaintenanceCollapse">
                        <img class="" src="{!! url('assets/icons/maintenance.png') !!}" alt="" width="25" height="25">
                        <span class="sidebar-text px-2">Manage Maintenance</span>
                    </a>
                </h2>
                <div id="manageMaintenanceCollapse" class="accordion-collapse collapse" aria-labelledby="manageMaintenanceHeading" data-bs-parent="#maintenanceAccordion">
                    <div class="accordion-body">
                        <a class="dropdown-item p-2" href="{{route('admin.maintenance.add')}}" data-toggle="tooltip" title="Manage your Facility">Facility Maintenance</a>
                        <a class="dropdown-item p-2" href="{{route('admin.maintenance.scheduleTask')}}" data-toggle="tooltip" title="Schedule your Task">Schedule Maintenance Task</a>
                        <a class="dropdown-item p-2" href="{{route('admin.manageTeamScheduler')}}" data-toggle="tooltip" title="Team Scheduler">Team Scheduler</a>
                        <a class="dropdown-item p-2" href="{{route('admin.maintenance.updateProcedure')}}" data-toggle="tooltip" title="Maintenance Procedure">Maintenance Procedure</a>
                        <a class="dropdown-item p-2" href="{{route('admin.maintenance.audit')}}" data-toggle="tooltip" title="Check your Audit Log">Maintenance Log</a>
                        <a class="dropdown-item p-2" href="{{route('admin.maintenance.viewTask')}}" data-toggle="tooltip" title="View Maintenance List">View Maintenance Task List</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-1 mt-2">
            <a class="sidebar-button p-3" href="{{route('admin.report.generate')}}" data-toggle="tooltip" title="Generate your report">
                <img class="" src="{!! url('assets/icons/report.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Generate Report</span>
            </a>
        </div>
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('admin.reservation.scanQR')}}" data-toggle="tooltip" title="Scan the renter's QR Code">
                <img class="" src="{!! url('assets/icons/qr-code.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">QR Scan</span>
            </a>
        </div>
    </div>
</div>
