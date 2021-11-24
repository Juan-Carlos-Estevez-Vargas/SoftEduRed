<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>USER</title>
 <link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>

<?php
require_once "cruds.php";
require_once "../Database/conexion.php";
include "../indexs/cruds.php";
$db = database::conectar();

if (isset($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		case 'actualizar':
			$update = new user_att_cruds();
			$update->actualizar($_POST['tdoc'],$_POST['id_user'],$_POST['f_name'],$_POST['s_name'],$_POST['f_lname'],$_POST['s_lname'],$_POST['gender'],$_POST['adress'],$_POST['email'],$_POST['phone'],$_POST['u_name'],$_POST['pass'],$_POST['s_ans'],$_POST['s_ques'],$_POST['relation']);
			break;
		case 'registrar':
			$insert = new user_att_cruds();
			$insert ->registrar($_POST['tdoc'],$_POST['id_user'],$_POST['f_name'],$_POST['s_name'],$_POST['f_lname'],$_POST['s_lname'],$_POST['gender'],$_POST['adress'],$_POST['email'],$_POST['phone'],$_POST['u_name'],$_POST['pass'],$_POST['s_ans'],$_POST['s_ques'],$_POST['relation']);
			break;
		case 'eliminar':
			$eliminar = new user_att_cruds();
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
	<link rel="stylesheet" href="../style/style_aten.css">
</head>
<body>

<br><br><a href="?action=ver&m=1">NEW RECORD</a><br>
<br>

<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>

<div id="new">
	
	<form action="#" method="post" enctype="multipart/form-data">
	<div id="text">
		<br><h2>NEW USER ATTENDANT</h2>
		<label>Relationship</label>
		 <select class="form-control" name="relation">
		<?php
            foreach ($db->query('SELECT * FROM relationship WHERE state=1') as $row1) {
                echo '<option value="'.$row1['desc_relationship'].'">'.$row1["desc_relationship"].'</option>';
            }
        ?>
        </select>
		<label>Type Document:</label>
        <select class="form-control" name="tdoc">
        <?php
            foreach ($db->query('SELECT * FROM type_of_document') as $row)
            {
                echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
            }
        ?>
        </select><br>
        <br>
        <label>Number Indentify:</label><input id="space" type="number" name="id_user" placeholder="Number Indentify" required><br>
        <br>
        <label>First Name:</label><input id="space" type="text" name="f_name" placeholder="First Name" required>
        <label>Second Name:</label><input id="space" type="text" name="s_name" placeholder="Second Name" ><br>
        <br>
        <label>First Lastname:</label><input id="space" type="text" name="f_lname" placeholder="First Lastname" required>
        <label>Second Lastname:</label><input id="space" type="text" name="s_lname" placeholder="Second Lastname" ><br>
        <br>
        <label>Gender:</label>
        <select class="form-control" name="gender">


		<?php
            foreach ($db->query('SELECT * FROM gender WHERE state=1') as $row1)
            {
                echo '<option value="'.$row1['desc_gender'].'">'.$row1["desc_gender"].'</option>';
            }
        ?>
        </select>
        <label>Adress:</label><input id="space" type="text" name="adress" placeholder="Adress"><br>
        <br><br>
        <label>Email:</label><input id="space" type="text" name="email" placeholder="Email" required>
        <label>Phone:</label><input id="space" type="text" name="phone" placeholder="Phone" required><br>
        <br><br>
        <label>Nickname:</label><input id="space" type="text" name="u_name" placeholder="Nickname" required>
        <label>Password:</label><input id="space" type="password" name="pass" placeholder="Password" required><br>
        <br><br>
   
        <label>Security Questions:</label>
        <select class="form-control" name="s_ques">
        <?php
            foreach ($db->query('SELECT * FROM security_question WHERE state=1') as $row2)
            {
                echo '<option value="'.$row2['question'].'">'.$row2["question"].'</option>';
            }
        ?>
        </select>
		<label>Answer:</label>
		<input id="ans" type="text" name="s_ans" placeholder="Answer" required>
     	<br><br>
		<input id="reg" type="submit" value="Save" onclick="this.form.action ='?action=registrar';">

	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['t_doc']) && !empty($_GET['id_user'])  && !empty($_GET['action']) ) { ?>

<div id="update">
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM user WHERE pk_fk_cod_doc = '$tdoc' and id_user = '$id'"; 

	$query = $db->query($sql);

	while ($r = $query->fetch(PDO::FETCH_ASSOC)) 
	{
		
	?>

	<h2>UPDATE ATTENDANT</h2>
	<div id="text">
		<label>Relationship</label>
		<select class="form-control" name="relation">
		<?php
            foreach ($db->query('SELECT * FROM relationship WHERE state=1') as $row1)
            {
                echo '<option value="'.$row1['desc_relationship'].'">'.$row1["desc_relationship"].'</option>';
            }
        ?>
        </select>
		<label>TYPE OF DOCUMENT</label><input id="space" type="text" name="tdoc" value="<?php echo $r['pk_fk_cod_doc'];?>" readonly required>
		<label>N° IDENTIFY</label><input id="space" type="number" name="id_user" value="<?php echo $r['id_user'];?>" readonly required><br>
		<br>
        <label>First Name:</label><input id="space" type="text" name="f_name" value="<?php echo $r['first_name'];?>" placeholder="First Name" required>
        <label>Second Name:</label><input id="space" type="text" name="s_name" value="<?php echo $r['second_name'];?>" placeholder="Second Name" ><br>
        <br>
        <label>First Lastname:</label><input id="space" type="text" name="f_lname" value="<?php echo $r['surname'];?>" placeholder="First Lastname" required>
        <label>Second Lastname:</label><input id="space" type="text" name="s_lname" value="<?php echo $r['second_surname'];?>" placeholder="Second Lastname" ><br>
        <br>
        <label>Gender:</label>
        <select class="form-control" name="gender">
		<?php
            foreach ($db->query('SELECT * FROM gender') as $row1)
            {
                echo '<option value="'.$row1['desc_gender'].'">'.$row1['desc_gender'].'</option>';
            }
        ?>
        </select>
        <label>Adress:</label><input id="space" type="text" name="adress" value="<?php echo $r['adress'];?>" placeholder="Adress"><br>
        <br>
        <label>Email:</label><input id="space" type="text" name="email" value="<?php echo $r['email'];?>" placeholder="Email" required>
        <label>Phone:</label><input id="space" type="text" name="phone" value="<?php echo $r['phone'];?>" placeholder="Phone" required><br>
        <br>
        <label>Nickname:</label><input id="space" type="text" name="u_name" value="<?php echo $r['user_name'];?>" placeholder="Nickname" required>
        <label>Password:</label><input id="space" type="text" name="pass" value="<?php echo $r['pass'];?>" placeholder="Password" required><br><br>
     
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
		<input id="ans" type="text" name="s_ans" value="<?php echo $r['security_answer'];?>" required>
		</div>
		<br><br>
		<input id="reg" type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">

	</form>	
</div>
<?php
	 	}
	} 

