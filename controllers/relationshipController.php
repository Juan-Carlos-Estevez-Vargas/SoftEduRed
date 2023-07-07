<?php
	require_once "../persistence/database/Database.php";
	require_once "../services/RelationshipService.php";

  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'register') {
			$registrar = new RelationshipService();
			$registrar->register($_POST['relation'], $_POST['state']);
		} elseif ($action == 'update') {
			$update = new RelationshipService();
			$update->update($_POST['id_relationship'], $_POST['state']);
		} elseif ($action == 'delete') {
			$delete = new RelationshipService();
			$delete->delete($_GET['id_relationship']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_relationship'];
		}
	}
?>