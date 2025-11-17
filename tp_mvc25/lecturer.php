<?php
include_once("views/Template.php");
include_once("models/DB.php");
include_once("controllers/LecturerController.php");

$lecturer = new LecturerController();

if (isset($_POST['add'])) {
    $lecturer->add();
    header("location:lecturer.php");
    exit;
} else if (!empty($_GET['id_hapus'])) {
    $_GET['id'] = $_GET['id_hapus'];
    $lecturer->delete();
    header("location:lecturer.php");
    exit;
} else if (!empty($_GET['id_edit'])) {
    $id = $_GET['id_edit'];
    include_once("models/Lecturer.php");
    include_once("models/Department.php");
    $db = new Lecturer(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
    $dept = new Department(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);

    $db->open();
    $db->getLecturerById($id);
    $row = $db->getResult();
    $db->close();

    $dept->open();
    $dept->getDepartments();
    $opts = "";
    while ($d = $dept->getResult()) {
      $selected = ($d['id'] == $row['department_id']) ? "selected" : "";
      $opts .= "<option value='{$d['id']}' $selected>{$d['dept_name']}</option>";
    }
    $dept->close();
    ?>
    <!DOCTYPE html><html><head><title>Edit Lecturer</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
    <body>
    <div class="container my-4">
      <h3>Update Lecturer</h3>
      <form method="post" action="lecturer.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="mb-2"><label>Name</label><input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control"></div>
        <div class="mb-2"><label>NIDN</label><input type="text" name="nidn" value="<?php echo $row['nidn']; ?>" class="form-control"></div>
        <div class="mb-2"><label>Phone</label><input type="text" name="phone" value="<?php echo $row['phone']; ?>" class="form-control"></div>
        <div class="mb-2"><label>Join Date</label><input type="date" name="join_date" value="<?php echo $row['join_date']; ?>" class="form-control"></div>
        <div class="mb-2"><label>Department</label>
          <select name="department_id" class="form-control">
            <option value="">-- Pilih Department --</option>
            <?php echo $opts; ?>
          </select>
        </div>
        <button type="submit" name="edit" class="btn btn-primary">Update</button>
        <a href="lecturer.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
    </body></html>
    <?php
    exit;
} else if (isset($_POST['edit'])) {
    $lecturer->edit();
    header("location:lecturer.php");
    exit;
} else {
    $lecturer->index();
}
