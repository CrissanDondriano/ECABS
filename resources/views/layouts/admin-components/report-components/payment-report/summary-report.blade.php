<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="view-head text-center">Total number of payments</th>
            <th class="view-head text-center">Total payment amount</th>
            <th class="view-head text-center">Average payment amount</th>
            <th class="view-head text-center">Number of payments with status "Paid"</th>
            <th class="view-head text-center">Number of payments with status "Unpaid"</th>
            <th class="view-head text-center">Earliest payment date</th>
            <th class="view-head text-center">Latest payment date</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="view-head text-center">{{ $totalPayments }}</td>
            <td class="view-head text-center">₱ {{ $totalPaymentAmount }}</td>
            <td class="view-head text-center">₱ {{ $averagePaymentAmount }}</td>
            <td class="view-head text-center">{{ $paidPayments }}</td>
            <td class="view-head text-center">{{ $unpaidPayments }}</td>
            <td class="view-head text-center">{{ $earliestPaymentDate }}</td>
            <td class="view-head text-center">{{ $latestPaymentDate }}</td>
        </tr>
    </tbody>
</table>