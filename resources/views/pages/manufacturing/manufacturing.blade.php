@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Manufacturing')

@section('content')
{{-- Button Trigger Modal --}}
<button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
    data-bs-toggle="modal" data-bs-target="#modal">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="white" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
    </svg>Create MO</button>


<div class="col-12">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <tr>
                    <th>BoM Code</th>
                    <th>Product Code</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                @forelse ($manufacturings as $item)
                <tr>
                    <td>{{ $item->material->code }}</td>
                    <td>{{ $item->material->product->code }}</td>
                    <td>{{ $item->material->product->name }}</td>
                    <th><span class="badge 
                        @if($item->status == 0) bg-secondary 
                        @elseif($item->status == 1) bg-warning
                        @else bg-success
                        @endif">
                            @if($item->status == 0) Mark as Todo
                            @elseif($item->status == 1) Ready To Produce
                            @else Done
                            @endif</span></th>
                    <td class="d-flex align-items-center gap-2"><a href="#" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#detail{{ $item->id }}"><i class="bi bi-eye text-white"></i></a>
                        <form action="{{ route('manufacturing.destroy', $item->id) }}" method="POST"
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
                <td colspan="5">Manufacturing Not Found</td>
                @endforelse

            </table>
        </div>
    </div>
</div>

{{-- Showing Modal Add  --}}
<div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <form action="{{ route('manufacturing.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create Manufacturing Order</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="idMaterials" name="idMaterials" class="fw-medium mb-2">BoM Code</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="idMaterials" name="idMaterials" required>
                                        <option value="">--Choose BoM--</option>
                                        @foreach ($filteredMaterials as $item)
                                        <option value="{{ $item->id }}" data-product-name="{{ $item->product->name }}"
                                            data-ingredients="{{ $materials->where('code', $item->code)->map(function ($material) {
                                            return [
                                                'ingredient' => $material->ingredient->name,
                                                'stock' => $material->ingredient->stock
                                            ];
                                        })->values() }}">
                                            {{ $item->code }}
                                        </option>
                                        @endforeach
                                    </select>
                                </fieldset>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="fw-medium mb-2">Product Name</label>
                                <input type="text" class="form-control" id="name">
                            </div>
                            <div class="form-group mb-3">
                                <label for="qty" class="fw-medium mb-2">Quantity to Produce</label>
                                <input type="number" class="form-control" id="qty" name="qty" placeholder="100">
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-md" id="ingredients-table">
                                <thead>
                                    <tr>
                                        <th>Ingredients</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2" align="center" id="no-product-selected">Product Not Choose</td>
                                    </tr>
                                </tbody>
                            </table>
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
                        <span class="d-none d-sm-block">Mark as Todo</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach ($manufacturings as $item)
{{-- Showing Detail Modal --}}
<div class="modal fade modal-borderless modal-lg @if (session('modal_id') == $item->id) show @endif"
    id="detail{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"
    @if (session('modal_id')==$item->id) style="display: block;" @endif>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <form action="{{ route('manufacturing.update', ['id' => $item->id]) }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fs-2">{{ $item->material->code }}</h5>
                </div>
                <div class="modal-body">
                    {{-- Tampilkan Pesan Error Jika Ada --}}
                    @if (session('error') && session('modal_id') == $item->id)
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <h6>Produk: [{{ $item->material->product->code }}] {{ $item->material->product->name }}</h6>
                            <p>Quantity to Produce: {{ $item->qty }}</p>
                            <p>Status : <span class="badge 
                                @if($item->status == 0) bg-secondary 
                                @elseif($item->status == 1) bg-warning
                                @else bg-success
                                @endif">
                                    @if($item->status == 0) Mark as Todo
                                    @elseif($item->status == 1) Ready To Produce
                                    @else Done
                                    @endif</span></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <thead>
                                    <tr>
                                        <th>Ingredients</th>
                                        <th>To Consume</th>
                                        <th>Reserved</th>
                                        <th>Consumed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($materials->where('code', $item->material->code) as $material)
                                    <tr>
                                        <td>{{ $material->ingredient->name }}</td>
                                        <td>{{ $material->qtyBom * $item->qty}}</td>
                                        <td>{{ $material->ingredient->stock }}</td>
                                        <td>
                                            @if ($item->status == 2)
                                            {{  $material->qtyBom * $item->qty }}
                                            @else
                                            0
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary ms-1" @if ($item->status == 2) disabled @endif>
                        @if ($item->status == 0)
                        Check Availability
                        @elseif ($item->status == 1)
                        Produce
                        @else
                        Done
                        @endif
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
        const bomDropdown = document.getElementById('idMaterials');
        const productNameInput = document.getElementById('name');
        const ingredientsTable = document.getElementById('ingredients-table').querySelector('tbody');
        const noProductSelectedRow = document.getElementById('no-product-selected');

        bomDropdown.addEventListener('change', function () {
            const selectedOption = bomDropdown.options[bomDropdown.selectedIndex];
            const productName = selectedOption.getAttribute('data-product-name');
            const ingredientsJson = selectedOption.getAttribute('data-ingredients');

            productNameInput.value = productName || '';

            ingredientsTable.innerHTML = '';

            try {
                const ingredientsData = JSON.parse(ingredientsJson);

                if (ingredientsData.length > 0) {
                    ingredientsData.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${item.ingredient}</td>
                    <td>${item.stock}</td>
                `;
                        ingredientsTable.appendChild(row);
                    });
                } else {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                <td colspan="2" align="center">Product Not Choose</td>
            `;
                    ingredientsTable.appendChild(row);
                }
            } catch (error) {
                console.error('Error parsing ingredients data:', error);
                const row = document.createElement('tr');
                row.innerHTML = `
            <td colspan="2" align="center">Product Not Choose</td>
        `;
                ingredientsTable.appendChild(row);
            }
        });

    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalId = '{{ session('
        modal_id ') }}';
        if (modalId) {
            const modal = new bootstrap.Modal(document.getElementById(`detail${modalId}`));
            modal.show();
        }
    });

</script>
@endsection
