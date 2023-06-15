<?php
	require_once "../persistence/atributes/SecurityQuestion.php";
	require_once "../Database/conexion.php";
	include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new SecurityQuestion();
			$update->updateQuestionState($_POST['question'],$_POST['state']);
		} elseif ($action == 'register') {
			$insert = new SecurityQuestion();
			$insert ->addSecurityQuestion($_POST['question'],$_POST['state']);
		} elseif ($action == 'delete') {
			$eliminar = new SecurityQuestion();
			$eliminar->deleteQuestion($_GET['question']);
		} elseif ($action == 'edit') {
			$id = $_GET['question'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Security Question</title>
	<link rel="stylesheet" href="../style/question.css">
	<link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
	<a href="?action=ver&m=1">New Record</a>
	<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
	<div id="new">
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Security Question</h2>
			<label>Question:</label>
			<input id="space" type="text" name="question" placeholder="QUESTION" required style="text-transform:uppercase" />
			
			<label>State:</label>
			Active <input type="radio" name="state" value="1" checked />
			Inactive <input type="radio" name="state" value="0" checked />

			<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=register';" />
		</form>
	</div>
<?php } ?>

<?php if (!empty($_GET['question']) && !empty($_GET['action'])) { ?>
	<div id="update">
		<form action="#" method="post" enctype="multipart/form-data">
			<?php $sql = "SELECT * FROM security_question WHERE question = '$id'";
				$query = $db->query($sql);
				while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
			?>
			<h2>UPDATE QUESTION</h2>
			<label>Question:</label>
			<input id="space" type="text" name="question" value="<?php echo $r['question']?>" required style="text-transform:uppercase" size="40" readonly />

			<label>State:</label>
			Active<input type="radio" name="state" value="1" <?php echo $r['state'] === '1' ? 'checked' : '' ?> />
			Inactive<input type="radio" name="state" value="0" <?php echo $r['state'] === '0' ? 'checked' : '' ?> />
			
			<input id="boton" type="submit" value="Update" onclick="this.form.action = '?action=update';">
		</form>
	</div>
<?php
	 	}
	}

	$sql = "SELECT * FROM security_question";
	$query = $db ->query($sql);

	if ($query->rowCount()>0): ?>
	
	<div>
		<header>Question of Security</header>
		<table>
			<caption>Security Question's Information Results</caption>
			<thead>
				<tr>
					<th>Question</th>
					<th>State</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
				<tr>
					<?php echo "<td>".$row['question'] . "</td>";
						if ($row['state'] == 1) {
							echo "<td>"."Active" . "</td>";
						} else {
							echo "<td>"."Inactive" . "</td>";
						}
					?>
					<td>
						<a href="?action=edit&question=<?php echo $row['question'];?>">
							Update
						</a>
						<a href="?action=delete&question=<?php echo $row['question'];?>"
								onclick="return confirm('¿Esta seguro de eliminar este usuario?')">
							Delete
						</a>
					</td>
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>
	<?php else: ?>
		<h4>Mr.User DO NOT find registration</h4>
	<?php endif; ?>
</body>
</html>

