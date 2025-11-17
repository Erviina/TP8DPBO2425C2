<?php
include_once("views/Template.php");
include_once("models/DB.php");
include_once("controllers/CourseController.php");

$course = new CourseController();

if (isset($_POST['add'])) {
    $course->add();
    header("location:index.php");
    exit;
} else if (!empty($_GET['id_hapus'])) {
    $_GET['id'] = $_GET['id_hapus'];
    $course->delete();
    header("location:index.php");
    exit;
} else if (!empty($_GET['id_edit'])) {
    $id = $_GET['id_edit'];
    include_once("models/Course.php");
    include_once("models/Lecturer.php");
    $c = new Course(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
    $l = new Lecturer(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);

    $c->open();
    $c->getCourseById($id);
    $row = $c->getResult();
    $c->close();

    $l->open();
    $l->getLecturers();
    $opts = "";
    while ($le = $l->getResult()) {
      $sel = ($le['id'] == $row['lecturer_id']) ? "selected" : "";
      $opts .= "<option value='{$le['id']}' $sel>{$le['name']}</option>";
    }
    $l->close();
    ?>
    <!DOCTYPE html><html><head><title>Edit Course</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
    <body>
    <div class="container my-4">
      <h3>Update Course</h3>
      <form method="post" action="index.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="mb-2"><label>Course Name</label><input type="text" name="course_name" value="<?php echo $row['course_name']; ?>" class="form-control"></div>
        <div class="mb-2"><label>SKS</label><input type="number" name="sks" value="<?php echo $row['sks']; ?>" class="form-control"></div>
        <div class="mb-2"><label>Semester</label><input type="number" name="semester" value="<?php echo $row['semester']; ?>" class="form-control"></div>
        <div class="mb-2"><label>Lecturer</label>
          <select name="lecturer_id" class="form-control">
            <option value="">-- Pilih Lecturer --</option>
            <?php echo $opts; ?>
          </select>
        </div>
        <button type="submit" name="edit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
    </body></html>
    <?php
    exit;
} else if (isset($_POST['edit'])) {
    $course->edit();
    header("location:index.php");
    exit;
} else {
    $course->index();
}
