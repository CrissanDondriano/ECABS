@extends('layouts.staff-app')

@section('content')
<div class="container-fluid content-wrapper">
    <div class="row mt-4 inventory-container m-2 p-3">
        <h3 class=" fw-bold mb-4">View Inventory</h3>
        <div class="table-responsive">
            <table id="view-inventory" class="table table-striped table-hover nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Item ID</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Status</th>
                        <th>Date Received</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($addtblInventoriesC as $inventories)
                        <tr>
                            <td>{{ $inventories->id }}</td>
                            <td>{{ $inventories->name }}</td>
                            <td>{{ $inventories->quantity }}</td>
                            <td>{{ $inventories->unit }}</td>
                            <td><span class="badge rounded-pill d-inline-block
                                @if($inventories->status === 'Out of Stock')
                                    bg-danger
                                @elseif ($inventories->status === 'Low Stock') bg-warning
                                @else
                                    bg-success
                                @endif">
                                {{ $inventories->status }}
                                </span></td>
                            <td>{{$inventories->created_at}}</td>
                        </tr>
                        @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection