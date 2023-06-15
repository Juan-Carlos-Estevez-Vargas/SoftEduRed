<?php
	require_once "../persistence/atributes/DocumentType.php";
	require_once "../Database/conexion.php";
	include "../indexs/cruds.php";
	$db = database::conectar();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new DocumentType();
			$update->updateDocumentType($_POST['doc'],$_POST['queryy'],$_POST['desc_doc']);
		} elseif ($action == 'register') {
			$insert = new DocumentType();
			$insert ->registerDocumentType($_POST['doc'],$_POST['desc_doc']);
		} elseif ($action == 'delete') {
			$eliminar = new DocumentType();
			$eliminar->deleteDocumentType($_GET['id_doc']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_doc'];
		}
	}
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Tupe of Document</title>
	<link rel="stylesheet" type="text/css" href="../style/style_tables.css">
	<link rel="stylesheet" href="../indexs/style/cruds_style.css" >
</head>
<body>
	<a href="?action=ver&m=1">New Record</a>
	<?php if (!empty($_GET['m']) && !empty($_GET['action'])) { ?>
	<div id="new">
		<form action="#" method="post" enctype="multipart/form-data">
			<h2>New Document</h2>
			<label>Document:</label>
			<input id="space" type="text" name="doc" placeholder="Ej: C.C" required style="text-transform:uppercase" />
			
			<label>Type of Document</label>
			<input id="spacen" type="text" name="desc_doc" placeholder="Ej:Cedula de Ciudadania" style="text-transform:uppercase" required />

			<input id="boton" type="submit" value="Save" onclick="this.form.action ='?action=register'" />
		</form>
	</div>
	<?php } ?>

	<?php if (!empty($_GET['id_doc']) && !empty($_GET['action']) ) { ?>
	<div id="update">
		<form action="#" method="post" enctype="multipart/form-data">
			<?php $sql = "SELECT * FROM type_of_document WHERE cod_document = '$id'";
				$query = $db->query($sql);
				while ($r = $query->fetch(PDO::FETCH_ASSOC)) {
			?>
			<h2>Update Document</h2>
			<label>Type of Document:</label>
			<input id="Space" type="text" name="queryy" value="<?php echo $r['cod_document']?>" required />

			<label>Desc Document:</label>
			<input id="Space" type="text" name="desc_doc" value="<?php echo $r['Des_doc']?>" required style="text-transform:uppercase" />

			<input id="boton" type="submit" value="Update" onclick="this.form.action = '?action=update';" />
		</form>
	</div>
	<?php
			}
		}

		$sql = "SELECT * FROM type_of_document";
		$query = $db ->query($sql);

		if ($query->rowCount()>0): ?>

	<div>
		<header>Document</header>
		<table>
			<caption>Document Type Information Results</caption>
			<thead>
				<tr>
					<h3><th>Code</th></h3>
					<th>Type of Document</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php while ($row = $query->fetch(PDO::FETCH_ASSOC)): ?>
				<tr>
					<?php
					echo "<td>".$row['cod_document']."</td>";
					echo "<td>".$row['Des_doc']."</td>";
					?>
					<td>
						<a href="?action=edit&id_doc=<?php echo $row['cod_document'];?>">
							Update
						</a>
						<a href="?action=delete&id_doc=<?php echo $row['cod_document'];?>"
								onclick="return confirm('�Esta seguro de eliminar este usuario?')">
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

