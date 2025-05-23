<!-- resources/views/admin/purchases/index.blade.php -->
@extends('admin.master')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-header py-3" style="background-color: rgba(5, 71, 40,0.9)">
                            <h4 class="mb-0 text-white"><i class="fas fa-shopping-cart"></i> Manage Purchases</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <button class="btn text-white py-2" style="background-color: rgba(5, 71, 40,0.9)"
                                    data-bs-toggle="modal" data-bs-target="#addPurchaseModal">
                                    <i class="fas fa-plus"></i> Add Purchase
                                </button>
                            </div>
                            <table id="purchasesTable" class="table table-bordered table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Purchase Code</th>
                                        <th>Supplier</th>
                                        <th>User</th>
                                        <th>Purchase Date</th>
                                        <th>Total Amount</th>
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
    <!-- Add Purchase Modal -->
    <div class="modal fade" id="addPurchaseModal" tabindex="-1" aria-labelledby="addPurchaseModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="addPurchaseModalLabel">
                        <i class="fas fa-shopping-cart me-2 text-white"></i>Add New Purchase
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="addPurchaseForm">
                    <div class="modal-body py-3">
                        <div id="addError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="supplier_id" class="form-label fw-medium ">Supplier</label>
                                <select class="form-select rounded-2" id="supplier_id" name="supplier_id" required>
                                    <option value="" disabled selected>Select a supplier</option>
                                    @foreach (\App\Models\Supplier::all() as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="purchase_date" class="form-label fw-medium ">Purchase Date</label>
                                <input type="date" class="form-control rounded-2" id="purchase_date" name="purchase_date"
                                    required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-medium">Purchase Items</h6>
                            <table class="table table-bordered" id="purchaseItemsTable">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="purchaseItemsBody"></tbody>
                            </table>
                            <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">Add Item</button>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-2">
                        <button type="button" class="btn btn-outline-dark py-2" data-bs-dismiss="modal"
                            style="transition: all 0.2s ease-in-out;">
                            Discard
                        </button>
                        <button type="submit" class="btn text-white py-2" style="background-color: rgba(5, 71, 40,0.9)">
                            Add Purchase
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Purchase Modal -->
    <div class="modal fade" id="editPurchaseModal" tabindex="-1" aria-labelledby="editPurchaseModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="editPurchaseModalLabel">
                        <i class="fas fa-shopping-cart me-2 text-white"></i>Edit Purchase
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editPurchaseForm">
                    <div class="modal-body py-3">
                        <div id="editError" class="alert alert-danger d-none mb-3 " role="alert"></div>
                        <input type="hidden" id="edit_id" name="id">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit_supplier_id" class="form-label fw-medium ">Supplier</label>
                                <select class="form-select rounded-2" id="edit_supplier_id" name="supplier_id" required>
                                    <option value="" disabled>Select a supplier</option>
                                    @foreach (\App\Models\Supplier::all() as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="edit_purchase_date" class="form-label fw-medium ">Purchase Date</label>
                                <input type="date" class="form-control rounded-2" id="edit_purchase_date"
                                    name="purchase_date" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6 class="fw-medium">Purchase Items</h6>
                            <table class="table table-bordered" id="editPurchaseItemsTable">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Subtotal</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="editPurchaseItemsBody"></tbody>
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
                            Update Purchase
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Purchase Modal -->
    <div class="modal fade" id="viewPurchaseModal" tabindex="-1" aria-labelledby="viewPurchaseModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="viewPurchaseModalLabel">
                        <i class="fas fa-shopping-cart me-2 text-white"></i>Purchase Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Purchase Code</div>
                        <div class="col-7"><span id="view_purchase_code"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Supplier</div>
                        <div class="col-7"><span id="view_supplier"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">User</div>
                        <div class="col-7"><span id="view_user"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Purchase Date</div>
                        <div class="col-7"><span id="view_purchase_date"></span></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-medium">Total Amount</div>
                        <div class="col-7">$<span id="view_total_amount"></span></div>
                    </div>
                    <div class="mt-3">
                        <h6 class="fw-medium">Purchase Items</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Medicine</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="viewPurchaseItems"></tbody>
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deletePurchaseModal" tabindex="-1" aria-labelledby="deletePurchaseModalLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-sm rounded-3">
                <div class="modal-header border-bottom-0 pb-2" style="background-color: #054728;">
                    <h5 class="modal-title fw-bold text-white" id="deletePurchaseModalLabel">
                        <i class="fas fa-trash me-2 text-white"></i>Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-3">
                    <p class="mb-0">Are you sure you want to delete this purchase? This action cannot be undone.</p>
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
            var table = $('#purchasesTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('purchases.data') }}",
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
                        data: 'purchase_code',
                        name: 'purchase_code'
                    },
                    {
                        data: 'supplier_name',
                        name: 'supplier_name'
                    },
                    {
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'purchase_date',
                        name: 'purchase_date'
                    },
                    {
                        data: 'total_amount',
                        name: 'total_amount'
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
                addItemRow('purchaseItemsBody');
            });

            // Add item button for edit modal
            $('#editAddItemBtn').on('click', function() {
                addItemRow('editPurchaseItemsBody');
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

                    // Only include rows with all fields filled
                    if (medicineId && quantity && unitPrice) {
                        items.push({
                            medicine_id: medicineId,
                            quantity: quantity,
                            unit_price: unitPrice
                        });
                    } else if (medicineId || quantity || unitPrice) {
                        // If any field is filled but not all, mark as invalid
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

            // Add Purchase
            $('#addPurchaseForm').on('submit', function(e) {
                e.preventDefault();
                var {
                    valid,
                    items,
                    errors
                } = validateAndFilterItems('addPurchaseForm', 'purchaseItemsBody');

                if (!valid) {
                    $('#addError').removeClass('d-none').html('');
                    errors.forEach(error => $('#addError').append('<p>' + error + '</p>'));
                    return;
                }

                // Prepare form data
                var formData = {
                    supplier_id: $('#supplier_id').val(),
                    purchase_date: $('#purchase_date').val(),
                    items: items
                };

                $.ajax({
                    url: "{{ route('purchases.store') }}",
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#addPurchaseModal').modal('hide');
                        $('#addPurchaseForm')[0].reset();
                        $('#purchaseItemsBody').empty();
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

            // Edit Purchase
            $(document).on('click', '.edit-purchase', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('purchases.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        console.log('Edit Purchase Response:', response); // Debug response
                        $('#edit_id').val(response.id);
                        $('#edit_supplier_id').val(response.supplier_id || '');

                        // Format purchase_date as YYYY-MM-DD
                        let purchaseDate = response.purchase_date ?
                            new Date(response.purchase_date) :
                            new Date(); // Fallback to today
                        if (isNaN(purchaseDate)) {
                            purchaseDate = new Date(); // Fallback if invalid
                        }
                        const formattedDate = purchaseDate.toISOString().split('T')[
                        0]; // YYYY-MM-DD
                        console.log('Formatted Purchase Date:', formattedDate); // Debug date
                        $('#edit_purchase_date').val(formattedDate);

                        $('#editPurchaseItemsBody').empty();
                        if (response.purchase_details && Array.isArray(response
                                .purchase_details)) {
                            response.purchase_details.forEach(function(detail) {
                                addItemRow(
                                    'editPurchaseItemsBody',
                                    detail.medicine_id || '',
                                    detail.quantity || '',
                                    detail.unit_price || ''
                                );
                            });
                        } else {
                            // Add one empty row if no details exist
                            addItemRow('editPurchaseItemsBody');
                        }
                        $('#editPurchaseModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('Edit Purchase AJAX Error:', xhr.status, xhr.responseText);
                        toastr.error('Failed to load purchase for editing');
                    }
                });
            });

            $('#editPurchaseForm').on('submit', function(e) {
                e.preventDefault();
                var {
                    valid,
                    items,
                    errors
                } = validateAndFilterItems('editPurchaseForm', 'editPurchaseItemsBody');

                if (!valid) {
                    $('#editError').removeClass('d-none').html('');
                    errors.forEach(error => $('#editError').append('<p>' + error + '</p>'));
                    return;
                }

                // Prepare form data
                var formData = {
                    supplier_id: $('#edit_supplier_id').val(),
                    purchase_date: $('#edit_purchase_date').val(),
                    items: items
                };

                var id = $('#edit_id').val();
                $.ajax({
                    url: "{{ route('purchases.update', ':id') }}".replace(':id', id),
                    type: 'PUT',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#editPurchaseModal').modal('hide');
                        $('#editPurchaseItemsBody').empty();
                        $('#editError').addClass('d-none').html('');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        console.log('Edit Purchase Submit AJAX Error:', xhr.status, xhr
                            .responseText);
                        $('#editError').removeClass('d-none').html('');
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                $('#editError').append('<p>' + value + '</p>');
                            });
                        } else {
                            $('#editError').append('<p>Failed to update purchase</p>');
                        }
                    }
                });
            });


            // View Purchase
            $(document).on('click', '.view-purchase', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: "{{ route('purchases.show', ':id') }}".replace(':id', id),
                    type: 'GET',
                    success: function(response) {
                        $('#view_purchase_code').text(response.purchase_code || 'N/A');
                        $('#view_supplier').text(response.supplier ? response.supplier.name :
                            'N/A');
                        $('#view_user').text(response.user ? response.user.name : 'N/A');
                        // Format purchase_date as human-readable (e.g., "May 23, 2025")
                        $('#view_purchase_date').text(
                            response.purchase_date ?
                            new Intl.DateTimeFormat('en-US', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            }).format(new Date(response.purchase_date)) :
                            'N/A'
                        );
                        $('#view_total_amount').text(
                            isNaN(parseFloat(response.total_amount)) ?
                            '0.00' :
                            parseFloat(response.total_amount).toFixed(2)
                        );
                        $('#viewPurchaseItems').empty();
                        if (response.purchase_details && Array.isArray(response
                                .purchase_details)) {
                            response.purchase_details.forEach(function(detail) {
                                // Ensure unit_price and subtotal are numbers with fallback
                                var unitPrice = isNaN(parseFloat(detail.unit_price)) ?
                                    0 :
                                    parseFloat(detail.unit_price);
                                var subtotal = isNaN(parseFloat(detail.subtotal)) ?
                                    0 :
                                    parseFloat(detail.subtotal);
                                $('#viewPurchaseItems').append(`
                                    <tr>
                                        <td>${detail.medicine ? detail.medicine.name : 'N/A'}</td>
                                        <td>${detail.quantity || 'N/A'}</td>
                                        <td>$${unitPrice.toFixed(2)}</td>
                                        <td>$${subtotal.toFixed(2)}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            $('#viewPurchaseItems').append(`
                                <tr>
                                    <td colspan="4" class="text-center">No items found</td>
                                </tr>
                            `);
                        }
                        $('#viewPurchaseModal').modal('show');
                    },
                    error: function(xhr) {
                        console.log('View Purchase AJAX Error:', xhr.status, xhr.responseText);
                        toastr.error('Failed to load purchase details');
                    }
                });
            });

            // Delete Purchase
            var deleteId;
            $(document).on('click', '.delete-purchase', function() {
                deleteId = $(this).data('id');
                $('#deletePurchaseModal').modal('show');
            });

            $('#confirmDelete').on('click', function() {
                $.ajax({
                    url: "{{ route('purchases.destroy', ':id') }}".replace(':id', deleteId),
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#deletePurchaseModal').modal('hide');
                        table.ajax.reload();
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        $('#deletePurchaseModal').modal('hide');
                        toastr.error(xhr.responseJSON.error || 'Failed to delete purchase');
                    }
                });
            });

            // Initialize with one empty row in add modal
            addItemRow('purchaseItemsBody');
        });
    </script>
@endpush
