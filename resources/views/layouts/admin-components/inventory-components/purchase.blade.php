@extends('layouts.admin-app')

@section('content')
    <style>
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
                    <a class="nav-link " style="color: rgb(255, 136, 0);">
                        <i class="fa-solid fa-scroll fa-fw fa-lg me-2"></i>Purchase Request
                    </a>
                </li>
                <ul class="nav  nav-tabs justify-content-end" style="flex-grow: 1;">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="ex-with-icons-tab-1" data-bs-toggle="tab"
                            href="#ex-with-icons-tabs-1" role="tab" aria-controls="ex-with-icons-tabs-1"
                            aria-selected="true">Item List</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="ex-with-icons-tab-2" data-bs-toggle="tab" href="#ex-with-icons-tabs-2"
                            role="tab" aria-controls="ex-with-icons-tabs-2" aria-selected="false">Request Status</a>
                    </li>
                </ul>
            </ul>
            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content" id="ex-with-icons-content">
                <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-1">
                    <div class="col mt-3">
                        <h3 class="fw-bold pb-3">List of Item</h3>
                        <div class="alert alert-primary alert-dismissible fade show">
                            <strong>Reminder!</strong> Please click the plus button to add in List Item For Request.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        <div class="col d-flex justify-content-between pb-3">
                            <button type="submit" class="btn btn-outline-primary text-capitalize ms-1"
                                data-bs-toggle="modal" data-bs-target="#makepurchaseModal"><i
                                    class="fas fa-cart-shopping text-outline-primary" style="padding-right: 8px;"></i>List
                                Item For Request
                                @php
                                    $length = count($addRequestItems);
                                @endphp

                                @if ($length > 0)
                                    <span class="badge bg-danger ms-1">
                                        {{ $length }}
                                    </span>
                                @endif
                            </button>
                            <button type="submit" class="btn btn-outline-success text-capitalize ms-1"
                                data-bs-toggle="modal" data-bs-target="#addModal"><i
                                    class="fa-regular fa-square-plus text-outline-success"
                                    style="padding-right: 8px;"></i>Add Item</button>
                        </div>

                        <table id="listItem" class="table table-striped mb-4 nowrap table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Item Description</th>
                                    <th>Item Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($addItems as $addItem)
                                    <tr>
                                        <td class="text-center">
                                            <form method="POST"
                                                action="{{ route('admin.inventory.addRequestItem', $addItem->id) }}"
                                                accept-charset="UTF-8" class="formAddRequestItem">
                                                @csrf
                                                <button type="submit" class="btn btn-primary ms-1"
                                                    style="border-radius: 20px;"><i class="fas fa-plus"></i></button>

                                            </form>
                                        </td>
                                        <td>{{ $addItem->name }}</td>
                                        <td>{{ $addItem->type }}</td>
                                        <td>
                                            <button type="submit" class="btn btn-warning updateListItem"
                                                data-id="{{ $addItem->id }}" data-name="{{ $addItem->name }}"
                                                data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fas fa-pen"
                                                    style="color: #ffffff"></i></button>
                                            <button type="submit" class="btn btn-danger deleteListItem"
                                                data-id="{{ $addItem->id }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteItemModal"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>

                <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
                    <h3 class=" fw-bold my-3">Letter of Request List</h3>
                    <div class="table-responsive">
                        <table id="requestStatus" class="table table-striped mb-4 nowrap table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $latestRequestLists = $addRequestLists->sortByDesc('created_at');
                                @endphp
                                @foreach ($latestRequestLists as $addRequestList)
                                    <tr>
                                        <td>{{ $addRequestList->id }}</td>
                                        <td>{{ $addRequestList->created_at }}</td>
                                        <td> <span
                                                class="badge rounded-pill d-inline-block
                                            @if ($addRequestList->status === 'Pending') bg-warning
                                            @elseif ($addRequestList->status === 'Rejected') bg-danger
                                            @else bg-success @endif">
                                                {{ $addRequestList->status }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($addRequestList->status === 'Pending')
                                                <button type="submit" class="btn btn-success approveRequest"
                                                    data-id="{{ $addRequestList->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#approveModal">
                                                    <i class="fa-regular fa-circle-check fa-lg"></i>
                                                </button>
                                                <button type="submit" class="btn btn-danger rejectRequest"
                                                    data-id="{{ $addRequestList->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal">
                                                    <i class="fa-regular fa-circle-xmark fa-lg"></i>
                                                </button>
                                            @endif
                                            <button type="submit" class="btn btn-info viewModalBtn"
                                                data-id="{{ $addRequestList->id }}" data-bs-toggle="modal"
                                                data-bs-target="#viewModal">
                                                <i class="fas fa-eye" style="color: #ffffff"></i>
                                            </button>
                                            <button type="submit" class="btn btn-danger deleteRequest"
                                                data-id="{{ $addRequestList->id }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal1">
                                                <i class="fas fa-trash fa-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Tabs content -->
        </div>
    </div>

    <!-- Add Item List Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.inventory.addItem') }}" accept-charset="UTF-8">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="addModalLabel">Add Item</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating my-3">
                            <input type="text" name="itemName" id="form12" class="form-control"
                                placeholder=" " />
                            <label for="form12">Item Description</label>
                        </div>
                        <div class="form-floating my-3">
                            <select class="form-select" aria-label="Default select example" name="itemType">
                                <option selected>Select Unit</option>
                                <option value="consumable">consumable</option>
                                <option value="furniture">furniture</option>
                            </select>
                            <label for="form12">Item Type</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Item</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Update Item Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" id="listUpdateForm" action="" accept-charset="UTF-8">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title fw-bold" id="updateItemModalLabel">Modify Item Description</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="my-2">
                            <label for="itemId" class="form-label fw-bold">Item No: <span
                                    class="requestListIdUpd"></span></label>
                        </div>
                        <div class="my-2">
                            <label for="itemName" class="form-label">Item Description: </label>
                            <input type="text" name="itemName" id="form12" class="form-control requestListNameUpd"
                                placeholder=" " />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="listItemUpdateBtn" class="btn btn-warning">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Item Modal -->
    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteItemModalLabel">Delete Item</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Item No. <span class="requestListIdDel"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="listItemDeleteBtn" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Make Purchase Modal --}}
    <div class="modal fade" id="makepurchaseModal" tabindex="-1" aria-labelledby="makepurchaseModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="makepurchaseModalLabel">Request List</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="requestList" class="table table-striped mb-4 nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Item No.</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Item Description</th>
                                    <th>Item Type</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($addRequestItems as $addRequestItem)
                                    <tr class="requestItemRow">
                                        <td>{{ $addRequestItem->itemId }}</td>
                                        <td>
                                            <input type="number" class="form-control" style="width: 60px;"
                                                value="{{ $addRequestItem->quantity }}">
                                        </td>

                                        <td>
                                            <select class="form-select" aria-label="Default select example"
                                                style="width: 130px;" @if ($addRequestItem->type === 'furniture') disabled @endif>
                                                <option value="">Select Unit</option>

                                                <option value="1">set</option>
                                                <option value="2" @if ($addRequestItem->type === 'furniture') selected @endif>
                                                    pieces
                                                </option>
                                                <option value="3">kg</option>
                                                <option value="4">bdl</option>
                                                <option value="5">gal</option>
                                                <option value="6">doz</option>
                                                <option value="7">roll</option>
                                                <option value="8">ltr</option>
                                                <option value="9">drum</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control"
                                                    aria-describedby="button-addon2" value="{{ $addRequestItem->name }}"
                                                    disabled>
                                                <button class="btn btn-warning enable-button" type="button"
                                                    id="button-addon2"> <i class="fas fa-pen"></i></button>
                                            </div>
                                        </td>
                                        <td>{{ $addRequestItem->type }}</td>

                                        <td>
                                            <button type="submit" class="btn btn-danger deleteRequestItem"
                                                data-id="{{ $addRequestItem->id }}"
                                                data-itemid="{{ $addRequestItem->itemId }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="makePurchase" class="btn btn-outline-primary text-capitalize"
                        data-bs-toggle="modal"><i class="fa-regular fa-paper-plane text-outline-primary"
                            style="padding-right: 8px;"></i>View Overall Request & Purpose</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add to Cart Modal -->
    <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="addToCartModalLabel">Preview Item</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 class="text-center mb-4 fw-bold">Please login</h2>
                    <div class="d-grid gap-2 mb-3">
                        <input type="number" class="form-control" name="username" placeholder="Quantity" required />
                        <select class="form-select">
                            <option value="" selected>Select Unit</option>
                            <option value="1">set</option>
                            <option value="2">pieces</option>
                            <option value="3">kg</option>
                            <option value="4">bdl</option>
                            <option value="5">gal</option>
                            <option value="6">doz</option>
                            <option value="7">roll</option>
                            <option value="8">ltr</option>
                            <option value="9">drum</option>
                        </select>
                    </div>

                    <div class="d-grid my-2 mt-2">
                        <button type="button" id="cartBtn" class="btn btn-primary">Add to Cart</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Purchase Modal -->
    <div class="modal fade" id="purchaseModal" tabindex="-1" aria-labelledby="purchaseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="purchaseModalLabel">Make Letter Request</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container ">
                        <table id="requestTable" class="table table-bordered my-3 nowrap" style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th>Item No.</th>
                                    <th>Qty</th>
                                    <th>Unit</th>
                                    <th>Item Description</th>
                                    <th>Item Type</th>
                                </tr>
                            </thead>
                            <tbody id="modalTableBody">
                            </tbody>
                        </table>
                        <div class="mb-3 mt-2">
                            <label for="purpose" class="form-label fw-bold control-label">Purpose ("What your purpose for
                                this item?")</label>
                            <textarea class="form-control bg-white" id="purpose" cols="120" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="purpose" class="form-label fw-bold control-label">Purpose 2 ("Explain in detailed
                                on how you can use the chosen item.")</label>
                            <textarea class="form-control bg-white" id="purpose2" cols="120" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="generateRequestBtn" class="btn btn-outline-primary text-capitalize"><i
                            class="fa-solid fa-file-lines text-outline-primary" style="padding-right: 8px;"></i>Make
                        Letter Request</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Request List Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteModalLabel">Delete Request</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="requestItemIdDel" style="display: none;"></span>
                    <p>Are you sure you want to delete this Item No. <span class="requestItemId2Del"></span> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="requestItemDeleteBtn" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Received Request List Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="approveModalLabel"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body overflow-auto" id="approveModalBody" style="max-height: 50rem;">

                </div>
                <div class="d-grid">
                    <button type="button" id="approveRequestBtn" class="btn btn-success rrounded-0 btn-block">Received</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Reject Request List Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="rejectModalLabel">Reject Request List</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure that you want to reject this request letter?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="rejectRequestBtn" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Request List Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="viewModalLabel">View Letter Request</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="page">
                        <div class="container">
                            <div class="mb-4">
                                <h5 class="text-center fw-bold" style="font-family: 'Times New Roman', serif;">LETTER REQUEST<br>CABUYAO
                                    CITY<br><span style="font-style: italic;">LGU</span></h5>
                            </div>
                            <table id="exportTable" class="table table-bordered table-sm" >
                                <thead>
                                    <tr>
                                        <th class="head-color">Department</th>
                                        <td colspan="3" class="head-color fw-bold">CABS</td>
                                        <th class="head-color">LR No.:</th>
                                        <th class="head-color">Date: </th>
                                    </tr>
                                    <tr>
                                        <th class="head-color">Purpose:</th>
                                        <td colspan="5" id="purposeValue" class="head-color"></td>
                                    </tr>
                                    <tr class="text-center">
                                        <th class="head-color py-2">Item No.</th>
                                        <th class="head-color py-2">Qty</th>
                                        <th class="head-color py-2">Unit</th>
                                        <th class="head-color py-2">Item Description</th>
                                        <th class="head-color py-2">Estimated Unit Cost</th>
                                        <th class="head-color py-2">Estimated Cost</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsTable" class="head-color"></tbody>
                                <tfoot>
                                    <tr>
                                        <th class="head-color"></th>
                                        <th colspan="4" class="text-end head-color p-2">TOTAL:</th>
                                        <th class="head-color"></th>
                                    </tr>
                                    <tr>
                                        <th class="head-color">Purpose</th>
                                        <td colspan="5" id="purpose2Value" class="head-color"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="head-color" style="padding: 15px;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="head-color"></td>
                                        <td colspan="2" class="head-color fw-bold">Requested by: </td>
                                        <td colspan="2" class="head-color fw-bold">Approved by: </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="head-color">Signature: </th>
                                        <td colspan="2" class="head-color"></td>
                                        <td colspan="2" class="head-color"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="head-color">Printed Name: </th>
                                        <td colspan="2" class="text-center head-color">Ruben L. Morales</td>
                                        <td colspan="2" class="text-center head-color">Hon. Dennis Felipe C. Hain
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="head-color">Department: </th>
                                        <td colspan="2" class="text-center fw-bold head-color">CABS</td>
                                        <td colspan="2" class="text-center fw-bold head-color">City Mayor</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="exportButton">Print or Generate to PDF</button>
                    <button type="button" class="btn btn-primary sendEmailBtn" data-bs-toggle="modal"
                        data-bs-target="#sendEmailModal">Send Letter via Email</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Request Modal -->
    <div class="modal fade" id="deleteModal1" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="deleteModalLabel">Delete Request</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Request ID. <span class="requestIdDel"></span>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="requestDeleteBtn" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Show Request Modal -->
    <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="sendEmailModalLabel">Send Request Letter via Email</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-2">
                            <div class="form-group">
                                <label for="send-email">Email the Request ID: <span
                                        id="addRequestIdPlaceholder"></span></label>
                                <input id="send-email" class="form-control" type="email"
                                    placeholder="user@example.com">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="sentMailBtn" class="btn btn-primary">Send Email</button>
                </div>
            </div>
        </div>
    </div>
@endsection
