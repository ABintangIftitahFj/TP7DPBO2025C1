<?php
require_once 'config/db.php';
require_once 'class/crud_interface.php';

class User implements CrudInterface {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id_user = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nama, $email, $password, $no_hp) {
        $stmt = $this->db->prepare("INSERT INTO user (nama, email, password, no_hp) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nama, $email, $password, $no_hp]);
    }

    public function update($id, $nama, $email, $password, $no_hp) {
        $stmt = $this->db->prepare("UPDATE user SET nama = ?, email = ?, password = ?, no_hp = ? WHERE id_user = ?");
        return $stmt->execute([$nama, $email, $password, $no_hp, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM user WHERE id_user = ?");
        return $stmt->execute([$id]);
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $stmt->execute([$email, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>