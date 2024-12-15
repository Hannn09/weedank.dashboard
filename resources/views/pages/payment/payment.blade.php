@extends('layouts.admin')

@section('heading', 'Payment Order')

@section('content')
{{-- Button Trigger Modal --}}
<button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
    data-bs-toggle="modal" data-bs-target="#modal">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="white" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
    </svg>Create Bill</button>

<div class="col-12">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <tr>
                    <th>Vendor</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @forelse ($payment as $item)
                <tr>
                    <td>{{ $item->purchase->quotation->vendor->name }}</td>
                    <td>{{ $item->purchase->quotation->total }}</td>
                    <td> <span class="badge 
                        @if($item->status == 0) bg-secondary
                        @elseif($item->status == 1) bg-warning
                        @elseif($item->status == 2) bg-success
                        @endif">
                            @if($item->status == 0) Draft
                            @elseif($item->status == 1) Waiting Payment
                            @elseif($item->status == 2) Paid
                            @endif
                        </span></td>
                    <td class="d-flex align-items-center gap-2"><a href="#" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#detail{{ $item->id }}">
                            <i class="bi bi-eye text-white"></i></a>
                        <form action="{{ route('payment.destroy', ['id' => $item->id]) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash-fill text-white"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <td colspan="5" align="center">Payment Not Found</td>
                @endforelse

            </table>
        </div>
    </div>
</div>

{{-- Showing Modal Add --}}
<div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <form action="{{ route('payment.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create Bill</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="idPurchase" class="fw-medium mb-2">PO Code</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="idPurchase" name="idPurchase" required>
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
                        <span class="d-none d-sm-block">Create Bill</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Show Modal Rgister Payment --}}
@foreach ($filteredPayments as $data)
@php
$payment = $data['payment'];
$quotations = $data['quotations'];
@endphp

<div class="modal fade modal-borderless modal-lg" id="detail{{ $payment->id }}" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <form action="{{ route('payment.update', ['id' => $payment->id]) }}" method="post">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">PO : {{ $payment->purchase->code }}</h1>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="paymentMethod" class="fw-medium mb-2">Payment Method</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                                        <option value="">--Choose Payment Method--</option>
                                        <option value="Cash" 
                                            @if(in_array($payment->status, [1, 2]) && $payment->paymentMethod == 'Cash') selected @endif>
                                            Cash
                                        </option>
                                        <option value="Debit" 
                                            @if(in_array($payment->status, [1, 2]) && $payment->paymentMethod == 'Debit') selected @endif>
                                            Debit
                                        </option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="form-group mb-3">
                                <label for="paymentDate" class="fw-medium mb-2">Payment Date</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="paymentDate" 
                                       name="paymentDate" 
                                       value="{{ in_array($payment->status, [1, 2]) ? $payment->paymentDate : '' }}" 
                                       required>
                            </div>
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
                                    @forelse ($quotations as $quotation)
                                    <tr>
                                        <td>{{ $quotation->ingredient->name }}</td>
                                        <td>{{ $quotation->qtyIngredients }}</td>
                                        <td>{{ $quotation->ingredient->price }}</td>
                                        <td>{{ $quotation->qtyIngredients * $quotation->ingredient->price }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" align="center">No Ingredients Found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <span class="d-flex align-items-end justify-content-end">Total : {{ $payment->purchase->quotation->total }}</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancel</span>
                    </button>
                    <button type="submit" class="btn btn-success ms-1" 
                            @if($payment->status == 2) disabled @endif>
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">
                            @if ($payment->status == 0)
                                Register Payment
                            @elseif($payment->status == 1)
                                Pay
                            @elseif($payment->status == 2)
                            Done
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
        const purchaseDropdown = document.getElementById('idPurchase');
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
