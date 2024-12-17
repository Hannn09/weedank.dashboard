@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Bill Of Materials')

@section('content')
<section>
    <div class="d-flex align-items-center justify-content-between">
        {{-- Button Trigger Modal --}}
        <button class="btn btn-primary mb-4 px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="white"
                    d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
            </svg>Create BoM
        </button>

        {{-- Button Report
        <button class="btn btn-primary mb-4 px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
            onclick="location.href='{{ route('materials.report') }}'">
            </svg>Report Data
        </button> --}}
    </div>

    {{-- Table --}}
    <div class="col-12">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <tr>
                        <th>Product Name</th>
                        <th>BoM Code</th>
                        <th>Qty</th>
                        <th>BoM Cost</th>
                        <th>Product Cost</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($filteredMaterials as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ $item->qtyProduct }}</td>
                        <td>Rp {{ number_format($item->bomCost, 2) }}</td>
                        <td>Rp {{ number_format($item->productCost, 2) }}</td>
                        <td class="d-flex  align-items-center gap-2">
                            <a href="" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#detail{{ $item->id }}"><i
                                class="bi bi-eye text-white"></i></a>
                            <form action="{{ route('materials.destroy', $item->code) }}" method="POST"
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
                    <td colspan="6" align="center" class="text-white fw-bold">BoM Not Found</td>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    {{-- Showing Modal --}}
    <div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content p-3">
                <form id="materials-form" action="{{ route('materials.store') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Create BoM</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="code" class="fw-medium mb-2">BoM Code</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                        id="code" placeholder="C001" name="code" required>
                                    @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name" class="fw-medium mb-2">Product Name</label>
                                    <fieldset class="form-group">
                                        <select class="form-select  @error('idProducts') is-invalid @enderror" id="name"
                                            name="idProducts" required>
                                            <option value="">--Choose Product--</option>
                                            @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                    @error('idProducts')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="qtyProduct" class="fw-medium mb-2">Product Qty</label>
                                    <input type="number" class="form-control @error('qtyProduct') is-invalid @enderror"
                                        id="qtyProduct" placeholder="1" name="qtyProduct">
                                    @error('qtyProduct')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
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
                                                class="form-control @error('qtyBom') is-invalid @enderror"
                                                name="qtyBom[]" placeholder="Qty" style="flex: 1;" required>
                                            @error('qtyBom')
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

    @foreach ($filteredMaterials as $item)
    {{-- Modal Detail --}}
    <div class="modal fade modal-borderless modal-lg" id="detail{{ $item->id }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title fs-2">{{ $item->code }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="d-flex align-items-center">
                            <p class="mb-0 me-2">Quantity:</p>
                            <span class="fw-bold">{{ $item->qtyProduct }}.00 Unit</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <thead>
                                    <tr>
                                        <th>Ingredients</th>
                                        <th>Qty</th>
                                        <th>BoM Cost</th>
                                        <th>Product Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materials->where('code', $item->code) as $material)
                                        <tr>
                                            <td>{{ $material->ingredient->name }}</td>
                                            <td>{{ $material->qtyBom }}</td>
                                            <td>Rp {{ number_format($material->ingredient->price, 2) }}</td>
                                            <td>Rp {{ number_format((($material->qtyBom * $material->ingredient->price) * ($material->product->profit / 100)) + ($material->qtyBom * $material->ingredient->price), 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="1"></td>
                                        <td class="fw-bold" align="left">Unit Cost:</td>
                                        <td align="left">Rp {{ number_format($item->bomCost, 2) }}</td>
                                        <td align="left">Rp {{ number_format($item->productCost, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

</section>
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
            qtyInput.name = 'qtyBom[]';
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
