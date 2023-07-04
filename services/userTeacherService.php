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
	require_once '../utils/Message.php';
	require_once '../persistence/UserDAO.php';
	require_once '../persistence/UserTeacherDAO.php';
		
	class UserTeacherService
	{
		/**
		 * Constructor for creating a database connection.
		 *
		 * @throws PDOException if connection to database fails.
		 */
		public function __construct()
		{
				try {
						$this->teacher = new UserTeacherDAO();
				} catch (PDOException $e) {
						throw new PDOException("Failed to connect to database: " . $e->getMessage());
				}
		}

		/**
		 * Registers a new user with the provided information.
		 *
		 * @param string $documentType - Primary key of the document type.
		 * @param int $identificationNumber - User's identification number.
		 * @param string $firstName - User's first name.
		 * @param string $secondName - User's second name.
		 * @param string $surname - User's first last name.
		 * @param string $secondSurname - User's second last name.
		 * @param string $gender - User's gender.
		 * @param string $address - User's address.
		 * @param string $email - User's email.
		 * @param string $phone - User's phone number.
		 * @param string $username - User's username.
		 * @param string $password - User's password.
		 * @param string $securityQuestion - User's security question.
		 * @param string $securityAnswer - User's security answer.
		 * @param string $salary - User's salary.
		 *
		 * @return void.
		 */
		public function register(
			string $documentType, int $identificationNumber, string $firstName, string $secondName,
			string $surname, string $secondSurname, string $gender, string $address, string $email,
			string $phone, string $username, string $password, string $securityQuestion,
			string $securityAnswer,	string $salary
		): void {
				try {
						if (!empty($documentType) && !empty($identificationNumber) && !empty($firstName)
						&& !empty($surname)	&& !empty($gender) && !empty($email)
						&& !empty($username) && !empty($password) && !empty($securityAnswer)
						&& !empty($securityQuestion))
						{
								if (Message::isRegistered(Database::connect(), 'user', 'identification_number', $identificationNumber, false, null)) {
										Utils::showErrorMessage(
												"El número de identificación ingresado ya se encuentra registrado en la plataforma",
												'../../views/userStudentView.php'
										);
										return;
								}

								if (Message::isRegistered(Database::connect(), 'user', 'email', $email, false, null)) {
										Utils::showErrorMessage(
												"El correo electrónico ingresado ya se encuentra registrado en la plataforma.",
												'../../views/userStudentView.php'
										);
										return;
								}

								if (!empty($phone) && Message::isRegistered(Database::connect(), 'user', 'phone', $phone, false, null)) {
										Utils::showErrorMessage(
												"El teléfono ingresado ya se encuentra registrado en la plataforma.",
												'../../views/userStudentView.php'
										);
										return;
								}

								if (Message::isRegistered(Database::connect(), 'user', 'username', $username, false, null)) {
										Utils::showErrorMessage(
												"El usuario ingresado ya se encuentra registrado en la plataforma.",
												'../../views/userStudentView.php'
										);
										return;
								}
                
								$this->teacher->register(
                    $documentType, $identificationNumber, $firstName,
                    $secondName, $surname, $secondSurname, $gender,
                    $address, $email, $phone, $username, $password,
                    $securityQuestion, $securityAnswer, $salary
                );

								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/userTeacherView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/userTeacherView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/userTeacherView.php'
						);
				}
		}

		/**
		 * Updates teacher information based on user ID and document type.
		 *
		 * @param string $idType User's document type.
		 * @param int $identificationNumber User's identification number.
		 * @param string $firstName User's first name.
		 * @param string $secondName User's second name.
		 * @param string $surname User's surname.
		 * @param string $secondSurname User's second surname.
		 * @param string $gender User's gender.
		 * @param string $address User's address.
		 * @param string $email User's email.
		 * @param string $phone User's phone number.
		 * @param string $username User's username.
		 * @param string $password User's password.
		 * @param string $securityQuestion User's security question.
		 * @param string $securityAnswer User's answer to security question.
		 * @param string $salary Teacher's salary.
		 *
		 * @return void
		 */
		public function update(
			int $userId, string $idType, int $identificationNumber, string $firstName,
			string $secondName,	string $surname, string $secondSurname, string $gender,
			string $address, string $email,	string $phone, string $username, string $password,
			string $securityQuestion,	string $securityAnswer, string $salary
		) {
				try {
						if (!empty($idType) && !empty($identificationNumber) && !empty($firstName)
						&& !empty($surname)	&& !empty($gender) && !empty($email) && !empty($userId)
						&& !empty($username) && !empty($password) && !empty($securityAnswer)
						&& !empty($securityQuestion) && !empty($salary))
						{
								if (Message::isRegistered(Database::connect(), 'user', 'identification_number', $identificationNumber, true, $userId, 'id_user')) {
										Message::showErrorMessage(
												"El número de identificación ingresado ya se encuentra registrado en la plataforma",
												'../../views/userStudentView.php'
										);
										return;
								}

								if (Message::isRegistered(Database::connect(), 'user', 'email', $email, true, $userId, 'id_user')) {
										Message::showErrorMessage(
												"El correo electrónico ingresado ya se encuentra registrado en la plataforma.",
												'../../views/userStudentView.php'
										);
										return;
								}

								if (!empty($phone) && Message::isRegistered(Database::connect(), 'user', 'phone', $phone, true, $userId, 'id_user')) {
										Message::showErrorMessage(
												"El teléfono ingresado ya se encuentra registrado en la plataforma.",
												'../../views/userStudentView.php'
										);
										return;
								}

								if (Message::isRegistered(Database::connect(), 'user', 'username', $username, true, $userId, 'id_user')) {
										Message::showErrorMessage(
												"El usuario ingresado ya se encuentra registrado en la plataforma.",
												'../../views/userStudentView.php'
										);
										return;
								}

								$this->teacher->update(
                    $userId, $idType, $identificationNumber, $firstName, $secondName,
                    $surname, $secondSurname, $gender, $address, $email, $phone,
                    $username, $password, $securityQuestion, $securityAnswer, $salary
								);
			
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/userTeacherView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/userTeacherView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/userTeacherView.php'
						);
				}
		}

		/**
		 * Deletes a user from the database with the given id and document type.
		 *
		 * @param int $userId the id of the user to be deleted
		 * @throws PDOException if there was an error executing the SQL query
		 * @return void
		 */
		public function delete(int $userId): void
		{
				try {
						if (!empty($userId)) {
                $this->teacher->delete($userId);
								
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/userTeacherView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/userTeacherView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/userTeacherView.php'
						);
				}
		}
	}
?>
</body>

</html>