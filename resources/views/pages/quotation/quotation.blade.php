@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Request For Quotation')

@section('content')
{{-- Button Trigger Modal --}}
<button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
    data-bs-toggle="modal" data-bs-target="#modal">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="white" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
    </svg>Tambah RFQ</button>

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
                    </tr>
                    <tr>
                        <td>B001</td>
                        <td>7-11-2024</td>
                        <td>PT Jaya Abadi</td>
                        <td>Rp 250.000</td>
                        <td>
                            <span class="badge bg-info">RFQ</span>
                        </td>
                    </tr>
    
                </table>
            </div>
        </div>
    </div>

    {{-- Showing Modal --}}
    <div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah RFQ</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group mb-3">
                                <label for="name" class="fw-medium mb-2">Vendor</label>
                                <fieldset class="form-group">
                                    <select class="form-select" id="name">
                                        <option>PT Jaya Abadi</option>
                                        <option>CV Sinar Abadi</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="form-group mb-3">
                                <label for="count" class="fw-medium mb-2">Vendor Reference</label>
                                <input type="text" class="form-control" id="count" placeholder="B001">
                            </div>
                            <div class="form-group mb-3">
                                <label for="count" class="fw-medium mb-2">Order Date</label>
                                <input type="date" class="form-control" id="count" placeholder="7-11-2024">
                            </div>
                            <div class="form-group mb-3">
                                <label for="count" class="fw-medium mb-2">Company</label>
                                <input type="text" class="form-control" id="count" placeholder="PT Jaya Jaya Jaya">
                            </div>
                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-striped table-md">
                                <tr>
                                   
                                    <th>Produk</th>
                                    <th>Deskripsi</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                                <tr>
                                    {{-- <td>1</td>
                                    <td>Tepung Terigu</td>
                                    <td>...</td>
                                    <td>100</td> --}}
                                    <td colspan="5" align="center">Produk Belum Dipilih</td>
                                </tr>
    
                            </table>
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
@endsection