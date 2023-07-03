<?php
	require_once "../persistence/database/Database.php";
	require_once "../services/DocumentTypeService.php";
	
  $db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action == 'update') {
			$update = new DocumentTypeService();
			$update->update(
        $_POST['id_document_type'], $_POST['document_type'],
        $_POST['description'], $_POST['state']
      );
		} elseif ($action == 'register') {
			$insert = new DocumentTypeService();
			$insert->register($_POST['document_type'], $_POST['description']);
		} elseif ($action == 'delete') {
			$delete = new DocumentTypeService();
			$delete->delete($_GET['id_document_type']);
		} elseif ($action == 'edit') {
			$id = $_GET['id_document_type'];
		}
	}
?>