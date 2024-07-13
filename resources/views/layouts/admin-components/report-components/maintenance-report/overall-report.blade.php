<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="view-head text-center">Schedule ID</th>
            <th class="view-head text-center">Task Name</th>
            <th class="view-head text-center">Location</th>
            <th class="view-head text-center">Schedule Date</th>
            <th class="view-head text-center">Assigned Staff</th>
            <th class="view-head text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($addScheduleTask as $scheduleTask)
            <tr>
                <td class="view-head text-center fw-bold">{{ $scheduleTask->id }}</td>
                <td class="view-head text-center">{{ $scheduleTask->name }}</td>
                <td class="view-head text-center">{{ $scheduleTask->location }}</td>
                <td class="view-head text-center">{{ $scheduleTask->date }}</td>
                @php
                    $staffList = json_decode($scheduleTask->staff_list, true);
                    $length = 0;
                    
                    if ($staffList) {
                        $length = count($staffList);
                    }
                @endphp

                @if ($length > 0)
                    <td class="view-head text-center">{{ $length }}</td>
                @else
                    <td class="view-head text-center">0</td>
                @endif
                <td class="view-head text-center">{{ $scheduleTask->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No data available</td>
            </tr>
        @endforelse
    </tbody>

</table>
