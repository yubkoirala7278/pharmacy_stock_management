<!-- resources/views/admin/medicines/index.blade.php -->
@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header py-3 " style="background-color: rgba(5, 71, 40,0.9)">
                            <h4 class="mb-0 text-white"><i class="fas fa-pills"></i> Manage Medicines</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn text-white py-2" style="background-color: rgba(5, 71, 40,0.9)"
                                    data-bs-toggle="modal" data-bs-target="#addMedicineModal">
                                    <i class="fas fa-plus"></i> Add Medicine
                                </button>
                            </div>
                            <table id="medicinesTable" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Batch Number</th>
                                        <th>Expiry Date</th>
                                        <th>Cost Price</th>
                                        <th>Selling Price</th>
                                        <th>Stock Quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <!-- Add Medicine Modal -->
    <div class="modal fade" id="addMedicineModal" tabindex="-1" aria-labelledby="addMedicineModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="addMedicineModalLabel">
                        <i class="fas fa-capsules me-2 text-white"></i>Add New Medicine
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addMedicineForm">
                    <div class="modal-body py-3">
                        <div id="addError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium ">Medicine Name</label>
                            <input type="text" class="form-control rounded-2" id="name" name="name" required
                                placeholder="Enter medicine name">
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label fw-medium ">Category</label>
                            <select class="form-select rounded-2" id="category_id" name="category_id" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach (\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="batch_number" class="form-label fw-medium ">Batch Number</label>
                            <input type="text" class="form-control rounded-2" id="batch_number" name="batch_number"
                                required placeholder="Enter batch number">
                        </div>
                        <div class="mb-3">
                            <label for="expiry_date" class="form-label fw-medium ">Expiry Date</label>
                            <input type="date" class="form-control rounded-2" id="expiry_date" name="expiry_date"
                                required>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="cost_price" class="form-label fw-medium ">Cost Price</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$</span>
                                    <input type="number" step="0.01" class="form-control rounded-end-2" id="cost_price"
                                        name="cost_price" required placeholder="0.00">
                                </div>
                            </div>
                            <div class="col">
                                <label for="selling_price" class="form-label fw-medium ">Selling Price</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$</span>
                                    <input type="number" step="0.01" class="form-control rounded-end-2"
                                        id="selling_price" name="selling_price" required placeholder="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="stock_quantity" class="form-label fw-medium ">Stock Quantity</label>
                            <input type="number" class="form-control rounded-2" id="stock_quantity"
                                name="stock_quantity" required placeholder="Enter quantity">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn text-white py-2" style="background-color: #054728;">
                            Add Medicine
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Modal -->
    <div class="modal fade" id="editMedicineModal" tabindex="-1" aria-labelledby="editMedicineModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="editMedicineModalLabel">
                        <i class="fas fa-capsules me-2 text-white"></i>Edit Medicine
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editMedicineForm">
                    <div class="modal-body py-3">
                        <div id="editError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label fw-medium ">Medicine Name</label>
                            <input type="text" class="form-control rounded-2" id="edit_name" name="name" required
                                placeholder="Enter medicine name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_category_id" class="form-label fw-medium ">Category</label>
                            <select class="form-select rounded-2" id="edit_category_id" name="category_id" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach (\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_batch_number" class="form-label fw-medium ">Batch Number</label>
                            <input type="text" class="form-control rounded-2" id="edit_batch_number"
                                name="batch_number" required placeholder="Enter batch number">
                        </div>
                        <div class="mb-3">
                            <label for="edit_expiry_date" class="form-label fw-medium ">Expiry Date</label>
                            <input type="date" class="form-control rounded-2" id="edit_expiry_date"
                                name="expiry_date" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="edit_cost_price" class="form-label fw-medium ">Cost Price</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$</span>
                                    <input type="number" step="0.01" class="form-control rounded-end-2"
                                        id="edit_cost_price" name="cost_price" required placeholder="0.00">
                                </div>
                            </div>
                            <div class="col">
                                <label for="edit_selling_price" class="form-label fw-medium ">Selling Price</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light">$</span>
                                    <input type="number" step="0.01" class="form-control rounded-end-2"
                                        id="edit_selling_price" name="selling_price" required placeholder="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_stock_quantity" class="form-label fw-medium ">Stock Quantity</label>
                            <input type="number" class="form-control rounded-2" id="edit_stock_quantity"
                                name="stock_quantity" required placeholder="Enter quantity">
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn btn-success text-white px-3 py-2"
                            style="background-color: #054728; border-color: #054728; transition: all 0.2s ease-in-out;">
                            Update Medicine
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Medicine Modal -->
    <div class="modal fade" id="viewMedicineModal" tabindex="-1" aria-labelledby="viewMedicineModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="viewMedicineModalLabel">
                        <i class="fas fa-capsules me-2 text-white"></i>Medicine Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="row mb-2">
                        <div class="col-5 fw-medium ">Medicine Name</div>
                        <div class="col-7"><span id="view_name"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium ">Category</div>
                        <div class="col-7"><span id="view_category"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium ">Batch Number</div>
                        <div class="col-7"><span id="view_batch_number"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium ">Expiry Date</div>
                        <div class="col-7"><span id="view_expiry_date"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium ">Cost Price</div>
                        <div class="col-7">$<span id="view_cost_price"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium ">Selling Price</div>
                        <div class="col-7">$<span id="view_selling_price"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium ">Stock Quantity</div>
                        <div class="col-7"><span id="view_stock_quantity"></span></div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-2">
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-3 fw-medium  border-2 px-3 py-2"
                        data-bs-dismiss="modal" style="transition: all 0.2s ease-in-out;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteMedicineModal" tabindex="-1" aria-labelledby="deleteMedicineModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="deleteMedicineModalLabel">
                        <i class="fas fa-trash me-2 text-white"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0">Are you sure you want to delete this medicine? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-top-0 pt-2">
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-3 fw-medium  border-2 px-3 py-2"
                        data-bs-dismiss="modal" style="transition: all 0.2s ease-in-out;">
                        Cancel
                    </button>
                    <button type="button" class="btn btn-danger btn-sm rounded-3 fw-medium text-white px-3 py-2"
                        id="confirmDelete" style="transition: all 0.2s ease-in-out;">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            var table = $('#medicinesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('medicines.data') }}",
                columns: [ {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'category_name',
                        name: 'category_name'
                    },
                    {
                        data: 'batch_number',
                        name: 'batch_number'
                    },
                    {
                        data: 'expiry_date',
                        name: 'expiry_date'
                    },
                    {
                        data: 'cost_price',
                        name: 'cost_price'
                    },
                    {
                        data: 'selling_price',
                        name: 'selling_price'
                    },
                    {
                        data: 'stock_quantity',
                        name: 'stock_quantity'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                     {
                        data: 'created_at',
                        name: 'created_at',
                        visible: false // Hide this column from the table
                    }
                ],
                  order: [
                    [9, 'desc'] // Sort by 'created_at'
                ],
            });

            // Add Medicine
            $('#addMedicineForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('medicines.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addMedicineModal').modal('hide');
                        $('#addMedicineForm')[0].reset();
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        $('#addError').removeClass('d-none').html('');
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#addError').append('<p>' + value + '</p>');
                        });
                    }
                });
            });

            // View Medicine
            $(document).on('click', '.view-medicine', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('medicines.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#view_name').text(response.name);
                        $('#view_category').text(response.category ? response.category.name :
                            'N/A');
                        $('#view_batch_number').text(response.batch_number);
                        $('#view_expiry_date').text(response.expiry_date || 'N/A');
                        $('#view_cost_price').text(response.cost_price);
                        $('#view_selling_price').text(response.selling_price);
                        $('#view_stock_quantity').text(response.stock_quantity);
                        $('#viewMedicineModal').modal('show');
                    }
                });
            });

            // Edit Medicine
            $(document).on('click', '.edit-medicine', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('medicines.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#edit_id').val(response.id);
                        $('#edit_name').val(response.name);
                        $('#edit_category_id').val(response.category_id);
                        $('#edit_batch_number').val(response.batch_number);
                        $('#edit_expiry_date').val(response.expiry_date ? new Date(response.expiry_date).toISOString().split('T')[0] : '');
                        $('#edit_cost_price').val(response.cost_price);
                        $('#edit_selling_price').val(response.selling_price);
                        $('#edit_stock_quantity').val(response.stock_quantity);
                        $('#editMedicineModal').modal('show');
                    }
                });
            });

            $('#editMedicineForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                $.ajax({
                    url: "{{ route('medicines.update', ':id') }}".replace(':id', id),
                    type: 'PUT',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editMedicineModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        $('#editError').removeClass('d-none').html('');
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            $('#editError').append('<p>' + value + '</p>');
                        });
                    }
                });
            });

            // Delete Medicine
            var deleteId;
            $(document).on('click', '.delete-medicine', function() {
                deleteId = $(this).data('id');
                $('#deleteMedicineModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('medicines.destroy', ':id') }}".replace(':id', deleteId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteMedicineModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        $('#deleteMedicineModal').modal('hide');
                        toastr.error(xhr.responseJSON.error || 'Failed to delete medicine');
                    }
                });
            });
        });
    </script>
@endpush