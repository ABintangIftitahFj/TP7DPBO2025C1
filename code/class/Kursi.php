<?php
require_once 'config/db.php';
require_once 'class/crud_interface.php';

class Kursi implements CrudInterface {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT k.*, j.tanggal_berangkat, j.jam_berangkat FROM kursi k JOIN jadwal j ON k.id_jadwal = j.id_jadwal");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT k.*, j.tanggal_berangkat, j.jam_berangkat FROM kursi k JOIN jadwal j ON k.id_jadwal = j.id_jadwal WHERE k.id_kursi = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByJadwal($id_jadwal) {
        $stmt = $this->db->prepare("SELECT * FROM kursi WHERE id_jadwal = ?");
        $stmt->execute([$id_jadwal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($id_jadwal, $nomor_kursi, $status = 'tersedia') {
        $stmt = $this->db->prepare("INSERT INTO kursi (id_jadwal, nomor_kursi, status) VALUES (?, ?, ?)");
        return $stmt->execute([$id_jadwal, $nomor_kursi, $status]);
    }

    public function update($id, $id_jadwal, $nomor_kursi, $status) {
        $stmt = $this->db->prepare("UPDATE kursi SET id_jadwal = ?, nomor_kursi = ?, status = ? WHERE id_kursi = ?");
        return $stmt->execute([$id_jadwal, $nomor_kursi, $status, $id]);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE kursi SET status = ? WHERE id_kursi = ?");
        return $stmt->execute([$status, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM kursi WHERE id_kursi = ?");
        return $stmt->execute([$id]);
    }

    public function generateKursi($id_jadwal, $jumlah_kursi) {
        // Delete existing seats for this schedule if any
        $stmt = $this->db->prepare("DELETE FROM kursi WHERE id_jadwal = ?");
        $stmt->execute([$id_jadwal]);
        
        // Generate new seats
        $success = true;
        for ($i = 1; $i <= $jumlah_kursi; $i++) {
            $nomor = str_pad($i, 2, '0', STR_PAD_LEFT);
            $result = $this->create($id_jadwal, $nomor);
            if (!$result) {
                $success = false;
            }
        }
        return $success;
    }

    public function getKursiByJadwal($id_jadwal) {
        $stmt = $this->db->prepare("SELECT * FROM kursi WHERE id_jadwal = ? AND status = 'tersedia'");
        $stmt->execute([$id_jadwal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>