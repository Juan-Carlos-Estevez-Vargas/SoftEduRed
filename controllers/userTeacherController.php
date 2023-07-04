<?php
	require_once "../persistence/database/Database.php";
	require_once "../services/userTeacherService.php";

	$db = database::connect();

	if (isset($_REQUEST['action'])) {
		$action = $_REQUEST['action'];

		if ($action === 'update') {
        $update = new userTeacherService();
        $update->update(
            $_POST['id_user'], $_POST['document_type'], $_POST['identification_number'],
            $_POST['first_name'], $_POST['second_name'], $_POST['surname'],
            $_POST['second_surname'], $_POST['gender'], $_POST['address'],
            $_POST['email'], $_POST['phone'], $_POST['username'], $_POST['password'],
            $_POST['security_question'], $_POST['answer'], $_POST['salary']
        );
		} elseif ($action === 'register') {
        $insert = new userTeacherService();
        $insert->register(
            $_POST['document_type'], $_POST['identification_number'],
            $_POST['first_name'], $_POST['second_name'], $_POST['surname'],
            $_POST['second_surname'], $_POST['gender'], $_POST['address'],
            $_POST['email'], $_POST['phone'], $_POST['username'], $_POST['password'],
            $_POST['security_question'], $_POST['answer'], $_POST['salary']
        );
		} elseif ($action === 'delete') {
			  $delete = new userTeacherService();
			  $delete->delete($_GET['id_user']);
		} elseif ($action === 'edit') {
        $id = $_GET['id_user'];
    }
	}
?>