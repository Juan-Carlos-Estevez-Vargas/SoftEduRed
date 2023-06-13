<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>User</title>
    <link rel="stylesheet" href="../indexs/style/cruds_style.css">
</head>
<body>
<?php
    require_once "../persistence/user/UserStudentDAO.php";
    require_once "../Database/conexion.php";
    include "../indexs/cruds.php";

    $db = database::conectar();

    if (isset($_REQUEST['action'])) {
        $action = $_REQUEST['action'];

        if ($action === 'update') {

            $update = new UserStudentDAO();
            $update->updateUserStudent(
                $_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'],
                $_POST['f_lname'], $_POST['s_lname'], $_POST['gender'], $_POST['adress'],
                $_POST['email'], $_POST['phone'], $_POST['u_name'], $_POST['pass'], $_POST['s_ans'],
                $_POST['s_ques'], $_POST['att_doc'], $_POST['att_id'], $_POST['course']
            );

        } elseif ($action === 'register') {

            $insert = new UserStudentDAO();
            $insert->registerUserAndStudent(
                $_POST['tdoc'], $_POST['id_user'], $_POST['f_name'], $_POST['s_name'], $_POST['f_lname'],
                $_POST['s_lname'], $_POST['gender'], $_POST['adress'], $_POST['email'], $_POST['phone'],
                $_POST['u_name'], $_POST['pass'], $_POST['s_ans'], $_POST['s_ques'], $_POST['att_doc'],
                $_POST['att_id'], $_POST['course']);
        
        } elseif ($action === 'delete') {

            $eliminar = new UserStudentDAO();
            $eliminar->deleteStudentUser($_GET['id_user'], $_GET['t_doc']);

        } elseif ($action === 'edit') {

            $id = $_GET['id_user'];
            $tdoc = $_GET['t_doc'];

        }
    }
?>
</body>
</html>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>New Record</title>
    <link rel="stylesheet" href="../indexs/style/cruds_style.css">
</head>
<a id="record" href="?action=ver&m=1">New Record</a>

<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
<div id="new">
	<form action="#" method="post" enctype="multipart/form-data">
		<h2>New Record</h2>
        <div id="text">
            <label>Document Type:</label>
            <select class="form-control" name="tdoc">
            <?php
                foreach ($db->query('SELECT * FROM type_of_document') as $row) {
                    echo '<option value="'.$row['cod_document'].'">'.$row["Des_doc"].'</option>';
                }
            ?>
            </select>

            <label>Number Indentify:</label>
            <input id="space" type="number" name="id_user" placeholder="Number Indentify" required />

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
                foreach ($db->query('SELECT * FROM gender') as $row) {
                    echo '<option value="'.$row['desc_gender'].'">'.$row["desc_gender"].'</option>';
                }
            ?>
            </select>

            <label>Adress:</label>
            <input id="space" type="text" name="adress" placeholder="Adress" />

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
                foreach ($db->query('SELECT * FROM security_question') as $security)  {
                    echo '<option value="'.$security['question'].'">'.$security["question"].'</option>';
                }
            ?>
            </select>

            <label>Answer:</label>
            <input id="ans" type="text" name="s_ans" placeholder="Answer" required />

            <label>Type Document Of Attendant:</label>
            <select class="form-control" name="att_doc">
            <?php
                foreach ($db->query('SELECT * FROM attendant') as $row1)  {
                    echo '<option value="'.$row1['user_pk_fk_cod_doc'].'">'.$row1["user_pk_fk_cod_doc"].'</option>';
                }
            ?>
            </select>
   
            <label>Number Of Indentify Of Attendant:</label>
            <select class="form-control" name="att_id">
            <?php
                foreach ($db->query('SELECT * FROM attendant') as $attendant) {
                    echo '<option value="'.$attendant['user_id_user'].'">'.$attendant["user_id_user"].'</option>';
                }
            ?>
            </select>

            <label>Course Of Student:</label>
            <select class="form-control" name="course">
            <?php
                foreach ($db->query('SELECT * FROM course WHERE state=1') as $course) {
                    echo '<option value="'.$course['cod_course'].'">'.$course["cod_course"].'</option>';
                }
            ?>
            </select>

            <input id="reg" type="submit" value="Save" onclick="this.form.action ='?action=register';">
        </div>
	</form>
</div>
<?php } ?>

