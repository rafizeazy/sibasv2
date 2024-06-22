<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "u330845453_db_sibas";
    public $koneksi;

    public function __construct() {
        $this->koneksi = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->koneksi->connect_error) {
            die("Connection failed: " . $this->koneksi->connect_error);
        }
    }

    public function query($sql) {
        return $this->koneksi->query($sql);
    }

    public function escape_string($value) {
        return $this->koneksi->real_escape_string($value);
    }

    public function fetch_assoc($result) {
        return $result->fetch_assoc();
    }

    public function close() {
        $this->koneksi->close();
    }
}
?>
