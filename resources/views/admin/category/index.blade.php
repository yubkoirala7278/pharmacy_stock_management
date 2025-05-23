<!-- resources/views/admin/categories/index.blade.php -->
@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header py-3" style="background-color: rgba(5, 71, 40,0.9)">
                            <h4 class="mb-0 text-white"><i class="fas fa-folder"></i> Manage Categories</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn text-white py-2" style="background-color: rgba(5, 71, 40,0.9)"
                                    data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                    <i class="fas fa-plus"></i> Add Category
                                </button>
                            </div>
                            <table id="categoriesTable" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
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
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="addCategoryModalLabel">
                        <i class="fas fa-folder-plus me-2 text-white"></i>Add New Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addCategoryForm">
                    <div class="modal-body py-3">
                        <div id="addError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium ">Category Name</label>
                            <input type="text" class="form-control rounded-2" id="name" name="name" required
                                placeholder="Enter category name">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label fw-medium ">Description</label>
                            <textarea class="form-control rounded-2" id="description" name="description" rows="4"
                                placeholder="Enter description (optional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn text-white py-2" style="background-color: #054728;">
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="editCategoryModalLabel">
                        <i class="fas fa-folder-open me-2 text-white"></i>Edit Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editCategoryForm">
                    <div class="modal-body py-3">
                        <div id="editError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label fw-medium ">Category Name</label>
                            <input type="text" class="form-control rounded-2" id="edit_name" name="name" required
                                placeholder="Enter category name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label fw-medium ">Description</label>
                            <textarea class="form-control rounded-2" id="edit_description" name="description" rows="4"
                                placeholder="Enter description (optional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn btn-success text-white px-3 py-2"
                            style="background-color: #054728; border-color: #054728; transition: all 0.2s ease-in-out;">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Category Modal -->
    <div class="modal fade" id="viewCategoryModal" tabindex="-1" aria-labelledby="viewCategoryModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="viewCategoryModalLabel">
                        <i class="fas fa-folder me-2 text-white"></i>Category Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Category Name</div>
                        <div class="col-7"><span id="view_name"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Description</div>
                        <div class="col-7"><span id="view_description"></span></div>
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
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="deleteCategoryModalLabel">
                        <i class="fas fa-trash me-2 text-white"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0">Are you sure you want to delete this category? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-top-0 pt-2">
                    <button type="button"
                        class="btn btn-outline-dark btn-sm rounded-3 fw-medium text-dark border-2 px-3 py-2"
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
            var table = $('#categoriesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.data') }}",
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
                        data: 'description',
                        name: 'description'
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
                    [5, 'desc'] // Sort by 'created_at'
                ],
            });

            // Add Category
            $('#addCategoryForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('categories.store') }}",
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addCategoryModal').modal('hide');
                        $('#addCategoryForm')[0].reset();
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

            // View Category
            $(document).on('click', '.view-category', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('categories.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#view_name').text(response.name);
                        $('#view_description').text(response.description || 'N/A');
                        $('#view_created_at').text(response.created_at ? new Date(response
                            .created_at).toISOString().split('T')[0] : 'N/A');
                        $('#viewCategoryModal').modal('show');
                    }
                });
            });

            // Edit Category
            $(document).on('click', '.edit-category', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('categories.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#edit_id').val(response.id);
                        $('#edit_name').val(response.name);
                        $('#edit_description').val(response.description || '');
                        $('#editCategoryModal').modal('show');
                    }
                });
            });

            $('#editCategoryForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                $.ajax({
                    url: "{{ route('categories.update', ':id') }}".replace(':id', id),
                    type: 'PUT',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editCategoryModal').modal('hide');
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

            // Delete Category
            var deleteId;
            $(document).on('click', '.delete-category', function() {
                deleteId = $(this).data('id');
                $('#deleteCategoryModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('categories.destroy', ':id') }}".replace(':id', deleteId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteCategoryModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        $('#deleteCategoryModal').modal('hide');
                        toastr.error(xhr.responseJSON.error || 'Failed to delete category');
                    }
                });
            });
        });
    </script>
@endpush
