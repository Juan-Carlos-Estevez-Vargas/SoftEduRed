<?php
	require_once "../persistence/roles/Teacher.php";
	require_once "../persistence/database/Conexion.php";
	include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {

		$action = $_REQUEST['action'];
		
		if ($action == "update") {

			$update = new Teacher();
			$update->updateTeacherInfo(
				$_POST['tdoc_t'], $_POST['tdoc_t2'], $_POST['id_user_t'],
				$_POST['id_user_t2'], $_POST['salary']);

		} elseif ($action == "register") {

			$insert = new Teacher();
			$insert ->registerTeacher($_POST['tdoc_t'],$_POST['id_user_t'],$_POST['salary']);

		} elseif ($action == "delete") {

			$eliminar = new Teacher();
			$eliminar->deleteTeacher($_GET['tdoc_t'], $_GET['id_user_t']);

		} elseif ($action == "edit") {

			$id_t = $_GET['id_user_t'];
      $tdoc_t = $_GET['tdoc_t'];

		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Teacher</title>
</head>
<body>
	<a href="?action=ver&m=1">New Record</a><br>
	<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
	<div>
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Teacher</h2>
			<label>Type of Document:</label>
			<select class="form-control" name="tdoc_t">
			<?php
				foreach (
					$db->query("SELECT cod_document, Des_doc FROM type_of_document
											JOIN user ON cod_document = pk_fk_cod_doc
											JOIN user_has_role ON tdoc_role = pk_fk_cod_doc
											AND id_user = pk_fk_id_user
											WHERE pk_fk_role = 'TEACHER'")
					as $teacher
				)	{
					echo '<option value="'.$teacher['cod_document'].'">'.$teacher["Des_doc"].'</option>';
					}
			?>
			</select>

			<label>Number of Identify, Registered:</label>
			<select class="form-control" name="id_user_t">
      <?php
        foreach (
					$db->query("SELECT id_user FROM user
											JOIN user_has_role ON tdoc_role = pk_fk_cod_doc
											AND id_user = pk_fk_id_user
											WHERE pk_fk_role = 'TEACHER'")
					as $user
				) {
          echo '<option value="'.$user['id_user'].'">'.$user["id_user"].'</option>';
        }
       ?>
      </select>

			<label>SALARY:</label>
      <input name="salary" type="number" />
		
			<input type="submit" value="Save" onclick="this.form.action ='?action=register';" />
		</form>
	</div>
<?php } ?>

<?php if (!empty($_GET['tdoc_t']) && !empty($_GET['id_user_t']) && !empty($_GET['action'])) { ?>
	<div>
		<form action="#" method="post" enctype="multipart/form-data">
		<?php $sql = "SELECT * FROM teacher WHERE user_pk_fk_cod_doc = '$tdoc_t' && user_id_user  = '$id_t'";
			$query = $db->query($sql);

			while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
		?>
			<h2>Update Teacher Information</h2>
			<label>Type of Document:</label>
			<select class="form-control" name="tdoc_t">
			<?php
				foreach ($db->query("SELECT cod_document, Des_doc FROM type_of_document
														 JOIN user ON cod_document = pk_fk_cod_doc
														 JOIN user_has_role ON tdoc_role = pk_fk_cod_doc
														 AND id_user = pk_fk_id_user
														 WHERE pk_fk_role = 'TEACHER'")
					as $teacher
				) {
					echo '<option value="'.$teacher['cod_document'].'">'.$teacher["Des_doc"].'</option>';
				}
			?>

      <input type="text" name="tdoc_t2" value="<?php echo $r['user_pk_fk_cod_doc']?>" style="display: none" />
      </select>

			<label>Number of Identify:</label>
			<select class="form-control" name="id_user_t">
      <?php
        foreach ($db->query("SELECT id_user FROM user
														 JOIN user_has_role ON tdoc_role = pk_fk_cod_doc
														 AND id_user = pk_fk_id_user
														 WHERE pk_fk_role = 'TEACHER'")
					as $user
				) {
          echo '<option value="'.$user['id_user'].'">'.$user["id_user"].'</option>';
        }
      ?>
      </select>

			<input type="text" name="id_user_t2" value="<?php echo $r['user_id_user']?>" style="display: none" />
      <input type="number" name="salary" value="<?php echo $r['SALARY']?>" />
			<input type="submit" value="Update" onclick="this.form.action = '?action=update';" />
		</form>
	</div>
<?php
	 	}
	}

	$sql = "SELECT * FROM teacher";
	$query = $db ->query($sql);

	if ($query->rowCount()>0): ?>
	<div>
	<h1>Teacher</h1>
	<table>
		<caption>Teacher Information Results</caption>
		<thead>
			<tr>
				<th>Teacher T.Doc</th>
				<th>Teacher N.Ident</th>
				<th>Actions</th>
			</tr>
		</thead>
		<tbody>
			<tr>
			<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
			<?php echo "<td>".$row['user_pk_fk_cod_doc'] . "</td>";
				echo "<td>".$row['user_id_user'] . "</td>";
			?>
				<td>
					<a href="?action=edit&tdoc_t=<?php echo $row['user_pk_fk_cod_doc'];?>&id_user_t=<?php echo $row['user_id_user'];?>">
						Update
					</a>
					<a href="?action=delete&tdoc_t=<?php echo $row['user_pk_fk_cod_doc'];?>&id_user_t=<?php echo $row['user_id_user'];?>"
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

