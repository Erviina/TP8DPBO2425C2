<?php 
class Lecturer extends DB
{
    // Mengambil semua data dosen
    function getLecturers()
    {
        // l = lecturers, d = departments
        // LEFT JOIN memastikan dosen tetap muncul meski tidak punya department
        $query = "SELECT l.*, d.dept_name 
                  FROM lecturers l 
                  LEFT JOIN departments d ON l.department_id = d.id";
        return $this->execute($query);  // jalankan query
    }

    //Mengambil satu data dosen berdasarkan ID
    function getLecturerById($id)
    {
        $query = "SELECT * FROM lecturers WHERE id = $id";
        return $this->execute($query);
    }

    // Menambahkan data dosen baru
    function add($data)
    {
        // Ambil nilai dari form POST
        $name = $data['name'];
        $nidn = $data['nidn'];
        $phone = $data['phone'];
        $join_date = $data['join_date'];

        // Jika department_id kosong, maka nilainya NULL (tidak dikutip)
        $department_id = isset($data['department_id']) && $data['department_id'] !== '' 
                         ? $data['department_id'] 
                         : "NULL";

        // Query INSERT untuk menambah data dosen
        $query = "INSERT INTO lecturers (name, nidn, phone, join_date, department_id)
                  VALUES ('$name', '$nidn', '$phone', '$join_date', $department_id)";
        
        return $this->execute($query);
    }

    //Memperbarui data dosen berdasarkan ID
    function update($data)
    {
        // Ambil nilai dari form POST
        $id = $data['id'];
        $name = $data['name'];
        $nidn = $data['nidn'];
        $phone = $data['phone'];
        $join_date = $data['join_date'];

        // Sama seperti add(), jika tidak memilih departemen, set NULL
        $department_id = isset($data['department_id']) && $data['department_id'] !== '' 
                         ? $data['department_id'] 
                         : "NULL";

        // Query UPDATE
        $query = "UPDATE lecturers SET
                  name='$name',
                  nidn='$nidn',
                  phone='$phone',
                  join_date='$join_date',
                  department_id=$department_id
                  WHERE id = $id";

        return $this->execute($query);
    }

    //Menghapus data dosen berdasarkan ID
    function delete($id)
    {
        $query = "DELETE FROM lecturers WHERE id = $id";
        return $this->execute($query);
    }
}
