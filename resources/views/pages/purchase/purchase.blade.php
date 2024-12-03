@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Purchase Order')

@section('content')
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
                    <th>Action</th>
                </tr>
                <tr>
                    <td>B001</td>
                    <td>7-11-2024</td>
                    <td>PT Jaya Abadi</td>
                    <td>Rp 250.000</td>
                    <td>
                        <span class="badge bg-success">Purchase Order</span>
                    </td>
                    <td><a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal">Detail</a>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</div>

{{-- Showing Modal Accepted --}}
<div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Product PO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
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
                    </div>
                    <div class="col-md-6">
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
                <div class="row mt-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <tr>

                                <th>Producrt</th>
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
                <button type="button" class="btn btn-danger">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Decline</span>
                </button>
                <button type="button" class="btn btn-success  ms-1" data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Accepted</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Showing Modal Validate --}}
<div class="modal fade modal-borderless modal-lg" id="validate" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Validate PO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="fw-medium mb-2">Vendor</label>
                            <fieldset class="form-group">
                                <select class="form-select" id="name">
                                    <option>PT Jaya Abadi</option>
                                    <option>CV Sinar Abadi</option>
                                </select>
                            </fieldset>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="count" class="fw-medium mb-2">Order Date</label>
                            <input type="date" class="form-control" id="count" placeholder="7-11-2024">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <tr>

                                <th>Produk</th>
                                <th>Request</th>
                                <th>Recieved</th>
                            </tr>
                            <tr>
                                <td colspan="3" align="center">Produk Belum Ada</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
               
                <button type="button" class="btn btn-success  ms-1" data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Validate</span>
                </button>
            </div>
        </div>
    </div>
</div>


@endsection
