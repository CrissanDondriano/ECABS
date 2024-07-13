<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="view-head text-center">Invoice Number</th>
            <th class="view-head text-center">Renter's Name</th>
            <th class="view-head text-center">Payment Amount</th>
            <th class="view-head text-center">Payment Date</th>
            <th class="view-head text-center">Payment Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($addPayment as $payment)
            <tr>
                <td class="view-head text-center fw-bold">INV-{{ $payment->id }}</td>
                <td class="view-head text-center">{{ $payment->name }}</td>
                <td class="view-head text-center">₱ {{ $payment->amount }}</td>
                <td class="view-head text-center">{{ $payment->date }}</td>
                <td class="view-head text-center">{{ $payment->status }}</td>   
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">No data available</td>
            </tr>
        @endforelse
    </tbody>

</table>
