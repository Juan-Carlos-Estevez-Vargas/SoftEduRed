<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profesor</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	class UserTeacher
	{
		/**
		 * Constructor for creating a database connection.
		 *
		 * @throws PDOException if connection to database fails.
		 */
		public function __construct()
		{
				try {
						$this->pdo = Database::connect();
				} catch (PDOException $e) {
						throw new PDOException("Failed to connect to database: " . $e->getMessage());
				}
		}

		/**
		 * Registers a new user with the provided information
		 *
		 * @param string $documentType - Primary key of the document type
		 * @param string $userId - User's ID
		 * @param string $firstName - User's first name
		 * @param string $secondName - User's second name
		 * @param string $firstLastName - User's first last name
		 * @param string $secondLastName - User's second last name
		 * @param string $gender - User's gender
		 * @param string $address - User's address
		 * @param string $email - User's email
		 * @param string $phone - User's phone number
		 * @param string $username - User's username
		 * @param string $pass - User's password
		 * @param string $securityAnswer - User's security answer
		 * @param string $securityQuestion - User's security question
		 *
		 * @return void
		 */
		public function register(
			string $documentType, int $identificationNumber, string $firstName, string $secondName,
			string $surname, string $secondSurname, string $gender, string $address, string $email,
			string $phone, string $username, string $password, string $securityQuestion,
			string $securityAnswer,	string $relationId) {
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
												relationship_id
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
										'../../views/user/userTeacherView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/user/userTeacherView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userTeacherView.php'
						);
				}
		}

		/**
		 * Updates user information based on user ID and document type.
		 *
		 * @param string $documentType User's document type.
		 * @param int $userId User's ID.
		 * @param string $firstName User's first name.
		 * @param string $secondName User's second name.
		 * @param string $firstLastName User's first last name.
		 * @param string $secondLastName User's second last name.
		 * @param string $gender User's gender.
		 * @param string $address User's address.
		 * @param string $email User's email.
		 * @param string $phone User's phone number.
		 * @param string $username User's username.
		 * @param string $password User's password.
		 * @param string $securityAnswer User's answer to security question.
		 * @param string $securityQuestion User's security question.
		 *
		 * @return string Success message.
		 */
		public function updateUserTeacherInformation(
			$documentType, $userId, $firstName,	$secondName, $firstLastName, $secondLastName,
			$gender, $address, $email, $phone, $username,	$password, $securityAnswer,	$securityQuestion
		) {
				try {
						if (!empty($documentType) && !empty($userId) && !empty($firstName)
							&& !empty($firstLastName) && !empty($gender) && !empty($email)
							&& !empty($username) && !empty($password) && !empty($securityAnswer)
							&& !empty($securityQuestion))
							{
									$updateUserQuery = "
											UPDATE user SET
													first_name = ?,
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

									$statement = $this->pdo->prepare($updateUserQuery);
									$statement->execute([
											$firstName,	$secondName, $firstLastName, $secondLastName,	$gender,
											$address, $email, $phone,	$username, $password,	$securityAnswer,
											$securityQuestion, $documentType,	$userId,
									]);
									
									$this->showSuccessMessage(
											"Registro Actualizado Exitosamente.",
											'../../views/user/userTeacherView.php'
									);
							} else {
									$this->showWarningMessage(
											"Debes llenar todos los campos.",
											'../../views/user/userTeacherView.php'
									);
							}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userTeacherView.php'
						);
				}
		}

		/**
		 * Deletes a user from the database with the given id and document type.
		 *
		 * @param int $userId the id of the user to be deleted
		 * @param string $docType the document type of the user to be deleted
		 * @throws PDOException if there was an error executing the SQL query
		 * @return void
		 */
		public function deleteUserTeacher(int $userId, string $docType): void
		{
				try {
						if (!empty($userId) && !empty($docType)) {
								$sql = "
										DELETE FROM user
										WHERE id_user = ?
												AND pk_fk_cod_doc = ?
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([$userId, $docType]);
								
								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/user/userTeacherView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/user/userTeacherView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userTeacherView.php'
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