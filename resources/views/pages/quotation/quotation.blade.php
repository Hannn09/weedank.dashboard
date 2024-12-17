@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Request For Quotation')

@section('content')
{{-- Button Trigger Modal --}}
<button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
    data-bs-toggle="modal" data-bs-target="#modal">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="white" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
    </svg>Create RFQ</button>

{{-- Table --}}
<div class="col-12">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <tr>
                    <th>Reference</th>
                    <th>Order Date</th>
                    <th>Vendor</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @forelse ($filteredQuotation as $reference => $quotations)
                <tr>
                    <td>{{ $reference }}</td>
                    <td>{{ $quotations->first()->orderDate }}</td>
                    <td>{{ $quotations->first()->vendor->name }}</td>
                    <td>Rp {{ number_format($quotations->first()->total, 2) }}</td>
                    <td>
                        <span class="badge @if($quotations->first()->status == 0) bg-secondary 
                        @elseif($quotations->first()->status == 1) bg-warning
                        @elseif($quotations->first()->status == 2) bg-info
                        @elseif($quotations->first()->status == 3) bg-success
                        @endif"> 
                            @if($quotations->first()->status == 0) Draft
                            @elseif($quotations->first()->status == 1) RFQ Sent
                            @elseif($quotations->first()->status == 2) Approve RFQ
                            @elseif($quotations->first()->status == 3) Purchase Order
                            @endif
                        </span>
                    </td>
                    <td class="d-flex align-items-center gap-2">
                        <a href="#" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detail{{ $reference }}">
                            <i class="bi bi-eye text-white"></i>
                        </a>
                        <form action="{{ route('quotation.destroy', $reference) }}" method="POST"
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
                    <td colspan="6" align="center">Quotation Not Found</td>
                </tr>
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
            <form id="quotation-form" action="{{ route('quotation.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create RFQ</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="reference" class="fw-medium mb-2">References</label>
                                <input type="text" class="form-control" name="reference" id="reference"
                                    placeholder="R001">
                            </div>
                            <div class="form-group mb-3">
                                <label for="idVendor" class="fw-medium mb-2">Vendor</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="idVendor" name="idVendor">
                                        <option value="">--Choose Vendor--</option>
                                        @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="form-group mb-3">
                                <label for="orderDate" class="fw-medium mb-2">Order Date</label>
                                <input type="date" class="form-control" id="orderDate" name="orderDate">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <label class="fw-medium mb-2">Ingredients</label>
                            <div id="ingredients-container">
                                <div class="d-flex gap-2 ingredients-row mb-2">
                                    <select class="form-select @error('idIngredients') is-invalid @enderror"
                                        name="idIngredients[]" style="flex: 2;" required>
                                        <option value="">--Choose Ingredient--</option>
                                        @foreach ($ingredients as $ingredient)
                                        <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('idIngredients')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <input type="number"
                                        class="form-control @error('qtyIngredients') is-invalid @enderror"
                                        name="qtyIngredients[]" placeholder="Qty" style="flex: 1;" required>
                                    @error('qtyIngredients')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <a href="#" class="btn btn-success add-ingredient">
                                        <i class="bi bi-plus fw-bold"></i>
                                    </a>
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

{{-- Showwing Detail Model --}}
@foreach ($filteredQuotation as $reference => $quotations)
<div class="modal fade modal-borderless modal-lg"
    id="detail{{ $reference }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <form action="{{ route('quotation.update', ['id' => $reference]) }}" method="post">
                @csrf
            <div class="modal-header">
                <h5 class="modal-title fs-2">{{ $reference }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h6>Vendor: [{{ $quotations->first()->vendor->code }}] {{ $quotations->first()->vendor->name }}</h6>
                        <p>Status : <span class="badge 
                            @if($quotations->first()->status == 0) bg-secondary 
                            @elseif($quotations->first()->status == 1) bg-warning
                            @elseif($quotations->first()->status == 2) bg-info
                            @elseif($quotations->first()->status == 3) bg-success
                            @endif">
                                @if($quotations->first()->status == 0) Draft
                                @elseif($quotations->first()->status == 1) RFQ Sent
                                @elseif($quotations->first()->status == 2) Approve RFQ
                                @elseif($quotations->first()->status == 3) Purchase Order
                                @endif
                            </span></p>
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
                                @foreach ($quotations as $quotation)
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
                    <span class="d-flex justify-content-end mt-2">Total : Rp {{ number_format($quotations->first()->total, 2) }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancel</span>
                </button>
                <button type="submit" class="btn btn-success ms-1" @if ($quotations->first()->status == 3) disabled @endif>
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">
                        @if ($quotations->first()->status == 0) Send RFQ
                        @elseif ($quotations->first()->status == 1) Approve RFQ
                        @elseif ($quotations->first()->status == 2) Create Purchase Order
                        @elseif ($quotations->first()->status == 3) Purchase Order
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
{{-- Dynamic Input --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ingredientsOptions = `<option value="">--Choose Ingredient--</option>
        {!! $ingredients->map(function($ingredient){
            return '<option value="'.$ingredient->id.'">'.$ingredient->name.'</option>';
        })->implode('') !!}`;

        function addIngredientRow() {
            const newRow = document.createElement('div');
            newRow.classList.add('d-flex', 'gap-2', 'ingredients-row', 'mt-2');

            const ingredientSelect = document.createElement('select');
            ingredientSelect.name = 'idIngredients[]';
            ingredientSelect.classList.add('form-select');
            ingredientSelect.style.flex = '2';

            ingredientSelect.innerHTML = ingredientsOptions;

            const qtyInput = document.createElement('input');
            qtyInput.type = 'number';
            qtyInput.name = 'qtyIngredients[]';
            qtyInput.placeholder = 'Qty';
            qtyInput.classList.add('form-control');
            qtyInput.style.flex = '1';

            const removeButton = document.createElement('a');
            removeButton.href = '#';
            removeButton.classList.add('btn', 'btn-danger', 'remove-ingredient');
            removeButton.innerHTML = '<i class="bi bi-x fw-bold"></i>';

            newRow.appendChild(ingredientSelect);
            newRow.appendChild(qtyInput);
            newRow.appendChild(removeButton);

            document.getElementById('ingredients-container').appendChild(newRow);

            updateButtonsVisibility();
        }

        function removeIngredientRow(event) {
            event.preventDefault();
            const row = event.target.closest('.ingredients-row');
            row.remove();
            updateButtonsVisibility();
        }

        function updateButtonsVisibility() {
            const rows = document.querySelectorAll('.ingredients-row');
            rows.forEach((row, index) => {
                const addButton = row.querySelector('.add-ingredient');
                const removeButton = row.querySelector('.remove-ingredient');

                if (index === rows.length - 1) {
                    if (!addButton) {

                        const newAddButton = document.createElement('a');
                        newAddButton.href = '#';
                        newAddButton.classList.add('btn', 'btn-success', 'add-ingredient');
                        newAddButton.innerHTML = '<i class="bi bi-plus fw-bold"></i>';
                        newAddButton.addEventListener('click', function (e) {
                            e.preventDefault();
                            addIngredientRow();
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

        document.querySelector('.add-ingredient').addEventListener('click', function (e) {
            e.preventDefault();
            addIngredientRow();
        });

        document.getElementById('ingredients-container').addEventListener('click', function (e) {
            if (e.target.closest('.remove-ingredient')) {
                removeIngredientRow(e);
            }
        });
    });

</script>
@endsection
