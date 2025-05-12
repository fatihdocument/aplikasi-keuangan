<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/functions.php';

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$laporan = getLaporanBulanan($bulan, $tahun);

// Hitung total pemasukan dan pengeluaran
$totalPemasukan = 0;
$totalPengeluaran = 0;

foreach ($laporan as $item) {
    if ($item['jenis'] == 'pemasukan') {
        $totalPemasukan += $item['total'];
    } else {
        $totalPengeluaran += $item['total'];
    }
}
?>

<div class="card mb-4">
    <div class="card-header">
        <h5>Laporan Bulanan</h5>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Bulan</label>
                <select class="form-select" name="bulan">
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>>
                        <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                    </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Tahun</label>
                <select class="form-select" name="tahun">
                    <?php for ($i = date('Y'); $i >= date('Y') - 5; $i--): ?>
                    <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Pemasukan</div>
                    <div class="card-body">
                        <h5 class="card-title">Rp <?= number_format($totalPemasukan, 2, ',', '.') ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Total Pengeluaran</div>
                    <div class="card-body">
                        <h5 class="card-title">Rp <?= number_format($totalPengeluaran, 2, ',', '.') ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h6>Detail Pemasukan</h6>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($laporan as $item): ?>
                        <?php if ($item['jenis'] == 'pemasukan'): ?>
                        <tr>
                            <td><?= $item['kategori'] ?></td>
                            <td>Rp <?= number_format($item['total'], 2, ',', '.') ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h6>Detail Pengeluaran</h6>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kategori</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($laporan as $item): ?>
                        <?php if ($item['jenis'] == 'pengeluaran'): ?>
                        <tr>
                            <td><?= $item['kategori'] ?></td>
                            <td>Rp <?= number_format($item['total'], 2, ',', '.') ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>