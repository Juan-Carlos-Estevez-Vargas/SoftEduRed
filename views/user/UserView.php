<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>User</title>
</head>
<body>
<?php
	require_once "../persistence/user/UserDAO.php";
	require_once "../Database/conexion.php";
	include "../indexs/cruds.php";

	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			// //Espacio que genera el almacenamiento de las imagenes
			// $file = $_FILES['image']['name'];
			// $ruta_file = $_FILES['image']['tmp_name'];
			// $photo = "Images_User/".$file;

			// //Se copia el archivo a la carpeta file
			// copy($ruta_file,$photo);

			$update = new UserDAO();
			$update->updateUser(
				$_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'],
				$_POST['f_lname'], $_POST['s_lname'], $_POST['gender'], $_POST['adress'],
				$_POST['email'], $_POST['phone'], $_POST['u_name'], $_POST['pass'],
				$_POST['s_ans'], $_POST['s_ques']
			);

		} elseif ($action == 'register') {

			$insert = new UserDAO();
			$insert ->registerUser(
				$_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'],
				$_POST['f_lname'], $_POST['s_lname'], $_POST['gender'], $_POST['adress'],
				$_POST['email'], $_POST['phone'], $_POST['u_name'], $_POST['pass'],
				$_POST['s_ans'], $_POST['s_ques']
			);

		} elseif ($action == 'delete') {

			$eliminar = new UserDAO();
			$eliminar->deleteUser($_GET['id_user'],$_GET['t_doc']);

		} elseif ($action == 'edit') {

			$id = $_GET['id_user'];
			$tdoc = $_GET['t_doc'];

		}
	}

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>New Record</title>
</head>
<body>

	<a href="?action=ver&m=1">New Record</a><br>

	<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
	<div>
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Record</h2>
			<div id="contenedor">
				<label>Type of Document:</label>
				<select class="form-control" name="tdoc">
				<?php
					foreach ($db->query('SELECT * FROM type_of_document') as $typeOfDocument) {
						echo '<option value="'.$typeOfDocument['cod_document'].'">'.$typeOfDocument["Des_doc"].'</option>';
					}
				?>
				</select>

        <label>Number Indentify:</label>
				<input type="number" name="id_user" placeholder="Number Indentify" required />

        <label>First Name:</label>
				<input type="text" name="f_name" placeholder="First Name" required />

        <label>Second Name:</label>
				<input type="text" name="s_name" placeholder="Second Name" />

        <label>First Lastname:</label>
				<input type="text" name="f_lname" placeholder="First Lastname" required />

        <label>Second Lastname:</label>
				<input type="text" name="s_lname" placeholder="Second Lastname" />

        <label>Gender:</label>
        <select class="form-control" name="gender">
				<?php
          foreach ($db->query('SELECT * FROM gender') as $gender) {
            echo '<option value="'.$gender['desc_gender'].'">'.$gender["desc_gender"].'</option>';
          }
        ?>
        </select>

        <label>Adress:</label>
				<input type="text" name="adress" placeholder="Adress" />

        <label>Email:</label>
				<input type="text" name="email" placeholder="Email" required />

        <label>Phone:</label>
				<input type="text" name="phone" placeholder="Phone" required />

        <label>Nickname:</label>
				<input type="text" name="u_name" placeholder="Nickname" required />

        <label>Password:</label>
				<input type="password" name="pass" placeholder="Password" required />

				<label>Security Questions:</label>
        <select class="form-control" name="s_ques">
        <?php
          foreach ($db->query('SELECT * FROM security_question') as $securityQuestion) {
            echo '<option value="'.$securityQuestion['question'].'">'.$securityQuestion["question"].'</option>';
          }
        ?>
        </select>

				<label>Answer:</label>
				<input type="text" name="s_ans" placeholder="Answer" required />
     	</div>
			<input type="submit" value="Save" onclick="this.form.action ='?action=registrar';">
		</form>
	</div>
<?php } ?>

<?php if (!empty($_GET['t_doc']) && !empty($_GET['id_user']) && !empty($_GET['action'])) { ?>
	<div>
		<form action="#" method="post" enctype="multipart/form-data">
		<?php $sql = "SELECT * FROM user WHERE pk_fk_cod_doc = '$tdoc' and id_user = '$id'";
			$query = $db->query($sql);

			while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
		?>

			<h2>Update User</h2>

			<input type="text" name="tdoc" style="display:none" value="<?php echo $r['pk_fk_cod_doc'];?>" required />

			<input type="number" name="id_user" style="display:none" value="<?php echo $r['id_user'];?>" required />

      <label>First Name:</label>
			<input type="text" name="f_name" value="<?php echo $r['first_name'];?>" placeholder="First Name" required />
      
			<label>Second Name:</label>
			<input type="text" name="s_name" value="<?php echo $r['second_name'];?>" placeholder="Second Name" />

      <label>First Lastname:</label>
			<input type="text" name="f_lname" value="<?php echo $r['surname'];?>" placeholder="First Lastname" required />

      <label>Second Lastname:</label>
			<input type="text" name="s_lname" value="<?php echo $r['second_surname'];?>" placeholder="Second Lastname" />

      <label>Gender:</label>
      <select class="form-control" name="gender">
			<?php
        foreach ($db->query('SELECT * FROM gender') as $gender) {
          echo '<option value="'.$gender['desc_gender'].'">'.$gender['desc_gender'].'</option>';
        }
      ?>
      </select>
      
			<label>Adress:</label>
			<input type="text" name="adress" value="<?php echo $r['adress'];?>" placeholder="Adress" />

      <label>Email:</label>
			<input type="text" name="email" value="<?php echo $r['email'];?>" placeholder="Email" required />

      <label>Phone:</label>
			<input type="text" name="phone" value="<?php echo $r['phone'];?>" placeholder="Phone" required />

      <label>Nickname:</label>
			<input type="text" name="u_name" value="<?php echo $r['user_name'];?>" placeholder="Nickname" required />

      <label>Password:</label>
			<input type="text" name="pass" value="<?php echo $r['pass'];?>" placeholder="Password" required />
     
      <label>Security Questions:</label>
      <select class="form-control" name="s_ques">
      <?php
        foreach ($db->query('SELECT * FROM security_question') as $securityQuestion) {
          echo '<option value="'.$securityQuestion['question'].'">'.$r["fk_s_question"].'</option>';
        }
      ?>
      </select>
		
			<label>Answer:</label>
			<input type="text" name="s_ans" value="<?php echo $r['security_answer'];?>" required />

			<input type="submit" value="Update" onclick="this.form.action = '?action=update';">
		</form>
	</div>
<?php
	 	}
	}

	$sql = "SELECT * FROM user";
	$query = $db ->query($sql);

	if ($query->rowCount()>0): ?>

	<h1>User Information</h1>

	<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
	<div>
		<?php echo $row['pk_fk_cod_doc'];?> <br>
		<?php echo $row['id_user'] . "</br>";?>
		<a href="?action=edit&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>">
			Update
		</a>
		<a href="?action=delete&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>"
				onclick="return confirm('¿Esta seguro de eliminar este usuario?')">
			Delete
		</a>
	</div>
	<?php endwhile; ?>
<?php else: ?>
	<h4>Mr. User DO NOT find registration</h4>
<?php endif; ?>

</body>
</html>

</body>
</html>