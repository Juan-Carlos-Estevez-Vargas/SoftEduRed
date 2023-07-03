<?php
	require_once "../persistence/database/Database.php";
	require_once "../services/genderService.php";
  
	$db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new GenderService();
			$update->update($_POST['id_gender'], $_POST['gender'], $_POST['state']);
		} elseif ($action == 'register') {
			$insert = new GenderService();
			$insert ->register($_POST['gender'], $_POST['state']);
		} elseif ($action == 'delete') {
			$delete = new GenderService();
			$delete->delete($_GET['id_gender']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_gender'];
		}
	}
?>