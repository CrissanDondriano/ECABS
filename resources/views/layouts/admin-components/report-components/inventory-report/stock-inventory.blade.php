
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="view-head text-center">Item Description</th>
            <th class="view-head text-center">Total Quantity</th>
            <th class="view-head text-center">Unit</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($addtblInventoriesConsumable as $addtblInventoryC)
            <tr>
                <td class="view-head text-center">{{ $addtblInventoryC->name }}</td>
                <td class="view-head text-center">{{ $addtblInventoryC->quantity }}</td>
                <td class="view-head text-center">{{ $addtblInventoryC->unit }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center">No data available</td>
            </tr>
        @endforelse
    </tbody>
    <tbody>
        @foreach ($addtblInventoriesF as $furnitureItem)
            <tr>
                <td class="view-head text-center">{{ $furnitureItem['name'] }}</td>
                <td class="view-head text-center">{{ $furnitureItem['total_quantity'] }}</td>
                <td class="view-head text-center">pieces</td>
            </tr>
        @endforeach
    </tbody>
</table>
