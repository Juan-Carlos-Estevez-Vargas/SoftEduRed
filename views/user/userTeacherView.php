<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>User</title>
	<link rel="stylesheet" href="../indexs/style/cruds_style.css">
	<link rel="stylesheet" href="../style/style_teacher.css">
</head>
<body>

<?php
	require_once "../Database/conexion.php";
	require_once "../persistence/user/teacher/UserTeacherDAO.php";

	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action === 'update') {

			$update = new UserTeacherDAO();
			$update->updateUserTeacherInformation(
				$_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'], $_POST['f_lname'],
				$_POST['s_lname'], $_POST['gender'], $_POST['adress'], $_POST['email'], $_POST['phone'],
				$_POST['u_name'], $_POST['pass'], $_POST['s_ans'], $_POST['s_ques']
			);

		} elseif ($action === 'register') {

			$insert = new UserTeacherDAO();
			$insert->register(
				$_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'], $_POST['f_lname'],
				$_POST['s_lname'], $_POST['gender'], $_POST['adress'], $_POST['email'], $_POST['phone'],
				$_POST['u_name'], $_POST['pass'], $_POST['s_ans'], $_POST['s_ques']
			);

		} elseif ($action === 'delete') {
			
			$eliminar = new UserTeacherDAO();
			$eliminar->eliminar($_GET['id_user'], $_GET['t_doc']);

		}

		if ($action === 'edit') {
			$id = $_GET['id_user'];
			$tdoc = $_GET['t_doc'];
		}
	}
?>

<a href="?action=ver&m=1">New Record</a>

<?php if (!empty($_GET['m']) && !empty($_GET['action'])): ?>
	<div id="new">
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Teacher</h2>
			<div id="text">
				<label>Type Document:</label>
				<select class="form-control" name="tdoc">
				<?php
					foreach ($db->query('SELECT * FROM type_of_document') as $row) {
						echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
					}
				?>
				</select>
				
				<label>Number Identify:</label>
				<input id="space" type="number" name="id_user" placeholder="Number Identify" required />

				<label>First Name:</label>
				<input id="space" type="text" name="f_name" placeholder="First Name" required />

				<label>Second Name:</label>
				<input id="space" type="text" name="s_name" placeholder="Second Name" />

				<label>First Lastname:</label>
				<input id="space" type="text" name="f_lname" placeholder="First Lastname" required />

				<label>Second Lastname:</label>
				<input id="space" type="text" name="s_lname" placeholder="Second Lastname" />

				<label>Gender:</label>
				<select class="form-control" name="gender">
				<?php
					foreach ($db->query('SELECT * FROM gender') as $row1) {
						echo '<option value="'.$row1['desc_gender'].'">'.$row1["desc_gender"].'</option>';
					}
				?>
				</select>

				<label>Address:</label>
				<input id="space" type="text" name="adress" placeholder="Address" />
				
				<label>Email:</label>
				<input id="space" type="text" name="email" placeholder="Email" required />

				<label>Phone:</label>
				<input id="space" type="text" name="phone" placeholder="Phone" required />

				<label>Nickname:</label>
				<input id="space" type="text" name="u_name" placeholder="Nickname" required />

				<label>Password:</label>
				<input id="space" type="password" name="pass" placeholder="Password" required />

				<label>Security Questions:</label>
				<select class="form-control" name="s_ques">
				<?php
					foreach ($db->query('SELECT * FROM security_question') as $row2) {
						echo '<option value="'.$row2['question'].'">'.$row2["question"].'</option>';
					}
				?>
				</select>

				<label>Answer:</label>
				<input id="space" type="text" name="s_ans" placeholder="Answer" required />

				<input id="reg" type="submit" value="Save" onclick="this.form.action = '?action=register';">
			</div>
		</form>
	</div>
<?php endif; ?>