$sql = "SELECT * FROM user JOIN user_has_role ON tdoc_role = pk_fk_cod_doc AND id_user = pk_fk_id_user WHERE pk_fk_role = 'ATTENDANT'";
$query = $db ->query($sql);

if ($query->rowCount()>0): ?>
<div>
<table>
<header>ATTENDANT INFO</header>
	<thead>        
        <tr>   
        	<th>DOCUMENT</th>
       		<th>NOº OF IDENTIFICATION</th>
            <th>FIRST NAME</th>
            <th>SECOND NAME</th>
            <th>SURNAME</th>
            <th>SECOND NAME</th>
            <th>GENDER</th>
            <th>ADRESS </th>
            <th>EMAIL</th>
            <th>PHONE</th>
            <th class="actions">ACTIONS</th>
 		</tr>
</thead>
<tbody>
<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
<tr>
<?php echo "<th>".$row['pk_fk_cod_doc'];?> 
<?php echo "<th>".$row['id_user'] ."</th>";?>
<?php echo "<th>".$row['first_name'] . "</th>";?>
<?php echo "<th>".$row['second_name'] . "</th>";?>
<?php echo "<th>".$row['surname'] . "</th>";?>
<?php echo "<th>".$row['second_surname'] . "</th>";?>
<?php echo "<th>".$row['fk_gender'] . "</th>";?>
<?php echo "<th>".$row['adress'] . "</th>";?>
<?php echo "<th>".$row['email'] . "</th>";?>
<?php echo "<th>".$row['phone'] . "</th>";?>
<th><a href="?action=editar&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>">Update</a>
<a href="?action=eliminar&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>" onclick="return confirm('¿Esta seguro de eliminar este usuario?')">Delete</a></th>
 </tr>


<?php endwhile; ?>
 </tbody>
 </table>
 </div>
<?php else: ?>
	<h4>Mr. User DO NOT find registration</h4>
<?php endif; ?>	

</body>
</html>

</body>
</html>