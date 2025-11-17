Saya Ervina Kusnanda dengan NIM 2409082 mengerjakan TP 8 dalam mata kuliah Desain Pemogramana Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

## Penjelasan Database / Tabel ##
Saya menggunakan sebuah database yang berisi tiga tabel utama, yaitu: courses, lecturers, dan departments. Ketiga tabel ini saling berhubungan satu sama lain dan dipakai untuk menyimpan data mata kuliah, data dosen, dan data jurusan.

![Teks alternatif](https://github.com/Erviina/TP8DPBO2425C2/blob/main/Dokumentasi/Tabel.png?raw=true)


1. Tabel departments, menyimpan informasi mengenai jurusan atau program studi yang ada
   - Kolom id digunakan sebagai identitas unik setiap jurusan.
   - Kolom name digunakan untuk menyimpan nama jurusan seperti "Teknik Informatika", "Matematika", dan sebagainya.
     Tabel ini menjadi foreign key di tabel lecturers
     
2. Tabel lecturers, digunakan untuk menyimpan data dosen dan jurusan mereka mengajar
   - kolom id digunakan sebagai primary key
   - kolom name untuk nama dosen
   - kolom nidn digunakan untuk nomor induk dosen nasional
   - kolom phone untuk nomor telpon
   - kolom join_date nerisi tanggal kapan dosen itu bergabung
   - kolom department_id merupakan foreign key ke tabel departments

3. Tabel courses, ini dinuat seperti tabel utama, digunakan untuk menyimpan data mata kuliah
   - kolom id merupakan primary key
   - kolom name, digunakan untuk nama mata kuliah
   - kolom SKS digunakan untuk menyimpan jumlah SKS nya
   - kolom semester digunakan untuk semester yang diambilnya
   - kolom lecturer_id, foreign key ke tabel lecturers

## Penjelasan Desain Program ##
1. Bagian Model (Course.php, Lecturer.php, DB.php)
   Bagian ini adalah bagian yang berhubungan langsung dengan database.
   a. DB.php, File ini berfungsi sebagai pengatur koneksi database. Jadi setiap kali   Controller atau Model butuh query, mereka tinggal memanggil fungsi dari DB.php, tanpa perlu bikin koneksi berulang kali.
Di sini juga disediakan fungsi eksekusi query berbasis prepared statement, jadi query lebih aman dan tidak rawan SQL Injection.
   b. Course.php
      Berisi fungsi-fungsi CRUD untuk data course:
      - mengambil daftar course
      - menambah course baru
      - mengedit course
      - menghapus course
      Setiap query yang ada di sini berjalan lewat DB.php dan semuanya menggunakan prepared statement.
   c. Lecturer.php
      Fungsinya sama seperti Course.php, tetapi khusus mengelola data Lecturer.
Model–model ini hanya fokus pada pemrosesan data, tanpa tahu apa yang terjadi di tampilan.

2. View
   view bagian yg bertugas menampilkan halaman ke pengguna. Dalam program ini terdapat 3 file view:
   - CourseView.php
   - LecturerView.php
   - Departments.php
   ketiga file ini menghasilkan tampilan berbentuk tabel yang berisi daftar seluruh data yang ada di database. Di bagian ini juga terdapat form untuk menambah atau mengedit data. View tidak memanggil database secara langsung, melainkan menerima data dari Controller.

3. Controller merupakan pengatur alur logika. Ada tiga controller:
   - CourseController.php
   - LecturerController.php
   - DepartmentsController.php
   
   Fungsi controller antara lain:
   - menerima permintaan dari user (add, edit, delete)
   - memanggil fungsi yang tepat dari Model
   - mengambil data dari Model
   - mengirim data tersebut ke View

     Controller tidak menyimpan data dan tidak menampilkan data, ia hanya mengatur prosesnya.

4. templates/*.html
   Berisi:
   - form input
   - navbar
   - table
   - placeholder (string yang akan digantikan view)


## Penjelasan Alur kode ##

1. User Membuka URL, misal: index.php?page=course
   yang pertama kali dijalankan adalah index.php.
   - index.php membaca parameter page
   - berdasarkan nilai page, index akan memanggil Controller yang sesuai
   - Contoh: page=course memanggil CourseController, page=lecturer memanggil LecturerController
   Jadi index.php cuma bertugas mengarahkan jalur saja.

2. Controller Dipanggil
   Contoh: user membuka menu Course, CourseController dipanggil.
   Di dalam CourseController.php:
   - Controller membuat objek model, $this->course = new Course($db);
   - Controller juga memanggil View, $this->view = new CourseView();
   
   Artinya:
   - Model disiapkan untuk mengambil data dari database.
   - View disiapkan untuk menampilkan hasil.
   
   Kemudian Controller memeriksa aksi (action):
   - tampil data
   - tambah data
   - hapus data
   - update data
   
   Contoh, untuk menampilkan halaman awal Course:
   $this->course->getAllCourse();
   $this->view->render($data);

3. Model Mengambil Data ke Database
   Model ini tidak melakukan query mentah, tapi lewat DB.php.

   Contoh fungsi di model:
   public function getAllCourse() {
  $query = "SELECT * FROM course";
  return $this->db->executeSelectQuery($query);
}

4️. DB.php Menjalankan Prepared Statement
   DB.php adalah inti koneksi database.
   Ketika model memanggil:
   executeSelectQuery("SELECT * FROM course");
   
   DB.php melakukan:
   - prepare()
   - bind_param() (kalau ada parameter)
   - execute()
   - get_result()
   
   DB.php adalah jantungnya database.

5. Model Mengirimkan Data ke Controller
   Model mengembalikan hasil query dalam bentuk array atau objek.
   Contoh: $courses = $this->course->getAllCourse();
   Isi $courses adalah data semua matakuliah dari database.
   Controller menerima data ini, lalu mengirimkannya ke view.

6. Controller Mengirim Data ke View
    Controller mengirimkan data ke view seperti: $this->view->render($courses);
    Tugas view:
    - menerima data dari controller
    - menampilkannya dalam bentuk tabel HTML

7️. View Menampilkan Data ke User

   File seperti views/CourseView.php, views/LecturerView.php
   
   View akan mengolah data (tanpa melakukan query) menjadi tampilan HTML.
   Contoh di CourseView:
   foreach ($data as $course) {
     echo "<td>".$course['name']."</td>";
   }
   
   View hanya menampilkan. Tidak ada logika database di sini.

8. User Melakukan Aksi (Tambah, Hapus, Edit)
   Ketika user klik "Tambah" pada Course:
   user diarahkan ke URL contoh : index.php?page=course&action=add


## Dokumentasi ##
CRUD courses

![Add Courses](https://github.com/Erviina/TP8DPBO2425C2/blob/main/Dokumentasi/add%20courses.gif?raw=true)

![Edit/update courses](https://github.com/Erviina/TP8DPBO2425C2/blob/main/Dokumentasi/edit%20course.gif?raw=true)

![Delete courses](https://github.com/Erviina/TP8DPBO2425C2/blob/main/Dokumentasi/hapus%20course.gif?raw=true)

CRUD lecturer

![Add lecturer](https://github.com/Erviina/TP8DPBO2425C2/blob/main/Dokumentasi/add%20lecturer.gif?raw=true)

![edit lecturer ](https://github.com/Erviina/TP8DPBO2425C2/blob/main/Dokumentasi/edit%20lecturer.gif?raw=true)

![hapus lecturer ](https://github.com/Erviina/TP8DPBO2425C2/blob/main/Dokumentasi/hapus%20lecturer.gif?raw=true)

CRUD Department

![Add department ](https://github.com/Erviina/TP8DPBO2425C2/blob/main/Dokumentasi/add%20department.gif?raw=true)

![Edit Department ](https://github.com/Erviina/TP8DPBO2425C2/blob/main/Dokumentasi/edit%20department.gif?raw=true)

![hapus department](https://github.com/Erviina/TP8DPBO2425C2/blob/main/Dokumentasi/hapus%20department.gif?raw=true)


