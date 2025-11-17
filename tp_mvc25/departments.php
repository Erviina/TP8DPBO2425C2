<?php
include_once("views/Template.php");
include_once("models/DB.php");
include_once("controllers/DepartmentController.php");

$dept = new DepartmentController();

if (isset($_POST['add'])) {
    $dept->add();
    header("location:departments.php");
    exit;
} else if (!empty($_GET['id_hapus'])) {
    $_GET['id'] = $_GET['id_hapus'];
    $dept->delete();
    header("location:departments.php");
    exit;
} else if (!empty($_GET['id_edit'])) {
    $id = $_GET['id_edit'];
    include_once("models/Department.php");
    $d = new Department(Config::$db_host, Config::$db_user, Config::$db_pass, Config::$db_name);
    $d->open();
    $d->getDepartmentById($id);
    $row = $d->getResult();
    $d->close();
    ?>
    <!DOCTYPE html><html><head><title>Edit Dept</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
    <body>
    <div class="container my-4">
      <h3>Edit Department</h3>
      <form method="post" action="departments.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <div class="mb-2"><label>Department Name</label><input type="text" name="dept_name" value="<?php echo $row['dept_name']; ?>" class="form-control"></div>
        <div class="mb-2"><label>Building</label><input type="text" name="building" value="<?php echo $row['building']; ?>" class="form-control"></div>
        <button type="submit" name="edit" class="btn btn-primary">Update</button>
        <a href="departments.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
    </body></html>
    <?php
    exit;
} else if (isset($_POST['edit'])) {
    $dept->edit();
    header("location:departments.php");
    exit;
} else {
    $dept->index();
}
