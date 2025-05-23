<!-- resources/views/admin/sales/index.blade.php -->
@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header py-3" style="background-color: rgba(5, 71, 40,0.9)">
                            <h4 class="mb-0 text-white"><i class="fas fa-cash-register"></i> Manage Sales</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn text-white py-2" style="background-color: rgba(5, 71, 40,0.9)"
                                    data-bs-toggle="modal" data-bs-target="#addSaleModal">
                                    <i class="fas fa-plus"></i> Add Sale
                                </button>
                            </div>
                            <table id="salesTable" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Sale Code</th>
                                        <th>Customer</th>
                                        <th>User</th>
                                        <th>Sale Date</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Due Amount</th>
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
    <!-- Add Sale Modal -->
    <div class="modal fade" id="addSaleModal" tabindex="-1" aria-labelledby="addSaleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="addSaleModalLabel">
                        <i class="fas fa-cash-register me-2 text-white"></i>Add New Sale
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addSaleForm">
                    <div class="modal-body py-3">
                        <div id="addError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="sale_date" class="form-label fw-medium ">Sale Date</label>
                                <input type="date" class="form-control rounded-2" id="sale_date" name="sale_date"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="paid_amount" class="form-label fw-medium ">Paid Amount</label>
                                <input type="number" class="form-control rounded-2" id="paid_amount" name="paid_amount"
                                    step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="customer_name" class="form-label fw-medium ">Customer Name</label>
                                <input type="text" class="form-control rounded-2" id="customer_name"
                                    name="customer_name">
                            </div>
                            <div class="col-md-6">
                                <label for="customer_phone" class="form-label fw-medium ">Customer Phone</label>
                                <input type="text" class="form-control rounded-2" id="customer_phone"
                                    name="customer_phone">
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-medium">Sale Items</h6>
                            <table class="table table-bordered" id="saleItemsTable">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="saleItemsBody"></tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">Add Item</button>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn text-white py-2"  style="background-color: #054728;">
                            Add Sale
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Sale Modal -->
    <div class="modal fade" id="editSaleModal" tabindex="-1" aria-labelledby="editSaleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="editSaleModalLabel">
                        <i class="fas fa-cash-register me-2 text-white"></i>Edit Sale
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editSaleForm">
                    <div class="modal-body py-3">
                        <div id="editError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <input type="hidden" id="edit_id" name="id">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_sale_date" class="form-label fw-medium ">Sale Date</label>
                                <input type="date" class="form-control rounded-2" id="edit_sale_date"
                                    name="sale_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_paid_amount" class="form-label fw-medium ">Paid Amount</label>
                                <input type="number" class="form-control rounded-2" id="edit_paid_amount"
                                    name="paid_amount" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_customer_name" class="form-label fw-medium ">Customer Name</label>
                                <input type="text" class="form-control rounded-2" id="edit_customer_name"
                                    name="customer_name">
                            </div>
                            <div class="col-md-6">
                                <label for="edit_customer_phone" class="form-label fw-medium ">Customer Phone</label>
                                <input type="text" class="form-control rounded-2" id="edit_customer_phone"
                                    name="customer_phone">
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-medium">Sale Items</h6>
                            <table class="table table-bordered" id="editSaleItemsTable">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="editSaleItemsBody"></tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-primary" id="editAddItemBtn">Add Item</button>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn btn-success text-white px-3 py-2"
                            style="background-color: #054728; border-color: #054728; transition: all 0.2s ease-in-out;">
                            Update Sale
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Sale Modal -->
    <div class="modal fade" id="viewSaleModal" tabindex="-1" aria-labelledby="viewSaleModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="viewSaleModalLabel">
                        <i class="fas fa-cash-register me-2 text-white"></i>Sale Details
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
                        <div class="col-5 fw-medium">Customer Name</div>
                        <div class="col-7"><span id="view_customer_name"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Customer Phone</div>
                        <div class="col-7"><span id="view_customer_phone"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">User</div>
                        <div class="col-7"><span id="view_user"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Sale Date</div>
                        <div class="col-7"><span id="view_sale_date"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Total Amount</div>
                        <div class="col-7">$<span id="view_total_amount"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Paid Amount</div>
                        <div class="col-7">$<span id="view_paid_amount"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Due Amount</div>
                        <div class="col-7">$<span id="view_due_amount"></span></div>
                    </div>
                    <div class="mt-3">
                        <h6 class="fw-medium">Sale Items</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="viewSaleItems"></tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <h6 class="fw-medium">Payments</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Payment Date</th>
                                    <th>Method</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody id="viewPayments"></tbody>
                        </table>
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

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="addPaymentModalLabel">
                        <i class="fas fa-money-bill me-2 text-white"></i>Add Payment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addPaymentForm">
                    <div class="modal-body py-3">
                        <div id="paymentError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <input type="hidden" id="payment_sale_id" name="sale_id">
                        <div class="mb-3">
                            <label for="payment_amount" class="form-label fw-medium ">Amount</label>
                            <input type="number" class="form-control rounded-2" id="payment_amount" name="amount"
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
                            <label for="payment_notes" class="form-label fw-medium ">Notes</label>
                            <textarea class="form-control rounded-2" id="payment_notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn text-white py-2" style="background-color: #054728;">
                            Add Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteSaleModal" tabindex="-1" aria-labelledby="deleteSaleModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="deleteSaleModalLabel">
                        <i class="fas fa-trash me-2 text-white"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0">Are you sure you want to delete this sale? This action cannot be undone.</p>
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
            var table = $('#salesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('sales.data') }}",
                    error: function(xhr, error, thrown) {
                        console.log('Sales AJAX Error:', xhr.status, xhr.responseText);
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
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'sale_date',
                        name: 'sale_date'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
                    },
                    {
                        data: 'paid_amount',
                        name: 'paid_amount'
                    },
                    {
                        data: 'due_amount',
                        name: 'due_amount'
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

            // Function to add a new item row
            function addItemRow(tbodyId, medicineId = '', quantity = '', unitPrice = '') {
                var row = `
                    <tr>
                        <td>
                            <select class="form-select medicine-select" name="items[][medicine_id]" required>
                                <option value="" disabled ${!medicineId ? 'selected' : ''}>Select a medicine</option>
                                @foreach (\App\Models\Medicine::all() as $medicine)
                                    <option value="{{ $medicine->id }}" ${medicineId == {{ $medicine->id }} ? 'selected' : ''}>
                                        {{ $medicine->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" class="form-control quantity" name="items[][quantity]" value="${quantity}" min="1" required>
                        </td>
                        <td>
                            <input type="number" class="form-control unit-price" name="items[][unit_price]" value="${unitPrice}" step="0.01" min="0" required>
                        </td>
                        <td>
                            <span class="subtotal">${(quantity * unitPrice).toFixed(2)}</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger remove-item">Remove</button>
                        </td>
                    </tr>
                `;
                $(`#${tbodyId}`).append(row);
            }

            // Update subtotal when quantity or unit price changes
            $(document).on('input', '.quantity, .unit-price', function() {
                var row = $(this).closest('tr');
                var quantity = parseFloat(row.find('.quantity').val()) || 0;
                var unitPrice = parseFloat(row.find('.unit-price').val()) || 0;
                row.find('.subtotal').text((quantity * unitPrice).toFixed(2));
            });

            // Add item button for add modal
            $('#addItemBtn').on('click', function() {
                addItemRow('saleItemsBody');
            });

            // Add item button for edit modal
            $('#editAddItemBtn').on('click', function() {
                addItemRow('editSaleItemsBody');
            });

            // Remove item row
            $(document).on('click', '.remove-item', function() {
                var tbody = $(this).closest('tbody');
                if (tbody.find('tr').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    toastr.error('At least one item is required.');
                }
            });

            // Validate and filter items before submission
            function validateAndFilterItems(formId, tbodyId) {
                var items = [];
                var valid = true;
                var errors = [];

                $(`#${tbodyId} tr`).each(function(index) {
                    var medicineId = $(this).find('.medicine-select').val();
                    var quantity = $(this).find('.quantity').val();
                    var unitPrice = $(this).find('.unit-price').val();

                    if (medicineId && quantity && unitPrice) {
                        items.push({
                            medicine_id: medicineId,
                            quantity: quantity,
                            unit_price: unitPrice
                        });
                    } else if (medicineId || quantity || unitPrice) {
                        valid = false;
                        errors.push(
                            `Item ${index + 1}: All fields (medicine, quantity, unit price) are required.`
                            );
                    }
                });

                if (items.length === 0) {
                    valid = false;
                    errors.push('At least one valid item is required.');
                }

                return {
                    valid,
                    items,
                    errors
                };
            }

            // Add Sale
            $('#addSaleForm').on('submit', function(e) {
                e.preventDefault();
                var {
                    valid,
                    items,
                    errors
                } = validateAndFilterItems('addSaleForm', 'saleItemsBody');

                if (!valid) {
                    $('#addError').removeClass('d-none').html('');
                    errors.forEach(error => $('#addError').append('<p>' + error + '</p>'));
                    return;
                }

                var formData = {
                    sale_date: $('#sale_date').val(),
                    customer_name: $('#customer_name').val(),
                    customer_phone: $('#customer_phone').val(),
                    paid_amount: $('#paid_amount').val(),
                    items: items
                };

                $.ajax({
                    url: "{{ route('sales.store') }}",
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addSaleModal').modal('hide');
                        $('#addSaleForm')[0].reset();
                        $('#saleItemsBody').empty();
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
                                'Failed to create sale') + '</p>');
                        }
                    }
                });
            });

            // View Sale
            $(document).on('click', '.view-sale', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('sales.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#view_sale_code').text(response.sale_code || 'N/A');
                        $('#view_customer_name').text(response.customer_name || 'N/A');
                        $('#view_customer_phone').text(response.customer_phone || 'N/A');
                        $('#view_user').text(response.user ? response.user.name : 'N/A');
                        $('#view_sale_date').text(
                            response.sale_date ?
                            new Intl.DateTimeFormat('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            }).format(new Date(response.sale_date)) :
                            'N/A'
                        );
                        $('#view_total_amount').text(
                            isNaN(parseFloat(response.total_amount)) ?
                            '0.00' :
                            parseFloat(response.total_amount).toFixed(2)
                        );
                        $('#view_paid_amount').text(
                            isNaN(parseFloat(response.paid_amount)) ?
                            '0.00' :
                            parseFloat(response.paid_amount).toFixed(2)
                        );
                        $('#view_due_amount').text(
                            isNaN(parseFloat(response.due_amount)) ?
                            '0.00' :
                            parseFloat(response.due_amount).toFixed(2)
                        );
                        $('#viewSaleItems').empty();
                        if (response.sale_details && Array.isArray(response.sale_details)) {
                            response.sale_details.forEach(function(detail) {
                                var unitPrice = isNaN(parseFloat(detail.unit_price)) ?
                                    0 :
                                    parseFloat(detail.unit_price);
                                var subtotal = isNaN(parseFloat(detail.subtotal)) ?
                                    0 :
                                    parseFloat(detail.subtotal);
                                $('#viewSaleItems').append(`
                                    <tr>
                                        <td>${detail.medicine ? detail.medicine.name : 'N/A'}</td>
                                        <td>${detail.quantity || 'N/A'}</td>
                                        <td>$${unitPrice.toFixed(2)}</td>
                                        <td>$${subtotal.toFixed(2)}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            $('#viewSaleItems').append(`
                                <tr>
                                    <td colspan="4" class="text-center">No items found</td>
                                </tr>
                            `);
                        }
                        $('#viewPayments').empty();
                        if (response.payments && Array.isArray(response.payments)) {
                            response.payments.forEach(function(payment) {
                                $('#viewPayments').append(`
                                    <tr>
                                        <td>$${parseFloat(payment.amount).toFixed(2)}</td>
                                        <td>${new Intl.DateTimeFormat('en-US', {
                                            year: 'numeric',
                                            month: 'long',
                                            day: 'numeric'
                                        }).format(new Date(payment.payment_date))}</td>
                                        <td>${payment.payment_method}</td>
                                        <td>${payment.notes || 'N/A'}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            $('#viewPayments').append(`
                                <tr>
                                    <td colspan="4" class="text-center">No payments found</td>
                                </tr>
                            `);
                        }
                        $('#viewSaleModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('View Sale AJAX Error:', xhr.status, xhr.responseText);
                        toastr.error('Failed to load sale details');
                    }
                });
            });

            // Edit Sale
            $(document).on('click', '.edit-sale', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('sales.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        console.log('Edit Sale Response:', response);
                        $('#edit_id').val(response.id);
                        let saleDate = response.sale_date ?
                            new Date(response.sale_date) :
                            new Date();
                        if (isNaN(saleDate)) {
                            saleDate = new Date();
                        }
                        const formattedDate = saleDate.toISOString().split('T')[0];
                        console.log('Formatted Sale Date:', formattedDate);
                        $('#edit_sale_date').val(formattedDate);
                        $('#edit_customer_name').val(response.customer_name || '');
                        $('#edit_customer_phone').val(response.customer_phone || '');
                        $('#edit_paid_amount').val(
                            isNaN(parseFloat(response.paid_amount)) ?
                            '0.00' :
                            parseFloat(response.paid_amount).toFixed(2)
                        );
                        $('#editSaleItemsBody').empty();
                        if (response.sale_details && Array.isArray(response.sale_details)) {
                            response.sale_details.forEach(function(detail) {
                                addItemRow(
                                    'editSaleItemsBody',
                                    detail.medicine_id || '',
                                    detail.quantity || '',
                                    detail.unit_price || ''
                                );
                            });
                        } else {
                            addItemRow('editSaleItemsBody');
                        }
                        $('#editSaleModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('Edit Sale AJAX Error:', xhr.status, xhr.responseText);
                        toastr.error('Failed to load sale for editing');
                    }
                });
            });

            $('#editSaleForm').on('submit', function(e) {
                e.preventDefault();
                var {
                    valid,
                    items,
                    errors
                } = validateAndFilterItems('editSaleForm', 'editSaleItemsBody');

                if (!valid) {
                    $('#editError').removeClass('d-none').html('');
                    errors.forEach(error => $('#editError').append('<p>' + error + '</p>'));
                    return;
                }

                var formData = {
                    sale_date: $('#edit_sale_date').val(),
                    customer_name: $('#edit_customer_name').val(),
                    customer_phone: $('#edit_customer_phone').val(),
                    paid_amount: $('#edit_paid_amount').val(),
                    items: items
                };

                var id = $('#edit_id').val();
                $.ajax({
                    url: "{{ route('sales.update', ':id') }}".replace(':id', id),
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editSaleModal').modal('hide');
                        $('#editSaleItemsBody').empty();
                        $('#editError').addClass('d-none').html('');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.log('Edit Sale Submit AJAX Error:', xhr.status, xhr
                            .responseText);
                        $('#editError').removeClass('d-none').html('');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#editError').append('<p>' + value + '</p>');
                            });
                        } else {
                            $('#editError').append('<p>' + (xhr.responseJSON.error ||
                                'Failed to update sale') + '</p>');
                        }
                    }
                });
            });

            // Add Payment
            $(document).on('click', '.add-payment', function() {
                var id = $(this).data('id');
                $('#payment_sale_id').val(id);
                $('#payment_date').val(new Date().toISOString().split('T')[0]);
                $('#addPaymentModal').modal('show');
            });

            $('#addPaymentForm').on('submit', function(e) {
                e.preventDefault();
                var formData = {
                    amount: $('#payment_amount').val(),
                    payment_date: $('#payment_date').val(),
                    payment_method: $('#payment_method').val(),
                    notes: $('#payment_notes').val(),
                };
                var saleId = $('#payment_sale_id').val();

                $.ajax({
                    url: "{{ route('sales.payment', ':id') }}".replace(':id', saleId),
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addPaymentModal').modal('hide');
                        $('#addPaymentForm')[0].reset();
                        $('#paymentError').addClass('d-none').html('');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.log('Add Payment AJAX Error:', xhr.status, xhr.responseText);
                        $('#paymentError').removeClass('d-none').html('');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#paymentError').append('<p>' + value + '</p>');
                            });
                        } else {
                            $('#paymentError').append('<p>' + (xhr.responseJSON.error ||
                                'Failed to add payment') + '</p>');
                        }
                    }
                });
            });

            // Delete Sale
            var deleteId;
            $(document).on('click', '.delete-sale', function() {
                deleteId = $(this).data('id');
                $('#deleteSaleModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('sales.destroy', ':id') }}".replace(':id', deleteId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deleteSaleModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.log('Delete Sale AJAX Error:', xhr.status, xhr.responseText);
                        $('#deleteSaleModal').modal('hide');
                        toastr.error(xhr.responseJSON.error || 'Failed to delete sale');
                    }
                });
            });

            // Initialize with one empty row in add modal
            addItemRow('saleItemsBody');
        });
    </script>
@endpush
