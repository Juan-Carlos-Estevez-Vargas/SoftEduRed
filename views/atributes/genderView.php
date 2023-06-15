<?php
	require_once "../persistence/atributes/Gender.php";
	require_once "../Database/conexion.php";
	include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new gender();
			$update->actualizar($_POST['gender'],$_POST['queryy'],$_POST['state']);
		} elseif ($action == 'registrar') {
			$insert = new gender();
			$insert ->registrar($_POST['gender'],$_POST['state']);
		} elseif ($action == 'eliminar') {
			$eliminar = new gender();
			$eliminar->eliminar($_GET['id_gender']);
		} elseif ($action == 'editar') {
			$id = $_GET['id_gender'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Gender</title>
	<link rel="stylesheet" href="../style/gender.css">
	 <link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
	<a href="?action=ver&m=1">New Record</a>
	<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
	<div id="new">
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Gender</h2>
			<label>Gender:</label>
			<input id="space" type="text" name="gender" placeholder="GENDER:"	required style="text-transform:uppercase" />

			<label>State:</label>
			Active <input id="space" type="radio" name="state" value="1" checked />
			Inactive <input id="space" type="radio" name="state" value="0" checked />

			<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=register';"></h2>
		</form>
	</div>
	<?php } ?>

	<?php if (!empty($_GET['id_gender']) && !empty($_GET['action'])) { ?>
	<div>
		<form action="#" method="post" enctype="multipart/form-data">
			<?php $sql = "SELECT * FROM gender WHERE desc_gender = '$id'";
				$query = $db->query($sql);
				while ($r = $query->fetch(PDO::FETCH_ASSOC)) {?>
	    <h2>Update Relatinship</h2>
			<label>Type RelationShip:</label>
			<input type="text" name="queryy" value="<?php echo $r['desc_gender']?>" style="display: none" />
			<input type="text" name="gender" value="<?php echo $r['desc_gender']?>" required />
			
			<label>State:</label>
			Active <input type="radio" name="state" value="1" <?php echo $r['state'] === '1' ? 'checked' : '' ?> />
			Inactive <input type="radio" name="state" value="0" <?php echo $r['state'] === '0' ? 'checked' : '' ?> />
			
			<input type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">
		</form>
	</div>
	<?php
	 	}
	}

	$sql = "SELECT * FROM gender";
	$query = $db ->query($sql);
	if ($query->rowCount()>0): ?>
	<div>
		<header>Gender</header>
		<table>
			<caption>Attendant Role Information Results</caption>
			<thead>
				<tr>
					<th>Gender</th>
					<th>State</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
				<tr>
					<?php echo "<td>".$row['desc_gender'] . "</td>";
						if ($row['state'] == 1) {
							echo "<td>"."Active" . "</td>";
						} else {
							echo "<td>"."Inactive" . "</td>";
						}
					?>
					<td>
						<a href="?action=edit&id_gender=<?php echo $row['desc_gender'];?>">
							Update
						</a>
						<a href="?action=delete&id_gender=<?php echo $row['desc_gender'];?>"
								onclick="return confirm('¿Esta seguro de eliminar este usuario?')">
							Delete
						</a>
					</td>
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

		