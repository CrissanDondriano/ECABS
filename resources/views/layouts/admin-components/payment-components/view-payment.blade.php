@extends('layouts.admin-app')

@section('content')
    <div class="container-fluid content-wrapper">
        <div class="row mt-4 m-1">
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
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('#view-payment').dataTable({
                responsive: true,
                fixedheader: true,
                "order": [
                    [0, "desc"]
                ]
            });

        });
    </script>
@endsection
