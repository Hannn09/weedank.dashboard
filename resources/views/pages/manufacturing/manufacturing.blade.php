@extends('layouts.admin')

@section('title', 'Weedank | Admin Dashboard')

@section('heading', 'Manufacturing')

@section('content')
{{-- Button Trigger Modal --}}
<button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
    data-bs-toggle="modal" data-bs-target="#modal">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="white" d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
    </svg>Tambah MO</button>


<div class="col-12">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-md">
                <tr>
                    <th>Kode BoM</th>
                    <th>Kode Produk</th>
                    <th>Produk</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>B001</td>
                    <td>A001</td>
                    <td>Wedang Jahe</td>
                    <td><a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#detail">Detail</a>
                    </td>
                </tr>

            </table>
        </div>
    </div>
</div>

{{-- Showing Modal Add  --}}
<div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Manufacturing Order</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group mb-3">
                            <label for="name" class="fw-medium mb-2">Produk</label>
                            <fieldset class="form-group">
                                <select class="form-select" id="name">
                                    <option>Wedang Jahe</option>
                                    <option>Angsle</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="form-group mb-3">
                            <label for="count" class="fw-medium mb-2">Jumlah Produksi</label>
                            <input type="text" class="form-control" id="count" placeholder="100">
                        </div>
                        <div class="form-group mb-3">
                            <label for="kode" class="fw-medium mb-2">Kode BoM</label>
                            <fieldset class="form-group">
                                <select class="form-select" id="kode">
                                    <option>A001</option>
                                    <option>A002</option>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <tr>
                                <th>No</th>
                                <th>Bahan Baku</th>
                                <th>Tracking</th>
                                <th>To Consume</th>
                            </tr>
                            <tr>
                                {{-- <td>1</td>
                                <td>Tepung Terigu</td>
                                <td>...</td>
                                <td>100</td> --}}
                                <td colspan="4" align="center">Produk Belum Dipilih</td>
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

{{-- Showing Detail Modal --}}
<div class="modal fade modal-borderless modal-lg" id="detail" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content p-3">
            <div class="modal-header">
                <h5 class="modal-title">Detail Manufacturing Order</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <h6>Produk: [A003] Ronde</h6>
                        <p>Quantity to Produce: 100</p>
                        <p>Bill of Material: B001</p>
                        <p >Status : <span class="text-green-600">To Produce</span></p>
                    </div>
                </div>
                {{-- <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="statusSelect" class="mb-2">Status:</label>
                        <select class="form-select" id="statusSelect">
                            <option value="" selected disabled>Select Status</option>
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped table-md">
                            <tr>
                                <th>Product</th>
                                <th>Tracking</th>
                                <th>To Consume</th>
                                <th>Reserved</th>
                                <th>Consumed</th>
                            </tr>
                            <tr>
                                <td>Serai</td>
                                <td></td>
                                <td>500</td>
                                <td>500</td>
                                <td>500</td>
                            </tr>
                            <tr>
                                <td>Air</td>
                                <td></td>
                                <td>15000</td>
                                <td>15000</td>
                                <td>15000</td>
                              </tr>
                              <tr>
                                <td>Jahe</td>
                                <td></td>
                                <td>1000</td>
                                <td>1000</td>
                                <td>1000</td>
                              </tr>
                              <tr>
                                <td>Gongkeh</td>
                                <td></td>
                                <td>100</td>
                                <td>50</td>
                                <td>50</td>
                              </tr>
                              <tr>
                                <td>Gula Pasir</td>
                                <td></td>
                                <td>3000</td>
                                <td>3000</td>
                                <td>3000</td>
                              </tr>
                              <tr>
                                <td>Garam</td>
                                <td></td>
                                <td>100</td>
                                <td>100</td>
                                <td>100</td>
                              </tr>
                              <tr>
                                <td>Tepung Ketan</td>
                                <td></td>
                                <td>17000</td>
                                <td>17000</td>
                                <td>17000</td>
                              </tr>
                              <tr>
                                <td>Tepung Beras</td>
                                <td></td>
                                <td>4000</td>
                                <td>4000</td>
                                <td>4000</td>
                              </tr>
                              <tr>
                                <td>Pasta Pandan</td>
                                <td></td>
                                <td>100</td>
                                <td>100</td>
                                <td>100</td>
                              </tr>
                              <tr>
                                <td>Pasta Coklat</td>
                                <td></td>
                                <td>100</td>
                                <td>100</td>
                                <td>100</td>
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
                    {{-- Button Changed Follow Status --}}
                    <span class="d-none d-sm-block">Mark as Done</span>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
