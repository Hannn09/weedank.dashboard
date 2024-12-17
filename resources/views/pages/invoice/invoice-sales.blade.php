@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Invoice Sales')

@section('content')
<button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
    data-bs-toggle="modal" data-bs-target="#modal">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="white" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
    </svg>Create Invoice Sales</button>
{{-- Table --}}
<div class="col-12">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <tr>
                    <th>Sales Code</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                @forelse ($salesOrders as $item)
                <tr>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->customer->name }}</td>
                    <td>Rp. {{ number_format($item->total, 2) }}</td>
                    <td> <a href="" class="btn btn-info">
                        <i class="bi bi-printer text-white"></i></a></td>
                </tr>
                @empty
                <td colspan="5" class="text-center text-white fw-bold">Invoice Sales Not Found</td>
                    
                @endforelse
                

            </table>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <form id="sales-order-form" action="{{ route('invoice-sales.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Create Invoice Sales</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="salesOrderId" class="fw-medium mb-2">Sales Order Code</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="salesOrderId" name="salesOrderId" required>
                                        <option value="" selected disabled>-- Select Sales Order Code --</option>
                                        @foreach ($filteredSales as $item)
                                        <option value="{{ $item->id }}" data-products='@json($item->products)'>
                                            {{ $item->code }} - {{ $item->customer->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            {{-- Quotation Products --}}
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Price</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody id="quotation-products">
                                            <tr>
                                                <td colspan="4" class="text-center">No products selected</td>
                                            </tr>
                                        </tbody>
                                        <tfoot id="quotation-total" style="display: none;">
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                                                <td id="grand-total">Rp. 0</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

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
                        <span class="d-none d-sm-block">Save</span>
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
        const quotationSelect = document.getElementById('salesOrderId');
        const productsTableBody = document.getElementById('quotation-products');
        const grandTotalRow = document.getElementById('quotation-total');
        const grandTotalCell = document.getElementById('grand-total');

        quotationSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const productsData = JSON.parse(selectedOption.getAttribute('data-products') || '[]');

            let grandTotal = 0;

            productsTableBody.innerHTML = ''; // Reset table body

            if (productsData.length > 0) {
                productsData.forEach(product => {
                    grandTotal += product.subtotal;

                    const row = `
                        <tr>
                            <td>${product.product_name}</td>
                            <td>${product.qty}</td>
                            <td>Rp. ${Number(product.price).toLocaleString()}</td>
                            <td>Rp. ${Number(product.subtotal).toLocaleString()}</td>
                        </tr>
                    `;
                    productsTableBody.innerHTML += row;
                });

                // Tampilkan Grand Total
                grandTotalRow.style.display = '';
                grandTotalCell.textContent = `Rp. ${Number(grandTotal).toLocaleString()}`;
            } else {
                productsTableBody.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center">No products found</td>
                    </tr>
                `;
                grandTotalRow.style.display = 'none';
            }
        });
    });

</script>

@endsection
