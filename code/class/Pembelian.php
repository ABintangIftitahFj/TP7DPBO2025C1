<?php
require_once 'config/db.php';

class Pembelian implements CrudInterface {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT p.*, 
                                 u.nama as nama_user, 
                                 j.tanggal_berangkat, 
                                 j.jam_berangkat,
                                 b.nama as nama_bus,
                                 t1.nama as terminal_asal,
                                 t2.nama as terminal_tujuan
                                 FROM pembelian p 
                                 JOIN user u ON p.id_user = u.id_user 
                                 JOIN jadwal j ON p.id_jadwal = j.id_jadwal
                                 JOIN bus b ON j.id_bus = b.id_bus
                                 JOIN terminal t1 ON j.id_terminal_asal = t1.id_terminal
                                 JOIN terminal t2 ON j.id_terminal_tujuan = t2.id_terminal");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT p.*, 
                                   u.nama as nama_user, 
                                   j.tanggal_berangkat, 
                                   j.jam_berangkat,
                                   b.nama as nama_bus,
                                   t1.nama as terminal_asal,
                                   t2.nama as terminal_tujuan
                                   FROM pembelian p 
                                   JOIN user u ON p.id_user = u.id_user 
                                   JOIN jadwal j ON p.id_jadwal = j.id_jadwal
                                   JOIN bus b ON j.id_bus = b.id_bus
                                   JOIN terminal t1 ON j.id_terminal_asal = t1.id_terminal
                                   JOIN terminal t2 ON j.id_terminal_tujuan = t2.id_terminal
                                   WHERE p.id_pembelian = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUser($id_user) {
        $stmt = $this->db->prepare("SELECT p.*, 
                                   u.nama as nama_user, 
                                   j.tanggal_berangkat, 
                                   j.jam_berangkat,
                                   b.nama as nama_bus,
                                   t1.nama as terminal_asal,
                                   t2.nama as terminal_tujuan
                                   FROM pembelian p 
                                   JOIN user u ON p.id_user = u.id_user 
                                   JOIN jadwal j ON p.id_jadwal = j.id_jadwal
                                   JOIN bus b ON j.id_bus = b.id_bus
                                   JOIN terminal t1 ON j.id_terminal_asal = t1.id_terminal
                                   JOIN terminal t2 ON j.id_terminal_tujuan = t2.id_terminal
                                   WHERE p.id_user = ?");
        $stmt->execute([$id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($id_user, $id_jadwal, $tanggal_pesan, $total_harga) {
        $stmt = $this->db->prepare("INSERT INTO pembelian (id_user, id_jadwal, tanggal_pesan, total_harga) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_user, $id_jadwal, $tanggal_pesan, $total_harga]);
    }

    public function createAndGetId($id_user, $id_jadwal, $tanggal_pesan, $total_harga) {
        $stmt = $this->db->prepare("INSERT INTO pembelian (id_user, id_jadwal, tanggal_pesan, total_harga) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id_user, $id_jadwal, $tanggal_pesan, $total_harga]);
        return $this->db->lastInsertId();
    }

    public function update($id, $id_user, $id_jadwal, $tanggal_pesan, $total_harga) {
        $stmt = $this->db->prepare("UPDATE pembelian SET id_user = ?, id_jadwal = ?, tanggal_pesan = ?, total_harga = ? WHERE id_pembelian = ?");
        return $stmt->execute([$id_user, $id_jadwal, $tanggal_pesan, $total_harga, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM pembelian WHERE id_pembelian = ?");
        return $stmt->execute([$id]);
    }
}
?>