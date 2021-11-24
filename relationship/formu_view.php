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

			$update = new relationship();
			$update->actualizar($_POST['relation'],$_POST['queryy'],$_POST['state']);

			break;
		
		case 'registrar':

			$insert = new relationship();
			$insert ->registrar($_POST['relation'],$_POST['state']);

			break;

		case 'eliminar':
				
			$eliminar = new relationship();
			$eliminar->eliminar($_GET['desc_relat']);

			break;	

		case 'editar':
			
			$id = $_GET['desc_relat'];

			break;	
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>RELATIONSHIP</title>
	<link rel="stylesheet" type="text/css" href="../style/style_relationship.css">
	<link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
	<center>

<br>
	

<br><br><a href="?action=ver&m=1">New Record</a><br>

	<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>

<div id="new">

	<form action="#" method="post" enctype="multipart/form-data">
		<h2>NEW RELATIONSHIP</h2>
		<label>Type RelationShip:</label><input id="space" type="text" name="relation" placeholder="Type RelationShip" required style="text-transform:uppercase"><br>

        <label>State:</label>
		Active <input type="radio" name="state" value="1" checked>
		Inactive <input type="radio" name="state" value="0" checked><br>

		<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=registrar';">

	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['desc_relat']) && !empty($_GET['action']) ) { ?>

<div id="update">
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM relationship WHERE desc_relationship = '$id'"; 

	$query = $db->query($sql);

	while ($r = $query->fetch(PDO::FETCH_ASSOC)) 
	{
	?>

    <br><h2>UPDATE RELATIONSHIP</h2><br><br>
	<label>Type RelationShip:</label>
	<input id="Space" type="text" name="queryy" value="<?php echo $r['desc_relationship']?>" style="display: none"><br>
	<input id="Space" type="text" name="relation" value="<?php echo $r['desc_relationship']?>" required>
	<label>State:</label>

		<br> Active<input type="radio" name="state" value="1" <?php echo $r['state'] === '1' ? 'checked' : '' ?> >
		Inactive<input type="radio" name="state" value="0" <?php echo $r['state'] === '0' ? 'checked' : '' ?> >

		<input id="boton" type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">

	</form>	
	<br>
</div>
<?php
	 	}
	} 

$sql = "SELECT * FROM relationship";
$query = $db ->query($sql);

if ($query->rowCount()>0): ?>

<div><br>
<header>RELATIONSHIP</header>
<table>
	<thead>
		<tr>
			<th>RELATIONSHIP</th>
			<th>STATE</th>
			<th>ACTIONS</th>
		</tr>
	</thead>
	<tbody>
		
<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
<tr>
<?php echo "<td>".$row['desc_relationship'] . "</td>"; 

	if ($row['state'] == 1) {
		echo "<td>"."Active" . "</td>";
	}else {
		echo "<td>"."Inactive" . "</td>";
	}
?>

<td><a href="?action=editar&desc_relat=<?php echo $row['desc_relationship'];?>">Update</a>
<a href="?action=eliminar&desc_relat=<?php echo $row['desc_relationship'];?>" onclick="return confirm('¿Esta seguro de eliminar este usuario?')">Delete</a></td>
		</tr>

<?php endwhile; ?>
	</tbody>
	</table>
</div>
<?php else: ?>
	<h4>Mr.User DO NOT find registration</h4>
<?php endif; ?>	
</center>
</body>
</html>

