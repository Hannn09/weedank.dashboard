@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Sales Order')

@section('content')
    <div class="d-flex align-items-center justify-content-between">
        {{-- Button Trigger Modal --}}
        <button class="btn btn-primary mb-4 px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#modalAdd">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="white"
                    d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
            </svg>Create Sales Order
        </button>
    </div>
    {{-- Table --}}
    <div class="col-12">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <tr>
                        <th>Sales Code</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($salesOrders as $order)
                        <tr>
                            <td>{{ $order->code }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td>Rp. {{ number_format($order->total, 2) }}</td>
                            <td>
                                @if ($order->status == 0)
                                    <span class="badge bg-secondary">Draft</span>
                                @elseif ($order->status == 1)
                                    <span class="badge bg-success">Accepted</span>
                                @elseif ($order->status == 2)
                                    <span class="badge bg-warning text-dark">Waiting Bill</span>
                                @elseif ($order->status == 3)
                                    <span class="badge bg-primary">Paid</span>
                                @endif
                            </td>
                            <td class="d-flex align-items-center gap-2">
                                <a href="" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#detail{{ $order->code }}"><i class="bi bi-eye text-white"></i></a>
                                <form action="{{ route('sales-order.destroy', $order->code) }}" method="POST"
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
                        <tr>
                            <td colspan="5" class="text-center text-white fw-bold">Sales Order Not Found</td>
                        </tr>
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
                <form id="sales-order-form" action="{{ route('sales-order.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Create Sales Order</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="quotationCode" class="fw-medium mb-2">Sales Quotation</label>
                                    <fieldset class="form-group">
                                        <select class="form-select @error('quotationCode') is-invalid @enderror"
                                            id="quotationCode" name="quotationCode" required>
                                            <option value="" selected disabled>-- Select Sales Quotation --</option>
                                            @foreach ($quotations as $quotation)
                                                <option value="{{ $quotation->code }}">{{ $quotation->code }} -
                                                    {{ $quotation->customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                    @error('quotationCode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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

    {{-- Modal Detail --}}
    @foreach ($salesOrders as $order)
        <div class="modal fade modal-borderless modal-lg" id="detail{{ $order->code }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Sales Order Detail: {{ $order->code }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 me-2">Customer:</p>
                                <span class="fw-bold">{{ $order->customer->name }}</span>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <p class="mb-0 me-2">Total:</p>
                                <span class="fw-bold"> Rp. {{ number_format($order->total, 2) }}</span>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <p class="mb-0 me-2">Status:</p>
                                <span class="fw-bold">
                                    @if ($order->status == 0)
                                        <span class="badge bg-secondary">Draft</span>
                                    @elseif ($order->status == 1)
                                        <span class="badge bg-success">Accepted</span>
                                    @elseif ($order->status == 2)
                                        <span class="badge bg-warning text-dark">Waiting Bill</span>
                                    @elseif ($order->status == 3)
                                        <span class="badge bg-primary">Paid</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                        {{-- Quotation Products --}}
                        <div class="row mt-3">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Reserved</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->quotation as $quotation)
                                            <tr>
                                                <td>{{ $quotation->product->name }}</td>
                                                <td>{{ $quotation->qty }}</td>
                                                <td>{{ $quotation->product->stock }}</td> {{-- Reserved stock --}}
                                                <td>Rp. {{ number_format($quotation->price, 2) }}</td>
                                                <td>Rp. {{ number_format($quotation->qty * $quotation->price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                                            <td>Rp. {{ number_format($order->total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- Button Accepted --}}
                        @if ($order->status == 0)
                            <form action="{{ route('sales-order.accept', $order->code) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check"></i> Accept
                                </button>
                            </form>
                        @endif

                        {{-- Button Check Availability --}}
                        @if ($order->status == 1)
                            <form action="{{ route('sales-order.check-availability', $order->code) }}" method="POST"
                                class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-check2-circle"></i> Check Availability
                                </button>
                            </form>
                        @endif

                        {{-- Button Validate --}}
                        @if ($order->status == 2)
                            <form action="{{ route('sales-order.paid', $order->code) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Paid
                                </button>
                            </form>
                        @endif

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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quotationSelect = document.getElementById('quotationCode');
            const productsTableBody = document.getElementById('quotation-products');
            const grandTotalRow = document.getElementById('quotation-total');
            const grandTotalCell = document.getElementById('grand-total');

            quotationSelect.addEventListener('change', function() {
                const quotationCode = this.value;

                if (quotationCode) {
                    fetch(`/sales-order/quotation-products/${quotationCode}`)
                        .then(response => response.json())
                        .then(data => {
                            // Clear existing rows
                            productsTableBody.innerHTML = '';

                            let grandTotal = 0;

                            if (data.length > 0) {
                                data.forEach(item => {
                                    const subtotal = item.qty * item.price;
                                    grandTotal += subtotal;

                                    const row = `
                                        <tr>
                                            <td>${item.product.name}</td>
                                            <td>${item.qty}</td>
                                            <td>Rp. ${Number(item.price).toLocaleString()}</td>
                                            <td>Rp. ${Number(subtotal).toLocaleString()}</td>
                                        </tr>
                                    `;
                                    productsTableBody.innerHTML += row;
                                });

                                // Show grand total
                                grandTotalRow.style.display = '';
                                grandTotalCell.textContent =
                                    `Rp. ${Number(grandTotal).toLocaleString()}`;
                            } else {
                                productsTableBody.innerHTML = `
                                    <tr>
                                        <td colspan="4" class="text-center">No products found</td>
                                    </tr>
                                `;
                                grandTotalRow.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            productsTableBody.innerHTML = `
                                <tr>
                                    <td colspan="4" class="text-center text-danger">Failed to load products</td>
                                </tr>
                            `;
                            grandTotalRow.style.display = 'none';
                        });
                }
            });
        });
    </script>

@endsection