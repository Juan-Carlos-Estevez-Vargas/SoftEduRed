<?php
	require_once "../services/subjectHasCourseService.php";
	require_once "../persistence/database/Database.php";

  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new subjectHasCourseService();
			$update->update($_POST['id'], $_POST['course'], $_POST['subject'], $_POST['state']);
		} elseif ($action == 'register') {
			$insert = new subjectHasCourseService();
			$insert->register($_POST['course'], $_POST['subject']);
		} elseif ($action == 'delete') {
			$delete = new SubjectHasCourseService();
			$delete->delete($_GET['id_subject']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_subject'];
		}
	}
?>