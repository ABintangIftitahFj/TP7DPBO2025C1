<?php
require_once 'config/db.php';
require_once 'class/crud_interface.php';

class AgenBus implements CrudInterface {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM agen_bus");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM agen_bus WHERE id_agen = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nama, $alamat, $kontak) {
        $stmt = $this->db->prepare("INSERT INTO agen_bus (nama, alamat, kontak) VALUES (?, ?, ?)");
        return $stmt->execute([$nama, $alamat, $kontak]);
    }

    public function update($id, $nama, $alamat, $kontak) {
        $stmt = $this->db->prepare("UPDATE agen_bus SET nama = ?, alamat = ?, kontak = ? WHERE id_agen = ?");
        return $stmt->execute([$nama, $alamat, $kontak, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM agen_bus WHERE id_agen = ?");
        return $stmt->execute([$id]);
    }
}
?>