<?php
require_once 'config/db.php';

interface CrudInterface {
    public function getAll();
    public function getById($id);
}

?>