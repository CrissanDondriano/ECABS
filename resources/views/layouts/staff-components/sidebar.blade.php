<div class="bg-white border-end" id="sidebar-wrapper">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{route('staff.home')}}" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none sidebar-heading">
            <img class="" src="{!! url('assets/images/CABS.png') !!}" alt="" width="45" height="45">
            <span class="h2 fw-bold mt-2 px-1 logo-name sidebar-text logo-text">eCABS</span>
        </a>
        <a class="sidebar-close p-4 fw-bold"><i class="fa-solid fa-x fa-xl" style="color: #000000;"></i></a>
    </div>
   
    <div class="list-group list-group-flush px-2">
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('staff.home')}}" data-toggle="tooltip" title="Overview">
                <img class="" src="{!! url('assets/icons/overview.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Overview</span>
            </a>
        </div>
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('staff.reservation.scanQR')}}" data-toggle="tooltip" title="Check the Renters QR Code">
                <img class="" src="{!! url('assets/icons/maintenance.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Scanning QR Code</span>
            </a>
        </div>
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('staff.reservation.view')}}" data-toggle="tooltip" title="View your Reservation List">
                <img class="" src="{!! url('assets/icons/booking.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Reservation List</span>
            </a>
        </div>
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('staff.inventory.view')}}" data-toggle="tooltip" title="View your Inventory">
                <img class="" src="{!! url('assets/icons/inventory.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Inventory Stock</span>
            </a>
        </div>
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('staff.maintenance.viewTask')}}" data-toggle="tooltip" title="Check your Maintenance Task">
                <img class="" src="{!! url('assets/icons/maintenance.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Maintenance List</span>
            </a>
        </div>
        <div class="p-1 mt-3">
            <a class="sidebar-button p-3" href="{{route('staff.payment.view')}}" data-toggle="tooltip" title="View your Payment Record List">
                <img class="" src="{!! url('assets/icons/money.png') !!}" alt="" width="25" height="25">
                <span class="sidebar-text px-1">Payment Record List</span>
            </a>
        </div>
    </div>
</div>
