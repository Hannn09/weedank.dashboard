@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Vendor')

@section('content')
    <div class="row">
        @forelse ($vendors as $item)
            <div class="col-sm-12 col-md-4 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-body d-flex align-items-center">
                        <div class="d-flex justify-content-between">
                            <img src="{{ asset('uploads/vendors/' . $item->img) }}" alt="{{ $item->name }}"
                                class="rounded-circle object-cover" style="width: 80px; height: 80px; object-fit: cover;"
                                onerror="this.onerror=null; this.src='{{ asset('assets/compiled/jpg/banana.jpg') }}';">
                            <div class="col-sm-12 ms-3">
                                <h5 class="card-title mb-1" style="font-size: 16px">Name : {{ $item->name }}</h5>
                                <p class="card-text mb-1" style="font-size: 14px">Address : {{ $item->address }}</p>
                                <p class="card-text mb-1" style="font-size: 14px">Email : {{ $item->email }}</p>
                                <p class="card-text mb-1" style="font-size: 14px">No. Handphone : {{ $item->phone }}</p>
                            </div>
                            <div class="dropdown position-absolute" style="top: 10px; right: 5px;">
                                <button class="btn btn-link text-white" type="button" id="dropdownMenuButton"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical fs-5"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end rounded-3" style="min-width: 11.25rem;"
                                    aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal"
                                            onclick="openModal('update', {{ $item }})">Update Vendor</a></li>
                                    <form action="{{ route('vendor.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this vendor?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">Delete Vendor</button>
                                    </form>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="d-flex justify-content-center align-items-center visually-hidden">
                <p class="fw-bold">Vendor Not Found</p>
            </div>
        @endforelse
    </div>
    {{-- Button Trigger Modal --}}
    <div class="position-absolute bottom-0 end-0 m-5">
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
                <form id="vendor-form" action="{{ route('vendor.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Add Vendor</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="code" class="fw-medium mb-2">Vendor Code</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                        id="code" placeholder="V001" name="code" required>
                                    @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name" class="fw-medium mb-2">Vendor Name</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                        placeholder="PT Maju Jaya" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="address" class="fw-medium mb-2">Address</label>
                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Jl. Raya Bogor No. 10"
                                        required></textarea>
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="fw-medium mb-2">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="user@domain.com" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phone" class="fw-medium mb-2">Phone Number</label>
                                    <input type="number" class="form-control" name="phone" id="phone"
                                        placeholder="081234556789" maxlength="13">
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="img" class="fw-medium mb-2">Vendor Image</label>
                                    <input type="file" class="basic-filepond" name="img" id="img">
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
@endsection
@section('script')
    <script>
        function openModal(action, vendor = null) {
            const modalTitle = document.getElementById('modal-title');
            const vendorForm = document.getElementById('vendor-form');
            const fileInput = document.getElementById('img');

            if (action == 'add') {
                modalTitle.textContent = 'Add Vendor';
                vendorForm.action = "{{ route('vendor.store') }}";

                document.getElementById('code').value = '';
                document.getElementById('name').value = '';
                document.getElementById('address').value = '';
                document.getElementById('email').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('img').value = '';

                FilePond.find(fileInput).removeFiles();
            } else if (action == 'update') {
                modalTitle.textContent = 'Update Vendor';
                vendorForm.action = "{{ route('vendor.update', ':id') }}".replace(':id', vendor.id);
                
                document.getElementById('code').value = vendor.code;
                document.getElementById('name').value = vendor.name;
                document.getElementById('address').value = vendor.address;
                document.getElementById('email').value = vendor.email;
                document.getElementById('phone').value = vendor.phone;

                const existingFile = "{{ asset('uploads/vendors/') }}" + '/' + vendor.img;
                FilePond.find(fileInput).addFile(existingFile);
            }
        }
    </script>
@endsection
