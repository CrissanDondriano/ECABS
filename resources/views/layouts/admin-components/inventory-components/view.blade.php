@extends('layouts.admin-app')

@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row m-1">

            <!-- Tabs navs -->
            <ul class="nav nav-tabs justify-content-between" id="ex-with-icons" role="tablist">
                <li class="nav-item text-start">
                    <a class="nav-link " style="color: rgb(255, 136, 0);">
                        <i class="fa-regular fa-calendar fa-fw fa-lg me-2" ></i>View Inventory
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
                </ul>
            </ul>
            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content" id="ex-with-icons-content">
                <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel"
                    aria-labelledby="ex-with-icons-tab-1">
                    <div class="col mt-3">
                        <h3 class=" fw-bold mb-4">View Consumable Inventory</h3>
                        <div class="table-responsive">
                            <table id="view-inventory" class="table table-striped mb-4 nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Item No.</th>
                                        <th>Item Description</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                        <th>Date Received</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($addtblInventoriesC as $consumable)
                                        <tr>
                                            <td>{{ $consumable->id }}</td>
                                            <td>{{ $consumable->name }}</td>
                                            <td>{{ $consumable->quantity }}</td>
                                            <td>{{ $consumable->unit }}</td>
                                            <td><span
                                                    class="badge rounded-pill d-inline-block
                                            @if ($consumable->status === 'Out of Stock') bg-danger
                                            @elseif ($consumable->status === 'Low Stock') bg-warning
                                            @else
                                                bg-success @endif">
                                                    {{ $consumable->status }}
                                                </span></td>
                                            <td>{{ $consumable->created_at }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2">
                    <div class="col mt-3">
                        <h3 class="fw-bold mb-4">View Equipment Inventory</h3>
                        <div class="table-responsive">
                            <table id="consumable-inventory" class="table table-striped mb-4 nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SKU</th>
                                        <th>Item Description</th>
                                        <th>Status</th>
                                        <th>Date Received</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($addtblInventoriesI as $furniture)
                                        <tr>
                                            <td class="fw-bold">{{ $furniture->itemId }}</td>
                                            <td>{{ $furniture->name }}</td>
                                            <td><span
                                                    class="badge rounded-pill d-inline-block
                                            @if ($furniture->status === 'Damaged') bg-danger
                                            @elseif ($furniture->status === 'Reserved') bg-info
                                            @else
                                                bg-success @endif">
                                                    {{ $furniture->status }}
                                                </span></td>
                                            <td>{{ $furniture->created_at }}</td>
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
@endsection
