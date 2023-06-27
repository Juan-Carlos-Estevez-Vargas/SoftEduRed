<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acudiente</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	class UserAttendantDAO
	{
		private $pdo;

		/**
		 * Constructor for the class.
		 *
		 * @throws PDOException if unable to connect to database.
		 */
		public function __construct()
		{
				try {
						$this->pdo = database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a new attendant user, attendant, and assigns role to user.
		 *
		 * @param string $documentType The type of document.
		 * @param int $identificationNumber The user's identification number.
		 * @param string $firstName The user's first name.
		 * @param string $secondName The user's second name.
		 * @param string $surname The user's first last name.
		 * @param string $secondSurname The user's second last name.
		 * @param string $gender The user's gender.
		 * @param string $address The user's address.
		 * @param string $email The user's email.
		 * @param string $phone The user's phone number.
		 * @param string $username The user's username.
		 * @param string $password The user's password.
		 * @param string $securityQuestion The user's security question.
		 * @param string $securityAnswer The user's security answer.
		 * @param string $relationId The user's relationship with the attendant.
		 *
		 * @return void
		 */
		public function registerAttendantUser(
			string $documentType, int $identificationNumber, string $firstName, string $secondName,
			string $surname, string $secondSurname, string $gender, string $address, string $email,
			string $phone, string $username, string $password, string $securityQuestion,
			string $securityAnswer,	string $relationId
		): void {
				try {
						if (!empty($documentType) && !empty($identificationNumber) && !empty($firstName)
						&& !empty($surname)	&& !empty($gender) && !empty($email)
						&& !empty($username) && !empty($password) && !empty($securityAnswer)
						&& !empty($securityQuestion))
						{
								$sql = "
										INSERT INTO user(
												first_name,
												second_name,
												surname,
												second_surname,
												gender_id,
												address,
												email,
												phone,
												username,
												password,
												security_answer,
												document_type_id,
												security_question_id,
												identification_number)
										VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, UPPER(?), ?, ?, ?);
								";
								
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([
										$firstName, $secondName, $surname, $secondSurname,	$gender,
										$address, $email, $phone, $username, $password,
										$securityAnswer, $documentType, $securityQuestion, $identificationNumber
								]);
					
								$userId = $this->pdo->lastInsertId();

								$stmtAttendant = $this->pdo->prepare("
										INSERT INTO attendant (
												user_id,
												relationship_id)
										VALUES (?, ?)
								");
								$stmtAttendant->execute([$userId, $relationId]);

								$stmtRole = $this->pdo->prepare("
										INSERT INTO user_has_role (
												user_id,
												role_id,
												state)
										VALUES (?, 5, 1)
								");
								$stmtRole->execute([$userId]);
								
								$this->showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/user/userAttendantView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/user/userAttendantView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userAttendantView.php'
						);
				}
		}

		/**
		 * Updates the user and attendant data in the database.
		 *
		 * @param string $document The user's identification document.
		 * @param int $userId The user's id.
		 * @param string $firstName The user's first name.
		 * @param string $secondName The user's second name.
		 * @param string $firstLastName The user's first last name.
		 * @param string $secondLastName The user's second last name.
		 * @param string $gender The user's gender.
		 * @param string $address The user's address.
		 * @param string $email The user's email.
		 * @param string $phone The user's phone number.
		 * @param string $userName The user's username.
		 * @param string $password The user's password.
		 * @param string $securityAnswer The user's security answer.
		 * @param int $securityQuestion The user's security question.
		 * @param string $relationship The attendant's relationship to the user.
		 */
		public function updateAttendantUser(
			int $userId, string $idType, int $identificationNumber, string $firstName,
			string $secondName,	string $surname, string $secondSurname, string $gender,
			string $address, string $email,	string $phone, string $username, string $password,
			string $securityQuestion,	string $securityAnswer,	string $relationId
		) {
				try {
						if (!empty($idType) && !empty($identificationNumber) && !empty($firstName)
						&& !empty($surname)	&& !empty($gender) && !empty($email) && !empty($userId)
						&& !empty($username) && !empty($password) && !empty($securityAnswer)
						&& !empty($securityQuestion) && !empty($relationId))
						{
								$sqlUpdateUser = "
										UPDATE
												user
										SET
												first_name = ?,
												second_name = ?,
												surname = ?,
												second_surname = ?,
												gender_id = ?,
												address = ?,
												email = ?,
												phone = ?,
												username = ?,
												password = ?,
												security_answer = ?,
												document_type_id = ?,
												security_question_id = ?,
												identification_number = ?
										WHERE
												id_user = ?
								";
							
								// Update student information query
								$sqlUpdateStudent = "
										UPDATE
												attendant
										SET
												relationship_id = ?
										WHERE
												user_id = ?
								";
								
								// Execute queries
								$this->pdo->prepare($sqlUpdateUser)->execute([
										$firstName, $secondName, $surname, $secondSurname, $gender,
										$address,	$email, $phone, $username, $password, $securityAnswer,
										$idType, $securityQuestion,	$identificationNumber, $userId
								]);
							
								$this->pdo->prepare($sqlUpdateStudent)->execute([
										$relationId, $userId
								]);
								
								$this->showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/user/userAttendantView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/user/userAttendantView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userAttendantView.php'
						);
				}
		}

		/**
		 * Deletes an attendant user from the database.
		 *
		 * @param string $userId The user's ID.
		 * @return void
		 */
		public function deleteAttendantUser(string $userId): void {
				try {
						if (!empty($userId)) {
								$stmtRole = $this->pdo->prepare("
										DELETE FROM user_has_role
										WHERE user_id = :id_user
								");
								$stmtRole->execute(['id_user' => $userId]);
								
								$stmt = $this->pdo->prepare("
										DELETE FROM attendant
										WHERE user_id = :id_user
								");
								$stmt->execute(['id_user' => $userId]);
								
								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/user/userAttendantView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/user/userAttendantView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userAttendantView.php'
						);
				}
		}

		/**
		 * Displays a success message using SweetAlert and redirects the user to a specified location.
		 *
		 * @param string $message The success message to display
		 * @param string $redirectURL The URL to redirect to after displaying the message
		 */
		private function showSuccessMessage(string $message, string $redirectURL): void
		{
				echo "
						<script>
								Swal.fire({
										position: 'top-end',
										icon: 'success',
										title: '$message',
										showConfirmButton: false,
										timer: 2000
								}).then(() => {
										window.location = '$redirectURL';
								});
						</script>
				";
		}

		/**
		 * Displays an error message using SweetAlert and redirects the user to a specified location.
		 *
		 * @param string $message The error message to display
		 * @param string $redirectURL The URL to redirect to after displaying the message
		 */
		private function showErrorMessage(string $message, string $redirectURL): void
		{
				echo "
						<script>
								Swal.fire({
										position: 'top-center',
										icon: 'error',
										title: '$message',
										showConfirmButton: false,
										timer: 2000
								}).then(() => {
										window.location = '$redirectURL';
								});
						</script>
				";
		}

		/**
		 * Displays an warning message using SweetAlert and redirects the user to a specified location.
		 *
		 * @param string $message The error message to display
		 * @param string $redirectURL The URL to redirect to after displaying the message
		 */
		private function showWarningMessage(string $message, string $redirectURL): void
		{
				echo "
						<script>
								Swal.fire({
										position: 'top-center',
										icon: 'warning',
										title: '$message',
										showConfirmButton: false,
										timer: 2000
								}).then(() => {
										window.location = '$redirectURL';
								});
						</script>
				";
		}
	}
?>
</body>

</html>