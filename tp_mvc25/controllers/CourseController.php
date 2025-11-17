<?php
// memanggil file konfigurasi database dan model-model yang dibutuhkan
include_once("config.php");           
include_once("models/Course.php");    
include_once("models/Lecturer.php");  
include_once("views/CourseView.php"); 

class CourseController
{
  // untuk menyimpan objek Course dan Lecturer
  private $course;
  private $lecturer;

  function __construct()
  {
    // membuat objek Course dan Lecturer dan melakukan koneksi database
    $this->course = new Course(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
    $this->lecturer = new Lecturer(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
  }

  public function index()
  {
    // membuka koneksi database untuk model Course
    $this->course->open();

    // memanggil fungsi model untuk mengambil semua data Course
    $this->course->getCourses();

    // menampung semua data Course ke dalam array $data
    $data = array();
    while ($row = $this->course->getResult()) {
      // Setiap hasil row dimasukkan ke array
      array_push($data, $row);
    }

    // menutup koneksi database setelah selesai mengambil data Course
    $this->course->close();



    // ambil data lecturer

    // membuka koneksi database untuk model Lecturer
    $this->lecturer->open();

    // mengambil semua data Lecturer
    $this->lecturer->getLecturers();

    // menampung hasilnya ke array $lecData
    $lecData = array();
    while ($row = $this->lecturer->getResult()) {
      array_push($lecData, $row);
    }

    // menutup koneksi database
    $this->lecturer->close();



    // membuat objek view untuk halaman Course
    $view = new CourseView();

    // render tampilan dengan mengirim data course + lecturer
    $view->render($data, $lecData);
  }

  public function add()
  {
    // fungsi untuk menambah data Course baru
    
    // jika tidak ada data POST, hentikan proses
    if (!isset($_POST)) return;

    // Buka koneksi
    $this->course->open();

    // Model memproses data POST untuk ditambahkan ke database
    $this->course->add($_POST);

    // Tutup koneksi database
    $this->course->close();
  }

  public function edit()
  {
    // Fungsi untuk update data Course

    // Mengecek apakah request ini adalah POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      // Buka koneksi ke database
      $this->course->open();

      // Memanggil fungsi update dari model Course
      $this->course->update($_POST);

      // Tutup koneksi database
      $this->course->close();
    }
  }

  public function delete()
  {
    // Fungsi menghapus data Course berdasarkan ID

    // Cek apakah parameter id dikirim melalui GET
    if (!empty($_GET['id'])) {

      $id = $_GET['id']; // Ambil id dari URL

      // Buka koneksi database
      $this->course->open();

      // Hapus data sesuai ID yang diberikan
      $this->course->delete($id);

      // Tutup koneksi
      $this->course->close();
    }
  }
}
