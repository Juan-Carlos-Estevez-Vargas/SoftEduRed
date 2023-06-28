<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuario</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	class UserCrudDAO
	{
		private $pdo;

		/**
		 * Constructor function that creates a PDO instance to connect to the database.
		 * @throws PDOException if connection to database fails.
		 */
		public function __construct() {
				try {
						$this->pdo = Database::connect();
				}
				catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Updates user information in the database.
		 *
		 * @param string $documentType The user's document type.
		 * @param int $userId The user's ID.
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
		 *
		 * @return void
		 */
		public function updateUser(
			$userId,
			$documentType,
			$identificationNumber,
			$firstName,
			$secondName,
			$surname,
			$secondSurname,
			$gender,
			$phone,
			$address,
			$email,
			$username,
			$password,
			$securityQuestion,
			$securityAnswer
	) {
			try {
					if (!empty($documentType) && !empty($userId) && !empty($firstName)
						&& !empty($surname) && !empty($gender) && !empty($email)
						&& !empty($username) && !empty($password) && !empty($securityAnswer)
						&& !empty($securityQuestion) && !empty($identificationNumber))
					{
							$sql = "
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
			
							$statement = $this->pdo->prepare($sql);
							$statement->execute([
									$firstName,
									$secondName,
									$surname,
									$secondSurname,
									$gender,
									$address,
									$email,
									$phone,
									$username,
									$password,
									$securityAnswer,
									$documentType,
									$securityQuestion,
									$identificationNumber,
									$userId
							]);
			
							$this->showSuccessMessage(
									"Registro Actualizado Exitosamente.",
									'userInformation.php'
							);
					} else {
							$this->showWarningMessage(
									"Debes llenar todos los campos.",
									'userInformation.php'
							);
					}
			} catch (Exception $e) {
					$this->showErrorMessage(
							"Ocurrió un error interno. Consulta al Administrador.",
							'userInformation.php'
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