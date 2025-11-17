<?php
class DB
{
    // untuk menyimpan konfigurasi database
    var $db_host = "";   // Host database
    var $db_user = "";   // Username MySQL
    var $db_pass = "";   // Password MySQL
    var $db_name = "";   // Nama database
    var $db_link = "";   // Variable untuk menyimpan link/handle koneksi
    var $result = 0;     // Variable untuk menyimpan hasil query

    //Konstruktor, menyimpan konfigurasi database ke properti 
    function __construct($db_host, $db_user, $db_pass, $db_name)
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }

    // Method open(), Membuka koneksi ke database
    function open()
    {
        // mysqli_connect akan mengembalikan link/handle koneksi
        $this->db_link = mysqli_connect(
            $this->db_host,
            $this->db_user,
            $this->db_pass,
            $this->db_name
        );

        // Jika gagal, hentikan program dan tampilkan pesan error
        if (!$this->db_link) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    // Method execute(), menjalankan query SQl
    function execute($query)
    {
        // Simpan hasil query ke property $result
        $this->result = mysqli_query($this->db_link, $query);

        // Kembalikan hasil query (berbentuk mysqli_result)
        return $this->result;
    }

    // Method getResult(), mengambil satu baris data dari hasil query
    function getResult()
    {
        // Mengambil array asosiatif dari result
        return mysqli_fetch_array($this->result);
    }

    // Method close(), menutup koneksi database
    function close()
    {
        mysqli_close($this->db_link);
    }
}
