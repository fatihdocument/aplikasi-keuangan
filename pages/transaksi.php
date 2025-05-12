<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kategori_id = $_POST['kategori_id'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    
    if (addTransaksi($kategori_id, $jumlah, $deskripsi, $tanggal)) {
        echo '<div class="alert alert-success">Transaksi berhasil ditambahkan!</div>';
    } else {
        echo '<div class="alert alert-danger">Gagal menambahkan transaksi!</div>';
    }
}

$transaksi = getTransaksi();
$kategoriPemasukan = getKategori('pemasukan');
$kategoriPengeluaran = getKategori('pengeluaran');
?>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Tambah Transaksi</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Jenis Transaksi</label>
                        <select class="form-select" id="jenisTransaksi" required>
                            <option value="">Pilih Jenis</option>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" id="kategoriSelect" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control" name="jumlah" step="0.01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Transaksi</h5>
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
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('jenisTransaksi').addEventListener('change', function() {
    const jenis = this.value;
    const kategoriSelect = document.getElementById('kategoriSelect');
    
    // Clear existing options
    kategoriSelect.innerHTML = '<option value="">Pilih Kategori</option>';
    
    if (jenis === 'pemasukan') {
        <?php foreach ($kategoriPemasukan as $k): ?>
        kategoriSelect.innerHTML += '<option value="<?= $k['id'] ?>"><?= $k['nama'] ?></option>';
        <?php endforeach; ?>
    } else if (jenis === 'pengeluaran') {
        <?php foreach ($kategoriPengeluaran as $k): ?>
        kategoriSelect.innerHTML += '<option value="<?= $k['id'] ?>"><?= $k['nama'] ?></option>';
        <?php endforeach; ?>
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>