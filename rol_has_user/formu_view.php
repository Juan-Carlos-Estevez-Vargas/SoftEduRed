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

			$update = new rol_user();
			$update->actualizar($_POST['tdoc_r'],$_POST['tdoc_r2'],$_POST['id_user_r'],$_POST['id_user_r2'],$_POST['role'],$_POST['role2'],$_POST['state']);

			break;
		
		case 'registrar':

			$insert = new rol_user();
			$insert ->registrar($_POST['tdoc_r'],$_POST['id_user_r']);

			break;

		case 'eliminar':
				
			$eliminar = new rol_user();
			$eliminar->eliminar($_GET['tdoc_r'], $_GET['id_user_r'],$_GET['role']);

			break;	

		case 'editar':
			
			$id_r = $_GET['id_user_r'];
            $tdoc_r = $_GET['tdoc_r'];
            $role = $_GET['role'];
			break;	
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ROLE OF USER</title>
	<link rel="stylesheet" href="../style/style_rol_user.css">
	<link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
<br><br>
<br><a href="?action=ver&m=1">New Record</a><br>
<br><br>
	<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>

<div id="new">
		<form action="#" method="post" enctype="multipart/form-data">
			<br><h2>NEW ROLE FOR USER</h2>
			<label>TYPE DOCUMENT:</label>
			<select class="form-control" name="tdoc_r">
	        <?php
	            foreach ($db->query('SELECT * FROM type_of_document') as $row)
	            {
	                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
	            }
	        ?>
	        </select><br>
			<label>NUMBER OF IDENTIFY, REGISTERED:</label>
			<select class="form-control" name="id_user_r">
	        <?php
	            foreach ($db->query('SELECT * FROM user') as $row)
	            {
	                echo '<option value="'.$row['id_user'].'">'.$row["id_user"]."-".$row["first_name"]."-".$row["surname"].'</option>';
	            }
	        ?>
	        </select><br>
			<label>TYPE ROLE:</label>
	        <?php
	            foreach ($db->query('SELECT * FROM role where state= 1') as $row)
	            { ?>
	                <br><input type="checkbox" name="<?php echo $row['desc_role']?>">
	        		<?php echo $row['desc_role'];?>
					<input type="radio" name="state_<?php echo $row['desc_role']?>" value="1" checked>Active
					<input type="radio" name="state_<?php echo $row['desc_role']?>" value="0" checked>Inactive
	        <?php } ?>
			<br>
			<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=registrar';">
		
	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['tdoc_r']) && !empty($_GET['id_user_r']) && !empty($_GET['role']) && !empty($_GET['action']) ) { ?>

<div id="update">
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM user_has_role WHERE tdoc_role = '$tdoc_r' && pk_fk_id_user  = '$id_r' && pk_fk_role = '$role'";
	$query = $db->query($sql);

	while ($r = $query->fetch(PDO::FETCH_ASSOC)) 
	{
	?>

    <br><h2>UPDATE ROLE OF USER</h2>
        <label>TYPE DOCUMENT:</label>
		<select class="form-control" name="tdoc_r">
        <?php
            foreach ($db->query('SELECT * FROM type_of_document') as $row)
            {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        <input type="text" name="tdoc_r2" value="<?php echo $r['tdoc_role']?>" style="display: none">
        </select><br>
		<label>NUMBER OF IDENTIFY:</label>
		<select class="form-control" name="id_user_r">
        <?php
            foreach ($db->query('SELECT * FROM user') as $row)
            {
                echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
            }
        ?>
        </select><br>
        <input type="text" name="id_user_r2" value="<?php echo $r['pk_fk_id_user']?>" style="display: none">
		<label>ROLE:</label>
		<select class="form-control" name="role">
        <?php
            foreach ($db->query('SELECT * FROM role WHERE state=1') as $row)
            {
                echo '<option value="'.$row['desc_role'].'">'.$row["desc_role"].'</option>';
            }
        ?>
        </select>
        <input type="text" name="role2" value="<?php echo $r['pk_fk_role']?>" style="display: none">
     	<br>
		<label>State:</label>
        Active<input type="radio" name="state" value="1" <?php echo $r['state'] === '1' ? 'checked' : '' ?> >
		Inactive<input type="radio" name="state" value="0" <?php echo $r['state'] === '0' ? 'checked' : '' ?> >
		<br><br>
		<input id="boton" type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">

	</form>	
</div>
<?php
	 	}
	} 

$sql = "SELECT * FROM user_has_role WHERE state=1 ORDER BY tdoc_role, pk_fk_id_user ASC";
$query = $db ->query($sql);

if ($query->rowCount()>0): ?>

<h1>ROLE OF USER</h1>

<div>
	<table>
		<thead>
		<tr>
			<th>T.DOCUMENT</th>
			<th>N° IDENTIFY</th>
			<th>ROLE</th>
			<th>STATE</th>
			<th>ACTIONS</th>
		</tr>
		</thead>
		<tbody>
<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>

			<tr>
<?php echo "<td>".$row['tdoc_role'] . "</td>";
	
    echo "<td>".$row['pk_fk_id_user'] . "</td>";
	
    echo "<td>".$row['pk_fk_role'] . "</td>"; 
	
	if ($row['state'] == 1) {
		echo "<td>"."Active" . "</td>";
	}else {
		echo "<td>"."Inactive" . "</td>";
	}

?>

<td><a href="?action=editar&tdoc_r=<?php echo $row['tdoc_role'];?>&id_user_r=<?php echo $row['pk_fk_id_user'];?>&role=<?php echo $row['pk_fk_role'];?>">Update</a>
<a href="?action=eliminar&tdoc_r=<?php echo $row['tdoc_role'];?>&id_user_r=<?php echo $row['pk_fk_id_user'];?>&role=<?php echo $row['pk_fk_role'];?>" onclick="return confirm('¿Esta seguro de eliminar este usuario?')">Delete</a></td>
			</tr>

<?php endwhile; ?>
		</tbody>
	</table>

</div>
<?php else: ?>
	<h4>Mr.User DO NOT find registration</h4>
<?php endif; ?>	

</body>
</html>

