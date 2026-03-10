<?= $this->extend('Modules\Inventory\Views\layouts\main') ?>

<?= $this->section('content') ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="bi bi-upc me-2"></i>Barcode Barang</h4>
            <a href="/inventory/items/view/<?= $item['id'] ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <h5 class="mb-3"><?= $item['name'] ?></h5>
                <p class="text-muted"><?= $item['item_code'] ?></p>
                
                <div class="my-4">
                    <!-- Simple barcode representation using Code 128 format -->
                    <svg class="barcode"
                        jsbarcode-value="<?= $item['barcode'] ?? $item['item_code'] ?>"
                        jsbarcode-format="CODE128"
                        jsbarcode-width="2"
                        jsbarcode-height="60"
                        jsbarcode-displayvalue="true">
                    </svg>
                </div>

                <div class="text-muted small">
                    <p>Scan barcode ini untuk melihat detail barang</p>
                </div>

                <div class="mt-4">
                    <a href="/inventory/items/edit/<?= $item['id'] ?>" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i> Edit Barang
                    </a>
                    <a href="/inventory/movements/create?item=<?= $item['id'] ?>" class="btn btn-primary">
                        <i class="bi bi-arrow-left-right me-1"></i> Catat Mutasi
                    </a>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                JsBarcode('.barcode').initialize();
            });
        </script>
    <?= $this->endSection() ?>
