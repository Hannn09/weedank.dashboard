@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Bahan Baku')

@section('content')
<section>
    {{-- Button Trigger Modal --}}
    <button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
        data-bs-toggle="modal" data-bs-target="#modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
            <path fill="white"
                d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
        </svg>Tambah Bahan Baku</button>
    {{-- Showing Modal --}}
    <div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Bahan Baku</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="kode" class="fw-medium mb-2">Kode Bahan Baku</label>
                                <input type="text" class="form-control" id="kode" placeholder="A001">
                            </div>
                            <div class="form-group mb-3">
                                <label for="name" class="fw-medium mb-2">Nama Bahan</label>
                                <input type="text" class="form-control" id="name" placeholder="Santan">
                            </div>
                            <div class="form-group mb-3">
                                <label for="count" class="fw-medium mb-2">Jumlah Stok</label>
                                <input type="text" class="form-control" id="count" placeholder="100">
                            </div>
                            <div class="form-group">
                                <label for="unit" class="fw-medium mb-2">Satuan</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="unit">
                                        <option>--Pilih Satuan--</option>
                                        <option>Gram (g)</option>
                                        <option>Mililiter (ml)</option>
                                    </select>
                                </fieldset>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="price" class="fw-medium mb-2">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" placeholder="10.000" id="price">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="image" class="fw-medium mb-2">Gambar Bahan Baku</label>
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
