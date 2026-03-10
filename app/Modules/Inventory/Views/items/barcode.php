<?= $this->extend('Modules\Inventory\Views\layouts\main') ?>

<?= $this->section('content') ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="bi bi-qr-code me-2"></i>QR Code Barang</h4>
            <a href="/inventory/items/view/<?= $item['id'] ?>" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body text-center">
                <h5 class="mb-3"><?= $item['name'] ?></h5>
                <p class="text-muted"><?= $item['item_code'] ?></p>
                
                <div class="my-4">
                    <!-- QR Code -->
                    <div id="qrcode"></div>
                </div>

                <div class="text-muted small">
                    <p>Scan QR code ini untuk melihat detail barang</p>
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

        <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Create QR code with item details URL
                const itemUrl = window.location.origin + '/inventory/items/view/<?= $item['id'] ?>';
                
                new QRCode(document.getElementById('qrcode'), {
                    text: itemUrl,
                    width: 200,
                    height: 200,
                    colorDark : '#000000',
                    colorLight : '#ffffff',
                    correctLevel : QRCode.CorrectLevel.H
                });
            });
        </script>
    <?= $this->endSection() ?>
