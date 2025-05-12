<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/functions.php';

$saldo = getSaldo();
$transaksi = getTransaksi(5);
?>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5>Saldo Saat Ini</h5>
            </div>
            <div class="card-body">
                <h3 class="card-title">Rp <?= number_format($saldo, 2, ',', '.'); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5>Transaksi Terakhir</h5>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $t): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($t['tanggal'])) ?></td>
                    <td><?= $t['kategori'] ?></td>
                    <td>
                        <span class="badge bg-<?= $t['jenis'] == 'pemasukan' ? 'success' : 'danger' ?>">
                            <?= ucfirst($t['jenis']) ?>
                        </span>
                    </td>
                    <td>Rp <?= number_format($t['jumlah'], 2, ',', '.') ?></td>
                    <td><?= $t['deskripsi'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="transaksi.php" class="btn btn-primary">Lihat Semua Transaksi</a>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>