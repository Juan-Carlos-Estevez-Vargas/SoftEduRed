<?php
	require_once "../persistence/atributes/Subject.php";
	require_once "../Database/conexion.php";
	include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new Subject();
			$update->actualizar($_POST['subject'], $_POST['state'], $_POST['tdoc_t'], $_POST['id_user_t'], $_POST['queryy']);
		} elseif ($action == 'register') {
			$insert = new Subject();
			$insert ->registrar($_POST['subject'], $_POST['state'], $_POST['tdoc_t'], $_POST['id_user_t']);
		} elseif ($action == 'delete') {
			$eliminar = new Subject();
			$eliminar->eliminar($_GET['id_subject']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_subject'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Subject</title>
 	<link rel="stylesheet" href="../style/subject.css">
 	<link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
	<a href="?action=ver&m=1">New Record</a>
	<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
	<div id="new">
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Subject</h2>
			<div id="text">
				<label>Matter/Subject:</label>
				<input id="space" type="text" name="subject" placeholder="Subject/Matter" required style="text-transform:uppercase" />

				<label>State:</label>
				Active <input type="radio" name="state" value="1" checked />
				Inactive <input type="radio" name="state" value="0" checked />

				<label>Document Teacher</label>
				<select class="form-control" name="tdoc_t">
				<?php
					foreach ($db->query("
						SELECT cod_document, Des_doc FROM type_of_document
						JOIN user ON cod_document = pk_fk_cod_doc
						JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user
						WHERE pk_fk_role = 'TEACHER'"
					) as $row) {
						echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
					}
				?>
				</select>

				<label>Number Identify Teacher</label>
				<select class="form-control" name="id_user_t">
				<?php
					foreach ($db->query("
						SELECT id_user FROM user
						JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user
						WHERE pk_fk_role = 'TEACHER'"
					) as $row) {
						echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
					}
				?>
				</select>

				<input id="reg" type="submit" value="Save" onclick="this.form.action ='?action=register';" />
			</div>
		</form>
	</div>
	<?php } ?>

	<?php if (!empty($_GET['id_subject']) && !empty($_GET['action'])) { ?>

	<div id="update">
		<form action="#" method="post" enctype="multipart/form-data">
		<?php $sql = "SELECT * FROM subject WHERE n_subject = '$id'";
			$query = $db->query($sql);
			while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
		?>
			<h2>Update Subject</h2>
			<div id="text">
				<label>Subject:</label>
				<input id="space" type="text" name="queryy" value="<?php echo $r['n_subject']?>" style="display: none" />
				<input id="space" type="text" name="subject" value="<?php echo $r['n_subject']?>" required />

				<label>State:</label>
				Active <input type="radio" name="state" value="1" <?php echo $r['state'] === '1' ? 'checked' : '' ?> />
				Inactive <input type="radio" name="state" value="0" <?php echo $r['state'] === '0' ? 'checked' : '' ?> />

				<label>Type of Document:</label>
				<select class="form-control" name="tdoc_t">
				<?php
					foreach ($db->query("
						SELECT cod_document, Des_doc FROM type_of_document
						JOIN user ON cod_document = pk_fk_cod_doc
						JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user
						WHERE pk_fk_role = 'TEACHER'"
					) as $row) {
						echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
					}
				?>
				</select>

				<label>Number of Identify:</label>
				<select class="form-control" name="id_user_t">
				<?php
					foreach ($db->query("
						SELECT id_user FROM user
						JOIN user_has_role ON tdoc_role = pk_fk_cod_doc and id_user = pk_fk_id_user
						WHERE pk_fk_role = 'TEACHER'"
					) as $row) {
						echo '<option value="'.$row['id_user'].'">'.$row["id_user"].'</option>';
					}
				?>
				</select>
			</div>
			<input id="reg" type="submit" value="Update" onclick="this.form.action = '?action=update';" />
		</form>
	</div>
	<?php
			}
		}

	$sql = "SELECT * FROM subject";
	$query = $db ->query($sql);

	if ($query->rowCount()>0): ?>
	<div>
		<header>Subject</header>
		<table>
			<caption>Subject Information Results</caption>
			<thead>
				<tr>
					<th>Subject</th>
					<th>State</th>
					<th>Teacher T.Doc</th>
					<th>Teacher N.Ident</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
				<tr>
				<?php echo "<td>".$row['n_subject'] . "</td>";
					if ($row['state'] == 1) {
						echo "<td>"."Active" . "</td>";
					}else {
						echo "<td>"."Inactive" . "</td>";
					}
					echo "<td>".$row['fk_tdoc_user_teacher'] . "</td>";
					echo "<td>".$row['fk_id_user_teacher'] . "</td>";
				?>
					<td>
						<a href="?action=edit&id_subject=<?php echo $row['n_subject'];?>">
							Update
						</a>
						<a href="?action=delete&id_subject=<?php echo $row['n_subject'];?>"
								onclick="return confirm('¿Esta seguro de eliminar este usuario?')">
							Delete
						</a>
					</td>
					<?php endwhile; ?>
				</tr>
			</tbody>
		</table>
	</div>
	<?php else: ?>
		<h4>Mr.User DO NOT find registration</h4>
	<?php endif; ?>
</body>
</html>
