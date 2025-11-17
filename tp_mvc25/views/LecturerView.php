<?php
class LecturerView
{
  public function render($data, $departments)
  {
    $no = 1;
    $dataLecturer = "";

    foreach ($data as $val) {
        $id = $val['id'];
        $name = $val['name'];
        $nidn = $val['nidn'];
        $phone = $val['phone'];
        $join_date = $val['join_date'];
        $dept_name = isset($val['dept_name']) ? $val['dept_name'] : '-';

        $dataLecturer .= "
            <tr>
                <td>$no</td>
                <td>$name</td>
                <td>$nidn</td>
                <td>$phone</td>
                <td>$join_date</td>
                <td>$dept_name</td>
                <td>
                  <a href='lecturer.php?id_edit=$id' class='btn btn-warning'>Edit</a>
                  <a href='lecturer.php?id_hapus=$id' class='btn btn-danger'>Hapus</a>
                </td>
            </tr>";
        $no++;
    }

    // options dropdown
    $opts = "";
    foreach ($departments as $d) {
        $opts .= "<option value='{$d['id']}'>{$d['dept_name']}</option>";
    }

    // INI yang sebelumnya salah
    $tpl = new Template("lecturer.html");

    $tpl->replace("JUDUL", "Lecturers");
    $tpl->replace("OPTION", $opts);
    $tpl->replace("DATA_TABEL", $dataLecturer);
    $tpl->write();
  }
}
