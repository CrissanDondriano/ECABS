<thead>
    <tr>
        <th class="view-head text-center">Reservation ID</th>
        <th class="view-head text-center">Recipient Name</th>
        <th class="view-head text-center">Activity</th>
        <th class="view-head text-center">Facility</th>
        <th class="view-head text-center">Date</th>
        <th class="view-head text-center">Time Category</th>
        <th class="view-head text-center">Status</th>
    </tr>
</thead>
<tbody>
    @forelse ($viewReservations as $viewReservation)
        <tr>
            <td class="view-head text-center fw-bold">{{ $viewReservation->id }}</td>
            <td class="view-head text-center">{{ $viewReservation->recipientName }}</td>
            <td class="view-head text-center">{{ $viewReservation->activity }}</td>
            <td class="view-head text-center">{{ $viewReservation->facility }}</td>
            <td class="view-head text-center">{{ $viewReservation->date }}</td>
            <td class="view-head text-center">{{ $viewReservation->time }}</td>
            <td class="view-head text-center">{{ $viewReservation->status }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">No data available</td>
        </tr>
    @endforelse
</tbody>
