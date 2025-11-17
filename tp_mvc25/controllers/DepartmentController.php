<?php
// Mengimpor konfigurasi database dan file model/view yang dibutuhkan
include_once("config.php");                 
include_once("models/Department.php");      
include_once("views/DepartmentView.php");   

class DepartmentController
{
  // untuk menyimpan objek Department
  private $department;

  function __construct()
  {
    // Membuat objek Department dan melakukan inisialisasi koneksi
    $this->department = new Department(
        Config::$db_host, 
        Config::$db_user, 
        Config::$db_pass, 
        Config::$db_name
    );
  }

  public function index()
  {

    // Membuka koneksi ke database
    $this->department->open();

    // Mengambil seluruh data Department dari tabel
    $this->department->getDepartments();

    // Menampung hasil query dalam bentuk array
    $data = array();
    while ($row = $this->department->getResult()) {
      // Setiap baris hasil query dimasukkan ke array $data
      array_push($data, $row);
    }

    // Menutup koneksi setelah data selesai diambil
    $this->department->close();

    
    // Membuat objek view untuk tampilan Department
    $view = new DepartmentView();

    // Mengirim data ke view agar ditampilkan dalam halaman
    $view->render($data);
  }

  public function add()
  {
    // Fungsi untuk menambah data department baru

    // Jika tidak ada request POST, hentikan proses
    if (!isset($_POST)) return;

    // Membuka koneksi database
    $this->department->open();

    // Mengirim data POST ke model untuk diproses (INSERT)
    $this->department->add($_POST);

    // Menutup koneksi database
    $this->department->close();
  }

  public function edit()
  {
    // Fungsi untuk mengedit data department

    // Mengecek apakah permintaan berasal dari method POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Membuka koneksi database
      $this->department->open();

      // Memanggil update() pada model untuk memperbarui data
      $this->department->update($_POST);

      // Menutup koneksi setelah update
      $this->department->close();
    }
  }

  public function delete()
  {
    // Fungsi untuk menghapus department berdasarkan ID

    // Mengecek apakah parameter id dikirim melalui URL (GET)
    if (!empty($_GET['id'])) {

      // Menyimpan id yang dikirim dari URL
      $id = $_GET['id'];

      // Membuka koneksi database
      $this->department->open();

      // Menghapus data sesuai ID
      $this->department->delete($id);

      // Menutup koneksi
      $this->department->close();
    }
  }
}
