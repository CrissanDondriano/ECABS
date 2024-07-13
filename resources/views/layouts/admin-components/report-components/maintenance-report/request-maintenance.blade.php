<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="view-head text-center">Task Name</th>
            <th class="view-head text-center">Location</th>
            <th class="view-head text-center">Schedule Date</th>
            <th class="view-head text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($addScheduleTask as $scheduleTask)
            <tr>
                <td class="view-head text-center">{{ $scheduleTask->name }}</td>
                <td class="view-head text-center">{{ $scheduleTask->location }}</td>
                <td class="view-head text-center">{{ $scheduleTask->date }}</td>
                <td class="view-head text-center">{{ $scheduleTask->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No data available</td>
            </tr>
        @endforelse
    </tbody>

</table>
