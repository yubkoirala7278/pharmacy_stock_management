<!-- resources/views/admin/payments/index.blade.php -->
@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header py-3" style="background-color: rgba(5, 71, 40,0.9)">
                            <h4 class="mb-0 text-white"><i class="fas fa-money-bill"></i> Manage Payments</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn text-white py-2" style="background-color: rgba(5, 71, 40,0.9)"
                                    data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                                    <i class="fas fa-plus"></i> Add Payment
                                </button>
                            </div>
                            <table id="paymentsTable" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Sale Code</th>
                                        <th>User</th>
                                        <th>Amount</th>
                                        <th>Payment Date</th>
                                        <th>Payment Method</th>
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
    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="addPaymentModalLabel">
                        <i class="fas fa-money-bill me-2 text-white"></i>Add New Payment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addPaymentForm">
                    <div class="modal-body py-3">
                        <div id="addError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <div class="mb-3">
                            <label for="sale_id" class="form-label fw-medium ">Sale</label>
                            <select class="form-control rounded-2" id="sale_id" name="sale_id" required>
                                <option value="" disabled selected>Select a sale</option>
                                @foreach (\App\Models\Sale::where('due_amount', '>', 0)->get() as $sale)
                                    <option value="{{ $sale->id }}">
                                        {{ $sale->sale_code }} (Due: ${{ number_format($sale->due_amount, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label fw-medium ">Amount</label>
                            <input type="number" class="form-control rounded-2" id="amount" name="amount"
                                step="0.01" min="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_date" class="form-label fw-medium ">Payment Date</label>
                            <input type="date" class="form-control rounded-2" id="payment_date" name="payment_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label fw-medium ">Payment Method</label>
                            <select class="form-control rounded-2" id="payment_method" name="payment_method" required>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="mobile">Mobile</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label fw-medium ">Notes</label>
                            <textarea class="form-control rounded-2" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn text-white py-2" style="background-color: rgba(5, 71, 40,0.9)">
                            Add Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Payment Modal -->
    <div class="modal fade" id="editPaymentModal" tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="editPaymentModalLabel">
                        <i class="fas fa-money-bill me-2 text-white"></i>Edit Payment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editPaymentForm">
                    <div class="modal-body py-3">
                        <div id="editError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_sale_id" class="form-label fw-medium ">Sale</label>
                            <select class="form-control rounded-2" id="edit_sale_id" name="sale_id" required>
                                <option value="" disabled>Select a sale</option>
                                @foreach (\App\Models\Sale::where('due_amount', '>', 0)->orWhereIn('id', \App\Models\Payment::pluck('sale_id'))->get() as $sale)
                                    <option value="{{ $sale->id }}">
                                        {{ $sale->sale_code }} (Due: ${{ number_format($sale->due_amount, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_amount" class="form-label fw-medium ">Amount</label>
                            <input type="number" class="form-control rounded-2" id="edit_amount" name="amount"
                                step="0.01" min="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_payment_date" class="form-label fw-medium ">Payment Date</label>
                            <input type="date" class="form-control rounded-2" id="edit_payment_date"
                                name="payment_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_payment_method" class="form-label fw-medium ">Payment Method</label>
                            <select class="form-control rounded-2" id="edit_payment_method" name="payment_method"
                                required>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="mobile">Mobile</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_notes" class="form-label fw-medium ">Notes</label>
                            <textarea class="form-control rounded-2" id="edit_notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn btn-success text-white px-3 py-2"
                            style="background-color: #054728; border-color: #054728; transition: all 0.2s ease-in-out;">
                            Update Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Payment Modal -->
    <div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewPaymentModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="viewPaymentModalLabel">
                        <i class="fas fa-money-bill me-2 text-white"></i>Payment Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Sale Code</div>
                        <div class="col-7"><span id="view_sale_code"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">User</div>
                        <div class="col-7"><span id="view_user"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Amount</div>
                        <div class="col-7">$<span id="view_amount"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Payment Date</div>
                        <div class="col-7"><span id="view_payment_date"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Payment Method</div>
                        <div class="col-7"><span id="view_payment_method"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Notes</div>
                        <div class="col-7"><span id="view_notes"></span></div>
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
    <div class="modal fade" id="deletePaymentModal" tabindex="-1" aria-labelledby="deletePaymentModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="deletePaymentModalLabel">
                        <i class="fas fa-trash me-2 text-white"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0">Are you sure you want to delete this payment? This action cannot be undone.</p>
                </div>
                <div class="modal-footer border-top-0 pt-2">
                    <button type="button" class="btn btn-outline-dark btn-sm rounded-3 fw-medium border-2 px-3 py-2"
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
            var table = $('#paymentsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('payments.data') }}",
                    error: function(xhr, error, thrown) {
                        console.log('Payments AJAX Error:', xhr.status, xhr.responseText);
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
                        data: 'sale_code',
                        name: 'sale_code'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'payment_date',
                        name: 'payment_date'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
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
                    [7, 'desc'] // Sort by 'created_at'
                ],
            });

            // Add Payment
            $('#addPaymentForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('payments.store') }}",
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addPaymentModal').modal('hide');
                        $('#addPaymentForm')[0].reset();
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
                                'Failed to create payment') + '</p>');
                        }
                    }
                });
            });

            // View Payment
            $(document).on('click', '.view-payment', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('payments.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#view_sale_code').text(response.sale ? response.sale.sale_code :
                            'N/A');
                        $('#view_user').text(response.user ? response.user.name : 'N/A');
                        $('#view_amount').text(
                            isNaN(parseFloat(response.amount)) ?
                            '0.00' :
                            parseFloat(response.amount).toFixed(2)
                        );
                        $('#view_payment_date').text(
                            response.payment_date ?
                            new Intl.DateTimeFormat('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            }).format(new Date(response.payment_date)) :
                            'N/A'
                        );
                        $('#view_payment_method').text(response.payment_method || 'N/A');
                        $('#view_notes').text(response.notes || 'N/A');
                        $('#viewPaymentModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('View Payment AJAX Error:', xhr.status, xhr.responseText);
                        toastr.error('Failed to load payment details');
                    }
                });
            });

            // Edit Payment
            $(document).on('click', '.edit-payment', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('payments.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        console.log('Edit Payment Response:', response);
                        $('#edit_id').val(response.id);
                        $('#edit_sale_id').val(response.sale_id || '');
                        $('#edit_amount').val(
                            isNaN(parseFloat(response.amount)) ?
                            '0.00' :
                            parseFloat(response.amount).toFixed(2)
                        );
                        let paymentDate = response.payment_date ?
                            new Date(response.payment_date) :
                            new Date();
                        if (isNaN(paymentDate)) {
                            paymentDate = new Date();
                        }
                        const formattedDate = paymentDate.toISOString().split('T')[0];
                        console.log('Formatted Payment Date:', formattedDate);
                        $('#edit_payment_date').val(formattedDate);
                        $('#edit_payment_method').val(response.payment_method || 'cash');
                        $('#edit_notes').val(response.notes || '');
                        $('#editPaymentModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('Edit Payment AJAX Error:', xhr.status, xhr.responseText);
                        toastr.error('Failed to load payment for editing');
                    }
                });
            });

            $('#editPaymentForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#edit_id').val();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('payments.update', ':id') }}".replace(':id', id),
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editPaymentModal').modal('hide');
                        $('#editError').addClass('d-none').html('');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.log('Edit Payment Submit AJAX Error:', xhr.status, xhr
                            .responseText);
                        $('#editError').removeClass('d-none').html('');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#editError').append('<p>' + value + '</p>');
                            });
                        } else {
                            $('#editError').append('<p>' + (xhr.responseJSON.error ||
                                'Failed to update payment') + '</p>');
                        }
                    }
                });
            });

            // Delete Payment
            var deleteId;
            $(document).on('click', '.delete-payment', function() {
                deleteId = $(this).data('id');
                $('#deletePaymentModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('payments.destroy', ':id') }}".replace(':id', deleteId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deletePaymentModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.log('Delete Payment AJAX Error:', xhr.status, xhr.responseText);
                        $('#deletePaymentModal').modal('hide');
                        toastr.error(xhr.responseJSON.error || 'Failed to delete payment');
                    }
                });
            });

            // Set default payment date to today
            $('#payment_date, #edit_payment_date').val(new Date().toISOString().split('T')[0]);
        });
    </script>
@endpush
