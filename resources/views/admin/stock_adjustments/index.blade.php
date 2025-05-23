<!-- resources/views/admin/stock_adjustments/index.blade.php -->
@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header py-3" style="background-color: rgba(5, 71, 40,0.9)">
                            <h4 class="mb-0 text-white"><i class="fas fa-boxes"></i> Manage Stock Adjustments</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn text-white py-2" style="background-color: rgba(5, 71, 40,0.9)"
                                    data-bs-toggle="modal" data-bs-target="#addAdjustmentModal">
                                    <i class="fas fa-plus"></i> Add Adjustment
                                </button>
                            </div>
                            <table id="adjustmentsTable" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Medicine</th>
                                        <th>User</th>
                                        <th>Quantity</th>
                                        <th>Type</th>
                                        <th>Adjustment Date</th>
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
    <!-- Add Adjustment Modal -->
    <div class="modal fade" id="addAdjustmentModal" tabindex="-1" aria-labelledby="addAdjustmentModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="addAdjustmentModalLabel">
                        <i class="fas fa-boxes me-2 text-white"></i>Add New Stock Adjustment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addAdjustmentForm">
                    <div class="modal-body py-3">
                        <div id="addError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <div class="mb-3">
                            <label for="medicine_id" class="form-label fw-medium ">Medicine</label>
                            <select class="form-control rounded-2" id="medicine_id" name="medicine_id" required>
                                <option value="" disabled selected>Select a medicine</option>
                                @foreach (\App\Models\Medicine::all() as $medicine)
                                    <option value="{{ $medicine->id }}">
                                        {{ $medicine->name }} (Stock: {{ $medicine->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label fw-medium ">Quantity</label>
                            <input type="number" class="form-control rounded-2" id="quantity" name="quantity"
                                min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label fw-medium ">Type</label>
                            <select class="form-control rounded-2" id="type" name="type" required>
                                <option value="add">Add</option>
                                <option value="remove">Remove</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reason" class="form-label fw-medium ">Reason</label>
                            <textarea class="form-control rounded-2" id="reason" name="reason" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="adjustment_date" class="form-label fw-medium ">Adjustment Date</label>
                            <input type="date" class="form-control rounded-2" id="adjustment_date" name="adjustment_date"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn text-white py-2" style="background-color: #054728;">
                            Add Adjustment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Adjustment Modal -->
    <div class="modal fade" id="editAdjustmentModal" tabindex="-1" aria-labelledby="editAdjustmentModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="editAdjustmentModalLabel">
                        <i class="fas fa-boxes me-2 text-white"></i>Edit Stock Adjustment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editAdjustmentForm">
                    <div class="modal-body py-3">
                        <div id="editError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_medicine_id" class="form-label fw-medium ">Medicine</label>
                            <select class="form-control rounded-2" id="edit_medicine_id" name="medicine_id" required>
                                <option value="" disabled>Select a medicine</option>
                                @foreach (\App\Models\Medicine::all() as $medicine)
                                    <option value="{{ $medicine->id }}">
                                        {{ $medicine->name }} (Stock: {{ $medicine->stock_quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_quantity" class="form-label fw-medium ">Quantity</label>
                            <input type="number" class="form-control rounded-2" id="edit_quantity" name="quantity"
                                min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_type" class="form-label fw-medium ">Type</label>
                            <select class="form-control rounded-2" id="edit_type" name="type" required>
                                <option value="add">Add</option>
                                <option value="remove">Remove</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_reason" class="form-label fw-medium ">Reason</label>
                            <textarea class="form-control rounded-2" id="edit_reason" name="reason" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_adjustment_date" class="form-label fw-medium ">Adjustment Date</label>
                            <input type="date" class="form-control rounded-2" id="edit_adjustment_date"
                                name="adjustment_date" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn btn-success text-white px-3 py-2"
                            style="background-color: #054728; border-color: #054728; transition: all 0.2s ease-in-out;">
                            Update Adjustment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Adjustment Modal -->
    <div class="modal fade" id="viewAdjustmentModal" tabindex="-1" aria-labelledby="viewAdjustmentModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="viewAdjustmentModalLabel">
                        <i class="fas fa-boxes me-2 text-white"></i>Stock Adjustment Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Medicine</div>
                        <div class="col-7"><span id="view_medicine"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">User</div>
                        <div class="col-7"><span id="view_user"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Quantity</div>
                        <div class="col-7"><span id="view_quantity"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Type</div>
                        <div class="col-7"><span id="view_type"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Reason</div>
                        <div class="col-7"><span id="view_reason"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Adjustment Date</div>
                        <div class="col-7"><span id="view_adjustment_date"></span></div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-2">
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-3 fw-medium border-2 px-3 py-2"
                        data-bs-dismiss="modal" style="transition: all 0.2s ease-in-out;">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteAdjustmentModal" tabindex="-1" aria-labelledby="deleteAdjustmentModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="deleteAdjustmentModalLabel">
                        <i class="fas fa-trash me-2 text-white"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0">Are you sure you want to delete this stock adjustment? This action cannot be undone.
                    </p>
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
            var table = $('#adjustmentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('stock_adjustments.data') }}",
                    error: function(xhr, error, thrown) {
                        console.log('Adjustments AJAX Error:', xhr.status, xhr.responseText);
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'medicine_name',
                        name: 'medicine_name'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'adjustment_date',
                        name: 'adjustment_date'
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
                    [7, 'desc'] // Sort by 'created_at'
                ],
            });

            // Add Adjustment
            $('#addAdjustmentForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('stock_adjustments.store') }}",
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addAdjustmentModal').modal('hide');
                        $('#addAdjustmentForm')[0].reset();
                        $('#addError').addClass('d-none').html('');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        $('#addError').removeClass('d-none').html('');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#addError').append('<p>' + value + '</p>');
                            });
                        } else {
                            $('#addError').append('<p>' + (xhr.responseJSON.error ||
                                'Failed to create adjustment') + '</p>');
                        }
                    }
                });
            });

            // View Adjustment
            $(document).on('click', '.view-adjustment', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('stock_adjustments.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#view_medicine').text(response.medicine ? response.medicine.name :
                            'N/A');
                        $('#view_user').text(response.user ? response.user.name : 'N/A');
                        $('#view_quantity').text(response.quantity || 'N/A');
                        $('#view_type').text(response.type || 'N/A');
                        $('#view_reason').text(response.reason || 'N/A');
                        $('#view_adjustment_date').text(
                            response.adjustment_date ?
                            new Intl.DateTimeFormat('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            }).format(new Date(response.adjustment_date)) :
                            'N/A'
                        );
                        $('#viewAdjustmentModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('View Adjustment AJAX Error:', xhr.status, xhr
                        .responseText);
                        toastr.error('Failed to load adjustment details');
                    }
                });
            });

            // Edit Adjustment
            $(document).on('click', '.edit-adjustment', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('stock_adjustments.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        console.log('Edit Adjustment Response:', response);
                        $('#edit_id').val(response.id);
                        $('#edit_medicine_id').val(response.medicine_id || '');
                        $('#edit_quantity').val(response.quantity || '');
                        $('#edit_type').val(response.type || 'add');
                        $('#edit_reason').val(response.reason || '');
                        let adjustmentDate = response.adjustment_date ?
                            new Date(response.adjustment_date) :
                            new Date();
                        if (isNaN(adjustmentDate)) {
                            adjustmentDate = new Date();
                        }
                        const formattedDate = adjustmentDate.toISOString().split('T')[0];
                        console.log('Formatted Adjustment Date:', formattedDate);
                        $('#edit_adjustment_date').val(formattedDate);
                        $('#editAdjustmentModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('Edit Adjustment AJAX Error:', xhr.status, xhr
                        .responseText);
                        toastr.error('Failed to load adjustment for editing');
                    }
                });
            });

            $('#editAdjustmentForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('stock_adjustments.update', ':id') }}".replace(':id', id),
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editAdjustmentModal').modal('hide');
                        $('#editError').addClass('d-none').html('');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.log('Edit Adjustment Submit AJAX Error:', xhr.status, xhr
                            .responseText);
                        $('#editError').removeClass('d-none').html('');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#editError').append('<p>' + value + '</p>');
                            });
                        } else {
                            $('#editError').append('<p>' + (xhr.responseJSON.error ||
                                'Failed to update adjustment') + '</p>');
                        }
                    }
                });
            });

            // Delete Adjustment
            var deleteId;
            $(document).on('click', '.delete-adjustment', function() {
                deleteId = $(this).data('id');
                $('#deleteAdjustmentModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('stock_adjustments.destroy', ':id') }}".replace(':id',
                        deleteId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteAdjustmentModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.log('Delete Adjustment AJAX Error:', xhr.status, xhr
                            .responseText);
                        $('#deleteAdjustmentModal').modal('hide');
                        toastr.error(xhr.responseJSON.error || 'Failed to delete adjustment');
                    }
                });
            });

            // Set default adjustment date to today
            $('#adjustment_date, #edit_adjustment_date').val(new Date().toISOString().split('T')[0]);
        });
    </script>
@endpush
