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

			$update = new type_of_document();
			$update->actualizar($_POST['doc'],$_POST['queryy'],$_POST['desc_doc']);

			break;
		
		case 'registrar':

			$insert = new type_of_document();
			$insert ->registrar($_POST['doc'],$_POST['desc_doc']);

			break;

		case 'eliminar':
				
			$eliminar = new type_of_document();
			$eliminar->eliminar($_GET['id_doc']);

			break;	

		case 'editar':
			
			$id = $_GET['id_doc'];

			break;	
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>TYPE OF DOCUMENT</title>
	<link rel="stylesheet" type="text/css" href="../style/style_tables.css">
	<link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
	<center>

<br>
<br><br><a href="?action=ver&m=1">New Record</a><br><br>

	<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>

<div id="new">
	
	<form action="#" method="post" enctype="multipart/form-data">
		<br><h2>NEW DOCUMENT<br><br>
		<label>DOCUMENT:</label><input id="space" type="text" name="doc" placeholder="Ej: C.C" required style="text-transform:uppercase"><br>
		
		<label>TYPE DOCUMENT</label><input id="spacen" type="text" name="desc_doc" placeholder="Ej:Cedula de Ciudadania" style="text-transform:uppercase" required><br></h2>
		<br>
		<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=registrar'">

	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['id_doc']) && !empty($_GET['action']) ) { ?>

<div id="update">
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM type_of_document WHERE cod_document = '$id'"; 

	$query = $db->query($sql);

	while ($r = $query->fetch(PDO::FETCH_ASSOC)) 
	{
	?>
   	<br><h2>UPDATE DOCUMENT<br><br>
			
	<label>Type Document:</label><input id="Space" type="text" name="queryy" value="<?php echo $r['cod_document']?>" required><br>
	<br>
	<label>Desc Document:</label><input id="Space" type="text" name="desc_doc" value="<?php echo $r['Des_doc']?>" required style="text-transform:uppercase"><br>
	<br></h2>

	<input id="boton" type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">

	</form>	
	<br>


</div>
<?php
	 	}
	} 

$sql = "SELECT * FROM type_of_document";
$query = $db ->query($sql);

if ($query->rowCount()>0): ?>

<div><br><br><br><br>
<header>DOCUMENT</header>
<table>
<thead>
	<tr>
		<h3><th>CODE</th></h3>
		<th>TYPE DOCUMENT</th>
		<th>ACTIONS</th>
	</tr>
</thead>
	<tbody>
	
<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
	<tr>
<?php 
echo "<td>".$row['cod_document']."</td>"; 
echo "<td>".$row['Des_doc']."</td>";

?>

<td><a href="?action=editar&id_doc=<?php echo $row['cod_document'];?>">Update</a>
<a href="?action=eliminar&id_doc=<?php echo $row['cod_document'];?>" onclick="return confirm('¿Esta seguro de eliminar este usuario?')">Delete</a></td>
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

