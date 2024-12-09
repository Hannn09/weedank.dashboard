@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Product')

@section('content')
<section>
    <div class="row">
        @forelse ($products as $item)
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card text-white bg-card mb-3 rounded-4">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="product-image">
                            <img src="{{ asset('uploads/products/' . $item->img) }}" alt="{{ $item->name }}"
                                class="rounded-4 w-100 object-cover" style="height: 250px"
                                onerror="this.onerror=null; this.src='{{ asset('assets/compiled/jpg/banana.jpg') }}';">
                        </div>
                        <div class="dropdown position-absolute" style="top: 10px; right: 5px;">
                            <button class="btn btn-link text-white" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end rounded-3" style="min-width: 11.25rem;"
                                aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal"
                                        onclick="openModal('update', {{ $item }})">Update Product</a></li>
                                <form action="{{ route('product.destroy', $item->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">Delete Product</button>
                                </form>
                            </ul>
                        </div>
                    </div>
                    <div class="card-information">
                        <h6 class="mt-3 text-card" style="font-size: 20px">{{ $item->name }}</h6>
                        <p class="card-subtitle text-body-secondary" style="font-size: 14px">Stok {{ $item->stock }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="card-text text-gray-400 mt-4" style="font-size: 12px">
                            {{ $item->created_at->format('d/m/Y H:i') }}</p>
                        <p class="card-text text-gray-400 mt-4" style="font-size: 12px">{{ $item->code }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="d-flex justify-content-center align-items-center text-center">
            <p class="fw-bold text-white">Product Not Found</p>
        </div>
        @endforelse
    </div>

    {{-- Button Trigger Modal --}}
    <div class="position-fixed bottom-0 end-0 m-5">
        <button type="button" class="btn btn-primary rounded-4" data-bs-toggle="modal" data-bs-target="#modal"
            onclick="openModal('add')">
            <i class="bi bi-plus fs-4"></i>
        </button>
    </div>
    {{-- Showing Modal --}}
    <div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content p-3">
                <form id="product-form" action="{{ route('product.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Add Product</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="code" class="fw-medium mb-2">Product Code</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                        id="code" placeholder="A001" name="code" required>
                                    @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name" class="fw-medium mb-2">Product Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" placeholder="Wedang Jahe" name="name" required>
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="sales" class="fw-medium mb-2">Profit Margin</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('profit') is-invalid @enderror"
                                            placeholder="10" name="profit" id="profit" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    @error('profit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                
                                <div class="form-group">
                                    <label for="img" class="fw-medium mb-2">Product Image</label>
                                    <input type="file" class="basic-filepond" name="img" id="img" required>
                                    @error('img')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block ">Cancel</span>
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
</section>
@endsection

@section('script')
<script>
    function openModal(action, product = null) {
        const modalTitle = document.getElementById('modal-title');
        const productForm = document.getElementById('product-form');
        const fileInput = document.getElementById('img');

        if (action == 'add') {
            modalTitle.textContent = 'Add Product';
            productForm.action = "{{ route('product.store') }}";         

            document.getElementById('code').value = '';
            document.getElementById('name').value = '';
            document.getElementById('profit').value = '';
            // document.getElementById('img').value = '';

            FilePond.find(fileInput).removeFiles();
        } else if (action == 'update') {
            modalTitle.textContent = 'Update Product';
            productForm.action = "{{ route('product.update', ':id') }}".replace(':id', product.id);

            document.getElementById('code').value = product.code;
            document.getElementById('name').value = product.name;   
            document.getElementById('profit').value = product.profit;
            
            const existingFile = "{{ asset('uploads/products/') }}" + '/' + product.img;
            FilePond.find(fileInput).addFile(existingFile);
        }
    }
</script>
@endsection
