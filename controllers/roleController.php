<?php
	require_once "../persistence/database/Database.php";
	require_once "../services/RoleService.php";

  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new RoleService();
			$update->update($_POST['id_role'], $_POST['state']);
		} elseif ($action == 'register') {
			$insert = new RoleService();
			$insert->register($_POST['role'], $_POST['state']);
		} elseif ($action == 'delete') {
			$delete = new RoleService();
			$delete->delete($_GET['id_role']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_role'];
		}
	}
?>