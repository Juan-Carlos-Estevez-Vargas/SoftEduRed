<?php
	require_once "../services/SubjectService.php";
	require_once "../persistence/database/Database.php";

  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new SubjectService();
			$update->update($_POST['id_subject'], $_POST['subject'], $_POST['state'], $_POST['teacher_id']);
		} elseif ($action == 'register') {
			$insert = new SubjectService();
			$insert->register($_POST['subject'], $_POST['teacher_id']);
		} elseif ($action == 'delete') {
			$delete = new SubjectService();
			$delete->delete($_GET['id_subject']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_subject'];
		}
	}
?>