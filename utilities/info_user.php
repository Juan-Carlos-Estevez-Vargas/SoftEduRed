<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>USER</title>
</head>
<body>
 <?php
 session_start();
  require_once "crud.php";
  require_once "../Database/conexion.php";
 $db = database::conectar();

if (isset($_REQUEST['action'])) {
	switch ($_REQUEST['action']) {
		case 'actualizar':
			$update = new user_cruds();
			$update->actualizar($_POST['tdoc'],$_POST['id_user'],$_POST['f_name'],
      $_POST['s_name'],$_POST['f_lname'],$_POST['s_lname'],$_POST['gender'],
      $_POST['adress'],$_POST['email'],$_POST['phone'],$_POST['u_name'],$_POST['pass'],
      $_POST['s_ans'],$_POST['s_ques']);
			break;
	}
}?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>NEW RECORD</title>
  <link rel="stylesheet" href="../style/info_user.css">
</head>
<body>
<div id="new">
    <?php 
    $tdoc = $_SESSION["TIPO_DOC"];
    $id = $_SESSION["ID_PERSONA"];
    ?>
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM user WHERE pk_fk_cod_doc = '$tdoc' and id_user = '$id'"; 
	$query = $db->query($sql);
	while ($r = $query->fetch(PDO::FETCH_ASSOC)) {?>
	<br><h2>UPDATE USER</h2>
     <div id="text">
      <table>
       <tr>
        <td><label>Type Document:</label>
       <input id="space" type="text" name="tdoc" value="<?php echo $r['pk_fk_cod_doc'];?>" required readonly></td>
        <td> <label>N° of Identify:</label>
         <input id="space" type="number" name="id_user" value="<?php echo $r['id_user'];?>" required readonly></td></tr>
       
        <tr><td><label>First Name:</label>
         <input id="space" type="text" name="f_name" value="<?php echo $r['first_name'];?>" 
         placeholder="First Name" required></td>
        <td><label>Second Name:</label>
         <input id="space" type="text" name="s_name" value="<?php echo $r['second_name'];?>" 
         placeholder="Second Name" ></td></tr>
       
       <tr> <td>    <label>First Lastname:</label>
        <input id="space" type="text" name="f_lname" value="<?php echo $r['surname'];?>" 
        placeholder="First Lastname" required></td>
        <td>   <label>Second Lastname:</label>
         <input id="space" type="text" name="s_lname" value="<?php echo $r['second_surname'];?>" 
         placeholder="Second Lastname" ></td></tr>
       
      <tr>  <td>  <label>Gender:</label>
       <select class="form-control" name="gender">
		<?php
            foreach ($db->query('SELECT * FROM gender') as $row1) {?>
                <option value="<?php echo $row1['desc_gender']; ?>" 
                <?php echo ($r['fk_gender'] === $row1['desc_gender']) ? 'selected' : ''?> > 
                <?php echo $row1['desc_gender']; ?></option>
           <?php  }
        ?>
        </select></td>
        <td>  <label>Adress:</label>
         <input type="text" name="adress" value="<?php echo $r['adress'];?>" placeholder="Adress" ></td></tr>
     
      <tr>  <td>  <label>Email:</label>
       <input type="text" name="email" value="<?php echo $r['email'];?>" placeholder="Email" required></td>
        <td>  <label>Phone:</label>
         <input type="text" name="phone" value="<?php echo $r['phone'];?>" placeholder="Phone" required></td></tr>
     
       <tr> <td> <label>Nickname:</label>
        <input type="text" name="u_name" value="<?php echo $r['user_name'];?>" placeholder="Nickname" required></td>
        <td>  <label>Password:</label>
         <input type="password" name="pass" value="<?php echo $r['pass'];?>" placeholder="Password" required></td></tr>
     
        <tr><td> <label>Security Questions:</label>
        <select class="form-control" name="s_ques">
        <?php
            foreach ($db->query('SELECT * FROM security_question WHERE state=1') as $row2) {?>
                <option value="<?php echo $row2['question']; ?>" 
                <?php echo ($r['fk_s_question'] === $row2['question']) ? 'selected' : ''?> > 
                <?php echo $row2['question']; ?></option>
           <?php }
        ?>
        </select></td>
        <td><label>Answer:</label>
         <input type="text" name="s_ans" value="<?php echo $r['security_answer'];?>" required></td></tr>
     
     </table>
       </div>
     <center>
      <br><br>
     
		<input id="buton" type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">
      <br><br>
     </center>

	</form>	
</div>
 <?php
	 	}?>
 </body>
 </html>