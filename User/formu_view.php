<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>USER</title>

</head>
<body>

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
			
			// //Espacio que genera el almacenamiento de las imagenes
			// $file = $_FILES['image']['name'];
			// $ruta_file = $_FILES['image']['tmp_name'];
			// $photo = "Images_User/".$file;

			// //Se copia el archivo a la carpeta file
			// copy($ruta_file,$photo);

			$update = new user_cruds();
			$update->actualizar($_POST['tdoc'],$_POST['id_user'],$_POST['f_name'],$_POST['s_name'],$_POST['f_lname'],$_POST['s_lname'],$_POST['gender'],$_POST['adress'],$_POST['email'],$_POST['phone'],$_POST['u_name'],$_POST['pass'],$_POST['s_ans'],$_POST['s_ques']);

			break;
		
		case 'registrar':
			

           
			$insert = new user_cruds();
			$insert ->registrar($_POST['tdoc'],$_POST['id_user'],$_POST['f_name'],$_POST['s_name'],$_POST['f_lname'],$_POST['s_lname'],$_POST['gender'],$_POST['adress'],$_POST['email'],$_POST['phone'],$_POST['u_name'],$_POST['pass'],$_POST['s_ans'],$_POST['s_ques']);

			break;

		case 'eliminar':
				
			$eliminar = new user_cruds();
			$eliminar->eliminar($_GET['id_user'],$_GET['t_doc']);

			break;	

		case 'editar':
			
			$id = $_GET['id_user'];
			$tdoc = $_GET['t_doc'];

			break;	
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>NEW RECORD</title>
</head>
<body>

<br><a href="?action=ver&m=1">NEW RECORD</a><br>

<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>

<div>
	
	<form action="#" method="post" enctype="multipart/form-data">
		<h2>NEW RECORD</h2>
		<label>Type Document:</label>
        <select class="form-control" name="tdoc">
        <?php
            foreach ($db->query('SELECT * FROM type_of_document') as $row)
            {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        </select>
     	<div id="contenedor">
        <label>Number Indentify:</label>
		<input type="number" name="id_user" placeholder="Number Indentify" required>
        <label>First Name:</label>
		<input type="text" name="f_name" placeholder="First Name" required>
        <label>Second Name:</label>
		<input type="text" name="s_name" placeholder="Second Name" >
        <label>First Lastname:</label>
		<input type="text" name="f_lname" placeholder="First Lastname" required>
        <label>Second Lastname:</label>
		<input type="text" name="s_lname" placeholder="Second Lastname" >
        <label>Gender:</label>
        <select class="form-control" name="gender">
     	</div>

		<?php
            foreach ($db->query('SELECT * FROM gender') as $row1)
            {
                echo '<option value="'.$row1['desc_gender'].'">'.$row1["desc_gender"].'</option>';
            }
        ?>
        </select>
        <label>Adress:</label>
		<input type="text" name="adress" placeholder="Adress">
        <label>Email:</label>
		<input type="text" name="email" placeholder="Email" required>
        <label>Phone:</label>
		<input type="text" name="phone" placeholder="Phone" required>
        <label>Nickname:</label>
		<input type="text" name="u_name" placeholder="Nickname" required>
        <label>Password:</label>
		<input type="password" name="pass" placeholder="Password" required>
   
        <label>Security Questions:</label>
        <select class="form-control" name="s_ques">
        <?php
            foreach ($db->query('SELECT * FROM security_question') as $row2)
            {
                echo '<option value="'.$row2['question'].'">'.$row2["question"].'</option>';
            }
        ?>
        </select>
		<label>Answer:</label>
		<input type="text" name="s_ans" placeholder="Answer" required>
	
        
		<input type="submit" value="Save" onclick="this.form.action ='?action=registrar';">

	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['t_doc']) && !empty($_GET['id_user'])  && !empty($_GET['action']) ) { ?>

<div>
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM user WHERE pk_fk_cod_doc = '$tdoc' and id_user = '$id'"; 

	$query = $db->query($sql);

	while ($r = $query->fetch(PDO::FETCH_ASSOC)) 
	{
		
	?>

	<h2>UPDATE USER</h2>

		<input type="text" name="tdoc" style="display:none" value="<?php echo $r['pk_fk_cod_doc'];?>" required>
		<input type="number" name="id_user" style="display:none" value="<?php echo $r['id_user'];?>" required>
        <label>First Name:</label>
		<input type="text" name="f_name" value="<?php echo $r['first_name'];?>" placeholder="First Name" required>
        <label>Second Name:</label>
		<input type="text" name="s_name" value="<?php echo $r['second_name'];?>" placeholder="Second Name" >
        <label>First Lastname:</label>
		<input type="text" name="f_lname" value="<?php echo $r['surname'];?>" placeholder="First Lastname" required>
        <label>Second Lastname:</label>
		<input type="text" name="s_lname" value="<?php echo $r['second_surname'];?>" placeholder="Second Lastname" >
        <label>Gender:</label>
        <select class="form-control" name="gender">
		<?php
            foreach ($db->query('SELECT * FROM gender') as $row1)
            {
                echo '<option value="'.$row1['desc_gender'].'">'.$row1['desc_gender'].'</option>';
            }
        ?>
        </select>
        <label>Adress:</label>
		<input type="text" name="adress" value="<?php echo $r['adress'];?>" placeholder="Adress" >
        <label>Email:</label>
		<input type="text" name="email" value="<?php echo $r['email'];?>" placeholder="Email" required>
        <label>Phone:</label>
		<input type="text" name="phone" value="<?php echo $r['phone'];?>" placeholder="Phone" required>
        <label>Nickname:</label>
		<input type="text" name="u_name" value="<?php echo $r['user_name'];?>" placeholder="Nickname" required>
        <label>Password:</label>
		<input type="text" name="pass" value="<?php echo $r['pass'];?>" placeholder="Password" required>
     
        <label>Security Questions:</label>
        <select class="form-control" name="s_ques">
        <?php
            foreach ($db->query('SELECT * FROM security_question') as $row2)
            {
                echo '<option value="'.$row2['question'].'">'.$r["fk_s_question"].'</option>';
            }
        ?>
        </select>
		<label>Answer:</label>
		<input type="text" name="s_ans" value="<?php echo $r['security_answer'];?>" required>

		<input type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">

	</form>	
</div>
<?php
	 	}
	} 

$sql = "SELECT * FROM user";
$query = $db ->query($sql);

if ($query->rowCount()>0): ?>

<h1>USER INFO</h1>

<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>

<div>
<?php echo $row['pk_fk_cod_doc'];?> <br>
<?php echo $row['id_user'] . "</br>";?>

<a href="?action=editar&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>">Update</a>
<a href="?action=eliminar&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>" onclick="return confirm('¿Esta seguro de eliminar este usuario?')">Delete</a>

</div>
<?php endwhile; ?>

<?php else: ?>
	<h4>Mr. User DO NOT find registration</h4>
<?php endif; ?>	

</body>
</html>

</body>
</html>