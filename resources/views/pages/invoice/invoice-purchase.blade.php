@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Invoice Purchase')

@section('content')
<button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
    data-bs-toggle="modal" data-bs-target="#modal">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="white" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
    </svg>Create Invoice Purchase</button>
{{-- Table --}}
<div class="col-12">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <tr>
                    <th>PO Code</th>
                    <th>Vendor</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                @forelse ($invoice as $item)
                <tr>
                    <td>{{ $item->purchase->code }}</td>
                    <td>{{ $item->purchase->quotation->vendor->name }}</td>
                    <td>Rp. {{ number_format($item->purchase->quotation->total, 2) }}</td>
                    <td>
                        <a href="{{ route('invoice-purchase.report', $item->id ) }}" class="btn btn-info">
                            <i class="bi bi-printer text-white"></i></a>
                    </td>
                </tr>
                @empty
                <td colspan="5" class="text-center text-white fw-bold">Invoices Not Found</td>
                @endforelse

            </table>
        </div>
    </div>
</div>

{{-- Showing Modal --}}
<div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <form action="{{ route('invoice-purchase.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create Invoice Purchase</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="purchaseId" class="fw-medium mb-2">PO Code</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="purchaseId" name="purchaseId" required>
                                        <option value="">--Choose PO Code--</option>
                                        @foreach ($filteredPurchase as $item)
                                        <option value="{{ $item['id'] }}"
                                            data-ingredients="{{ json_encode($item['ingredients']) }}">
                                            {{ $item['code'] }}
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
                                    <td colspan="4" align="center">Purchase Item Not Selected</td>
                                </tbody>
                            </table>
                        </div>
                        <span class="d-flex justify-content-end mt-2" id="total-price">
                            Total: 0
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancel</span>
                    </button>
                    <button type="submit" class="btn btn-primary  ms-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Create Invoice</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const purchaseDropdown = document.getElementById('purchaseId');
        const ingredientsTable = document.getElementById('ingredients-table').querySelector('tbody');
        const totalPriceSpan = document.getElementById('total-price');

        purchaseDropdown.addEventListener('change', function () {
            const selectedOption = purchaseDropdown.options[purchaseDropdown.selectedIndex];
            const ingredientsJson = selectedOption.getAttribute('data-ingredients');

            ingredientsTable.innerHTML = ''; // Reset tabel

            try {
                const ingredientsData = JSON.parse(ingredientsJson);
                let total = 0;

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
                        total += item.total;
                    });
                } else {
                    const row = document.createElement('tr');
                    row.innerHTML = `<td colspan="4" align="center">No Ingredients Available</td>`;
                    ingredientsTable.appendChild(row);
                }

                totalPriceSpan.textContent = `Total: ${total}`;
            } catch (error) {
                console.error('Error parsing ingredients data:', error);
                const row = document.createElement('tr');
                row.innerHTML = `<td colspan="4" align="center">Error Loading Ingredients</td>`;
                ingredientsTable.appendChild(row);
                totalPriceSpan.textContent = '0';
            }
        });
    });

</script>
@endsection
