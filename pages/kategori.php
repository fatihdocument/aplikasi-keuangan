<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    
    if (addKategori($nama, $jenis)) {
        echo '<div class="alert alert-success">Kategori berhasil ditambahkan!</div>';
    } else {
        echo '<div class="alert alert-danger">Gagal menambahkan kategori!</div>';
    }
}

$kategori = getKategori();
?>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Tambah Kategori</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select class="form-select" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="pemasukan">Pemasukan</option>
                            <option value="pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Daftar Kategori</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Dibuat Pada</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kategori as $k): ?>
                        <tr>
                            <td><?= $k['nama'] ?></td>
                            <td>
                                <span class="badge bg-<?= $k['jenis'] == 'pemasukan' ? 'success' : 'danger' ?>">
                                    <?= ucfirst($k['jenis']) ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($k['created_at'])) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>