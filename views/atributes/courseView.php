<?php
	require_once "../persistence/atributes/Course.php";
	require_once "../Database/conexion.php";
	include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new Course();
			$update->updateCourseRecord($_POST['course'], $_POST['queryy'], $_POST['state']);
		} elseif ($action == 'register') {
			$insert = new Course();
			$insert ->registerCourse($_POST['course'], $_POST['state']);
		} elseif ($action == 'delete') {
			$eliminar = new Course();
			$eliminar->deleteCourse($_GET['id_course']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_course'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Course</title>
	<link rel="stylesheet" type="text/css" href="../style/style_course.css">
</head>
<body>
	<a href="?action=ver&m=1">New Record</a>
	<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
	<div id="new">
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Course</h2>
			<label>Course:</label>
			<input id="space" type="text" name="course" placeholder="COURSE:" required style="text-transform:uppercase" />

			<label>State:</label>
			Active <input type="radio" name="state" value="1" checked />
			Inactive <input type="radio" name="state" value="0" checked />

			<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=register';" />
		</form>
	</div>
<?php } ?>

<?php if (!empty($_GET['id_course']) && !empty($_GET['action']) ) { ?>

<div id="update">
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM course WHERE cod_course = '$id'";
	$query = $db->query($sql);
	while ($r = $query->fetch(PDO::FETCH_ASSOC)) {?>
    <h2>Update Relationship</h2>
		<label>Type of RelationShip:</label>
		<input id="Space" type="text" name="queryy" value="<?php echo $r['cod_course']?>" style="display: none" />
		<input id="Space" type="text" name="course" value="<?php echo $r['cod_course']?>" required />
		
		<label>State:</label>
		Active <input type="radio" name="state" value="1" <?php echo $r['state'] === '1' ? 'checked' : '' ?> />
		Inactive<input type="radio" name="state" value="0" <?php echo $r['state'] === '0' ? 'checked' : '' ?> />
		
		<input id="boton" type="submit" value="Update" onclick="this.form.action = '?action=update';" />
	</form>
</div>
<?php
	 	}
	}

$sql = "SELECT * FROM course";
$query = $db ->query($sql);
if ($query->rowCount()>0): ?>

<div>
	<header>Course</header>
	<div>
		<table>
		<caption>Attendant Role Information Results</caption>
			<thead>
				<tr>
					<th>Course</th>
					<th>State</th>
					<th>Actions</th>
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
					<td>
						<a href="?action=edit&id_course=<?php echo $row['cod_course'];?>">
							Update
						</a>
						<a href="?action=delete&id_course=<?php echo $row['cod_course'];?>"
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
</div>
</body>
</html>

