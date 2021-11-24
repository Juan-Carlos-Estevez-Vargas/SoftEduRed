<?php

require_once "cruds.php";
require_once "../Database/conexion.php";

session_start();
 if ($_SESSION['role_index'] === 'e'):
include "../indexs/cruds.php";
endif;
$db = database::conectar();

if (isset($_REQUEST['action'])) 
{
	switch ($_REQUEST['action']) 
	{
		case 'actualizar':

			$update = new no_attendance();
			$update->actualizar($_POST["tdoc"],$_POST["id"],$_POST["subject"], $_POST["course"]);

			break;
		
		case 'registrar':

      
			$insert = new no_attendance();
			$insert ->registrar($_POST["tdoc"],$_POST["id"],$_POST["subject"], $_POST["course"]);

			break;

		case 'eliminar':
				
			$eliminar = new no_attendance();
			$eliminar->eliminar($_GET['cod_attendance']);

			break;	

		case 'editar':
			
			$id = $_GET['id_gender'];

			break;	
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>NO ATTENDANCE</title>
	<link rel="stylesheet" href="../style/style_asist.css">
    <link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
 <center>
 <br><br>
<div id="new">
  <form action="" method="">
   <div id="text">
     <br><br><label>Mr.(Ms) Teacher Select One Course: </label><br>
      <br><br>
        <select name="s">      
        <?php
              foreach ($db->query('SELECT * FROM course WHERE state= 1') as $row1) { ?>
            <option value="<?php echo $row1['cod_course']; ?>"> <?php echo $row1['cod_course']; ?></option>
        <?php } ?>
      </select>
     <br><br>
        <button id="boton">Buscar</button>
         <input id="buton" type="button" value="reset" onclick="window.location.href='formu_view.php?s '">
      </div>
  </form>
 </div>
<?php
$x = @$_GET['s'];

$sql1= "SELECT pk_fk_tdoc_user, pk_fk_user_id, surname, second_surname, first_name, second_name, fk_cod_course
FROM student
JOIN user ON pk_fk_user_id = id_user AND pk_fk_tdoc_user = 	pk_fk_cod_doc
WHERE fk_cod_course LIKE '$x'";

$query = $db->query($sql1);

if($query->rowCount()>0):?>
<br><br><br><br>   
<div id="asist">
<form action="" method="POST">
 <br><br><label>Que Materia desea?: </label>
      <select name="subject" class="form-control">      
      <?php
            foreach ($db->query("SELECT * FROM subject_has_course WHERE state_sub_course = 1 AND pk_fk_course_stu ='$x'") as $row2) { ?>
          <option value="<?php echo $row2['pk_fk_te_sub']; ?>"> <?php echo $row2['pk_fk_te_sub']; ?></option>
      <?php } ?>
    </select>


<br><br><h2>Estudiantes:</h2>
<?php  while ($row=$query->fetch(PDO::FETCH_ASSOC))
{

echo "<p>" ,"Estudiante: ";?>
<input id="space" type="text" name="tdoc" value="<?php echo $row['pk_fk_tdoc_user']; ?>" readonly>
<input id="space" type="text" name="id" value="<?php echo $row['pk_fk_user_id']; ?>" readonly>
<input id="space" type="text" value="<?php echo $row["first_name"]," ", $row["surname"];?>" disabled>
<input id="space" type="text" name="course" value="<?php echo $row['fk_cod_course']; ?>" readonly>
<input id="space" type="checkbox" name="<?php echo $row['pk_fk_user_id']; ?>" >
 
<?php } ?> 
<p><input id="reg" class="btn btn-primary" type="submit" value="Save" onclick = "this.form.action = '?action=registrar';"/>
 <br><br>
</form>
 </div>
<?php endif;?>
 </center>
</body>
</html>