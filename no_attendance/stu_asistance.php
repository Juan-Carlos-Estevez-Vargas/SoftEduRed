<?php

require_once "cruds.php";
require_once "../Database/conexion.php";;
$db = database::conectar();
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php session_start();?> WELCOME</title>
<link rel="stylesheet" href="../style/style_stu_asist.css">
 <link rel="stylesheet" href="../indexs/style/cruds_style.css">
</head>
<body>
	
	
<?php

if ($_SESSION['role_index'] === 'st'): ?>
	<div id="asist">
     <center>
  <br><h1>STUDENT <?php echo $_SESSION["NAME"]. " " .$_SESSION["SNAME"]." ".$_SESSION["LASTNAME"]." ".$_SESSION["SLASTNAME"];?></h1>
 <?php  
 $sql = "SELECT * FROM no_attendance WHERE fk_student_tdoc = '".$_SESSION["TIPO_DOC"]."' AND fk_student_user_id='".$_SESSION["ID_PERSONA"]."'";
 
 
 $query = $db->query($sql);
 echo "FALTASTE EL(los) DÍA(s) : ";?>
 <br>
 <br>
 <?php
while ($row=$query->fetch(PDO::FETCH_ASSOC))
{
?>
<input id="space" type="text" name="tdoc" value="<?php echo $row['fk_student_tdoc']; ?>" disabled>
<input id="space" type="text" name="tdoc" value="<?php echo $row['fk_student_user_id']; ?>" disabled>
<input id="space" type="text" name="tdoc" value="<?php echo $row['date']; ?>" disabled>
<input id="space" type="text" name="tdoc" value="<?php echo $row['fk_sub_has_course']; ?>" disabled><br>
<br>
<?php } ?> 
      </center>
	</div>
<?php		
endif; 
if ($_SESSION['role_index'] === 'att'):	
?>
<div id="new">
	<form action="" method="">
     <div id="text">
      <br><label>Mr.(Ms) Attendant Select One Student: </label><br><br>
        <select name="s" class="form-control">      
        <?php
              foreach ($db->query("SELECT * FROM student JOIN user ON pk_fk_tdoc_user = pk_fk_cod_doc AND pk_fk_user_id = id_user WHERE fk_attendat_cod_doc ='".$_SESSION["TIPO_DOC"]."' AND fk_attendant_id='".$_SESSION["ID_PERSONA"]."'") as $row1) { ?>
            <option value="<?php echo $row1['pk_fk_user_id']; ?>"> <?php echo $row1['first_name']." ".$row1['surname']; ?></option>
        <?php } ?>
      </select>
  
    <br><br><button id="boton">Buscar</button>
      <br><br>
  </form>
 
      
<?php
     if (isset($_GET['s'])){
$_SESSION['estu_id'] = $_GET['s'];
     }

$sql1= "SELECT * FROM student JOIN course ON cod_course = fk_cod_course JOIN subject_has_course ON cod_course = pk_fk_course_stu WHERE pk_fk_user_id LIKE '".@$_SESSION['estu_id']."' AND fk_attendat_cod_doc = '".$_SESSION['TIPO_DOC']."' AND fk_attendant_id ='".$_SESSION["ID_PERSONA"]."'";

$query = $db->query($sql1);
 if($query->rowCount()>0 or isset($_SESSION['b'])):
     $_SESSION['b']=1 ?>
		
<form action="" method="">
<br><label>Select The Subject For The NO Asistence Query:</label><br><br>
<select  name="sub" class=form-control>
<?php
		
	foreach ($db->query("SELECT * FROM student JOIN course ON cod_course = fk_cod_course JOIN subject_has_course ON cod_course = pk_fk_course_stu WHERE pk_fk_user_id LIKE '".$_SESSION['estu_id']."' AND fk_attendat_cod_doc = '".$_SESSION['TIPO_DOC']."' AND fk_attendant_id ='".$_SESSION["ID_PERSONA"]."'") as $row1) {?>
		
		<option value="<?php echo $row1['pk_fk_te_sub']; ?>"> <?php echo $row1['pk_fk_te_sub']?></option>
<?php

	}
		
?>
</select>
<br><button id="boton">Buscar</button><br><br>
</form>	



<?php
     $sub=@$_GET['sub'];
     if(isset($sub)) :?>
     <center>
 <br><br><h1>STUDENT</h1>
 <?php 
   
 $sql = "SELECT fk_student_tdoc, fk_student_user_id, DATE_FORMAT(date, '%Y - %b - %d, %H:%i') AS date FROM no_attendance JOIN student ON fk_student_tdoc = pk_fk_tdoc_user AND fk_student_user_id = pk_fk_user_id WHERE fk_attendat_cod_doc = '".$_SESSION["TIPO_DOC"]."' AND fk_attendant_id='".$_SESSION["ID_PERSONA"]."' AND fk_sub_has_course='$sub' AND fk_student_user_id='".$_SESSION['estu_id']."'";

 $query2 = $db->query($sql);

    if($query2->rowCount()>0){
      echo "FALTO EL(los) DÍA(s) : ";?>
      <br>
      <?php
     while ($row=$query2->fetch(PDO::FETCH_ASSOC))
     {
     ?>
     <input  id="space" type="text" name="tdoc" value="<?php echo $row['fk_student_tdoc']; ?>" disabled>
     <input id="space"  type="text" name="id" value="<?php echo $row['fk_student_user_id']; ?>" disabled>
     <input  id="space" type="text" name="date" value="<?php echo $row['date']; ?>" disabled><br>

     <?php 
     }
    }else{
     echo "El Estudiante Seleccionado NO Ha Fallado En Esta Asignatura";
    }
 endif;
 endif;		
		?> 
      </center>
     <br><br>
	</div>
<?php		

endif; ?>
   </div>
</body>

</html>
