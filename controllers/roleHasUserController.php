<?php
	require_once "../persistence/database/Database.php";
	require_once "../services/RoleHasUserService.php";

  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new RoleHasUserService();
			$update->update($_POST['id_user_has_role'], $_POST['state']);
		} elseif ($action == 'register') {
			$insert = new RoleHasUserService();
			$insert ->register($_POST['id_user'], $_POST['role'], $_POST['state']);
		} elseif ($action == 'delete') {
			$delete = new RoleHasUserService();
			$delete->delete($_GET['id_user_has_role']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_user'];
			$role = $_GET['role'];
		}
	}
?>