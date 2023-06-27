<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estudiante</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	class UserStudentDAO
	{

		/**
		 * Constructor method for the class.
		 * It initializes a database connection using the Database class.
		 *
		 * @throws PDOException if connection fails
		 */
		public function __construct() {
				try {
						$this->pdo = Database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a new user and student record in the database.
		 *
		 * @param string $idType The type of identification document.
		 * @param int $identificationNumber The identification number of the user.
		 * @param string $firstName The first name of the user.
		 * @param string $secondName The second name of the user.
		 * @param string $surname The first last name of the user.
		 * @param string $secondSurname The second last name of the user.
		 * @param string $gender The gender of the user.
		 * @param string $address The address of the user.
		 * @param string $email The email of the user.
		 * @param string $phone The phone number of the user.
		 * @param string $username The username of the user.
		 * @param string $password The password of the user.
		 * @param string $securityQuestion The security question of the user.
		 * @param string $securityAnswer The answer to the user's security question.
		 * @param string $attendantId The identification number of the attendant.
		 * @param int $courseId The ID of the course the student is enrolled in.
		 * @return void
		 */
		public function registerUserAndStudent(
			string $idType, int $identificationNumber, string $firstName, string $secondName,
			string $surname, string $secondSurname, string $gender, string $address, string $email,
			string $phone, string $username, string $password, string $securityQuestion,
			string $securityAnswer,	string $attendantId, int $courseId
		): void {
				try {
				    if (!empty($idType) && !empty($identificationNumber) && !empty($firstName)
						&& !empty($surname)	&& !empty($gender) && !empty($email)
						&& !empty($username) && !empty($password) && !empty($securityAnswer)
						&& !empty($securityQuestion) && !empty($attendantId) && !empty($courseId))
						{
								$stmt = $this->pdo->prepare("
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
								");
					
								$stmt->execute([
										$firstName, $secondName, $surname, $secondSurname,	$gender,
										$address, $email, $phone, $username, $password,
										$securityAnswer, $idType, $securityQuestion, $identificationNumber
								]);

								$userId = $this->pdo->lastInsertId();

								$stmt = $this->pdo->prepare("
										INSERT INTO student (
												user_id,
												attendant_id,
												course_id)
										VALUES (?, ?, ?)
								");
								$stmt->execute([$userId, $attendantId, $courseId]);

								$stmt = $this->pdo->prepare("
										INSERT INTO user_has_role (
												user_id,
												role_id,
												state)
										VALUES (?, 2, 1)
								");
								$stmt->execute([$userId]);
								
								$this->showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/user/userStudentView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/user/userStudentView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userStudentView.php'
						);
				}
		}

		/**
		 * Updates user and student information in the database
		 *
		 * @param int $userId The user's ID
		 * @param string $idType The document type of the user
		 * @param int $identificationNumber The user's identification number
		 * @param string $firstName The user's first name
		 * @param string $secondName The user's second name
		 * @param string $surname The user's surname
		 * @param string $secondSurname The user's second surname
		 * @param string $gender The user's gender
		 * @param string $address The user's address
		 * @param string $email The user's email
		 * @param string $phone The user's phone number
		 * @param string $username The user's username
		 * @param string $password The user's password
		 * @param string $securityQuestion The user's security question
		 * @param string $securityAnswer The user's security answer
		 * @param string $attendantId The ID of the attendant
		 * @param int $courseId The ID of the course
		 * @return void
		 */
		public function updateUserStudent(
			int $userId, string $idType, int $identificationNumber, string $firstName,
			string $secondName,	string $surname, string $secondSurname, string $gender,
			string $address, string $email,	string $phone, string $username, string $password,
			string $securityQuestion,	string $securityAnswer,	string $attendantId, int $courseId
		) {
				try {
						if (!empty($idType) && !empty($identificationNumber) && !empty($firstName)
						&& !empty($surname)	&& !empty($gender) && !empty($email) && !empty($userId)
						&& !empty($username) && !empty($password) && !empty($securityAnswer)
						&& !empty($securityQuestion) && !empty($attendantId) && !empty($courseId))
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
												student
										SET
												attendant_id = ?,
												course_id = ?
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
										$attendantId, $courseId, $userId
								]);
								
								$this->showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/user/userStudentView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/user/userStudentView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userStudentView.php'
						);
				}
		}

		/**
		 * Delete a user record based on their ID and document code.
		 *
		 * @param int $userId The user's ID.
		 * @return string A success message.
		 */
		public function deleteStudentUser($userId)
		{
				try {
					  if (!empty($userId)) {
								$stmtRole = $this->pdo->prepare("
										DELETE FROM user_has_role
										WHERE user_id = :id_user
								");
								$stmtRole->execute(['id_user' => $userId]);
								
								$stmt = $this->pdo->prepare("
										DELETE FROM student
										WHERE user_id = :id_user
								");
								$stmt->execute(['id_user' => $userId]);
								
								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/user/userStudentView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/user/userStudentView.php'
								);
						}
				} catch (Exception $e) {
					echo $e->getMessage();
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userStudentView.php'
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