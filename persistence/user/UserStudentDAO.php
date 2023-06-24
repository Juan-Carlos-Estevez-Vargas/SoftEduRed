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
		 * @param int $userId The identification number of the user.
		 * @param string $firstName The first name of the user.
		 * @param string $secondName The second name of the user.
		 * @param string $firstLastName The first last name of the user.
		 * @param string $secondLastName The second last name of the user.
		 * @param string $gender The gender of the user.
		 * @param string $address The address of the user.
		 * @param string $email The email of the user.
		 * @param string $phone The phone number of the user.
		 * @param string $username The username of the user.
		 * @param string $password The password of the user.
		 * @param string $securityAnswer The answer to the user's security question.
		 * @param string $securityQuestion The security question of the user.
		 * @param string $attendantIdType The type of identification document of the attendant.
		 * @param int $attendantId The identification number of the attendant.
		 * @param string $courseCode The code of the course the student is enrolled in.
		 * @return void
		 */
		public function registerUserAndStudent(
			string $idType, int $userId, string $firstName, string $secondName,	string $firstLastName,
			string $secondLastName, string $gender, string $address, string $email, string $phone,
			string $username, string $password, string $securityAnswer, string $securityQuestion,
			string $attendantIdType, int $attendantId, string $courseCode
		): void {
				try {
				    if (!empty($idType) && !empty($userId) && !empty($firstName) && !empty($firstLastName)
						&& !empty($gender) && !empty($email) && !empty($phone) && !empty($username) && !empty($password)
				    && !empty($securityAnswer) && !empty($securityQuestion) && !empty($attendantIdType)
				    && !empty($attendantId) && !empty($courseCode))
						{
								$stmt = $this->pdo->prepare("
										INSERT INTO user(
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
												`fk_s_question`)
										VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
								");
					
								$stmt->execute(
										[$idType, $userId, $firstName, $secondName, $firstLastName,
												$secondLastName, $gender, $address, $email, $phone, $username,
												$password, $securityAnswer, $securityQuestion
										]);

								$stmt = $this->pdo->prepare("
										INSERT INTO student (
												pk_fk_tdoc_user,
												pk_fk_user_id,
												fk_attendat_cod_doc,
												fk_attendant_id,
												fk_cod_course)
										VALUES (?, ?, ?, ?, ?)
								");
								$stmt->execute([$idType, $userId, $attendantIdType, $attendantId, $courseCode]);

								$stmt = $this->pdo->prepare("
										INSERT INTO user_has_role (tdoc_role, pk_fk_id_user, pk_fk_role, state)
										VALUES (?, ?, 'STUDENT', 1)
								");
								$stmt->execute([$idType, $userId]);
								
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
		 * @param string $documentType The document type of the user
		 * @param int $userId The user's ID
		 * @param string $firstName The user's first name
		 * @param string $secondName The user's second name
		 * @param string $firstLastName The user's first last name
		 * @param string $secondLastName The user's second last name
		 * @param string $gender The user's gender
		 * @param string $address The user's address
		 * @param string $email The user's email
		 * @param string $phone The user's phone number
		 * @param string $username The user's username
		 * @param string $pass The user's password
		 * @param string $securityAnswer The user's security answer
		 * @param string $securityQuestion The user's security question
		 * @param string $attendantDocument The document type of the attendant
		 * @param int $attendantId The ID of the attendant
		 * @param int $course The ID of the course
		 * @return void
		 */
		public function updateUserStudent(
			$documentType, $userId, $firstName, $secondName, $firstLastName, $secondLastName,
			$gender, $address, $email, $phone, $username, $pass, $securityAnswer,
			$securityQuestion, $attendantDocument, $attendantId, $course
		) {
				try {
						if (!empty($documentType) && !empty($userId) && !empty($firstName) && !empty($firstLastName)
						&& !empty($gender) && !empty($email) && !empty($phone) && !empty($username) && !empty($pass)
						&& !empty($securityAnswer) && !empty($securityQuestion) && !empty($attendantDocument)
						&& !empty($attendantId) && !empty($course))
						{
								$sqlUpdateUser = "
										UPDATE user
										SET first_name = ?,
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
							
								// Update student information query
								$sqlUpdateStudent = "
										UPDATE student
										SET fk_attendat_cod_doc = ?,
												fk_attendant_id = ?,
												fk_cod_course = ?
										WHERE pk_fk_tdoc_user = ?
												AND pk_fk_user_id = ?
								";
								
								// Execute queries
								$this->pdo->prepare($sqlUpdateUser)->execute([
										$firstName, $secondName, $firstLastName, $secondLastName, $gender, $address,
										$email, $phone, $username, $pass, $securityAnswer, $securityQuestion,
										$documentType, $userId
								]);
							
								$this->pdo->prepare($sqlUpdateStudent)->execute([
										$attendantDocument, $attendantId, $course, $documentType, $userId
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
		 * @param string $documentCode The document code.
		 * @return string A success message.
		 */
		public function deleteStudentUser($userId, $documentCode)
		{
				try {
					  if (!empty($userId) && !empty($documentCode)) {
								$stmt = $this->pdo->prepare("DELETE FROM user	WHERE id_user = :id_user AND pk_fk_cod_doc = :doc_code"
								);
								
								// Execute the SQL statement with the given parameters.
								$stmt->execute([
										'id_user' => $userId,
										'doc_code' => $documentCode
								]);
								
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