@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Bill Of Materials')

@section('content')
<section>
    <div class="d-flex align-items-center justify-content-between">
        {{-- Button Trigger Modal --}}
        <button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="white"
                    d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
            </svg>Tambah BoM</button>
        
        {{-- Button Report --}}
        <button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2" onclick="location.href='{{ route('materials.report') }}'"> 
            </svg>Report Data</button>
    </div>

    {{-- Showing Modal --}}
    <div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah BoM</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="kode" class="fw-medium mb-2">Kode BoM</label>
                                <input type="text" class="form-control" id="kode" placeholder="A001">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="fw-medium mb-2">Nama Produk</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="name">
                                        <option>Wedang Jahe</option>
                                        <option>Angsle</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="form-group mb-3">
                                <label for="count" class="fw-medium mb-2">Jumlah Stok</label>
                                <input type="text" class="form-control" id="count" placeholder="100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="price" class="fw-medium mb-2">Nama Bahan Baku</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="name">
                                        <option>Tepung</option>
                                        <option>Gula</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="form-group">
                                <label for="qty" class="fw-medium mb-2">Quantity Bahan Baku</label>
                                <input type="text" class="form-control" id="qty" placeholder="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancel</span>
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