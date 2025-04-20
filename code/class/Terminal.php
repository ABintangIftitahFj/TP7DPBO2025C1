<?php
require_once 'config/db.php';
require_once 'class/crud_interface.php';

class Terminal implements CrudInterface {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM terminal");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM terminal WHERE id_terminal = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nama, $lokasi) {
        $stmt = $this->db->prepare("INSERT INTO terminal (nama, lokasi) VALUES (?, ?)");
        return $stmt->execute([$nama, $lokasi]);
    }

    public function update($id, $nama, $lokasi) {
        $stmt = $this->db->prepare("UPDATE terminal SET nama = ?, lokasi = ? WHERE id_terminal = ?");
        return $stmt->execute([$nama, $lokasi, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM terminal WHERE id_terminal = ?");
        return $stmt->execute([$id]);
    }
}
?>