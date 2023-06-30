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
  require_once '../../utils/Message.php';
  require_once '../../utils/User.php';
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

		public function registerUserAndStudent(
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
						if (User::validateUserFields(
								$idType,
								$identificationNumber,
								$firstName,
								$surname,
								$gender,
								$email,
								$username,
								$password,
								$securityAnswer,
								$securityQuestion,
								$attendantId,
								$courseId
						)) {
								if (Message::isRegistered($this->pdo, 'identification_number', $identificationNumber)) {
										Utils::showErrorMessage(
												"El número de identificación ingresado ya se encuentra registrado en la plataforma",
												'../../views/user/userStudentView.php'
										);
										return;
								}
		
								if (Message::isRegistered($this->pdo, 'email', $email)) {
										Utils::showErrorMessage(
												"El correo electrónico ingresado ya se encuentra registrado en la plataforma.",
												'../../views/user/userStudentView.php'
										);
										return;
								}
		
								if (!empty($phone) && Message::isRegistered($this->pdo, 'phone', $phone)) {
										Utils::showErrorMessage(
												"El teléfono ingresado ya se encuentra registrado en la plataforma.",
												'../../views/user/userStudentView.php'
										);
										return;
								}
		
								if (Message::isRegistered($this->pdo, 'username', $username)) {
										Utils::showErrorMessage(
												"El usuario ingresado ya se encuentra registrado en la plataforma.",
												'../../views/user/userStudentView.php'
										);
										return;
								}
		
								$userId = User::createUser(
										$idType, $identificationNumber, $firstName, $secondName, $surname,
										$secondSurname, $gender, $address, $email, $phone, $username, $password, $securityQuestion,
										$securityAnswer, $this->pdo
								);
		
								$this->createStudent($userId, $attendantId, $courseId);
								$this->assignUserRole($userId);
		
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
						echo "Error: " . $e->getMessage();
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userStudentView.php'
						);
				}
		}
	

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
					// if (User::validateUserFields([
					// 		$idType,
					// 		$identificationNumber,
					// 		$firstName,
					// 		$surname,
					// 		$gender,
					// 		$email,
					// 		$userId,
					// 		$username,
					// 		$password,
					// 		$securityAnswer,
					// 		$securityQuestion,
					// 		$attendantId,
					// 		$courseId
					// ])) {
							if (Message::isRegistered($this->pdo, 'identification_number', $identificationNumber)) {
									$this->showErrorMessage(
											"El número de identificación ingresado ya se encuentra registrado en la plataforma",
											'../../views/user/userStudentView.php'
									);
									return;
							}
	
							if (Message::isRegistered($this->pdo, 'email', $email)) {
									$this->showErrorMessage(
											"El correo electrónico ingresado ya se encuentra registrado en la plataforma.",
											'../../views/user/userStudentView.php'
									);
									return;
							}
	
							if (!empty($phone) && Message::isRegistered($this->pdo, 'phone', $phone)) {
									$this->showErrorMessage(
											"El teléfono ingresado ya se encuentra registrado en la plataforma.",
											'../../views/user/userStudentView.php'
									);
									return;
							}
	
							if (Message::isRegistered($this->pdo, 'username', $username)) {
									$this->showErrorMessage(
											"El usuario ingresado ya se encuentra registrado en la plataforma.",
											'../../views/user/userStudentView.php'
									);
									return;
							}

							User::updateUser(
									$firstName,	$secondName, $surname,
									$secondSurname,	$gender, $address, $email, $phone,
									$username, $password,	$securityAnswer, $idType,
									$securityQuestion, $identificationNumber,	$userId
							);
		
							$this->updateStudent($attendantId, $courseId,	$userId);
	
							Message::showSuccessMessage(
									"Registro Actualizado Exitosamente.",
									'../../views/user/userStudentView.php'
							);
					// } else {
					// 		Message::showWarningMessage(
					// 				"Debes llenar todos los campos.",
					// 				'../../views/user/userStudentView.php'
					// 		);
					// }
			} catch (Exception $e) {
					Message::showErrorMessage(
							"Ocurrió un error interno. Consulta al Administrador.",
							'../../views/user/userStudentView.php'
					);
			}
	}
	
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
		
		private function createStudent(int $userId, string $attendantId, int $courseId): void {
				$stmt = $this->pdo->prepare("
						INSERT INTO student (user_id, attendant_id, course_id, state)
						VALUES (?, ?, ?, 1)
				");
				$stmt->execute([$userId, $attendantId, $courseId]);
		}
		
		private function assignUserRole(int $userId): void {
				$stmt = $this->pdo->prepare("
						INSERT INTO user_has_role (user_id, role_id, state)
						VALUES (?, 2, 1)
				");
				$stmt->execute([$userId]);
		}
	}
?>
</body>

</html>