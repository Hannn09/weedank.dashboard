@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Produk')

@section('content')
<section>
    <div class="d-flex justify-content-center align-items-center visually-hidden">
        <p class="fw-bold">Bahan Baku Tidak Tersedia</p>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="card text-white bg-card mb-3 rounded-4">
                <div class="card-body">
                    <div class="position-relative">
                        <div class="product-image">
                            <img src="assets/compiled/jpg/banana.jpg" alt="product" class="img-fluid rounded-4">
                        </div>
                        <div class="dropdown position-absolute" style="top: 10px; right: 5px;">
                            <button class="btn btn-link text-white" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-three-dots-vertical fs-5"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end rounded-3" style="min-width: 11.25rem;" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modal">Update Produk</a></li>
                                <li><a class="dropdown-item" href="#">Delete Produk</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-information">
                        <h6 class="mt-3 text-card" style="font-size: 20px">Angsle</h6>
                        <p class="card-subtitle text-body-secondary" style="font-size: 14px">Stok 100</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="card-text text-gray-400 mt-4" style="font-size: 12px">3/10/2024 20:55</p>
                        <p class="card-text text-gray-400 mt-4" style="font-size: 12px">A001</p>
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
                    <h5 class="modal-title">Tambah Produk</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="kode" class="fw-medium mb-2">Kode Produk</label>
                                <input type="text" class="form-control" id="kode" placeholder="A001">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="fw-medium mb-2">Nama Produk</label>
                                <input type="text" class="form-control" id="name" placeholder="Wedang Jahe">
                            </div>
                            <div class="form-group mb-3">
                                <label for="count" class="fw-medium mb-2">Jumlah Stok</label>
                                <input type="text" class="form-control" id="count" placeholder="100">
                            </div>
                            <div class="form-group">
                                <label for="cost" class="fw-medium mb-2">Produk Cost</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" placeholder="10.000">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="sales" class="fw-medium mb-2">Harga Jual</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" placeholder="10.000">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="fw-medium mb-2">Gambar Produk</label>
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
</section>

@endsection
