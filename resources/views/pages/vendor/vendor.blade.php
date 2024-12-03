@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Vendor')

@section('content')
<div class="d-flex justify-content-center align-items-center visually-hidden">
    <p class="fw-bold">Vendor Tidak Tersedia</p>
</div>
<div class="row">
    <div class="col-sm-12 col-md-4 mb-3 mb-sm-0">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <img src="assets/compiled/jpg/banana.jpg" alt="product" class="w-25 rounded-3 object-fit-cover">
                    <div class="col-sm-12 ms-3">
                        <h5 class="card-title" style="font-size: 16px">Nama Vendor : PT Maju Jaya</h5>
                        <p class="card-text" style="font-size: 14px">Email : ptmajujaya@gmail.com</p>
                        <p class="card-text" style="font-size: 14px">No. Handphone : 081234556789</p>
                    </div>
                    <div class="dropdown position-absolute" style="top: 15px; right: 5px;">
                        <button class="btn btn-link text-white" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi bi-three-dots-vertical "></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end rounded-3" style="min-width: 11.25rem;" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal">Update Vendor</a></li>
                            <li><a class="dropdown-item" href="#">Delete Vendor</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
{{-- Button Trigger Modal --}}
<div class="position-absolute bottom-0 end-0 m-5">
    <button type="button" class="btn btn-primary rounded-4" data-bs-toggle="modal" data-bs-target="#modal">
        <i class="bi bi-plus fs-4"></i>
    </button>
</div>
{{-- Showing Modal --}}
<div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Vendor</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="fw-medium mb-2">Nama Vendor</label>
                            <input type="text" class="form-control" id="name" placeholder="PT Maju Jaya">
                        </div>
                        <div class="form-group mb-3">
                            <label for="category" class="fw-medium mb-2">Kategori</label>
                            <fieldset class="form-group">
                                <select class="form-select" id="category">
                                    <option>Tepung Terigu</option>
                                    <option>Santan</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group">
                            <label for="address" class="fw-medium mb-2">Alamat</label>
                            <textarea class="form-control" id="address" rows="3"
                                placeholder="Jl. Raya Bogor No. 10"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="email" class="fw-medium mb-2">Email</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="user@domain.com">
                        </div>
                        <div class="form-group mb-3">
                            <label for="handphone" class="fw-medium mb-2">No. Handphone</label>
                            <input type="number" class="form-control" name="handphone" id="handphhone"
                                placeholder="081234556789" maxlength="13">
                        </div>
                        <div class="form-group">
                            <label for="image" class="fw-medium mb-2">Logo Perusahaan</label>
                            <input type="file" class="basic-filepond" name="image">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block ">Cancel</span>
                </button>
                <button type="button" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Save</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
