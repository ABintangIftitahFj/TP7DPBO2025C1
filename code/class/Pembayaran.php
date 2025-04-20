<?php
require_once 'config/db.php';
require_once 'class/crud_interface.php';

class Pembayaran implements CrudInterface {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT p.*, 
                                 pem.id_user,
                                 u.nama as nama_user, 
                                 pem.tanggal_pesan,
                                 pem.total_harga
                                 FROM pembayaran p 
                                 JOIN pembelian pem ON p.id_pembelian = pem.id_pembelian
                                 JOIN user u ON pem.id_user = u.id_user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT p.*, 
                                   pem.id_user,
                                   u.nama as nama_user, 
                                   pem.tanggal_pesan,
                                   pem.total_harga
                                   FROM pembayaran p 
                                   JOIN pembelian pem ON p.id_pembelian = pem.id_pembelian
                                   JOIN user u ON pem.id_user = u.id_user
                                   WHERE p.id_pembayaran = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByPembelian($id_pembelian) {
        $stmt = $this->db->prepare("SELECT * FROM pembayaran WHERE id_pembelian = ?");
        $stmt->execute([$id_pembelian]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($id_pembelian, $metode, $status = 'belum dibayar', $waktu_bayar = null) {
        if ($waktu_bayar === null) {
            $waktu_bayar = date("Y-m-d H:i:s");
        }
        $stmt = $this->db->prepare("INSERT INTO pembayaran (id_pembelian, metode, status, waktu_bayar) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_pembelian, $metode, $status, $waktu_bayar]);
    }

    public function update($id, $id_pembelian, $metode, $status, $waktu_bayar) {
        $stmt = $this->db->prepare("UPDATE pembayaran SET id_pembelian = ?, metode = ?, status = ?, waktu_bayar = ? WHERE id_pembayaran = ?");
        return $stmt->execute([$id_pembelian, $metode, $status, $waktu_bayar, $id]);
    }

    public function updateStatus($id, $status, $waktu_bayar = null) {
        if ($waktu_bayar === null && $status == 'sudah dibayar') {
            $waktu_bayar = date("Y-m-d H:i:s");
        }
        
        $stmt = $this->db->prepare("UPDATE pembayaran SET status = ?, waktu_bayar = ? WHERE id_pembayaran = ?");
        return $stmt->execute([$status, $waktu_bayar, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM pembayaran WHERE id_pembayaran = ?");
        return $stmt->execute([$id]);
    }
}
?>