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

			$update = new subj_course();
			$update->actualizar($_POST['subj'],$_POST['subj2'],$_POST['course'],$_POST['course2'],$_POST['state']);

			break;
		
		case 'registrar':

			$insert = new subj_course();
			$insert ->registrar($_POST['course']);

			break;

		case 'eliminar':
				
			$eliminar = new subj_course();
			$eliminar->eliminar($_GET['subj'], $_GET['course']);

			break;	

		case 'editar':
			
			$subj = $_GET['subj'];
            $course = $_GET['course'];
			break;	
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>SUBJECT FOR COURSE</title>
    <link rel="stylesheet" href="../style/style_subject_has_couse.css">
    <link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>

<br><br><a href="?action=ver&m=1">New Record</a><br><br>

	<?php if (!empty($_GET['m']) and !empty($_GET['action']) ) { ?>

<div id="new">
	
	<form action="#" method="post" enctype="multipart/form-data">
		<br><h2>NEW SUBJECT FOR COURSE</h2>
     <div id="text">
		<label>COURSE:</label>
		<select class="form-control" name="course">
        <?php
            foreach ($db->query('SELECT * FROM course WHERE state = 1') as $row)
            {
                echo '<option value="'.$row['cod_course'].'">'.$row["cod_course"].'</option>';
            }
        ?>
        </select><br>
      <br>
		<label>SUBJECT:</label><br>
        <?php
            foreach ($db->query('SELECT * FROM subject where state= 1') as $row)
            { ?>
                <br><input type="checkbox" name="<?php echo $row['n_subject']?>">
        		<?php echo $row['n_subject'];?>
				<input type="radio" name="state_<?php echo $row['n_subject']?>" value="1" checked>Active
				<input type="radio" name="state_<?php echo $row['n_subject']?>" value="0" checked>Inactive
         <br><br>
        <?php } ?>
     </div>
		<input id="reg" type="submit" value="Save" onclick="this.form.action ='?action=registrar';">

	</form>
</div>		
<?php } ?>

<?php if (!empty($_GET['subj']) && !empty($_GET['course']) && !empty($_GET['action']) ) { ?>

<div id="update">
	<form action="#" method="post" enctype="multipart/form-data">
	<?php $sql = "SELECT * FROM subject_has_course WHERE pk_fk_te_sub = '$subj' && pk_fk_course_stu = '$course'"; 

	$query = $db->query($sql);

	while ($r = $query->fetch(PDO::FETCH_ASSOC)) 
	{
	?>

    <br><h2>UPDATE SUBJECT FOR COURSE</h2>
        <div id="text">
		<label>SUBJECT:</label>
		<select class="form-control" name="subj">
        <?php
            foreach ($db->query('SELECT * FROM subject WHERE state = 1') as $row)
            {
                echo '<option value="'.$row['n_subject'].'">'.$row["n_subject"].'</option>';
            }
        ?>
        </select><br>
        <br>
        <input id="space" type="text" name="subj2" value="<?php echo $r['pk_fk_te_sub']?>" style="display: none">
		<label>COURSE:</label>
		<select class="form-control" name="course">
        <?php
            foreach ($db->query('SELECT * FROM course WHERE state = 1') as $row)
            {
                echo '<option value="'.$row['cod_course'].'">'.$row["cod_course"].'</option>';
            }
        ?>
        </select><br>
        <input id="space" type="text" name="course2" value="<?php echo $r['pk_fk_course_stu']?>" style="display: none">
        <br>
        <label>State:</label>
        Active<input type="radio" name="state" value="1" <?php echo $r['state_sub_course'] === '1' ? 'checked' : '' ?> >
		Inactive<input type="radio" name="state" value="0" <?php echo $r['state_sub_course'] === '0' ? 'checked' : '' ?> >
        <br><br>
		<input id="reg" type="submit" value="Update" onclick="this.form.action = '?action=actualizar';">
     </div>
	</form>	
</div>
<?php
	 	}
	} 

$sql = "SELECT * FROM subject_has_course ORDER BY pk_fk_te_sub ASC";
$query = $db ->query($sql);

if ($query->rowCount()>0): ?>

<div><br><br>
<header>SUBJECT OF COURSE</header>
<table>
	<thead>
		<tr>
			<th>COURSE</th>
			<th>N.SUBJECT</th>
			<th>STATE</th>
			<th>ACTIONS</th>
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

<td><a href="?action=editar&subj=<?php echo $row['pk_fk_te_sub'];?>&course=<?php echo $row['pk_fk_course_stu'];?>">Update</a>
<a href="?action=eliminar&subj=<?php echo $row['pk_fk_te_sub'];?>&course=<?php echo $row['pk_fk_course_stu'];?>" onclick="return confirm('¿Esta seguro de eliminar este usuario?')">Delete</a></td>


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

