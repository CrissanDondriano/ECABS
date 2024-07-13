@extends('layouts.admin-app')

@section('content')
    <style>
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
    </style>
    <div class="container-fluid content-wrapper">
        <div class="row m-1">

            <!-- Tabs navs -->
            <ul class="nav nav-tabs justify-content-between" id="ex-with-icons" role="tablist">
                <li class="nav-item text-start">
                    <a class="nav-link " style="color: rgb(255, 136, 0);">
                        <i class="fa-solid fa-box fa-fw fa-lg me-2"></i>Manage Inventory
                    </a>
                </li>
                <ul class="nav nav-tabs justify-content-end" style="flex-grow: 1;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="ex-with-icons-tab-1" data-bs-toggle="tab"
                            href="#ex-with-icons-tabs-1" role="tab" aria-controls="ex-with-icons-tabs-1"
                            aria-selected="true">Consumable</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex-with-icons-tab-2" data-bs-toggle="tab" href="#ex-with-icons-tabs-2"
                            role="tab" aria-controls="ex-with-icons-tabs-2" aria-selected="false">Equipment</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex-with-icons-tab-3" data-bs-toggle="tab" href="#ex-with-icons-tabs-3"
                            role="tab" aria-controls="ex-with-icons-tabs-3" aria-selected="false">Damaged</a>
                    </li>
                </ul>
            </ul>

            <!-- Tabs content -->
            <div class="tab-content" id="ex-with-icons-content">
                <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-1">
                    <div class="col mt-3">
                        <h3 class=" fw-bold mb-4">Consumable Item Inventory</h3>

                        <div class="col text-end pb-3">
                            <button type="submit" class="btn btn-outline-success text-capitalize ms-1"
                                data-bs-toggle="modal" data-bs-target="#addConsumableModal"><i
                                    class="fa-regular fa-square-plus text-outline-success"
                                    style="padding-right: 8px;"></i>Add
                                Consumable Item</button>
                        </div>

                        <div class="table-responsive">
                            <table id="consumable-inventory" class="table table-striped mb-4 nowrap table-sm"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Item No.</th>
                                        <th>Item Description</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($addtblInventoriesC as $addtblInventoryC)
                                        <tr>
                                            <td>{{ $addtblInventoryC->id }}</td>
                                            <td>{{ $addtblInventoryC->name }}</td>
                                            <td>{{ $addtblInventoryC->quantity }}</td>
                                            <td>{{ $addtblInventoryC->unit }}</td>
                                            <td><span
                                                    class="badge rounded-pill d-inline-block
                                    @if ($addtblInventoryC->status === 'Out of Stock') bg-danger
                                    @elseif ($addtblInventoryC->status === 'Low Stock') bg-warning
                                    @else
                                        bg-success @endif">
                                                    {{ $addtblInventoryC->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-warning consumableEditBtn"
                                                    data-id="{{ $addtblInventoryC->id }}"
                                                    data-name="{{ $addtblInventoryC->name }}"
                                                    data-quantity="{{ $addtblInventoryC->quantity }}"
                                                    data-unit="{{ $addtblInventoryC->unit }}"
                                                    data-status="{{ $addtblInventoryC->status }}" data-bs-toggle="modal"
                                                    data-bs-target="#updateConsumable">
                                                    <i class="fas fa-pen" style="color: #ffffff"></i>
                                                </button>
                                                <button type="submit" class="btn btn-info btnQRView"
                                                    data-qr="{{ $addtblInventoryC->qrcode }}" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal">
                                                    <i class="fas fa-qrcode fa-lg" style="color: #ffffff"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
                    <h3 class=" fw-bold my-3">Equipment Item Inventory</h3>
                    <div class="col text-end pb-3">
                        <button type="submit" class="btn btn-outline-success text-capitalize ms-1" data-bs-toggle="modal"
                            data-bs-target="#addFurnitureModal"><i class="fa-regular fa-square-plus text-outline-success"
                                style="padding-right: 8px;"></i>Add Equipment Item</button>
                    </div>
                    <div class="table-responsive">
                        <table id="equipment-inventory" class="table table-striped mb-4 nowrap table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Item Name</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addtblInventoriesI as $addtblInventoryI)
                                    @if ($addtblInventoryI->status === 'Available' || $addtblInventoryI->status === 'Reserved')
                                        <tr>
                                            <td class="fw-bold">{{ $addtblInventoryI->itemId }}</td>
                                            <td>{{ $addtblInventoryI->name }}</td>
                                            <td>
                                                <span
                                                    class="badge rounded-pill d-inline-block
                                                    @if ($addtblInventoryI->status === 'Reserved') bg-info
                                                    @else
                                                        bg-success @endif">
                                                    {{ $addtblInventoryI->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <button type="submit" id="inventoryEditBtn"
                                                    class="btn btn-warning inventoryEditBtn"
                                                    data-id="{{ $addtblInventoryI->id }}"
                                                    data-identity="{{ $addtblInventoryI->itemId }}"
                                                    data-name="{{ $addtblInventoryI->name }}"
                                                    data-quantity="{{ $addtblInventoryI->quantity }}"
                                                    data-status="{{ $addtblInventoryI->status }}" data-bs-toggle="modal"
                                                    data-bs-target="#updateFurniture">
                                                    <i class="fas fa-pen" style="color: #ffffff"></i>
                                                </button>
                                                <button type="submit" class="btn btn-info btnQRView"
                                                    data-qr="{{ $addtblInventoryI->qrcode }}" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal">
                                                    <i class="fas fa-qrcode fa-lg" style="color: #ffffff"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="tab-pane fade" id="ex-with-icons-tabs-3" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-3">
                    <h3 class=" fw-bold my-3">Damaged Item Inventory</h3>
                    <div class="table-responsive">
                        <table id="damaged-inventory" class="table table-striped mb-4 nowrap table-sm"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>SKU</th>
                                    <th>Item Name</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($addtblInventoriesI as $addtblInventoryI)
                                    @if ($addtblInventoryI->status === 'Damaged')
                                        <tr>
                                            <td class="fw-bold">{{ $addtblInventoryI->itemId }}</td>
                                            <td>{{ $addtblInventoryI->name }}</td>
                                            <td>
                                                <span class="badge rounded-pill d-inline-block bg-danger">
                                                    {{ $addtblInventoryI->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-warning inventoryEditBtn"
                                                    data-id="{{ $addtblInventoryI->id }}"
                                                    data-identity="{{ $addtblInventoryI->itemId }}"
                                                    data-name="{{ $addtblInventoryI->name }}"
                                                    data-quantity="{{ $addtblInventoryI->quantity }}"
                                                    data-status="{{ $addtblInventoryI->status }}" data-bs-toggle="modal"
                                                    data-bs-target="#updateFurniture">
                                                    <i class="fas fa-pen" style="color: #ffffff"></i>
                                                </button>
                                                <button type="submit" class="btn btn-info btnQRView"
                                                    data-qr="{{ $addtblInventoryI->qrcode }}" data-bs-toggle="modal"
                                                    data-bs-target="#viewModal">
                                                    <i class="fas fa-qrcode fa-lg" style="color: #ffffff"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Tabs content -->
            </div>
        </div>
    </div>

    <!-- Add Consumable Modal -->
    <div class="modal fade" id="addConsumableModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="addModalLabel">Add Consumable Item</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating my-3">
                            <input type="text" name="addItemConsumableName" id="addItemConsumableName"
                                class="form-control" />
                            <label for="form12">Item Description</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" name="addItemConsumableQuantity" id="addItemConsumableQuantity"
                                class="form-control" placeholder=" " />
                            <label for="form12">Quantity</label>
                        </div>

                        <select class="form-select" aria-label="Default select example" id="addItemConsumableUnit"
                            name="addItemConsumableUnit">
                            <option value="" selected>Select Unit</option>
                            <option value="set">set</option>
                            <option value="pieces">pieces</option>
                            <option value="kg">kg (kilogram)</option>
                            <option value="bdl">bdl (bundle)</option>
                            <option value="gal">gal (gallon)</option>
                            <option value="doz">doz (dozen)</option>
                            <option value="roll">roll</option>
                            <option value="ltr">ltr (liter)</option>
                            <option value="drum">drum</option>
                            <option value="box">box</option>
                        </select>

                        <div class="form-floating my-3">
                            <input type="text" name="addItemConsumableType" id="addItemConsumableType"
                                class="form-control" value="consumable" readonly>
                            <label for="form12">Item Type</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="addConsumableBtn">Add Item</button>
                    </div>
            </div>
        </div>
    </div>

    <!-- Add Furniture Modal -->
    <div class="modal fade" id="addFurnitureModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="addModalLabel">Add Equipment Item</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating my-3">
                            <input type="text" name="addItemFurnitureName" id="addItemFurnitureName"
                                class="form-control" placeholder=" " />
                            <label for="form12">Item Description</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="number" name="addItemFurnitureQuantity" id="addItemFurnitureQuantity"
                                class="form-control" placeholder=" " />
                            <label for="form12">Quantity</label>
                        </div>
                        <div class="form-floating my-3">
                            <input type="text" name="addItemFurnitureType" id="addItemFurnitureType"
                                class="form-control" value="furniture" readonly>
                            <label for="form12">Item Type</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="addFurnitureBtn">Add Item</button>
                    </div>
            </div>
        </div>
    </div>

    <!-- Update Consumable Modal -->
    <div class="modal fade" id="updateConsumable" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" class="inventoryEdit" action="" accept-charset="UTF-8">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="updateModalLabel">Update Item Information Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>Item Details:</p>
                                    <div class="form-floating my-3">
                                        <input type="text" name="name" id="form12"
                                            class="form-control inventoryNameForm" placeholder=" " />
                                        <label for="form12">Item Description</label>
                                    </div>
                                    <div class="form-floating my-3">
                                        <input type="number" name="quantity" id="form12"
                                            class="form-control inventoryQuantityForm" placeholder=" " />
                                        <label for="form12">Quantity</label>
                                    </div>
                                    <div class="form-floating my-3">
                                        {{-- <input type="text" name="unit" id="form12"
                                            class="form-control inventoryUnitForm" placeholder=" " /> --}}

                                        <select class="form-control inventoryUnitForm"
                                        name="unit" id="form12">
                                            <option value="" selected>Select Unit</option>
                                            <option value="set">set</option>
                                            <option value="pieces">pieces</option>
                                            <option value="kg">kg (kilogram)</option>
                                            <option value="bdl">bdl (bundle)</option>
                                            <option value="gal">gal (gallon)</option>
                                            <option value="doz">doz (dozen)</option>
                                            <option value="roll">roll</option>
                                            <option value="ltr">ltr (liter)</option>
                                            <option value="drum">drum</option>
                                            <option value="box">box</option>
                                        </select>
                                        <label for="form12">Item Unit</label>
                                        
                                    </div>
                                    <p>Status: <span id="ConsumableStatusForm"
                                            class="badge rounded-pill d-inline-block"></span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning ">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Update Furniture Modal -->
    <div class="modal fade" id="updateFurniture" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" class="inventoryEdit" action="" accept-charset="UTF-8">
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="updateModalLabel">Update Item Information Details</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <p>Item Details:</p>
                                    <div class="form-floating my-3">
                                        <input type="text" name="name" id="form12"
                                            class="form-control inventoryNameForm" placeholder=" " readonly />
                                        <label for="form12">Item Description</label>
                                    </div>
                                    <div class="form-floating my-3">
                                        <input type="number" name="quantity" id="form12"
                                            class="form-control inventoryQuantityForm" value="1" readonly />
                                        <label for="form12">Quantity</label>
                                    </div>
                                    <div class="form-floating my-3">
                                        <input type="text" name="unit" id="form12"
                                            class="form-control inventoryIdForm" value="pieces" readonly />
                                        <label for="form12">Item Id</label>
                                    </div>
                                    <p style="display: none"><span id="FurnitureIdForm"></span></p>
                                    <p>Status: <span id="FurnitureStatusForm"
                                            class="badge bg-success rounded-pill d-inline-block"></span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p>Update Status:</p>
                                    <div class="text-center">
                                        @csrf
                                        <button type="button"
                                            class="btn btn-success markChange inventoryMarkAvailable mb-2">Mark as
                                            Available</button>
                                        <button type="button"
                                            class="btn btn-primary markChange inventoryMarkReceived mb-2">Mark as
                                            Reserved</button>
                                        <button type="button" class="btn btn-danger inventoryMarkDamaged">Mark as
                                            Damaged</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        {{-- <button type="submit" class="btn btn-warning">Update Item</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View QR Code Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="viewModalLabel">Asset Tagging</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="content">
                        <div class="card-qr">
                            <img id="qrCodeImg" src=""
                                onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/h8AAwAB/6X2gVEAAAAASUVORK5CYII=';"
                                width="100%">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="downloadQRCode">Download
                        QR Code</button> --}}
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#addConsumableBtn").click(function() {
            var name = $("#addItemConsumableName").val();
            var quantity = $("#addItemConsumableQuantity").val();
            var unit = $("#addItemConsumableUnit").val();
            var type = $("#addItemConsumableType").val();

            $.ajax({
                url: '/admin/inventory/addConsumable',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    name: name,
                    quantity: quantity,
                    unit: unit,
                    type: type,
                },
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Consumable Item(s) has been Added!!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/inventory/manage';
                    });
                },
                error: function(xhr, status, error) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error on Adding Inventory item:<br>' +
                                    parseErrors(xhr.responseText) +
                                    '</div>',
                            },
                        },
                        icon: 'error'
                    });

                    console.log(xhr.responseText);
                }
            });
        });

        $("#addFurnitureBtn").click(function() {
            var name = $("#addItemFurnitureName").val();
            var quantity = $("#addItemFurnitureQuantity").val();
            var type = $("#addItemFurnitureType").val();

            $.ajax({
                url: '/admin/inventory/addInventory',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    name: name,
                    quantity: quantity,
                    type: type,
                },
                success: function(response) {
                    swal({
                        title: 'Success',
                        text: 'Furniture Item(s) has been Added!!',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/admin/inventory/manage';
                    });
                },
                error: function(xhr, status, error) {
                    swal({
                        title: 'Error',
                        content: {
                            element: 'div',
                            attributes: {
                                innerHTML: '<div style="text-align: left;">' +
                                    'Error on Adding Consumable item:<br>' +
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
