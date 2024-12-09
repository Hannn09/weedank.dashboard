    @extends('layouts.admin')

    @section('title', 'Weedank | Admin Dashboard')

    @section('heading', 'Ingredients')

    @section('content')
    <section>
        {{-- Button Trigger Modal --}}
        <button class="btn btn-primary mb-4  px-3 py-2 text-white rounded-3 fw-semibold d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#modal" onclick="openModal('add')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="white"
                    d="M18 12.998h-5v5a1 1 0 0 1-2 0v-5H6a1 1 0 0 1 0-2h5v-5a1 1 0 0 1 2 0v5h5a1 1 0 0 1 0 2z" />
            </svg>Add Ingredients</button>

        {{-- Showing Modal --}}
        <div class="modal fade modal-borderless modal-lg" id="modal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content p-3">
                    <form id="ingredients-form" action="{{ route('ingredients.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-title">Add Ingredients</h5>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="code" class="fw-medium mb-2">Ingredients Code</label>
                                        <input type="text" class="form-control @error('code') is-invalid @enderror"
                                            id="code" name="code" placeholder="A001" required>
                                        @error('code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="name" class="fw-medium mb-2">Ingredients Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" required placeholder="Santan">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="price" class="fw-medium mb-2">Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                                required placeholder="10.000" id="price" name="price">
                                            @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="img" class="fw-medium mb-2">Ingredients image</label>
                                        <input type="file" class="basic-filepond" name="img" id="img" required>
                                        @error('img')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary-outline" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Cancel</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="col-12">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <tr>
                            <th>Ingredients Code</th>
                            <th>Ingredients</th>
                            <th>Stock</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        @forelse ($ingredients as $item)
                        <tr>
                            <td>{{ $item->code }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ $item->price }}</td>
                            <td class="d-flex  align-items-center gap-2">
                                <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal"
                                    onclick="openModal('update', {{ $item }})"><i
                                        class="bi bi-pencil-square text-white"></i></a>
                                        <form action="{{ route('ingredients.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash-fill text-white"></i>
                                            </button>
                                        </form>
                            </td>
                        </tr>
                        @empty
                        <td colspan="5" align="center" class="text-white fw-bold">Ingredients Not Found</td>
                        @endforelse

                    </table>
                </div>
            </div>
        </div>
    </section>
    @endsection

@section('script')
    <script>
        function openModal(action, ingredients = null) {
            const modalTitle = document.getElementById('modal-title');
            const ingredientsForm = document.getElementById('ingredients-form');
            const fileInput = document.getElementById('img');

            if (action == 'add') {
                modalTitle.textContent = 'Add Ingredients';
                ingredientsForm.action = "{{ route('ingredients.store') }}";

                document.getElementById('code').value = '';
                document.getElementById('name').value = '';
                document.getElementById('price').value = '';

                FilePond.find(fileInput).removeFiles();
            } else if (action == 'update') {
                modalTitle.textContent = 'Update Ingredients';
                ingredientsForm.action = "{{ route('ingredients.update', ':id') }}".replace(':id', ingredients.id);

                document.getElementById('code').value = ingredients.code;
                document.getElementById('name').value = ingredients.name;
                document.getElementById('price').value = ingredients.price;

                const existingFile = "{{ asset('uploads/ingredients/') }}" + '/' + ingredients.img;
                FilePond.find(fileInput).addFile(existingFile);
            }
        }

    </script>
@endsection
