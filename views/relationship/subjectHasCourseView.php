<?php
	require_once "../persistence/relationship/SubjectHasCourse.php";
	require_once "../Database/conexion.php";
	include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new SubjectCourse();
			$update->actualizar($_POST['subj'],$_POST['subj2'],$_POST['course'],$_POST['course2'],$_POST['state']);
		} elseif ($action == 'register') {
			$insert = new SubjectCourse();
			$insert ->registrar($_POST['course']);
		} elseif ($action == 'delete') {
			$eliminar = new SubjectCourse();
			$eliminar->eliminar($_GET['subj'], $_GET['course']);
		} elseif ($action == 'edit') {
			$subj = $_GET['subj'];
      $course = $_GET['course'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Subject for Course</title>
  <link rel="stylesheet" href="../style/style_subject_has_couse.css" />
  <link rel="stylesheet" href="../indexs/style/cruds_style.css" />
</head>
<body>
	<a href="?action=ver&m=1">New Record</a>

	<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
	<div id="new">
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Subject for Course</h2>
			<div id="text">
				<label>Course:</label>
				<select class="form-control" name="course">
				<?php
					foreach ($db->query('SELECT * FROM course WHERE state = 1') as $row) {
						echo '<option value="'.$row['cod_course'].'">'.$row["cod_course"].'</option>';
					}
				?>
				</select>

				<label>Subject:</label><br>
				<?php
				foreach ($db->query('SELECT * FROM subject where state= 1') as $row) { ?>
				<input type="checkbox" name="<?php echo $row['n_subject']?>" />
				<?php echo $row['n_subject'];?>
				<input type="radio" name="state_<?php echo $row['n_subject']?>" value="1" checked />Active
				<input type="radio" name="state_<?php echo $row['n_subject']?>" value="0" checked />Inactive
				<?php } ?>
			</div>
		
			<input id="reg" type="submit" value="Save" onclick="this.form.action ='?action=register';">
		</form>
	</div>
	<?php } ?>

	<?php if (!empty($_GET['subj']) && !empty($_GET['course']) && !empty($_GET['action'])) { ?>

	<div id="update">
		<form action="#" method="post" enctype="multipart/form-data">
			<?php $sql = "
				SELECT * FROM subject_has_course
				WHERE pk_fk_te_sub = '$subj' &&
							pk_fk_course_stu = '$course'
				";

				$query = $db->query($sql);
				while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
			?>
			<h2>Update Subject for Course</h2>
			<div id="text">
				<label>Subject:</label>
				<select class="form-control" name="subj">
				<?php
					foreach ($db->query('SELECT * FROM subject WHERE state = 1') as $row) {
						echo '<option value="'.$row['n_subject'].'">'.$row["n_subject"].'</option>';
					}
				?>
				</select>
				<input id="space" type="text" name="subj2" value="<?php echo $r['pk_fk_te_sub']?>" style="display: none" />

				<label>Course:</label>
				<select class="form-control" name="course">
				<?php
					foreach ($db->query('SELECT * FROM course WHERE state = 1') as $row) {
						echo '<option value="'.$row['cod_course'].'">'.$row["cod_course"].'</option>';
					}
				?>
				</select>

				<input id="space" type="text" name="course2" value="<?php echo $r['pk_fk_course_stu']?>" style="display: none" />

				<label>State:</label>
				Active <input type="radio" name="state" value="1" <?php echo $r['state_sub_course'] === '1' ? 'checked' : '' ?> />
				Inactive <input type="radio" name="state" value="0" <?php echo $r['state_sub_course'] === '0' ? 'checked' : '' ?> />

				<input id="reg" type="submit" value="Update" onclick="this.form.action = '?action=update';">
			</div>
		</form>
	</div>
	<?php
			}
		}

	$sql = "SELECT * FROM subject_has_course ORDER BY pk_fk_te_sub ASC";
	$query = $db ->query($sql);

	if ($query->rowCount()>0): ?>

	<div>
		<header>SUBJECT OF COURSE</header>
		<table>
			<caption>Subject of Course</caption>
			<thead>
				<tr>
					<th>Course</th>
					<th>N. Subject</th>
					<th>State</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
				<tr>
					<?php echo "<td>".$row['pk_fk_course_stu'] . "</td>";
								echo "<td>".$row['pk_fk_te_sub'] . "</td>";
						if ($row['state_sub_course'] == 1) {
							echo "<td>"."Active" . "</td>";
						}else {
							echo "<td>"."Inactive" . "</td>";
						}
					?>
					<td>
						<a href="?action=edit&subj=<?php echo $row['pk_fk_te_sub'];?>&course=<?php echo $row['pk_fk_course_stu'];?>">
							Update
						</a>
						<a href="?action=delete&subj=<?php echo $row['pk_fk_te_sub'];?>&course=<?php echo $row['pk_fk_course_stu'];?>"
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

