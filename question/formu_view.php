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

			$update = new security_question();
			$update->actualizar($_POST['question'],$_POST['state']);

			break;
		
		case 'registrar':

			$insert = new security_question();
			$insert ->registrar($_POST['question'],$_POST['state']);

			break;

		case 'eliminar':
				
			$eliminar = new security_question();
			$eliminar->eliminar($_GET['question']);

			break;	

		case 'editar':
			
			$id = $_GET['question'];

			break;	
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>QUESTION</title>
	<link rel="stylesheet" href="../style/question.css">
	<link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
<center>
<br><br>
<br><a href="?action=ver&m=1">New Record</a><br>
<br><br>
	<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>

<div id="new">
	
	<form action="#" method="post" enctype="multipart/form-data">
		<br><h2>NEW QUESTION</h2>
		<label>Question:</label>
		<input id="space" type="text" name="question" placeholder="QUESTION" required style="text-transform:uppercase"><br>
		<label>STATE:</label>
		Active <input type="radio" name="state" value="1" checked>
		Inactive <input type="radio" name="state" value="0" checked><br>
        <br>
		<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=registrar';">

	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['question']) && !empty($_GET['action']) ) { ?>

<div id="update">
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM security_question WHERE question = '$id'"; 

	$query = $db->query($sql);

	while ($r = $query->fetch(PDO::FETCH_ASSOC)) 
	{
	?>

    <br><h2>UPDATE QUESTION</h2>
	<label>QUESTION:</label>
	<input id="space" type="text" name="question" value="<?php echo $r['question']?>" required style="text-transform:uppercase" size="40" readonly>
	<br>
		<label>State:</label>
		Active<input type="radio" name="state" value="1" <?php echo $r['state'] === '1' ? 'checked' : '' ?> >
		Inactive<input type="radio" name="state" value="0" <?php echo $r['state'] === '0' ? 'checked' : '' ?> >
		<br><br><input id="boton" type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">

	</form>	
</div>
<?php
	 	}
	} 

$sql = "SELECT * FROM security_question";
$query = $db ->query($sql);

if ($query->rowCount()>0): ?>
	
<div><br><br>
<header>QUESTION OF SECURITY</header>
<table>
	<thead>
		<tr>
			<th>QUESTION</th>
			<th>STATE</th>
			<th>ACTIONS</th>
		</tr>
	</thead>
	<tbody>
<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
<tr>

<?php echo "<td>".$row['question'] . "</td>"; 

	if ($row['state'] == 1) {
		echo "<td>"."Active" . "</td>";
	}else {
		echo "<td>"."Inactive" . "</td>";
	}
?>

<td><a href="?action=editar&question=<?php echo $row['question'];?>">Update</a>
<a href="?action=eliminar&question=<?php echo $row['question'];?>" onclick="return confirm('¿Esta seguro de eliminar este usuario?')">Delete</a></td>
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

