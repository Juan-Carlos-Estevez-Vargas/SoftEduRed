<?php
  require_once "../persistence/atributes/NoAttendance.php";
  require_once "../Database/conexion.php";

  session_start();
  if ($_SESSION['role_index'] === 'e'):
    include "../indexs/cruds.php";
  endif;

  $db = database::conectar();

  if (isset($_REQUEST['action'])) {
    $action = $_REQUEST['action'];

    if ($action === 'update') {
      $update = new NoAttendance();
			$update->updateGender($_POST["tdoc"], $_POST["id"], $_POST["subject"], $_POST["course"]);
    } elseif ($action === 'register') {
      $insert = new NoAttendance();
			$insert ->registerAbsence($_POST["tdoc"], $_POST["id"], $_POST["subject"], $_POST["course"]);
    } elseif ($action === 'delete') {
      $eliminar = new NoAttendance();
			$eliminar->deleteGender($_GET['cod_attendance']);
    } elseif ($action === 'edit') {
      $id = $_GET['id_gender'];
	  }
  }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>No Attendance</title>
	<link rel="stylesheet" href="../style/style_asist.css">
  <link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
  <div id="new">
    <form action="" method="">
      <div id="text">
        <label>Mr.(Ms) Teacher Select One Course: </label>
        <select name="s">
          <?php foreach ($db->query('SELECT * FROM course WHERE state= 1') as $row1) { ?>
          <option value="<?php echo $row1['cod_course']; ?>"> <?php echo $row1['cod_course']; ?></option>
          <?php } ?>
        </select>

        <button id="boton">Buscar</button>
        <input id="buton" type="button" value="reset" onclick="window.location.href='formu_view.php?s '" />
      </div>
    </form>
  </div>
  <?php
  $x = @$_GET['s'];

  $sql1= "
    SELECT
      pk_fk_tdoc_user,
      pk_fk_user_id,
      surname,
      second_surname,
      first_name,
      second_name,
      fk_cod_course
    FROM student
    JOIN user ON pk_fk_user_id = id_user AND pk_fk_tdoc_user = pk_fk_cod_doc
    WHERE fk_cod_course LIKE '$x'
  ";

  $query = $db->query($sql1);

  if($query->rowCount()>0):?>
  <div id="asist">
    <form action="" method="POST">
      <label>Que Materia desea?: </label>
      <select name="subject" class="form-control">
      <?php foreach ($db->query("
          SELECT * FROM subject_has_course
          WHERE state_sub_course = 1 AND pk_fk_course_stu ='$x'
        ") as $row2) { ?>
      <option value="<?php echo $row2['pk_fk_te_sub']; ?>"> <?php echo $row2['pk_fk_te_sub']; ?></option>
      <?php } ?>
      </select>

      <h2>Estudiantes:</h2>
      <?php  while ($row=$query->fetch(PDO::FETCH_ASSOC)) {
        echo "<p>" ,"Estudiante: ";
      ?>
      <input id="space" type="text" name="tdoc" value="<?php echo $row['pk_fk_tdoc_user']; ?>" readonly />
      <input id="space" type="text" name="id" value="<?php echo $row['pk_fk_user_id']; ?>" readonly />
      <input id="space" type="text" value="<?php echo $row["first_name"]," ", $row["surname"];?>" disabled />
      <input id="space" type="text" name="course" value="<?php echo $row['fk_cod_course']; ?>" readonly />
      <input id="space" type="checkbox" name="<?php echo $row['pk_fk_user_id']; ?>" >
    <?php } ?>
      <p>
        <input id="reg" class="btn btn-primary" type="submit" value="Save"
            onclick = "this.form.action = '?action=register';"/>
      </p>
    </form>
  </div>
  <?php endif;?>
</body>
</html>