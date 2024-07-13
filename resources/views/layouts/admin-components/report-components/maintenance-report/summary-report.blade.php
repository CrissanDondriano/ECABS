<table class="table table-striped table-bordered">
    <thead >
        <tr>
            <th class="view-head text-center">Total number of tasks</th>
            <th class="view-head text-center">Total number of locations</th>
            <th class="view-head text-center">Total number of assigned staff</th>
            <th class="view-head text-center">Total number of completed tasks</th>
            <th class="view-head text-center">Total number of pending tasks</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="view-head text-center">{{ $totalTasks }}</td>
            <td class="view-head text-center">{{ $totalLocations }}</td>
            <td class="view-head text-center">{{ $totalAssignedStaff }}</td>
            <td class="view-head text-center">{{ $totalCompletedTasks }}</td>
            <td class="view-head text-center">{{ $totalPendingTasks }}</td>
        </tr>
    </tbody>

</table>