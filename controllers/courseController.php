<?php
	require_once "../services/courseService.php";
	require_once "../persistence/database/Database.php";

  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new courseService();
			$update->update($_POST['id_course'], $_POST['course'], $_POST['state']);
		} elseif ($action == 'register') {
			$insert = new courseService();
			$insert ->register($_POST['course'], $_POST['state']);
		} elseif ($action == 'delete') {
			$delete = new courseService();
			$delete->delete($_GET['id_course']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_course'];
		}
	}
?>