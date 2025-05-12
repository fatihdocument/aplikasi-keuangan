<?php
require_once __DIR__ . '/../config/database.php';

function getSaldo() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT SUM(CASE WHEN k.jenis = 'pemasukan' THEN t.jumlah ELSE 0 END) - 
                         SUM(CASE WHEN k.jenis = 'pengeluaran' THEN t.jumlah ELSE 0 END) as saldo
                         FROM transaksi t
                         JOIN kategori k ON t.kategori_id = k.id");
    return $stmt->fetchColumn();
}

function getTransaksi($limit = null) {
    global $pdo;
    
    $sql = "SELECT t.*, k.nama as kategori, k.jenis 
            FROM transaksi t 
            JOIN kategori k ON t.kategori_id = k.id 
            ORDER BY t.tanggal DESC";
    
    if ($limit) {
        $sql .= " LIMIT $limit";
    }
    
    return $pdo->query($sql)->fetchAll();
}

function getKategori($jenis = null) {
    global $pdo;
    
    $sql = "SELECT * FROM kategori";
    if ($jenis) {
        $sql .= " WHERE jenis = '$jenis'";
    }
    
    return $pdo->query($sql)->fetchAll();
}

function addKategori($nama, $jenis) {
    global $pdo;
    
    $stmt = $pdo->prepare("INSERT INTO kategori (nama, jenis) VALUES (?, ?)");
    return $stmt->execute([$nama, $jenis]);
}

function addTransaksi($kategori_id, $jumlah, $deskripsi, $tanggal) {
    global $pdo;
    
    $stmt = $pdo->prepare("INSERT INTO transaksi (kategori_id, jumlah, deskripsi, tanggal) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$kategori_id, $jumlah, $deskripsi, $tanggal]);
}

function getLaporanBulanan($bulan, $tahun) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT k.nama as kategori, k.jenis, SUM(t.jumlah) as total
                           FROM transaksi t
                           JOIN kategori k ON t.kategori_id = k.id
                           WHERE MONTH(t.tanggal) = ? AND YEAR(t.tanggal) = ?
                           GROUP BY k.nama, k.jenis");
    $stmt->execute([$bulan, $tahun]);
    return $stmt->fetchAll();
}
?>