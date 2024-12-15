@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Sales Quotation')

@section('content')
    <div class="d-flex align-items-center justify-content-between">
        {{-- Button Trigger Modal --}}
        <button class="btn btn-primary mb-4 px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#modalAdd">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="white"
                    d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
            </svg>Create Sales Quotations
        </button>
    </div>

    <div class="col-12">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <tr>
                        <th>#</th>
                        <th>Quotation</th>
                        <th>Customer</th>
                        <th>Expiration Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    @forelse ($filteredQuotations as $quotation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quotation->code }}</td> <!-- Diganti dari quotation_number -->
                            <td>{{ $quotation->customer->name }}</td>
                            <td>{{ $quotation->expDate }}</td> <!-- Diganti dari exp_date -->
                            <td>Rp. {{ number_format($quotation->total, 2) }}</td>
                            <td><span
                                    class="badge {{ $quotation->status_badge_class }}">{{ $quotation->status_text }}</span>
                            </td>
                            <td class="d-flex  align-items-center gap-2">
                                <a href="" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#detail{{ $quotation->id }}"><i class="bi bi-eye text-white"></i></a>
                                <form action="{{ route('sales-quotation.destroy', $quotation->code) }}" method="POST"
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
                        <td colspan="6" align="center" class="text-white fw-bold">Sales Quotation Not Found</td>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade modal-borderless modal-lg" id="modalAdd" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content p-3">
                <form id="sales-quotation-form" action="{{ route('sales-quotation.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Create Sales Quotation</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="code" class="fw-medium mb-2">Quotation Code</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                        id="code" placeholder="S001" name="code" required>
                                    @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="idCustomers" class="fw-medium mb-2">Customer</label>
                                    <fieldset class="form-group">
                                        <select class="form-select  @error('idCustomers') is-invalid @enderror"
                                            id="idCustomers" name="idCustomers" required>
                                            <option value="">--Choose Customer--</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                    @error('idCustomers')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="fw-medium mb-2">Products</label>
                                    <div id="products-container">
                                        <div class="d-flex gap-2 products-row mb-2">
                                            <select class="form-select @error('idProducts') is-invalid @enderror"
                                                name="idProducts[]" style="flex: 2;" required>
                                                <option value="">--Choose Product--</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('idProducts')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <input type="number" class="form-control @error('qty') is-invalid @enderror"
                                                name="qty[]" placeholder="Qty" style="flex: 1;" required>
                                            @error('qty')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                                name="price[]" placeholder="Price" style="flex: 1;" required>
                                            @error('price')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <a href="#" class="btn btn-success add-product">
                                                <i class="bi bi-plus fw-bold"></i>
                                            </a>
                                        </div>
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

    @foreach ($filteredQuotations as $item)
        {{-- Modal Detail --}}
        <div class="modal fade modal-borderless modal-lg" id="detail{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title fs-2">Quotation Details: {{ $item->code }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Customer Information --}}
                        <div class="row">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 me-2">Customer:</p>
                                <span class="fw-bold">{{ $item->customer->name }}</span>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <p class="mb-0 me-2">Expiration Date:</p>
                                <span class="fw-bold">{{ $item->expDate }}</span>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <p class="mb-0 me-2">Status:</p>
                                <span class="badge {{ $item->status_badge_class }}">{{ $item->status_text }}</span>
                            </div>
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
                                            <th>SubTotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $grandTotal = 0; @endphp
                                        @foreach ($quotations->where('code', $item->code) as $quotation)
                                            @php
                                                $subtotal = $quotation->qty * $quotation->price;
                                                $grandTotal += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>{{ $quotation->product->name }}</td>
                                                <td>{{ $quotation->qty }}</td>
                                                <td>Rp. {{ number_format($quotation->price, 2) }}</td>
                                                <td>Rp. {{ number_format($subtotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="fw-bold" align="right">Grand Total:</td>
                                            <td class="fw-bold">Rp. {{ number_format($grandTotal, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-end gap-2">
                        <!-- Button Export PDF (Tampil jika status adalah Confirmed) -->
                        @if ($item->status == 0 || $item->status == 2)
                            <a href="{{ route('sales-quotation.export', $item->code) }}" class="btn btn-secondary">
                                Export to PDF
                            </a>
                        @endif

                        <!-- Button Confirm (Tampil jika status adalah Sent) -->
                        @if ($item->status == 1)
                            <form action="{{ route('sales-quotation.confirm', $item->code) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    Confirm Quotation
                                </button>
                            </form>
                        @endif

                        <!-- Button Send (Tampil jika status adalah Draft) -->
                        @if ($item->status == 0)
                            <form action="{{ route('sales-quotation.send', $item->code) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary">
                                    Send Quotation
                                </button>
                            </form>
                        @endif

                        <!-- Button Close -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top", // Posisi atas
                    position: "center", // Tengah
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                }).showToast();
            @endif

            @if (session('error'))
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top", // Posisi atas
                    position: "center", // Tengah
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }).showToast();
            @endif
        });
    </script>
    {{-- Dynamic Input --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productsOptions = `<option value="">--Choose Product--</option>
        {!! $products->map(function ($product) {
                return '<option value="' . $product->id . '">' . $product->name . '</option>';
            })->implode('') !!}`;

            function addproductRow() {
                const newRow = document.createElement('div');
                newRow.classList.add('d-flex', 'gap-2', 'products-row', 'mt-2');

                const productSelect = document.createElement('select');
                productSelect.name = 'idProducts[]';
                productSelect.classList.add('form-select');
                productSelect.style.flex = '2';

                productSelect.innerHTML = productsOptions;

                const qtyInput = document.createElement('input');
                qtyInput.type = 'number';
                qtyInput.name = 'qty[]';
                qtyInput.placeholder = 'Qty';
                qtyInput.classList.add('form-control');
                qtyInput.style.flex = '1';

                // Price input
                const priceInput = document.createElement('input');
                priceInput.type = 'number';
                priceInput.name = 'price[]';
                priceInput.placeholder = 'Price';
                priceInput.classList.add('form-control');
                priceInput.style.flex = '1';

                const removeButton = document.createElement('a');
                removeButton.href = '#';
                removeButton.classList.add('btn', 'btn-danger', 'remove-product');
                removeButton.innerHTML = '<i class="bi bi-x fw-bold"></i>';

                newRow.appendChild(productSelect);
                newRow.appendChild(qtyInput);
                newRow.appendChild(priceInput);
                newRow.appendChild(removeButton);

                document.getElementById('products-container').appendChild(newRow);

                updateButtonsVisibility();
            }

            function removeproductRow(event) {
                event.preventDefault();
                const row = event.target.closest('.products-row');
                row.remove();
                updateButtonsVisibility();
            }

            function updateButtonsVisibility() {
                const rows = document.querySelectorAll('.products-row');
                rows.forEach((row, index) => {
                    const addButton = row.querySelector('.add-product');
                    const removeButton = row.querySelector('.remove-product');

                    if (index === rows.length - 1) {
                        if (!addButton) {

                            const newAddButton = document.createElement('a');
                            newAddButton.href = '#';
                            newAddButton.classList.add('btn', 'btn-success', 'add-product');
                            newAddButton.innerHTML = '<i class="bi bi-plus fw-bold"></i>';
                            newAddButton.addEventListener('click', function(e) {
                                e.preventDefault();
                                addproductRow();
                            });
                            row.appendChild(newAddButton);
                        }
                    } else {
                        if (addButton) {
                            addButton.remove();
                        }
                    }

                    if (index === 0) {
                        if (removeButton) {
                            removeButton.style.display = 'none';
                        }
                    } else {
                        if (removeButton) {
                            removeButton.style.display = 'inline-block';
                        }
                    }
                });
            }

            document.querySelector('.add-product').addEventListener('click', function(e) {
                e.preventDefault();
                addproductRow();
            });

            document.getElementById('products-container').addEventListener('click', function(e) {
                if (e.target.closest('.remove-product')) {
                    removeproductRow(e);
                }
            });
        });
    </script>
@endsection
