<table class="table table-striped table-bordered">
    <thead style="background-color:#84B0CA ;" class="text-white">
        <tr>
            <th class="view-head text-center">Request ID</th>
            <th class="view-head text-center">Items</th>
            <th class="view-head text-center">Status</th>
            <th class="view-head text-center">Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($viewTblRequest as $request)
            <tr>
                <td class="view-head text-center fw-bold">{{ $request->id }}</td>
                <td class="view-head">
                    @foreach ($request->items as $item)
                        ● {{ $item[3] }}
                        <br>
                    @endforeach
                </td>
                <td class="view-head text-center">{{ $request->status }}</td>
                <td class="view-head text-center">{{ $request->created_at }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No data available</td>
            </tr>
        @endforelse
    </tbody>

</table>