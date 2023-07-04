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
  require_once '../utils/Message.php';
  require_once '../persistence/UserStudentDAO.php';
	
	class UserStudentService
	{

		/**
		 * Constructor method for the class.
		 * It initializes a database connection using the Database class.
		 *
		 * @throws PDOException if connection fails
		 */
		public function __construct() {
				try {
						$this->student = new UserStudentDAO();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a user and a student.
		 *
		 * @param string $idType The type of identification.
		 * @param int $identificationNumber The identification number.
		 * @param string $firstName The first name.
		 * @param string $secondName The second name.
		 * @param string $surname The surname.
		 * @param string $secondSurname The second surname.
		 * @param string $gender The gender.
		 * @param string $address The address.
		 * @param string $email The email.
		 * @param string $phone The phone number.
		 * @param string $username The username.
		 * @param string $password The password.
		 * @param string $securityQuestion The security question.
		 * @param string $securityAnswer The security answer.
		 * @param string $attendantId The attendant ID.
		 * @param int $courseId The course ID.
		 *
		 * @return void
		 */
		public function register(
			string $idType,
			int $identificationNumber,
			string $firstName,
			string $secondName,
			string $surname,
			string $secondSurname,
			string $gender,
			string $address,
			string $email,
			string $phone,
			string $username,
			string $password,
			string $securityQuestion,
			string $securityAnswer,
			string $attendantId,
			int $courseId
		): void {
				try {
						if (!empty($idType) && !empty($identificationNumber) && !empty($firstName) && !empty($surname)
            && !empty($gender) && !empty($email) && !empty($username) && !empty($password) && !empty($securityAnswer)
            && !empty($securityQuestion) && !empty($attendantId) && !empty($courseId))
            {
								if (Message::isRegistered($this->pdo, 'identification_number', $identificationNumber, false, null)) {
										Utils::showErrorMessage(
												"El número de identificación ingresado ya se encuentra registrado en la plataforma",
												'../../views/user/userStudentView.php'
										);
										return;
								}
		
								if (Message::isRegistered($this->pdo, 'email', $email, false, null)) {
										Utils::showErrorMessage(
												"El correo electrónico ingresado ya se encuentra registrado en la plataforma.",
												'../../views/user/userStudentView.php'
										);
										return;
								}
		
								if (!empty($phone) && Message::isRegistered($this->pdo, 'phone', $phone, false, null)) {
										Utils::showErrorMessage(
												"El teléfono ingresado ya se encuentra registrado en la plataforma.",
												'../../views/user/userStudentView.php'
										);
										return;
								}
		
								if (Message::isRegistered($this->pdo, 'username', $username, false, null)) {
										Utils::showErrorMessage(
												"El usuario ingresado ya se encuentra registrado en la plataforma.",
												'../../views/user/userStudentView.php'
										);
										return;
								}
		
								$this->student->register(
										$idType, $identificationNumber, $firstName, $secondName, $surname,
										$secondSurname, $gender, $address, $email, $phone, $username, $password, $securityQuestion,
										$securityAnswer, $this->pdo
								);
			
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/user/userStudentView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/user/userStudentView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userStudentView.php'
						);
				}
		}
	
		/**
		 * Updates a user's student information.
		 *
		 * @param int $userId - The ID of the user.
		 * @param string $idType - The type of identification.
		 * @param int $identificationNumber - The identification number.
		 * @param string $firstName - The first name.
		 * @param string $secondName - The second name.
		 * @param string $surname - The surname.
		 * @param string $secondSurname - The second surname.
		 * @param string $gender - The gender.
		 * @param string $address - The address.
		 * @param string $email - The email.
		 * @param string $phone - The phone number.
		 * @param string $username - The username.
		 * @param string $password - The password.
		 * @param string $securityQuestion - The security question.
		 * @param string $securityAnswer - The security answer.
		 * @param string $attendantId - The attendant ID.
		 * @param int $courseId - The course ID.
		 * @return void
		 */
		public function updateUserStudent(
			int $userId,
			string $idType,
			int $identificationNumber,
			string $firstName,
			string $secondName,
			string $surname,
			string $secondSurname,
			string $gender,
			string $address,
			string $email,
			string $phone,
			string $username,
			string $password,
			string $securityQuestion,
			string $securityAnswer,
			string $attendantId,
			int $courseId
		) {
			try {
					if (!empty($idType) && !empty($identificationNumber) && !empty($firstName)
					&& !empty($surname)	&& !empty($gender) && !empty($email) && !empty($userId)
					&& !empty($username) && !empty($password) && !empty($securityAnswer)
					&& !empty($securityQuestion) && !empty($attendantId) && !empty($courseId))
					{
							if (Message::isRegistered($this->pdo, 'identification_number', $identificationNumber, true, $userId)) {
									Message::showErrorMessage(
											"El número de identificación ingresado ya se encuentra registrado en la plataforma",
											'../../views/user/userStudentView.php'
									);
									return;
							}
	
							if (Message::isRegistered($this->pdo, 'email', $email, true, $userId)) {
									Message::showErrorMessage(
											"El correo electrónico ingresado ya se encuentra registrado en la plataforma.",
											'../../views/user/userStudentView.php'
									);
									return;
							}
	
							if (!empty($phone) && Message::isRegistered($this->pdo, 'phone', $phone, true, $userId)) {
									Message::showErrorMessage(
											"El teléfono ingresado ya se encuentra registrado en la plataforma.",
											'../../views/user/userStudentView.php'
									);
									return;
							}
	
							if (Message::isRegistered($this->pdo, 'username', $username, true, $userId)) {
									Message::showErrorMessage(
											"El usuario ingresado ya se encuentra registrado en la plataforma.",
											'../../views/user/userStudentView.php'
									);
									return;
							}

							User::updateUser(
									$firstName,	$secondName, $surname, $secondSurname,
									$gender, $address, $email, $phone, $username,
									$password,	$securityAnswer, $idType, $securityQuestion,
									$identificationNumber, $userId, $this->pdo
							);
		
							$this->updateStudent($attendantId, $courseId,	$userId);
	
							Message::showSuccessMessage(
									"Registro Actualizado Exitosamente.",
									'../../views/user/userStudentView.php'
							);
					} else {
							Message::showWarningMessage(
									"Debes llenar todos los campos.",
									'../../views/user/userStudentView.php'
							);
					}
			} catch (Exception $e) {
				echo $e->getMessage();
					Message::showErrorMessage(
							"Ocurrió un error interno. Consulta al Administrador.",
							'../../views/user/userStudentView.php'
					);
			}
		}
	
		/**
		 * Deletes a student user.
		 *
		 * @param int $userId The ID of the user to delete.
		 * @throws Exception If an error occurs during the deletion process.
		 */
		public function delete($userId)
		{
				try {
						if (!empty($userId)) {
								$stmtRole = $this->pdo->prepare("
										DELETE FROM user_has_role
										WHERE user_id = :id_user
								");
								$stmtRole->execute(['id_user' => $userId]);
		
								$stmt = $this->pdo->prepare("
										UPDATE student
										SET state = 3
										WHERE user_id = :id_user
								");
								$stmt->execute(['id_user' => $userId]);
		
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/user/userStudentView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/user/userStudentView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userStudentView.php'
						);
				}
		}
	}
?>
</body>

</html>