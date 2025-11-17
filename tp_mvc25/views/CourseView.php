<?php
class CourseView
{
  public function render($data, $lecturers)
  {
    $no = 1;
    $dataCourse = null;
    foreach ($data as $val) {
      $id = $val['id'];
      $course_name = $val['course_name'];
      $sks = $val['sks'];
      $semester = $val['semester'];
      $lecturer_name = isset($val['lecturer_name']) ? $val['lecturer_name'] : '-';

      $dataCourse .= "<tr class='text-center align-middle'>
                <td>" . $no++ . "</td>
                <td>" . $course_name . "</td>
                <td>" . $sks . "</td>
                <td>" . $semester . "</td>
                <td>" . $lecturer_name . "</td>
                <td>
                  <a href='index.php?id_edit=" . $id .  "' class='btn btn-warning'>Edit</a>
                  <a href='index.php?id_hapus=" . $id . "' class='btn btn-danger'>Hapus</a>
                </td></tr>";
    }

    $dataLect = "";
    foreach ($lecturers as $val) {
      $dataLect .= "<option value='" . $val['id'] . "'>" . $val['name'] . "</option>";
    }

    $tpl = new Template("courses.html");
    $tpl->replace("JUDUL", "Courses");
    $tpl->replace("OPTION", $dataLect);
    $tpl->replace("DATA_TABEL", $dataCourse);
    $tpl->write();
  }
}
