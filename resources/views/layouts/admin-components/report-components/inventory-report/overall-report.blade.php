<table class="table table-striped table-bordered ">
    <thead>
        <tr>
            <th class="view-head text-center">Item No.</th>
            <th class="view-head text-center">Item Description</th>
            <th class="view-head text-center">Quantity</th>
            <th class="view-head text-center">Unit</th>
            <th class="view-head text-center">Status</th>
            <th class="view-head text-center">Date Received</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($addtblInventoriesC as $addtblInventoryC)
            <tr>
                <td class="view-head text-center fw-bold">{{ $addtblInventoryC->id }}</td>
                <td class="view-head text-center">{{ $addtblInventoryC->name }}</td>
                <td class="view-head text-center">{{ $addtblInventoryC->quantity }}</td>
                <td class="view-head text-center">{{ $addtblInventoryC->unit }}</td>
                <td class="view-head text-center">{{ $addtblInventoryC->status }}</td>
                <td class="view-head text-center">{{ $addtblInventoryC->created_at }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">No data available</td>
            </tr>
        @endforelse
    </tbody>
    <tbody>
        @foreach ($addtblInventoriesF as $addtblInventoryF)
            <tr>
                <td class="view-head text-center fw-bold">{{ $addtblInventoryF->itemId }}</td>
                <td class="view-head text-center">{{ $addtblInventoryF->name }}</td>
                <td class="view-head text-center">{{ $addtblInventoryF->quantity }}</td>
                <td class="view-head text-center">pieces</td>
                <td class="view-head text-center">{{ $addtblInventoryF->status }}</td>
                <td class="view-head text-center">{{ $addtblInventoryF->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

