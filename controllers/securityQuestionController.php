<?php
	require_once "../persistence/database/Database.php";
	require_once "../services/SecurityQuestionService.php";
  
	$db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new SecurityQuestionDAO();
			$update->update($_POST['id_security_question'], $_POST['state']);
		} elseif ($action == 'register') {
			$insert = new SecurityQuestionDAO();
			$insert->register($_POST['question'],$_POST['state']);
		} elseif ($action == 'delete') {
			$delete = new SecurityQuestionDAO();
			$delete->delete($_GET['id_security_question']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_security_question'];
		}
	}
?>