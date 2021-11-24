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

			$update = new teacher();
			$update->actualizar($_POST['tdoc_t'],$_POST['tdoc_t2'],$_POST['id_user_t'],$_POST['id_user_t2'],$_POST['salary']);

			break;
		
		case 'registrar':

			$insert = new teacher();
			$insert ->registrar($_POST['tdoc_t'],$_POST['id_user_t'],$_POST['salary']);

			break;

		case 'eliminar':
				
			$eliminar = new teacher();
			$eliminar->eliminar($_GET['tdoc_t'], $_GET['id_user_t']);

			break;	

		case 'editar':
			
			$id_t = $_GET['id_user_t'];
            $tdoc_t = $_GET['tdoc_t'];
			break;	
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>TEACHER</title>
</head>
<body>

<br><a href="?action=ver&m=1">New Record</a><br>

	<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>

<div>
	
	<form action="#" method="post" enctype="multipart/form-data">
		<h2>NEW TEACHER</h2>
		<label>TYPE DOCUMENT:</label>
		<select class="form-control" name="tdoc_t">
        <?php
            foreach ($db->query("SELECT cod_document, Des_doc FROM type_of_document JOIN user ON cod_document = pk_fk_cod_doc JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'TEACHER'") as $row)
            {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        </select><br>
		<label>NUMBER OF IDENTIFY, REGISTERED:</label>
		<select class="form-control" name="id_user_t">
        <?php
            foreach ($db->query("SELECT id_user FROM user JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'TEACHER'") as $row)
            {
                echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
            }
        ?>
        </select><br>
		<label>SALARY:</label>
        <input name="salary" type="number"> 
		
        
		<input type="submit" value="Save" onclick="this.form.action ='?action=registrar';">

	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['tdoc_t']) && !empty($_GET['id_user_t']) && !empty($_GET['action']) ) { ?>

<div>
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM teacher WHERE user_pk_fk_cod_doc = '$tdoc_t' && user_id_user  = '$id_t'";
	$query = $db->query($sql);

	while ($r = $query->fetch(PDO::FETCH_ASSOC)) 
	{
	?>

    <h2>UPDATE INFO TEACHER</h2>
        <label>TYPE DOCUMENT:</label>
		<select class="form-control" name="tdoc_t">
        <?php
            foreach ($db->query("SELECT cod_document, Des_doc FROM type_of_document JOIN user ON cod_document = pk_fk_cod_doc JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'TEACHER'") as $row)
            {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        <input type="text" name="tdoc_t2" value="<?php echo $r['user_pk_fk_cod_doc']?>" style="display: none">
        </select><br>
		<label>NUMBER OF IDENTIFY:</label>
		<select class="form-control" name="id_user_t">
        <?php
            foreach ($db->query("SELECT id_user FROM user JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user WHERE pk_fk_role = 'TEACHER'") as $row)
            {
                echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
            }
        ?>
        </select><br>
        <input type="text" name="id_user_t2" value="<?php echo $r['user_id_user']?>" style="display: none">
     
        <input type="number" name="salary" value="<?php echo $r['SALARY']?>">


		<input type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">

	</form>	
</div>
<?php
	 	}
	} 

$sql = "SELECT * FROM teacher";
$query = $db ->query($sql);

if ($query->rowCount()>0): ?>
<div>
<h1>TEACHER</h1>
<table>
	<thead>
		<tr>
			<th>TEACHER T.DOC</th>
			<th>TEACHER N.IDENT</th>
			<th>ACTIONS</th>
		</tr>
	</thead>
	<tbody>
		<tr>
<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>


<?php echo "<td>".$row['user_pk_fk_cod_doc'] . "</td>";
    echo "<td>".$row['user_id_user'] . "</td>";

?>

<td><a href="?action=editar&tdoc_t=<?php echo $row['user_pk_fk_cod_doc'];?>&id_user_t=<?php echo $row['user_id_user'];?>">Update</a>
<a href="?action=eliminar&tdoc_t=<?php echo $row['user_pk_fk_cod_doc'];?>&id_user_t=<?php echo $row['user_id_user'];?>" onclick="return confirm('¿Esta seguro de eliminar este usuario?')">Delete</a></td>


<?php endwhile; ?>
		</tr>
	</tbody>
	</table>
</div>
<?php else: ?>
	<h4>Mr.User DO NOT find registration</h4>
<?php endif; ?>	

</body>
</html>

