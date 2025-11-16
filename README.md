## Penjelasan Database / Tabel ##
Saya menggunakan sebuah database yang berisi tiga tabel utama, yaitu: courses, lecturers, dan departments. Ketiga tabel ini saling berhubungan satu sama lain dan dipakai untuk menyimpan data mata kuliah, data dosen, dan data jurusan.

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

   - DB.php, File ini berfungsi sebagai pengatur koneksi database. Jadi setiap kali Controller atau Model butuh query, mereka tinggal memanggil fungsi dari DB.php, tanpa perlu bikin koneksi berulang kali.
Di sini juga disediakan fungsi eksekusi query berbasis prepared statement, jadi query lebih aman dan tidak rawan SQL Injection.
- Course.php & Lecturer.php
Dua file ini jadi “wakil" tabel dalam database.
Tugasnya:

mengambil data

menambah data

mengubah data

menghapus data

Semua perintah SQL yang ada di sini memakai prepared statement bawaan DB.php.

Jadi bagian Model benar-benar fokus ke pengelolaan data.
