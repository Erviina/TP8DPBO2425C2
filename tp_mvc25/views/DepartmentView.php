<?php
class DepartmentView
{
  public function render($data)
  {
    $no = 1;
    $dataDept = null;
    foreach ($data as $val) {
        $id = $val['id'];
        $dept_name = $val['dept_name'];
        $building = $val['building'];
        $dataDept .= "<tr>
                    <td>" . $no++ . "</td>
                    <td>" . $dept_name . "</td>
                    <td>" . $building . "</td>
                    <td>
                      <a href='departments.php?id_edit=" . $id .  "' class='btn btn-warning'>Edit</a>
                      <a href='departments.php?id_hapus=" . $id . "' class='btn btn-danger'>Hapus</a>
                    </td>
                    </tr>";
    }

    $tpl = new Template("department.html");
    $tpl->replace("JUDUL", "Departments");
    $tpl->replace("DATA_TABEL", $dataDept);
    $tpl->write();
  }
}
