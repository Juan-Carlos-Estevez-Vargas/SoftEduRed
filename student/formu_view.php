<?php

require_once "cruds.php";
require_once "../Database/conexion.php";
include "../indexs/cruds.php";
$db = database::conectar();

if (isset($_REQUEST['action'])) 
{
	switch ($_REQUEST['action']) 
	{
		case 'actualizar':

			$update = new student();
			$update->actualizar($_POST['tdoc_t'],$_POST['id_user_t'],$_POST['id_atte'],$_POST['tdoc_atte'],$_POST['s_course'],$_POST['tdoc_t2'], $_POST['id_user_t2'], $_POST['id_atte2'], $_POST['tdoc_atte2'], $_POST['stu_course2']);

			break;
		
		case 'registrar':

			$insert = new student();
			$insert ->registrar($_POST['tdoc'],$_POST['id_user'],$_POST['id_atte'],$_POST['tdoc_atte'],$_POST['stu_course']);

			break;

		case 'eliminar':
				
			$eliminar = new student();
			$eliminar->eliminar($_GET['tdoc_t'],$_GET['id_user_t'],$_GET['id_atte'],$_GET['tdoc_atte'],$_GET['stu_course']);

			break;	

		case 'editar':
			$tdoc_t = $_GET['tdoc_t'];
            $id_user_t = $_GET['id_user_t'];
            $id_atte = $_GET['id_atte'];
            $tdoc_atte = $_GET['tdoc_atte'];
            $stu_course = $_GET['stu_course'];
			break;	
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>STUDENT</title>
</head>
<body>

<br><a href="?action=ver&m=1">New Record</a><br>

	<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>

<div>
	
	<form action="#" method="post" enctype="multipart/form-data">
		<h2>STUDENT</h2>
		<label>TYPE DOCUMENT OF STUDENT:</label>
		<select class="form-control" name="tdoc">
        <?php
            foreach ($db->query("SELECT cod_document, Des_doc FROM type_of_document JOIN user ON cod_document = pk_fk_cod_doc JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'STUDENT'") as $row)
            {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        </select><br>
		<label>NUMBER OF IDENTIFY OF STUDENT:</label>
		<select class="form-control" name="id_user">
        <?php
            foreach ($db->query("SELECT id_user FROM user JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'STUDENT'") as $row)
            {
                echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
            }
        ?>
        </select><br>
		<label>TYPE DOCUMENT OF ATTENDANT:</label>
		<select class="form-control" name="tdoc_atte">
        <?php
            foreach ($db->query("SELECT cod_document, Des_doc FROM type_of_document JOIN user ON cod_document = pk_fk_cod_doc JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'ATTENDANT'") as $row)
            {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        </select><br>
		<label>NUMBER OF IDENTIFY OF ATTENDANT:</label>
		<select class="form-control" name="id_atte">
        <?php
            foreach ($db->query("SELECT id_user FROM user JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'ATTENDANT'") as $row)
            {
                echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
            }
        ?>
         </select><br>
         <label>COURSE OF STUDENT:</label>
		<select class="form-control" name="stu_course">
        <?php
            foreach ($db->query("SELECT * from course") as $row)
            {
                echo '<option value="'.$row['cod_course'].'">'.$row["cod_course"].'</option>';
            }
        ?>
         </select><br>
        
        <br>
        
		<input type="submit" value="Save" onclick="this.form.action ='?action=registrar';">

	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['tdoc_t']) && !empty($_GET['id_user_t']) && !empty($_GET['tdoc_atte']) && !empty($_GET['id_atte']) && !empty($_GET['stu_course']) && !empty($_GET['action']) ) { ?>

<div>

	<form action="#" method="post" enctype="multipart/form-data">
	<?php 
    
    $sql = "SELECT * FROM student WHERE pk_fk_user_id = '$id_user_t' && pk_fk_tdoc_user = '$tdoc_t' && fk_attendant_id = '$id_atte' && fk_attendat_cod_doc = '$tdoc_atte' && fk_cod_course = '$stu_course'"; 

	$query = $db->query($sql);

	while ($r = $query->fetch(PDO::FETCH_ASSOC)) 
	{
	?>

    <h2>UPDATE STUDENT INFO</h2>
        <label>TYPE DOCUMENT OF STUDENT:</label>
		<select class="form-control" name="tdoc_t">
        <?php
            foreach ($db->query("SELECT cod_document, Des_doc FROM type_of_document JOIN user ON cod_document = pk_fk_cod_doc JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'STUDENT'") as $row)
            {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        </select><br>
		<label>NUMBER OF IDENTIFY OF STUDENT:</label>
		<select class="form-control" name="id_user_t">
        <?php
            foreach ($db->query("SELECT id_user FROM user JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'STUDENT'") as $row)
            {
                echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
            }
        ?>
        </select><br>
		<label>TYPE DOCUMENT OF ATTENDANT:</label>
		<select class="form-control" name="tdoc_atte">
        <?php
            foreach ($db->query("SELECT cod_document, Des_doc FROM type_of_document JOIN user ON cod_document = pk_fk_cod_doc JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'ATTENDANT'") as $row)
            {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        </select><br>
		<label>NUMBER OF IDENTIFY OF ATTENDANT:</label>
		<select class="form-control" name="id_atte">
        <?php
            foreach ($db->query("SELECT id_user FROM user JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'ATTENDANT'") as $row)
            {
                echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
            }
        ?>
        </select><br>    
         <label>COURSE OF STUDENT:</label>
		<select class="form-control" name="s_course">
        <?php
            foreach ($db->query("SELECT * from course") as $row)
            {
                echo '<option value="'.$row['cod_course'].'">'.$row["cod_course"].'</option>';
            }
        ?>
        </select><br>    
        <input type="text" name="tdoc_t2" value="<?php echo $r['pk_fk_tdoc_user']?>" style="display: none">
        <input type="text" name="id_user_t2" value="<?php echo $r['pk_fk_user_id']?>" style="display: none">
        <input type="text" name="id_atte2" value="<?php echo $r['fk_attendant_id']?>" style="display: none">
        <input type="text" name="tdoc_atte2" value="<?php echo $r['fk_attendat_cod_doc']?>" style="display: none">
        <input type="text" name="stu_course2" value="<?php echo $r['fk_cod_course']?>" style="display: none">

		<input type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">

	</form>	
</div>
<?php
	 	}
	} 

$sql = "SELECT * FROM student";
$query = $db ->query($sql);

if ($query->rowCount()>0): ?>

<h1>STUDENT</h1>

<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>

<div>
<table>
	<thead>
		<tr>
			<th>STU T.DOC</th>
			<th>STU N.IDEN</th>
			<th>ATTE T.DOC</th>
			<th>ATTE N.IDEN</th>
			<th>COURSE</th>
			<th>ACTIONS</th>
		</tr>
	</thead>
	<tbody>
		<tr>

<?php
    echo "<td>".$row['pk_fk_tdoc_user'] . "</td>";
    echo "<td>".$row['pk_fk_user_id'] . "</td>";
    echo "<td>".$row['fk_attendat_cod_doc'] . "</td>";
    echo "<td>".$row['fk_attendant_id'] . "</td>"; 
    echo "<td>".$row['fk_cod_course'] . "</td>"; 


?>

<td><a href="?action=editar&tdoc_t=<?php echo $row['pk_fk_tdoc_user'];?>&id_user_t=<?php echo $row['pk_fk_user_id'];?>&id_atte=<?php echo $row['fk_attendant_id'];?>&tdoc_atte=<?php echo $row['fk_attendat_cod_doc'];?>&stu_course=<?php echo $row['fk_cod_course'];?>">Update</a>
 
<a href="?action=eliminar&tdoc_t=<?php echo $row['pk_fk_tdoc_user'];?>&id_user_t=<?php echo $row['pk_fk_user_id'];?>&id_atte=<?php echo $row['fk_attendant_id'];?>&tdoc_atte=<?php echo $row['fk_attendat_cod_doc'];?>&stu_course=<?php echo $row['fk_cod_course'];?>" onclick="return confirm('¿Esta seguro de eliminar este usuario?')">Delete</a></td>
		</tr>
	</tbody>
	</table>

</div>;
<?php endwhile; ?>

<?php else: ?>
	<h4>Mr.User DO NOT find registration</h4>
<?php endif; ?>	

</body>
</html>

