<?php
require_once 'config/db.php';
require_once 'class/crud_interface.php';

class Jadwal implements CrudInterface {
    private $db;

    public function __construct() {
        $this->db = (new Database())->conn;
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT j.*, 
                                 b.nama as nama_bus, 
                                 t1.nama as terminal_asal_nama, 
                                 t2.nama as terminal_tujuan_nama 
                                 FROM jadwal j 
                                 JOIN bus b ON j.id_bus = b.id_bus 
                                 JOIN terminal t1 ON j.id_terminal_asal = t1.id_terminal 
                                 JOIN terminal t2 ON j.id_terminal_tujuan = t2.id_terminal");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT j.*, 
                                   b.nama as nama_bus, 
                                   t1.nama as terminal_asal_nama, 
                                   t2.nama as terminal_tujuan_nama 
                                   FROM jadwal j 
                                   JOIN bus b ON j.id_bus = b.id_bus 
                                   JOIN terminal t1 ON j.id_terminal_asal = t1.id_terminal 
                                   JOIN terminal t2 ON j.id_terminal_tujuan = t2.id_terminal 
                                   WHERE j.id_jadwal = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByRute($asal, $tujuan, $tanggal) {
        $stmt = $this->db->prepare("SELECT j.*, 
                                   b.nama as nama_bus, b.kelas,
                                   t1.nama as terminal_asal_nama, 
                                   t2.nama as terminal_tujuan_nama 
                                   FROM jadwal j 
                                   JOIN bus b ON j.id_bus = b.id_bus 
                                   JOIN terminal t1 ON j.id_terminal_asal = t1.id_terminal 
                                   JOIN terminal t2 ON j.id_terminal_tujuan = t2.id_terminal 
                                   WHERE j.id_terminal_asal = ? 
                                   AND j.id_terminal_tujuan = ? 
                                   AND j.tanggal_berangkat = ?");
        $stmt->execute([$asal, $tujuan, $tanggal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($id_bus, $id_terminal_asal, $id_terminal_tujuan, $tanggal_berangkat, $jam_berangkat, $harga) {
        $stmt = $this->db->prepare("INSERT INTO jadwal (id_bus, id_terminal_asal, id_terminal_tujuan, tanggal_berangkat, jam_berangkat, harga) 
                                   VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$id_bus, $id_terminal_asal, $id_terminal_tujuan, $tanggal_berangkat, $jam_berangkat, $harga]);
    }

    public function update($id, $id_bus, $id_terminal_asal, $id_terminal_tujuan, $tanggal_berangkat, $jam_berangkat, $harga) {
        $stmt = $this->db->prepare("UPDATE jadwal 
                                   SET id_bus = ?, 
                                       id_terminal_asal = ?, 
                                       id_terminal_tujuan = ?, 
                                       tanggal_berangkat = ?, 
                                       jam_berangkat = ?, 
                                       harga = ? 
                                   WHERE id_jadwal = ?");
        return $stmt->execute([$id_bus, $id_terminal_asal, $id_terminal_tujuan, $tanggal_berangkat, $jam_berangkat, $harga, $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM jadwal WHERE id_jadwal = ?");
        return $stmt->execute([$id]);
    }
}
?>