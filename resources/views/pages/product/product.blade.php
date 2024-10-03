@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Produk')

@section('content')
<section>
    <div class="d-flex justify-content-center align-items-center visually-hidden">
        <p class="fw-bold">Bahan Baku Tidak Tersedia</p>
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
                        <span class="d-none d-sm-block text-white">Cancel</span>
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
