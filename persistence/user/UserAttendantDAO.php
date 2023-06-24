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
		 * @param string $userId The user's ID.
		 * @param string $firstName The user's first name.
		 * @param string $secondName The user's second name.
		 * @param string $firstLastName The user's first last name.
		 * @param string $secondLastName The user's second last name.
		 * @param string $gender The user's gender.
		 * @param string $address The user's address.
		 * @param string $email The user's email.
		 * @param string $phone The user's phone number.
		 * @param string $username The user's username.
		 * @param string $password The user's password.
		 * @param string $securityAnswer The user's security answer.
		 * @param string $securityQuestion The user's security question.
		 * @param string $relation The user's relationship with the attendant.
		 *
		 * @return void
		 */
		public function registerAttendantUser(
			string $documentType, string $userId, string $firstName, string $secondName,
			string $firstLastName, string $secondLastName, string $gender, string $address,
			string $email, string $phone, string $username, string $password,
			string $securityAnswer, string $securityQuestion,	string $relation
		): void {
				try {
						if (!empty($documentType) && !empty($userId) && !empty($firstName)
								&& !empty($firstLastName) && !empty($gender) && !empty($email)
								&& !empty($username) && !empty($pass)	&& !empty($securityAnswer)
								&& !empty($securityQuestion))
						{
								$insertUserSql = "
										INSERT INTO user (
												pk_fk_cod_doc,
												id_user,
												first_name,
												second_name,
												surname,
												second_surname,
												fk_gender,
												adress,
												email,
												phone,
												user_name,
												pass,
												security_answer,
												fk_s_question)
										VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
								";

								$this->pdo->prepare($insertUserSql)->execute([
										$documentType, $userId, $firstName, $secondName,
										$firstLastName, $secondLastName, $gender, $address,
										$email, $phone, $username, $password, $securityAnswer,
										$securityQuestion
								]);
					
								$insertAttendantSql = "
										INSERT INTO attendant (
												user_pk_fk_cod_doc,
												user_id_user,
												fk_relationship)
										VALUES (?, ?, ?)
								";
								$this->pdo->prepare($insertAttendantSql)->execute([$documentType, $userId, $relation]);
					
								$assignRoleSql = "
										INSERT INTO user_has_role (
												tdoc_role,
												pk_fk_id_user,
												pk_fk_role, state)
										VALUES (?, ?, 'ATTENDANT', 1)
								";
								$this->pdo->prepare($assignRoleSql)->execute([$documentType, $userId]);
								
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
			$document, $userId, $firstName, $secondName, $firstLastName, $secondLastName,
			$gender, $address, $email, $phone, $userName, $password, $securityAnswer,
			$securityQuestion, $relationship
		) {
				try {
						if (!empty($document) && !empty($userId) && !empty($firstName)
								&& !empty($firstLastName) && !empty($gender) && !empty($email)
								&& !empty($userName) && !empty($password)	&& !empty($securityAnswer)
								&& !empty($securityQuestion))
						{
								// Update the user's data in the database.
								$sql = "
										UPDATE user
										SET	first_name = ?,
												second_name = ?,
												surname = ?,
												second_surname = ?,
												fk_gender = ?,
												adress = ?,
												email = ?,
												phone = ?,
												user_name = ?,
												pass = ?,
												security_answer = ?,
												fk_s_question = ?
										WHERE pk_fk_cod_doc = ?
												AND id_user = ?
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([
										$firstName, $secondName, $firstLastName, $secondLastName,
										$gender, $address, $email, $phone, $userName, $password,
										$securityAnswer, $securityQuestion, $document, $userId
								]);

								// Update the attendant's data in the database.
								$sql2 = "
										UPDATE attendant
										SET fk_relationship = ?
										WHERE user_pk_fk_cod_doc = ?
												AND user_id_user = ?
								";
								$stmt2 = $this->pdo->prepare($sql2);
								$stmt2->execute([$relationship, $document, $userId]);
								
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
		 * @param string $documentCode The user's document code.
		 * @return void
		 */
		public function deleteAttendantUser(string $userId, string $documentCode): void {
				try {
						if (!empty($userId) && !empty($documentCode)) {
								$sql = "
										DELETE FROM user
										WHERE id_user = ?
												AND pk_fk_cod_doc = ?
								";
								$statement = $this->pdo->prepare($sql);
								$statement->execute([$userId, $documentCode]);
								
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