<?php if (!empty($_GET['t_doc']) && !empty($_GET['id_user'])  && !empty($_GET['action'])) { ?>
	<form action="#" method="post" enctype="multipart/form-data">

	<?php $sql = "SELECT * FROM user WHERE pk_fk_cod_doc = '$tdoc' and id_user = '$id'";
	$query = $db->query($sql);

	while ($r = $query->fetch(PDO::FETCH_ASSOC)) {	?>
        <div id="update">
        <h2>Update User</h2>
        <div id="text">
    		<label>Type of Document</label>
            <input id="space" type="text" name="tdoc" value="<?php echo $r['pk_fk_cod_doc'];?>" readonly required />

    		<label>N° Identify</label>
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
                foreach ($db->query('SELECT * FROM gender') as $gender){
                    echo '<option value="'.$gender['desc_gender'].'">'.$gender['desc_gender'].'</option>';
                }
            ?>
            </select>

            <label>Adress:</label>
            <input  id="space" type="text" name="adress" value="<?php echo $r['adress'];?>" placeholder="Adress" />

            <label>Email:</label>
            <input id="space" type="text" name="email" value="<?php echo $r['email'];?>" placeholder="Email" required />

            <label>Phone:</label>
            <input id="space"  type="text" name="phone" value="<?php echo $r['phone'];?>" placeholder="Phone" required />

            <label>Nickname:</label>
            <input id="space" type="text" name="u_name" value="<?php echo $r['user_name'];?>" placeholder="Nickname" required />

            <label>Password:</label>
            <input id="space" type="password" name="pass" placeholder="Password" required />

            <label>Security Questions:</label>
            <select class="form-control" name="s_ques">
            <?php
                foreach ($db->query('SELECT * FROM security_question') as $securityQuestion) {
                    echo '<option value="'.$securityQuestion['question'].'">'.$r["fk_s_question"].'</option>';
                }
            ?>
            </select>

    		<label>Answer:</label>
    		<input id="space" type="text" name="s_ans" value="<?php echo $r['security_answer'];?>" required />
            
    		<label>Type Document Of Attendant:</label>
            <select class="form-control" name="att_doc">
    		<?php
                foreach ($db->query('SELECT * FROM attendant') as $attendant) {
                    echo '<option value="'.$attendant['user_pk_fk_cod_doc'].'">'.$attendant["user_pk_fk_cod_doc"].'</option>';
                }
            ?>
            </select>
       
            <label>Number Of Indentify Of Attendant:</label>
            <select class="form-control" name="att_id">
    		<?php
                foreach ($db->query('SELECT * FROM attendant') as $attendant){
                    echo '<option value="'.$attendant['user_id_user'].'">'.$attendant["user_id_user"].'</option>';
                }
            ?>
            </select>

            <label>Course Of Student:</label>
            <select class="form-control" name="course">
    		<?php
                foreach ($db->query('SELECT * FROM course WHERE state=1') as $course) {
                    echo '<option value="'.$course['cod_course'].'">'.$course["cod_course"].'</option>';
                }
            ?>
            </select>

        </div>
    	<input id="reg" type="submit" value="Update" onclick="this.form.action = '?action=update';">
    </div>
<?php
	 	}
	}

$sql = "SELECT * FROM user
    JOIN user_has_role ON tdoc_role = pk_fk_cod_doc
     AND id_user = pk_fk_id_user WHERE pk_fk_role = 'STUDENT'";

$query = $db ->query($sql);

if ($query->rowCount() > 0): ?>
    <div>
    <header>User Info</header>
    <table>
        <caption>Student Information Results</caption>
        <thead>
            <tr>
                <th id="doc">Document</th>
                <th id="studentId">Nº of Identification</th>
                <th id="name" >First Name</th>
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
                <?php echo "<th>".$row['pk_fk_cod_doc']."</th>";?>
                <?php echo "<th>".$row['id_user'] . "</th>";?>
                <?php echo "<th>".$row['first_name'] . "</th>";?>
                <?php echo "<th>".$row['second_name'] . "</th>";?>
                <?php echo "<th>".$row['surname'] . "</th>";?>
                <?php echo "<th>".$row['second_surname'] . "</th>";?>
                <?php echo "<th>".$row['fk_gender'] . "</th>";?>
                <?php echo "<th>".$row['adress'] . "</th>";?>
                <?php echo "<th>".$row['email'] . "</th>";?>
                <?php echo "<th>".$row['phone'] . "</th>";?>
                <th id="actions">
                    <a id="boton" href="?action=edit&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>">
                        Update
                    </a>
                    <a id="boton" href="?action=delete&id_user=<?php echo $row['id_user'];?>&t_doc=<?php echo $row['pk_fk_cod_doc'] ?>"
                        onclick="return confirm('¿Esta seguro de eliminar este usuario?')">
                        Delete
                    </a>
                </th>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
<h4>Mr. User DO NOT find registration</h4>
<?php endif; ?>
</body>
</html>