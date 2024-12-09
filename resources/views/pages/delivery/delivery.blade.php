@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Delivery')

@section('content')
{{-- Table --}}
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
                    <th>Action</th>
                </tr>
                <tr>
                    <td>7-11-2024</td>
                    <td>7-11-2024</td>
                    <td>PT Jaya Abadi</td>
                    <td>Rp 200.000</td>
                    <th><span class="badge bg-info">Waiting Bill</span></th>
                    <td class="d-flex align-items-center gap-2"><a href="" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#modal"><i
                        class="bi bi-eye text-white"></i></a>
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
                <h5 class="modal-title">Delivery</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="name" class="fw-medium mb-2">Customer</label>
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

                                <th>Product</th>
                                <th>Quantity</th>
                                <th>On Hand</th>
                            </tr>
                            <tr>
                                {{-- <td>1</td>
                                    <td>Tepung Terigu</td>
                                    <td>...</td>
                                    <td>100</td> --}}
                                <td colspan="5" align="center">Delivery Not Found</td>
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
                <button type="button" class="btn btn-primary  ms-1" data-bs-dismiss="modal">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Delivery</span>
                </button>
            </div>
        </div>
    </div>
</div>


@endsection