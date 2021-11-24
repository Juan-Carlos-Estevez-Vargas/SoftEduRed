<?php

require_once "cruds.php";
require_once "../Database/conexion.php";
include "../indexs/cruds.php";
$db = database::conectar();

if (isset($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		case 'actualizar':
			$update = new attendant();
			$update->actualizar($_POST['tdoc'],$_POST['tdoc2'],$_POST['id_user'],$_POST['id_user2'],$_POST['relation'],$_POST['relation2']);
			break;
		case 'registrar':
			$insert = new attendant();
			$insert ->registrar($_POST['tdoc'],$_POST['id_user'],$_POST['relation']);
			break;
		case 'eliminar':
			$eliminar = new attendant();
			$eliminar->eliminar($_GET['tdoc'], $_GET['id_user'],$_GET['relation']);
			break;	
		case 'editar':		
			$id = $_GET['id_user'];
            $tdoc = $_GET['tdoc'];
            $relation = $_GET['relation'];
			break;	
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ATTENDANT</title>
</head>
<body>

<br><a href="?action=ver&m=1">New Record</a><br>
	<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>
<div>
	<form action="#" method="post" enctype="multipart/form-data">
		<h2>NEW RELATIONSHIP</h2>
		<label>TYPE DOCUMENT:</label>
		<select class="form-control" name="tdoc">
        <?php
            // Mostrando el tipo de documento
            foreach ($db->query('SELECT * FROM type_of_document') as $row) {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        </select><br>
        <h2>NEW RELATIONSHIP</h2>
		<label>NUMBER OF IDENTIFY:</label>
		<select class="form-control" name="id_user">
        <?php
            // Mostrando el usuario
            foreach ($db->query('SELECT * FROM user') as $row) {
                echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
            }
        ?>
        </select><br>
        <h2>NEW RELATIONSHIP</h2>
		<label>RELATION WITH STUDENT:</label>
		<select class="form-control" name="relation">
        <?php
            // Mostrando la relacion 
            foreach ($db->query('SELECT * FROM relationship') as $row) {
                echo '<option value="'.$row['desc_relationship'].'">'.$row["desc_relationship"].'</option>';
            }
        ?>
        </select>   
        <br>
		<input type="submit" value="Save" onclick="this.form.action ='?action=registrar';">
	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['tdoc']) && !empty($_GET['id_user']) && !empty($_GET['action']) ) { ?>
<div>
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM attendant WHERE user_id_user  = '$id' && user_pk_fk_cod_doc = '$tdoc' && fk_relationship = '$relation'"; 
	$query = $db->query($sql);
	while ($r = $query->fetch(PDO::FETCH_ASSOC)) {?>
    <h2>UPDATE attendant</h2>
        <label>TYPE DOCUMENT:</label>
		<select class="form-control" name="tdoc_t">
        <?php
            foreach ($db->query('SELECT * FROM type_of_document') as $row) {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        <input type="text" name="tdoc_t2" value="<?php echo $r['user_pk_fk_cod_doc']?>" style="display: none">
        </select><br>
        <h2>NEW RELATIONSHIP</h2>
		<label>NUMBER OF IDENTIFY:</label>
		<select class="form-control" name="id_user_t">
        <?php
            foreach ($db->query('SELECT * FROM user') as $row) {
                echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
            }
        ?>
        </select><br>
        <input type="text" name="id_user_t2" value="<?php echo $r['user_id_user']?>" style="display: none">
        <h2>NEW RELATIONSHIP</h2>
		<label>RELATION WITH STUDENT:</label>
		<select class="form-control" name="relation">
        <?php
            foreach ($db->query('SELECT * FROM relationship') as $row) {
                echo '<option value="'.$row['desc_relationship'].'">'.$row["desc_relationship"].'</option>';
            }
        ?>
        </select>
        <input type="text" name="relation2" value="<?php echo $r['fk_relationship']?>" style="display: none">
		<input type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">
	</form>	
</div>
<?php
	 	}
	} 

$sql = "SELECT * FROM attendant";
$query = $db ->query($sql);

if ($query->rowCount()>0): ?>
<table>
<thead>
    <tr>
        <th>Type of Document</th>
        <th>NO� Identification</th>
        <th>Relation</th>
        <th>Update</th>
        <th>Delete</th>
    </tr>
</thead>
<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>

<div>
<?php echo "<td>".$row['user_pk_fk_cod_doc'] . "</td>";
    echo"<td>". $row['user_id_user'] . "</td>";
    echo"<td>". $row['fk_relationship'] . "</td>"; 
?>

<td><a href="?action=editar&tdoc=<?php echo $row['user_pk_fk_cod_doc'];?>&id_user=<?php echo $row['user_id_user'];?>&relation=<?php echo $row['fk_relationship'];?>">Update</a></td>
<td><a href="?action=eliminar&tdoc=<?php echo $row['user_pk_fk_cod_doc'];?>&id_user=<?php echo $row['user_id_user'];?>&relation=<?php echo $row['fk_relationship'];?>" onclick="return confirm('�Esta seguro de eliminar este usuario?')">Delete</a></td>
</table>
</div>
<?php endwhile; ?>
<?php else: ?>
	<h4>Mr.User DO NOT find registration</h4>
<?php endif; ?>	
</body>
</html>