<?php if (!empty($_GET['t_doc']) && !empty($_GET['id_user']) && !empty($_GET['action'])): ?>
	<div id="update">
		<form action="#" method="post" enctype="multipart/form-data">

			<?php
				$sql = "SELECT * FROM user WHERE pk_fk_cod_doc = '$tdoc' and id_user = '$id'";
				$query = $db->query($sql);
				while ($r = $query->fetch(PDO::FETCH_ASSOC)):
			?>

			<h2>Update Teacher</h2>
			<div id="text">
				<label>Type of Document:</label>
				<input id="space" type="text" name="tdoc" value="<?php echo $r['pk_fk_cod_doc'];?>" readonly required />

				<label>N° Identify:</label>
				<input id="space" type="number" name="id_user" value="<?php echo $r['id_user'];?>" readonly required />

				<label>First Name:</label>
				<input id="space" type="text" name="f_name" value="<?php echo $r['first_name'];?>" placeholder="First Name" required />

				<label>Second Name:</label>
				<input id="space" type="text" name="s_name" value="<?php echo $r['second_name'];?>" placeholder="Second Name" />

				<label>First Lastname:</label>
				<input id="space" type="text" name="f_lname" value="<?php echo $r['surname'];?>" placeholder="First Lastname" required />

				<label>Second Lastname:</label>
				<input id="space" type="text" name="s_lname" value="<?php echo $r['second_surname'];?>" placeholder="Second Lastname" />

				<label>Gender:</label>
				<select class="form-control" name="gender">
				<?php
					foreach ($db->query('SELECT * FROM gender') as $row1) {
						$selected = $r['fk_gender'] == $row1['desc_gender'] ? 'selected' : '';
						echo '<option value="'.$row1['desc_gender'].'" '.$selected.'>'.$row1['desc_gender'].'</option>';
					}
				?>
				</select>

				<label>Address:</label>
				<input id="space" type="text" name="adress" value="<?php echo $r['adress'];?>" placeholder="Address" />

				<label>Email:</label>
				<input id="space" type="text" name="email" value="<?php echo $r['email'];?>" placeholder="Email" required />

				<label>Phone:</label>
				<input id="space" type="text" name="phone" value="<?php echo $r['phone'];?>" placeholder="Phone" required />

				<label>Nickname:</label>
				<input id="space" type="text" name="u_name" value="<?php echo $r['user_name'];?>" placeholder="Nickname" required />
				
				<label>Password:</label>
				<input id="space" type="password" name="pass" placeholder="Password" required />

				<label>Security Questions:</label>
				<select class="form-control" name="s_ques">
					<?php
						foreach ($db->query('SELECT * FROM security_question') as $row2) {
							$selected = $r['fk_s_question'] == $row2['question'] ? 'selected' : '';
							echo '<option value="'.$row2['question'].'" '.$selected.'>'.$row2["question"].'</option>';
						}
					?>
				</select>

				<label>Answer:</label>
				<input id="ans" type="text" name="s_ans" value="<?php echo $r['security_answer'];?>" required />
			</div>
			<input id="boton" type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">
		</form>
	</div>
<?php endwhile; ?>
<?php endif; ?>

<?php
	$sql = "SELECT * FROM user
		JOIN user_has_role
		ON tdoc_role = pk_fk_cod_doc
		AND id_user = pk_fk_id_user
		WHERE pk_fk_role = 'TEACHER'";
	$query = $db->query($sql);

	if ($query->rowCount() > 0):
?>
	<div>
		<header>Teacher Info</header>
		<table>
			<caption>Teacher Information Results</caption>
			<thead>
				<tr>
					<th id="doc">Document</th>
					<th id="teacherId">Nº of Identify</th>
					<th id="name">First Name</th>
					<th id="sname">Second Name</th>
					<th id="lname">Surname</th>
					<th id="ssname">Second Surname</th>
					<th id="gender">Gender</th>
					<th id="address">Address</th>
					<th id="email">Email</th>
					<th id="phone">Phone</th>
					<th id="actions" class="actions">Actions</th>
				</tr>
			</thead>
			<tbody>
			<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
				<tr>
					<th id="doc"><?php echo $row['pk_fk_cod_doc']; ?></th>
					<th id="teacherId"><?php echo $row['id_user']; ?></th>
					<th id="name"><?php echo $row['first_name']; ?></th>
					<th id="sname"><?php echo $row['second_name']; ?></th>
					<th id="lname"><?php echo $row['surname']; ?></th>
					<th id="ssname"><?php echo $row['second_surname']; ?></th>
					<th id="gender"><?php echo $row['desc_gender']; ?></th>
					<th id="address"><?php echo $row['adress']; ?></th>
					<th id="email"><?php echo $row['email']; ?></th>
					<th id="phone"><?php echo $row['phone']; ?></th>
					<th id="actions" class="actions">
						<a href="?action=edit&id_user=<?php echo $row['id_user']; ?>&t_doc=<?php echo $row['pk_fk_cod_doc']; ?>">
							Edit
						</a> |
						<a href="?action=delete&id_user=<?php echo $row['id_user']; ?>&t_doc=<?php echo $row['pk_fk_cod_doc']; ?>">
							Delete
						</a>
					</th>
				</tr>
			<?php endwhile; ?>
			</tbody>
		</table>
	</div>
<?php else: ?>
	<p>No records found.</p>
<?php endif; ?>

</body>
</html>