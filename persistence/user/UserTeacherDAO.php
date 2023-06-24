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
			$documentType, $userId, $firstName, $secondName, $firstLastName, $secondLastName, $gender,
			$address, $email, $phone, $username, $pass, $securityAnswer, $securityQuestion
		) {
				try {
						if (!empty($documentType) && !empty($userId) && !empty($firstName)
								&& !empty($firstLastName) && !empty($gender) && !empty($email)
								&& !empty($username) && !empty($pass)	&& !empty($securityAnswer)
								&& !empty($securityQuestion))
								{
										$sql = "
												INSERT INTO user (
														pk_fk_cod_doc,
														id_user,
														first_name,
														second_name,
														surname,
														second_surname,
														`fk_gender`,
														adress,
														email,
														phone,
														user_name,
														pass,
														security_answer,
														fk_s_question`
												) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
										";
										
										$stmt = $this->pdo->prepare($sql);
										$stmt->execute([
												$documentType, $userId, $firstName,	$secondName, $firstLastName,
												$secondLastName, $gender,	$address,	$email,	$phone, $username,
												$pass,	$securityAnswer, $securityQuestion
										]);
							
										$this->registerTeacher($documentType, $userId);
										$this->registerUserAsTeacherRole($documentType, $userId);
										
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
		 * Registers a teacher with the given document number and user ID.
		 *
		 * @param string $documentNumber The document number of the teacher.
		 * @param int $userId The user ID of the teacher.
		 */
		private function registerTeacher(string $documentNumber, int $userId): void
		{
				try {
						if (!empty($documentNumber) && !empty($userId)) {
								$query = "
										INSERT INTO teacher (user_pk_fk_cod_doc, user_id_user)
										VALUES (?, ?)
								";
								$stmt = $this->pdo->prepare($query);
								$stmt->execute([$documentNumber, $userId]);
								
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
		 * Registers a user as a teacher role in the database.
		 *
		 * @param string $documentType The type of document for the user.
		 * @param int $userId The ID of the user to register.
		 *
		 * @return void
		 */
		private function registerUserAsTeacherRole(string $documentType, int $userId): void
		{
				$sql = "
						INSERT INTO user_has_role (tdoc_role, pk_fk_id_user, pk_fk_role, state)
						VALUES (:documentType, :userId, 'TEACHER', 1)
				";
				
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindValue(':documentType', $documentType);
				$stmt->bindValue(':userId', $userId);
				$stmt->execute();
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