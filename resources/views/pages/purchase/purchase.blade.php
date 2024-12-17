@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Purchase Order')

@section('content')
{{-- Button Trigger Modal --}}
<button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
    data-bs-toggle="modal" data-bs-target="#modal">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="white" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
    </svg>Create PO</button>
{{-- Table --}}
<div class="col-12">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <tr>
                    <th>PO Code</th>
                    <th>Reference</th>
                    <th>Order Date</th>
                    <th>Vendor</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @forelse ($purchase as $item)
                <tr>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->quotation->reference }}</td>
                    <td>{{ $item->quotation->orderDate }}</td>
                    <td>{{ $item->quotation->vendor->name }}</td>
                    <td>Rp {{ number_format( $item->quotation->total, 2) }}</td>
                    <td>
                        <span class="badge 
                        @if($item->status == 0) bg-secondary
                        @elseif($item->status == 1) bg-info
                        @elseif($item->status == 2) bg-warning
                        @elseif($item->status == 3) bg-success
                        @endif">
                            @if($item->status == 0) Draft
                            @elseif($item->status == 1) Sent
                            @elseif($item->status == 2) Confirmed
                            @elseif($item->status == 3) Received
                            @endif
                    </span>
                    </td>
                    <td class="d-flex align-items-center gap-2">
                        <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detail{{ $item->id }}">
                        <i class="bi bi-eye text-white"></i>
                    </a>
                    <form action="{{ route('purchase.destroy', ['id' => $item->id]) }}" method="POST"
                            onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash-fill text-white"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="7" align="center">Purchases Not Found</td>
                @endforelse
               

            </table>
        </div>
    </div>
</div>


{{-- Showing Modal Add  --}}
@foreach ($quotations as $item)
<div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <form action="{{ route('purchase.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create Purchase Order</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="code" class="fw-medium mb-2">Purchase Code</label>
                                <input type="text" class="form-control" id="code" name="code">
                            </div>
                            <div class="form-group mb-3">
                                <label for="idQuotation" class="fw-medium mb-2">RFQ Reference</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="idQuotation" name="idQuotation" required>
                                        <option value="">--Choose Reference--</option>
                                        @foreach ($filteredQuotations as $reference => $data)
                                        <option value="{{ $reference }}" 
                                                data-ingredients="{{ json_encode($data['ingredients']) }}"
                                                data-total="{{ $data['total'] }}">
                                            {{ $reference }}
                                        </option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>                   
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-md" id="ingredients-table">
                                <thead>
                                    <tr>
                                        <th>Ingredients</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="text-center">No ingredients selected</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <span id="total-price">Total: 0</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancel</span>
                    </button>
                    <button type="submit" class="btn btn-primary ms-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Create PO</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Showwing Detail Model --}}
@foreach ($purchase as $item)
<div class="modal fade modal-borderless modal-lg" id="detail{{ $item->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <form action="{{ route('purchase.update',['id' => $item->id]) }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fs-2">{{ $item->code }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Vendor: [{{ $item->quotation->vendor->code }}] {{ $item->quotation->vendor->name }}</h6>
                            <p>Status: 
                                <span class="badge 
                                    @if($item->status == 0) bg-secondary 
                                    @elseif($item->status == 1) bg-info
                                    @elseif($item->status == 2) bg-warning
                                    @elseif($item->status == 3) bg-success
                                    @endif">
                                    @if ($item->status == 0) Draft
                                    @elseif ($item->status == 1) Sent
                                    @elseif ($item->status == 2) Confirmed
                                    @elseif ($item->status == 3) Received
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <thead>
                                    <tr>
                                        <th>Ingredients</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($quotations->where('reference', $item->quotation->reference) as $quotation)
                                    <tr>
                                        <td>{{ $quotation->ingredient->name }}</td>
                                        <td>{{ $quotation->qtyIngredients }}</td>
                                        <td>Rp {{ number_format($quotation->ingredient->price, 2) }}</td>
                                        <td>Rp {{ number_format($quotation->qtyIngredients * $quotation->ingredient->price, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <span class="d-flex justify-content-end mt-2">
                            Total: Rp {{ number_format($item->quotation->total) }}
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancel</span>
                    </button>
                    <button type="submit" class="btn btn-success ms-1" @if ($item->status == 3) disabled @endif>
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">
                            @if ($item->status == 0) Sent
                            @elseif ($item->status == 1) Confirmed
                            @elseif ($item->status == 2) Received
                            @elseif ($item->status == 3) Payment
                            @endif
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const quotationDropdown = document.getElementById('idQuotation');
    const ingredientsTable = document.getElementById('ingredients-table').querySelector('tbody');
    const totalPriceSpan = document.getElementById('total-price');

    quotationDropdown.addEventListener('change', function () {
        const selectedOption = quotationDropdown.options[quotationDropdown.selectedIndex];
        const ingredientsJson = selectedOption.getAttribute('data-ingredients');
        const total = selectedOption.getAttribute('data-total');

        ingredientsTable.innerHTML = '';

        try {
            const ingredientsData = JSON.parse(ingredientsJson);

            if (ingredientsData.length > 0) {
                ingredientsData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.ingredient_name}</td>
                        <td>${item.qty}</td>
                        <td>${item.price}</td>
                        <td>${item.total}</td>
                    `;
                    ingredientsTable.appendChild(row);
                });
                totalPriceSpan.textContent = `Total: ${total}`;
            } else {
                const row = document.createElement('tr');
                row.innerHTML = `<td colspan="4" class="text-center">No ingredients available</td>`;
                ingredientsTable.appendChild(row);
                totalPriceSpan.textContent = 'Total: 0';
            }
        } catch (error) {
            console.error('Error parsing ingredients data:', error);
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="4" class="text-center">Error loading ingredients</td>`;
            ingredientsTable.appendChild(row);
            totalPriceSpan.textContent = 'Total: 0';
        }
    });
});
</script>


@endsection
