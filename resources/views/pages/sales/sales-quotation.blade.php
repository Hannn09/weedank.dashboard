@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Sales Quotation')  

@section('content')
{{-- Button Trigger Modal --}}
<button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
    data-bs-toggle="modal" data-bs-target="#modal">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="white" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
    </svg>Add Sales Quotation</button>

<div class="col-12">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <tr>
                    <th>Date</th>
                    <th>Exp Date</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td>7-11-2024</td>
                    <td>7-11-2024</td>
                    <td>PT Jaya Abadi</td>
                    <td>Rp 200.000</td>
                    <th><span class="badge bg-info">Waiting Bill</span></th>
                </tr>

            </table>
        </div>
    </div>
</div>

{{-- Showing Modal Add --}}
<div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Create Sales Quotation</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="fw-medium mb-2">Customer</label>
                            <fieldset class="form-group">
                                <select class="form-select" id="name">
                                    <option>Handoko</option>
                                    <option>Sutomo</option>
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
                            <label for="count" class="fw-medium mb-2">Exp Date</label>
                            <input type="date" class="form-control" id="count" placeholder="7-11-2024">
                        </div>
                        <div class="form-group">
                            <label for="name" class="fw-medium mb-2">Payment Type</label>
                            <fieldset class="form-group">
                                <select class="form-select" id="name">
                                    <option>Cash</option>
                                    <option>Debit</option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Sub Total</th>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">Produk Belum Ada</td>
                            </tr>

                        </table>
                         <span class="d-flex justify-content-end mt-2">Total : - </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Cancel</span>
                </button>
                <button type="button" class="btn btn-primary  ms-1" data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Save</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection