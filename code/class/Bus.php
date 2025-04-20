<?php
require_once 'config/db.php';
require_once 'class/crud_interface.php';


class Bus implements CrudInterface {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT b.*, a.nama as nama_agen FROM bus b JOIN agen_bus a ON b.id_agen = a.id_agen");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT b.*, a.nama as nama_agen FROM bus b JOIN agen_bus a ON b.id_agen = a.id_agen WHERE b.id_bus = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByAgen($id_agen) {
        $stmt = $this->db->prepare("SELECT * FROM bus WHERE id_agen = ?");
        $stmt->execute([$id_agen]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($id_agen, $nama, $kelas, $jumlah_kursi) {
        $stmt = $this->db->prepare("INSERT INTO bus (id_agen, nama, kelas, jumlah_kursi) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_agen, $nama, $kelas, $jumlah_kursi]);
    }

    public function update($id, $id_agen, $nama, $kelas, $jumlah_kursi) {
        $stmt = $this->db->prepare("UPDATE bus SET id_agen = ?, nama = ?, kelas = ?, jumlah_kursi = ? WHERE id_bus = ?");
        return $stmt->execute([$id_agen, $nama, $kelas, $jumlah_kursi, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM bus WHERE id_bus = ?");
        return $stmt->execute([$id]);
    }
}
?>