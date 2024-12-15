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
                        <th>Sales Code</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @forelse ($sales as $order)
                        <tr>
                            <td>{{ $order->salesOrderCode }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td>Rp. {{ number_format($order->total, 2) }}</td>
                            <td>
                                @if ($order->status == 0)
                                    <span class="badge bg-warning text-dark">Waiting Delivery</span>
                                @elseif ($order->status == 1)
                                    <span class="badge bg-success">Delivered</span>
                                @elseif ($order->status == 2)
                                    <span class="badge bg-primary">Done</span>
                                @else
                                    <span class="badge bg-dark">Unknown</span>
                                @endif
                            </td>
                            <td>
                                <a href="" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#detail{{ $order->salesOrderCode }}"><i
                                        class="bi bi-eye text-white"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-white fw-bold">Sales Order Not Found</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    @foreach ($sales as $order)
        <div class="modal fade modal-borderless modal-lg" id="detail{{ $order->salesOrderCode }}" tabindex="-1"
            role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content p-3">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Sales Order Detail: {{ $order->salesOrderCode }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 me-2">Customer:</p>
                                <span class="fw-bold">{{ $order->customer->name }}</span>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <p class="mb-0 me-2">Total:</p>
                                <span class="fw-bold"> Rp. {{ number_format($order->total, 2) }}</span>
                            </div>
                            <div class="d-flex align-items-center mt-2">
                                <p class="mb-0 me-2">Status:</p>
                                @if ($order->status == 0)
                                    <span class="badge bg-warning text-dark">Waiting Delivery</span>
                                @elseif ($order->status == 1)
                                    <span class="badge bg-success">Delivered</span>
                                @elseif ($order->status == 2)
                                    <span class="badge bg-primary">Done</span>
                                @else
                                    <span class="badge bg-dark">Unknown</span>
                                @endif
                            </div>
                        </div>
                        {{-- Quotation Products --}}
                        <div class="row mt-3">
                            <div class="table-responsive">
                                <table class="table table-striped table-md">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>On Hand</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->quotation as $quotation)
                                            <tr>
                                                <td>{{ $quotation->product->name }}</td>
                                                <td>{{ $quotation->qty }}</td>
                                                <td>{{ $quotation->product->stock }}</td> {{-- Reserved stock --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- Button Delivery --}}
                        @if ($order->status == 0)
                            <form action="{{ route('delivery.delivery', $order->salesOrderCode) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check"></i> Delivery
                                </button>
                            </form>
                        @endif
                        {{-- Button Close --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection
@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top", // Posisi atas
                    position: "center", // Tengah
                    backgroundColor: "linear-gradient(to right, #00b09b, #96c93d)",
                }).showToast();
            @endif

            @if (session('error'))
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top", // Posisi atas
                    position: "center", // Tengah
                    backgroundColor: "linear-gradient(to right, #ff5f6d, #ffc371)",
                }).showToast();
            @endif
        });
    </script>

@endsection
