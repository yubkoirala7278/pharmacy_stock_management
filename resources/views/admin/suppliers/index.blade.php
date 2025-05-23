<!-- resources/views/admin/suppliers/index.blade.php -->
@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header py-3" style="background-color: rgba(5, 71, 40,0.9)">
                            <h4 class="mb-0 text-white"><i class="fas fa-truck"></i> Manage Suppliers</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn text-white py-2" style="background-color: rgba(5, 71, 40,0.9)"
                                    data-bs-toggle="modal" data-bs-target="#addSupplierModal">
                                    <i class="fas fa-plus"></i> Add Supplier
                                </button>
                            </div>
                            <table id="suppliersTable" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Contact Person</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Created At</th>
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
    <!-- Add Supplier Modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" aria-labelledby="addSupplierModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="addSupplierModalLabel">
                        <i class="fas fa-truck-loading me-2 text-white"></i>Add New Supplier
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addSupplierForm">
                    <div class="modal-body py-3">
                        <div id="addError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium ">Supplier Name</label>
                            <input type="text" class="form-control rounded-2" id="name" name="name" required
                                placeholder="Enter supplier name">
                        </div>
                        <div class="mb-3">
                            <label for="contact_person" class="form-label fw-medium ">Contact Person</label>
                            <input type="text" class="form-control rounded-2" id="contact_person" name="contact_person"
                                placeholder="Enter contact person (optional)">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium ">Email</label>
                            <input type="email" class="form-control rounded-2" id="email" name="email"
                                placeholder="Enter email (optional)">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-medium ">Phone</label>
                            <input type="text" class="form-control rounded-2" id="phone" name="phone"
                                placeholder="Enter phone number (optional)">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label fw-medium ">Address</label>
                            <textarea class="form-control rounded-2" id="address" name="address" rows="4"
                                placeholder="Enter address (optional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn text-white py-2" style="background-color: #054728;">
                            Add Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Supplier Modal -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" aria-labelledby="editSupplierModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="editSupplierModalLabel">
                        <i class="fas fa-truck-loading me-2 text-white"></i>Edit Supplier
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editSupplierForm">
                    <div class="modal-body py-3">
                        <div id="editError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label fw-medium ">Supplier Name</label>
                            <input type="text" class="form-control rounded-2" id="edit_name" name="name" required
                                placeholder="Enter supplier name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_contact_person" class="form-label fw-medium ">Contact Person</label>
                            <input type="text" class="form-control rounded-2" id="edit_contact_person"
                                name="contact_person" placeholder="Enter contact person (optional)">
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label fw-medium ">Email</label>
                            <input type="email" class="form-control rounded-2" id="edit_email" name="email"
                                placeholder="Enter email (optional)">
                        </div>
                        <div class="mb-3">
                            <label for="edit_phone" class="form-label fw-medium ">Phone</label>
                            <input type="text" class="form-control rounded-2" id="edit_phone" name="phone"
                                placeholder="Enter phone number (optional)">
                        </div>
                        <div class="mb-3">
                            <label for="edit_address" class="form-label fw-medium ">Address</label>
                            <textarea class="form-control rounded-2" id="edit_address" name="address" rows="4"
                                placeholder="Enter address (optional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn btn-success text-white px-3 py-2"
                            style="background-color: #054728; border-color: #054728; transition: all 0.2s ease-in-out;">
                            Update Supplier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Supplier Modal -->
    <div class="modal fade" id="viewSupplierModal" tabindex="-1" aria-labelledby="viewSupplierModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="viewSupplierModalLabel">
                        <i class="fas fa-truck me-2 text-white"></i>Supplier Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Supplier Name</div>
                        <div class="col-7"><span id="view_name"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Contact Person</div>
                        <div class="col-7"><span id="view_contact_person"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Email</div>
                        <div class="col-7"><span id="view_email"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Phone</div>
                        <div class="col-7"><span id="view_phone"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Address</div>
                        <div class="col-7"><span id="view_address"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Created At</div>
                        <div class="col-7"><span id="view_created_at"></span></div>
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
    <div class="modal fade" id="deleteSupplierModal" tabindex="-1" aria-labelledby="deleteSupplierModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="deleteSupplierModalLabel">
                        <i class="fas fa-trash me-2 text-white"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0">Are you sure you want to delete this supplier? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-top-0 pt-2">
                    <button type="button"
                        class="btn btn-outline-dark btn-sm rounded-3 fw-medium  border-2 px-3 py-2"
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
            var table = $('#suppliersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('suppliers.data') }}",
                    error: function(xhr, error, thrown) {
                        console.log('AJAX Error:', xhr.status, xhr.responseText);
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
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'contact_person',
                        name: 'contact_person'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
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
                    },
                ],
                  order: [
                    [8, 'desc'] // Sort by 'created_at'
                ],
            });

            // Add Supplier
            $('#addSupplierForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('suppliers.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addSupplierModal').modal('hide');
                        $('#addSupplierForm')[0].reset();
                        $('#addError').addClass('d-none').html('');
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

            // View Supplier
            $(document).on('click', '.view-supplier', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('suppliers.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#view_name').text(response.name);
                        $('#view_contact_person').text(response.contact_person || 'N/A');
                        $('#view_email').text(response.email || 'N/A');
                        $('#view_phone').text(response.phone || 'N/A');
                        $('#view_address').text(response.address || 'N/A');
                        $('#view_created_at').text(response.created_at ? new Date(response
                            .created_at).toISOString().split('T')[0] : 'N/A');
                        $('#viewSupplierModal').modal('show');
                    }
                });
            });

            // Edit Supplier
            $(document).on('click', '.edit-supplier', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('suppliers.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#edit_id').val(response.id);
                        $('#edit_name').val(response.name);
                        $('#edit_contact_person').val(response.contact_person || '');
                        $('#edit_email').val(response.email || '');
                        $('#edit_phone').val(response.phone || '');
                        $('#edit_address').val(response.address || '');
                        $('#editSupplierModal').modal('show');
                    }
                });
            });

            $('#editSupplierForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                $.ajax({
                    url: "{{ route('suppliers.update', ':id') }}".replace(':id', id),
                    type: 'PUT',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editSupplierModal').modal('hide');
                        $('#editError').addClass('d-none').html('');
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

            // Delete Supplier
            var deleteId;
            $(document).on('click', '.delete-supplier', function() {
                deleteId = $(this).data('id');
                $('#deleteSupplierModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('suppliers.destroy', ':id') }}".replace(':id', deleteId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteSupplierModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        $('#deleteSupplierModal').modal('hide');
                        toastr.error(xhr.responseJSON.error || 'Failed to delete supplier');
                    }
                });
            });
        });
    </script>
@endpush
