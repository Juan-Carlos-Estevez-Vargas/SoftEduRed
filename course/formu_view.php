<?php
	require_once "cruds.php";
	require_once "../Database/conexion.php";
	include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		switch ($_REQUEST['action']) {
			case 'actualizar':
				$update = new course();
				$update->actualizar($_POST['course'],$_POST['queryy'],$_POST['state']);
				break;
			case 'registrar':
				$insert = new course();
				$insert ->registrar($_POST['course'],$_POST['state']);
				break;
			case 'eliminar':
				$eliminar = new course();
				$eliminar->eliminar($_GET['id_course']);
				break;	
			case 'editar':
				$id = $_GET['id_course'];
				break;	
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>COURSE</title>
	<link rel="stylesheet" type="text/css" href="../style/style_course.css">
</head>
<body>
	<center>
<br>
<br><br><a href="?action=ver&m=1">New Record</a><br><br>
	<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>
<div id="new">
	<form action="#" method="post" enctype="multipart/form-data">
		<br><h2>NEW COURSE</h2><br>
		<label>COURSE:</label>
		<input id="space" type="text" name="course" placeholder="COURSE:" required style="text-transform:uppercase"><br>
        <label>State:</label>
		Active <input type="radio" name="state" value="1" checked>
		Inactive <input type="radio" name="state" value="0" checked><br>
		<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=registrar';">
	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['id_course']) && !empty($_GET['action']) ) { ?>

<div id="update">
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM course WHERE cod_course = '$id'"; 
	$query = $db->query($sql);
	while ($r = $query->fetch(PDO::FETCH_ASSOC)) {?>
    <h2>UPDATE RELATIONSHIP</h2>
	<label>Type RelationShip:</label>
	<input id="Space" type="text" name="queryy" value="<?php echo $r['cod_course']?>" style="display: none">
	<input id="Space" type="text" name="course" value="<?php echo $r['cod_course']?>" required>
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

$sql = "SELECT * FROM course";
$query = $db ->query($sql);
if ($query->rowCount()>0): ?>

<div><br><br><br><br>
<header>COURSE</header>
<div>
<table>
	<thead>
		<tr>
			<th>COURSE</th>
			<th>STATE</th>
			<th>ACTIONS</th>
		</tr>
	</thead>
	<tbody>
<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
<tr>
<?php echo "<td>".$row['cod_course'] . "</td>"; 
	if ($row['state'] == 1) {
		echo "<td>"."Active" . "</td>";
	}else {
		echo "<td>"."Inactive" . "</td>";
	}
?>

<td><a href="?action=editar&id_course=<?php echo $row['cod_course'];?>">Update</a>
<a href="?action=eliminar&id_course=<?php echo $row['cod_course'];?>" onclick="return confirm('¿Esta seguro de eliminar este usuario?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
<?php else: ?>
	<h4>Mr.User DO NOT find registration</h4>
<?php endif; ?>	
</ceter>
</body>
</html>

