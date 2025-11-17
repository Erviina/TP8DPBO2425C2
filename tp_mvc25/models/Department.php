<?php 

class Department extends DB
{
    //Mengambil semua data departemen dari tabel departments
    function getDepartments()
    {
        $query = "SELECT * FROM departments";
        return $this->execute($query);  // jalankan query dan simpan hasilnya
    }

    //Mengambil 1 data departemen berdasarkan ID
    function getDepartmentById($id)
    {
        $query = "SELECT * FROM departments WHERE id = $id";
        return $this->execute($query);
    }

    // Menambahkan data departemen baru
    // Data dikirim melalui form POST dari controller
    function add($data)
    {
        $dept_name = $data['dept_name'];   // nama departemen
        $building = $data['building'];     // gedung departemen

        // Query insert
        $query = "INSERT INTO departments (dept_name, building)
                  VALUES ('$dept_name', '$building')";

        return $this->execute($query);
    }

    //Memperbarui data departemen berdasarkan ID
    function update($data)
    {
        $id = $data['id'];                 // ID departemen
        $dept_name = $data['dept_name'];   // nama departemen baru
        $building = $data['building'];     // gedung baru

        // Query update
        $query = "UPDATE departments
                  SET dept_name='$dept_name', building='$building'
                  WHERE id = $id";

        return $this->execute($query);
    }

    //Menghapus data departemen berdasarkan ID
    function delete($id)
    {
        $query = "DELETE FROM departments WHERE id = $id";
        return $this->execute($query);
    }
}
