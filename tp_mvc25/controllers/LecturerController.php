<?php
// Mengimpor file konfigurasi dan file MVC yang diperlukan
include_once("config.php");                 
include_once("models/Lecturer.php");        
include_once("models/Department.php");      
include_once("views/LecturerView.php");     

class LecturerController
{
  // untuk menyimpan objek Lecturer dan Department
  private $lecturer;
  private $department;

  function __construct()
  {
    // Membuat objek Lecturer dan Department
    $this->lecturer = new Lecturer(
        Config::$db_host, 
        Config::$db_user, 
        Config::$db_pass, 
        Config::$db_name
    );

    $this->department = new Department(
        Config::$db_host, 
        Config::$db_user, 
        Config::$db_pass, 
        Config::$db_name
    );
  }

  public function index()
  {
    // Membuka koneksi database untuk model Lecturer
    $this->lecturer->open();

    // Mengambil semua data lecturer (dosen)
    $this->lecturer->getLecturers();

    // Menyimpan hasil query ke dalam array
    $data = array();
    while ($row = $this->lecturer->getResult()) {
      array_push($data, $row);
    }

    // Menutup koneksi database
    $this->lecturer->close();


    // Membuka koneksi database untuk Department
    $this->department->open();

    // Mengambil daftar seluruh jurusan/department
    $this->department->getDepartments();

    // Menyimpan semua baris data ke array
    $deptData = array();
    while ($row = $this->department->getResult()) {
      array_push($deptData, $row);
    }

    // Menutup koneksi database setelah selesai
    $this->department->close();


    // Membuat objek view untuk halaman Lecturer
    $view = new LecturerView();

    // Memasukkan data lecturer + department ke dalam tampilan
    $view->render($data, $deptData);
  }

  public function add()
  {
    // Fungsi untuk menambah data dosen baru

    // Jika tidak ada data POST, hentikan proses
    if (!isset($_POST)) return;

    // Membuka koneksi
    $this->lecturer->open();

    // Tambahkan data baru berdasarkan input POST
    $this->lecturer->add($_POST);

    // Tutup koneksi
    $this->lecturer->close();
  }

  public function edit()
  {
    // Fungsi untuk mengubah data dosen

    // Mengecek apakah request berupa POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Buka koneksi database
      $this->lecturer->open();

      // Update data lecturer sesuai input
      $this->lecturer->update($_POST);

      // Tutup koneksi
      $this->lecturer->close();
    }
  }

  public function delete()
  {
    // Fungsi untuk menghapus data dosen berdasarkan ID

    // Mengecek apakah parameter id dikirim lewat URL
    if (!empty($_GET['id'])) {

      $id = $_GET['id']; // Menyimpan ID dari URL

      // Buka koneksi database
      $this->lecturer->open();

      // Menghapus dosen dengan ID tertentu
      $this->lecturer->delete($id);

      // Tutup koneksi
      $this->lecturer->close();
    }
  }
}
