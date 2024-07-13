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
    @forelse ($declinedReviewItems as $decline)
    <tr>
        <td class="view-head text-center fw-bold">{{ $decline->id }}</td>
        <td class="view-head text-center">{{ $decline->recipientName }}</td>
        <td class="view-head text-center">{{ $decline->activity }}</td>
        <td class="view-head text-center">{{ $decline->facility }}</td>
        <td class="view-head text-center">{{ $decline->date }}</td>
        <td class="view-head text-center">{{ $decline->time }}</td>
        <td class="view-head text-center">{{ $decline->status }}</td>
    </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center">No data available</td>
        </tr>
    @endforelse
</tbody>
