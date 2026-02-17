<?= $this->extend('Modules\Dashboard\Views\layout') ?>

<?= $this->section('content') ?>
<style>
    .invoice-header {
        background: linear-gradient(to right, #8B0000, #6B0000);
        color: white;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .btn-invoice {
        background: linear-gradient(to right, #8B0000, #6B0000);
        color: white;
        border: none;
    }

    .line-item-row {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
        align-items: flex-end;
    }

    .line-item-row .form-group {
        flex: 1;
        margin-bottom: 0;
    }

    .line-item-row .form-group.amount {
        flex: 0 0 150px;
    }

    .line-item-row .btn-danger {
        flex: 0 0 auto;
        padding: 6px 12px;
        height: 38px;
    }

    .items-table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .items-table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #ddd;
        padding: 10px;
        text-align: left;
        font-weight: 600;
    }

    .items-table td {
        border-bottom: 1px solid #ddd;
        padding: 10px;
    }

    .total-row {
        background-color: #fff3cd;
        font-weight: 600;
    }

    .total-row td {
        padding: 12px 10px;
    }
</style>

<div class="container-fluid">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="invoice-header">
        <h3 class="mb-0"><i class="bi bi-arrow-repeat"></i> Perpanjang Faktur</h3>
    </div>

    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i> <strong>Catatan:</strong> Perpanjangan faktur akan membuat <strong>faktur baru</strong> dengan nomor baru. 
        Faktur asli akan ditandai sebagai "Diperpanjang" dan terhubung ke faktur baru.
    </div>

    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('invoice/store') ?>" method="post" id="invoiceForm">
                <?= csrf_field() ?>
                <input type="hidden" name="action" value="extend">

                <!-- Student Selection -->
                <div class="mb-3">
                    <label class="form-label">Siswa *</label>
                    <select name="registration_number" class="form-select" id="studentSelect">
                        <option value="">Pilih Siswa Terlebih Dahulu</option>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= esc($student['registration_number']) ?>">
                                <?= esc($student['full_name']) ?> (<?= esc($student['registration_number']) ?>)
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <!-- Invoice Selection -->
                <div class="mb-3" id="invoiceSelectContainer" style="display: none;">
                    <label class="form-label">Pilih Faktur untuk Diperpanjang *</label>
                    <select name="invoice_id" class="form-select" id="invoiceSelect">
                        <option value="">Pilih Faktur</option>
                    </select>
                </div>

                <input type="hidden" name="invoice_type" id="extendInvoiceType" value="">

                <!-- Due Date -->
                <div class="mb-3" id="dueDateContainer" style="display: none;">
                    <label class="form-label">Tanggal Jatuh Tempo *</label>
                    <input type="date" name="due_date" class="form-control" id="extendDueDate">
                </div>

                <!-- Selected Invoice Details -->
                <div id="selectedInvoiceDetails" class="alert alert-info" style="display: none;">
                    <!-- Invoice details will be loaded here -->
                </div>

                <!-- Line Items Section -->
                <div class="card bg-light mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Item Faktur Baru</h5>
                    </div>
                    <div class="card-body">
                        <div id="lineItemsContainer">
                            <!-- Line items will be added here -->
                        </div>

                        <button type="button" class="btn btn-sm btn-primary" id="addLineItem">
                            <i class="bi bi-plus"></i> Tambah Item
                        </button>
                    </div>
                </div>

                <!-- Items Summary Table -->
                <table class="items-table">
                    <thead>
                        <tr>
                            <th>Deskripsi</th>
                            <th style="width: 150px; text-align: right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody id="itemsPreview">
                        <!-- Preview will be shown here -->
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td style="text-align: right;">Jumlah Faktur Baru:</td>
                            <td style="text-align: right;">
                                <span id="totalAmount">0.00</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?= base_url('invoice') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-invoice"><i class="bi bi-arrow-repeat"></i> Perpanjang Faktur</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let lineItemCount = 0;

    // Load student invoices when student is selected
    document.getElementById('studentSelect').addEventListener('change', function() {
        const registrationNumber = this.value;
        const invoiceSelectContainer = document.getElementById('invoiceSelectContainer');
        const dueDateContainer = document.getElementById('dueDateContainer');
        const invoiceSelect = document.getElementById('invoiceSelect');
        const detailsDiv = document.getElementById('selectedInvoiceDetails');

        // Hide details
        detailsDiv.style.display = 'none';

        if (!registrationNumber) {
            invoiceSelectContainer.style.display = 'none';
            dueDateContainer.style.display = 'none';
            return;
        }

        // Fetch invoices via AJAX
        fetch(`/invoice/student-invoices?registration_number=${registrationNumber}`)
            .then(response => response.json())
            .then(data => {
                if (data.invoices && data.invoices.length > 0) {
                    invoiceSelect.innerHTML = '<option value="">Pilih Faktur</option>';
                    data.invoices.forEach(invoice => {
                        const items = JSON.parse(invoice.items || '[]');
                        const itemDescriptions = items.map(i => i.description).join(', ');
                        invoiceSelect.innerHTML += `
                            <option value="${invoice.id}" data-invoice-type="${invoice.invoice_type}">
                                ${invoice.invoice_number} - ${formatCurrency(invoice.amount)}
                                (${invoice.status}) - ${itemDescriptions}
                            </option>
                        `;
                    });
                    invoiceSelectContainer.style.display = 'block';
                    dueDateContainer.style.display = 'block';
                } else {
                    invoiceSelectContainer.style.display = 'none';
                    dueDateContainer.style.display = 'none';
                    alert('Tidak ditemukan faktur yang dapat diperpanjang untuk siswa ini.');
                }
            })
            .catch(error => {
                console.error('Error fetching invoices:', error);
                alert('Gagal memuat faktur. Silakan coba lagi.');
            });
    });

    // Show invoice details when invoice is selected
    document.getElementById('invoiceSelect').addEventListener('change', function() {
        const invoiceId = this.value;
        const detailsDiv = document.getElementById('selectedInvoiceDetails');
        const invoiceTypeInput = document.getElementById('extendInvoiceType');

        if (!invoiceId) {
            detailsDiv.style.display = 'none';
            invoiceTypeInput.value = '';
            return;
        }

        // Get selected option
        const selectedOption = this.options[this.selectedIndex];
        const invoiceType = selectedOption.getAttribute('data-invoice-type');

        // Set the invoice type
        invoiceTypeInput.value = invoiceType;

        // Fetch invoice summary via AJAX
        fetch(`/invoice/invoice-summary?invoice_id=${invoiceId}`)
            .then(response => response.json())
            .then(data => {
                if (data.summary) {
                    const s = data.summary;
                    detailsDiv.innerHTML = `
                        <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Ringkasan Faktur Asli</h6>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Nomor Faktur Asli:</strong> ${s.invoice_number}
                                </div>
                                <div class="mb-2">
                                    <strong>Jumlah Faktur Asli:</strong> ${formatCurrency(s.current_invoice_amount)}
                                </div>
                                <div class="mb-2">
                                    <strong>Status Faktur:</strong>
                                    <span class="badge bg-${s.invoice_status === 'paid' ? 'success' : s.invoice_status === 'partially_paid' ? 'info' : s.invoice_status === 'expired' ? 'danger' : 'warning'}">
                                        ${s.invoice_status.replace('_', ' ')}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Total Kontrak:</strong> ${formatCurrency(s.total_initial_amount)}
                                </div>
                                <div class="mb-2">
                                    <strong>Total Dibayar:</strong> <span class="text-success">${formatCurrency(s.total_paid)}</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Sisa Saldo:</strong>
                                    <span class="badge ${s.outstanding_balance > 0 ? 'bg-warning' : 'bg-success'}">
                                        ${formatCurrency(s.outstanding_balance)}
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                    detailsDiv.className = 'alert alert-info';
                    detailsDiv.style.display = 'block';
                } else if (data.error) {
                    detailsDiv.innerHTML = `
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> ${data.error}
                        </div>
                    `;
                    detailsDiv.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching invoice summary:', error);
                detailsDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle"></i> Gagal memuat ringkasan faktur. Silakan coba lagi.
                    </div>
                `;
                detailsDiv.style.display = 'block';
            });
    });

    function addLineItem() {
        lineItemCount++;
        const itemId = 'item_' + lineItemCount;

        const html = `
            <div class="line-item-row" data-item-id="${itemId}">
                <div class="form-group flex-grow-1">
                    <input type="text" name="items[${lineItemCount}][description]"
                           class="form-control item-description" placeholder="Deskripsi item" >
                </div>
                <div class="form-group amount">
                    <input type="number" name="items[${lineItemCount}][amount]"
                           class="form-control item-amount" placeholder="0.00" step="0.01" min="0" >
                </div>
                <button type="button" class="btn btn-danger btn-sm removeLineItem">Hapus</button>
            </div>
        `;

        document.getElementById('lineItemsContainer').insertAdjacentHTML('beforeend', html);

        // Add event listeners to the new inputs
        const descInput = document.querySelector(`[name="items[${lineItemCount}][description]"]`);
        const amountInput = document.querySelector(`[name="items[${lineItemCount}][amount]"]`);

        descInput.addEventListener('input', updateSummary);
        amountInput.addEventListener('input', updateSummary);

        // Add remove button listener
        document.querySelector(`[data-item-id="${itemId}"] .removeLineItem`).addEventListener('click', function() {
            document.querySelector(`[data-item-id="${itemId}"]`).remove();
            updateSummary();
        });
    }

    function updateSummary() {
        const descriptions = document.querySelectorAll('.item-description');
        const amounts = document.querySelectorAll('.item-amount');

        let total = 0;
        let previewHtml = '';

        descriptions.forEach((desc, index) => {
            if (desc.value.trim()) {
                const amount = parseFloat(amounts[index].value) || 0;
                total += amount;

                previewHtml += `
                    <tr>
                        <td>${escapeHtml(desc.value)}</td>
                        <td style="text-align: right;">${amount.toLocaleString('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    </tr>
                `;
            }
        });

        document.getElementById('itemsPreview').innerHTML = previewHtml;
        document.getElementById('totalAmount').textContent = total.toLocaleString('id-ID', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(amount);
    }

    // Event delegation for remove buttons
    document.getElementById('lineItemsContainer').addEventListener('click', function(e) {
        if (e.target.classList.contains('removeLineItem')) {
            e.preventDefault();
            e.target.closest('.line-item-row').remove();
            updateSummary();
        }
    });

    // Add click listener for add button
    document.getElementById('addLineItem').addEventListener('click', function(e) {
        e.preventDefault();
        addLineItem();
    });

    // Form validation
    document.getElementById('invoiceForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default submission

        // Validate extend invoice fields
        const studentSelect = document.getElementById('studentSelect');
        const invoiceSelect = document.getElementById('invoiceSelect');
        const extendDueDate = document.getElementById('extendDueDate');

        if (!studentSelect.value) {
            alert('Silakan pilih siswa');
            return false;
        }

        if (!invoiceSelect.value) {
            alert('Silakan pilih faktur untuk diperpanjang');
            return false;
        }

        if (!extendDueDate.value) {
            alert('Silakan pilih tanggal jatuh tempo');
            return false;
        }

        // Validate line items
        const lineItems = document.querySelectorAll('.line-item-row');
        if (lineItems.length === 0) {
            alert('Silakan tambahkan setidaknya satu item');
            return false;
        }

        // Check if all items have description and amount
        const allValid = Array.from(lineItems).every(item => {
            const desc = item.querySelector('.item-description').value.trim();
            const amount = item.querySelector('.item-amount').value;
            return desc && amount;
        });

        if (!allValid) {
            alert('Semua item harus memiliki deskripsi dan jumlah');
            return false;
        }

        // Submit the form
        this.submit();
    });

    // Initialize with one empty line item
    addLineItem();
</script>
<?= $this->endSection() ?>
