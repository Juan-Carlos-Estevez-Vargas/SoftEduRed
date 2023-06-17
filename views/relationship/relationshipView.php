<?php
	require_once "../persistence/relationship/Relationship.php";
	require_once "../Database/conexion.php";
	include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'register') {
			$registrar = new Relationship();
			$registrar->registerRelationship($_POST['relation'], $_POST['state']);
		} elseif ($action == 'update') {
			$update = new Relationship();
			$update->updateRecord($_POST['relation'], $_POST['queryy'], $_POST['state']);
		} elseif ($action == 'delete') {
			$eliminar = new Relationship();
				$eliminar->deleteRelationship($_GET['desc_relat']);
		} elseif ($action == 'edit') {
			$id = $_GET['desc_relat'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Relationship</title>
	<link rel="stylesheet" type="text/css" href="../style/style_relationship.css">
	<link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
	<a href="?action=ver&m=1">New Record</a>
	<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
	<div id="new">
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Relationship</h2>
			<label>Type of RelationShip:</label>
			<input id="space" type="text" name="relation" placeholder="Type RelationShip" required style="text-transform:uppercase" />

			<label>State:</label>
			Active <input type="radio" name="state" value="1" checked />
			Inactive <input type="radio" name="state" value="0" checked />

			<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=registrar';">
		</form>
	</div>
	<?php } ?>

	<?php if (!empty($_GET['desc_relat']) && !empty($_GET['action'])) { ?>
	<div id="update">
		<form action="#" method="post" enctype="multipart/form-data">
			<?php $sql = "SELECT * FROM relationship WHERE desc_relationship = '$id'";
				$query = $db->query($sql);
				while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
			?>
			<h2>Update Relationship</h2>

			<label>Type of RelationShip:</label>
			<input id="Space" type="text" name="queryy" value="<?php echo $r['desc_relationship']?>" style="display: none" />
			<input id="Space" type="text" name="relation" value="<?php echo $r['desc_relationship']?>" required />
			
			<label>State:</label>
			Active <input type="radio" name="state" value="1" <?php echo $r['state'] === '1' ? 'checked' : '' ?> />
			Inactive <input type="radio" name="state" value="0" <?php echo $r['state'] === '0' ? 'checked' : '' ?> />

			<input id="boton" type="submit" value="Update" onclick="this.form.action = '?action=update';" />
		</form>
	</div>
	<?php
		}
	}

	$sql = "SELECT * FROM relationship";
	$query = $db ->query($sql);

	if ($query->rowCount()>0): ?>
	<div>
		<header>Relationship</header>
		<table>
			<caption>Relationship Information Results</caption>
			<thead>
				<tr>
					<th>Relationship</th>
					<th>State</th>
					<th>Actions</th>
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
					<td>
						<a href="?action=edit&desc_relat=<?php echo $row['desc_relationship'];?>" />
							Update
						</a>
						<a href="?action=delete&desc_relat=<?php echo $row['desc_relationship'];?>"
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

