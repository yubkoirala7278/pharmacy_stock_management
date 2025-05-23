<!-- resources/views/admin/users/index.blade.php -->
@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header py-3" style="background-color: rgba(5, 71, 40,0.9)">
                            <h4 class="mb-0 text-white"><i class="fas fa-users"></i> Manage Users</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn text-white py-2" style="background-color: rgba(5, 71, 40,0.9)"
                                    data-bs-toggle="modal" data-bs-target="#addUserModal">
                                    <i class="fas fa-plus"></i> Add User
                                </button>
                            </div>
                            <table id="usersTable" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
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
    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="addUserModalLabel">
                        <i class="fas fa-users me-2 text-white"></i>Add New User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addUserForm">
                    <div class="modal-body py-3">
                        <div id="addError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <div class="mb-3">
                            <label for="name" class="form-label fw-medium ">Name</label>
                            <input type="text" class="form-control rounded-2" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium ">Email</label>
                            <input type="email" class="form-control rounded-2" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium ">Password</label>
                            <input type="password" class="form-control rounded-2" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-medium ">Confirm Password</label>
                            <input type="password" class="form-control rounded-2" id="password_confirmation"
                                name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label fw-medium ">Role</label>
                            <select class="form-control rounded-2" id="role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="pharmacist">Pharmacist</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn btn-success text-white py-2">
                            Add User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="editUserModalLabel">
                        <i class="fas fa-users me-2 text-white"></i>Edit User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editUserForm">
                    <div class="modal-body py-3">
                        <div id="editError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label fw-medium ">Name</label>
                            <input type="text" class="form-control rounded-2" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label fw-medium ">Email</label>
                            <input type="email" class="form-control rounded-2" id="edit_email" name="email"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_password" class="form-label fw-medium ">Password (leave blank to keep
                                unchanged)</label>
                            <input type="password" class="form-control rounded-2" id="edit_password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="edit_password_confirmation" class="form-label fw-medium ">Confirm
                                Password</label>
                            <input type="password" class="form-control rounded-2" id="edit_password_confirmation"
                                name="password_confirmation">
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label fw-medium ">Role</label>
                            <select class="form-control rounded-2" id="edit_role" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="pharmacist">Pharmacist</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn btn-success text-white px-3 py-2"
                            style="background-color: #054728; border-color: #054728; transition: all 0.2s ease-in-out;">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="viewUserModalLabel">
                        <i class="fas fa-users me-2 text-white"></i>User Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Name</div>
                        <div class="col-7"><span id="view_name"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Email</div>
                        <div class="col-7"><span id="view_email"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Role</div>
                        <div class="col-7"><span id="view_role"></span></div>
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
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="deleteUserModalLabel">
                        <i class="fas fa-trash me-2 text-white"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0">Are you sure you want to delete this user? This action cannot be undone.</p>
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
            var table = $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.data') }}",
                    error: function(xhr, error, thrown) {
                        console.log('Users AJAX Error:', xhr.status, xhr.responseText);
                    }
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'role'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Add User
            $('#addUserForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('users.store') }}",
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addUserModal').modal('hide');
                        $('#addUserForm')[0].reset();
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
                                'Failed to create user') + '</p>');
                        }
                    }
                });
            });

            // View User
            $(document).on('click', '.view-user', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('users.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#view_name').text(response.name || 'N/A');
                        $('#view_email').text(response.email || 'N/A');
                        $('#view_role').text(response.role ? response.role.charAt(0)
                            .toUpperCase() + response.role.slice(1) : 'N/A');
                        $('#viewUserModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('View User AJAX Error:', xhr.status, xhr.responseText);
                        toastr.error('Failed to load user details');
                    }
                });
            });

            // Edit User
            $(document).on('click', '.edit-user', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('users.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        console.log('Edit User Response:', response);
                        $('#edit_id').val(response.id);
                        $('#edit_name').val(response.name || '');
                        $('#edit_email').val(response.email || '');
                        $('#edit_role').val(response.role || 'staff');
                        $('#edit_password').val('');
                        $('#edit_password_confirmation').val('');
                        $('#editUserModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('Edit User AJAX Error:', xhr.status, xhr.responseText);
                        toastr.error('Failed to load user for editing');
                    }
                });
            });

            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('users.update', ':id') }}".replace(':id', id),
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editUserModal').modal('hide');
                        $('#editError').addClass('d-none').html('');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.log('Edit User Submit AJAX Error:', xhr.status, xhr
                            .responseText);
                        $('#editError').removeClass('d-none').html('');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#editError').append('<p>' + value + '</p>');
                            });
                        } else {
                            $('#editError').append('<p>' + (xhr.responseJSON.error ||
                                'Failed to update user') + '</p>');
                        }
                    }
                });
            });

            // Delete User
            var deleteId;
            $(document).on('click', '.delete-user', function() {
                deleteId = $(this).data('id');
                $('#deleteUserModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('users.destroy', ':id') }}".replace(':id', deleteId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteUserModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.log('Delete User AJAX Error:', xhr.status, xhr.responseText);
                        $('#deleteUserModal').modal('hide');
                        toastr.error(xhr.responseJSON.error || 'Failed to delete user');
                    }
                });
            });
        });
    </script>
@endpush
