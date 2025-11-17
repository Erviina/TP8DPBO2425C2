<?php
class Course extends DB
{
    function getCourses()
    {
        // Query menampilkan semua mata kuliah, dan joinannya
        $query = "SELECT c.*, l.name AS lecturer_name FROM courses c LEFT JOIN lecturers l ON c.lecturer_id = l.id";

        // Mengeksekusi query dan mengembalikan hasilnya
        return $this->execute($query);
    }

    function getCourseById($id)
    {
        // Mengambil satu mata kuliah berdasarkan ID
        // Query ini hanya mengambil data tanpa join
        $query = "SELECT * FROM courses WHERE id = $id";

        return $this->execute($query);
    }

    function add($data)
    {
        // Mengambil data dari form (POST)
        $course_name = $data['course_name'];
        $sks = (int)$data['sks'];               
        $semester = (int)$data['semester'];     
        // lecturer_id bisa NULL jika user tidak memilih dosen
        $lecturer_id = isset($data['lecturer_id']) && $data['lecturer_id'] !== '' 
                        ? $data['lecturer_id'] 
                        : "NULL";

        // Query untuk insert data baru ke tabel courses
        $query = "INSERT INTO courses (course_name, sks, semester, lecturer_id)
                  VALUES ('$course_name', $sks, $semester, $lecturer_id)";

        // Eksekusi query insert
        return $this->execute($query);
    }

    function update($data)
    {
        // Mengambil data dari POST untuk memperbarui
        $id = $data['id'];
        $course_name = $data['course_name'];
        $sks = (int)$data['sks'];
        $semester = (int)$data['semester'];

        // lecturer bisa NULL
        $lecturer_id = isset($data['lecturer_id']) && $data['lecturer_id'] !== '' 
                        ? $data['lecturer_id'] 
                        : "NULL";

        // Query untuk update data pada courses
        $query = "UPDATE courses 
                  SET course_name='$course_name', sks=$sks, semester=$semester, lecturer_id=$lecturer_id
                  WHERE id = $id";

        return $this->execute($query);
    }

    function delete($id)
    {
        // Query menghapus data mata kuliah berdasarkan ID
        $query = "DELETE FROM courses WHERE id = $id";

        return $this->execute($query);
    }
}
