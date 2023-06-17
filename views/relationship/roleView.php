<?php
	require_once "cruds.php";
	require_once "../Database/conexion.php";
	include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new Role();
			$update->updateRole($_POST['relation'], $_POST['queryy'], $_POST['state']);
		} elseif ($action == 'register') {
			$insert = new Role();
			$insert ->registrar($_POST['relation'], $_POST['state']);
		} elseif ($action == 'delete') {
			$eliminar = new Role();
			$eliminar->addRole($_GET['desc_relat']);
		} elseif ($action == 'edit') {
			$id = $_GET['desc_relat'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Role</title>
	<link rel="stylesheet" type="text/css" href="../style/style_role.css" />
	<link rel="stylesheet" href="../indexs/style/cruds_style.css" />
</head>
<body>
	<a href="?action=ver&m=1">New Record</a>
	<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
	<div id="new">
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Role</h2>
			<label>Type of Role:</label>
			<input id="space" type="text" name="relation" placeholder="ROLE" required style="text-transform:uppercase" />

			<label>State:</label>
			Active <input type="radio" name="state" value="1" checked />
			Inactive <input type="radio" name="state" value="0" checked />
					
			<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=register';" />
		</form>
	</div>
	<?php } ?>

	<?php if (!empty($_GET['desc_relat']) && !empty($_GET['action'])) { ?>
	<div id="update">
		<form action="#" method="post" enctype="multipart/form-data">
			<?php
				$sql = "
					SELECT * FROM role
					WHERE desc_role = '$id'
				";
				$query = $db->query($sql);
				while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
			?>

    	<h2>Update Role</h2>
			<label>Type of Role:</label>
			<input id="Space" type="text" name="queryy" value="<?php echo $r['desc_role']?>" style="display: none" />
			<input id="Space" type="text" name="relation" value="<?php echo $r['desc_role']?>" required />
	
			<label>State:</label>
			Active <input type="radio" name="state" value="1" <?php echo $r['state'] === '1' ? 'checked' : '' ?> />
			Inactive<input type="radio" name="state" value="0" <?php echo $r['state'] === '0' ? 'checked' : '' ?> />

			<input id="boton" type="submit" value="Update" onclick="this.form.action = '?action=update';" />
		</form>
	</div>
	<?php
		 	}
		}

	$sql = "SELECT * FROM role";
	$query = $db ->query($sql);

	if ($query->rowCount()>0): ?>

	<div>
		<header>Roles</header>
		<div>
			<table>
				<caption>Role's Results</caption>
				<thead>
					<tr>
						<th>Role</th>
						<th>State</th>
						<th>Actions</th>
					</tr>
				</thead>
				<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
				<tr>
					<?php echo "<td>".$row['desc_role'] . "</td>";
						if ($row['state'] == 1) {
							echo "<td>"."Active" . "</td>";
						} else {
							echo "<td>"."Inactive" . "</td>";
						}
					?>
					<td>
						<a href="?action=edit&desc_relat=<?php echo $row['desc_role'];?>" />
							Update
						</a>
						<a href="?action=delete&desc_relat=<?php echo $row['desc_role'];?>"
								onclick="return confirm('¿Esta seguro de eliminar este usuario?')">
							Delete
						</a>
					</td>
					<?php endwhile; ?>
				</tr>
			</table>
		</div>
	</div>
	<?php else: ?>
		<h4>Mr.User DO NOT find registration</h4>
	<?php endif; ?>
</body>
</html>
