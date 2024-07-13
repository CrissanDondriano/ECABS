<thead>
    <tr>
        <th colspan="2" class="text-center">Multi-Purpose Hall</th>
    </tr>
    <tr>
        <th class="view-head text-center">Approved Reservation</th>
        <th class="view-head text-center">Cancelled Reservation</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td id="totalReservations" class="view-head text-center">{{ $totalHallApproved }}</td>
        <td id="totalActivities" class="view-head text-center">{{ $totalHallCancelled }}</td>
    </tr>
    <tr>
        <td class="view-head text-center">Total Reservation</td>
        <td class="view-head text-center">{{ $totalHallOverall }}</td>
    </tr>
</tbody>

<thead>
    <tr>
        <th colspan="2" class="text-center">Aquatic Center</th>
    </tr>
    <tr>
        <th class="view-head text-center">Approved Reservation</th>
        <th class="view-head text-center">Cancelled Reservation</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td id="totalReservations" class="view-head text-center">{{ $totalAquaticApproved }}</td>
        <td id="totalActivities" class="view-head text-center">{{ $totalAquaticCancelled }}</td>
    </tr>
    <tr>
        <td id="totalReservations" class="view-head text-center">Total Reservation</td>
        <td id="totalActivities" class="view-head text-center">{{ $totalAquaticOverall }}</td>
    </tr>
</tbody>
