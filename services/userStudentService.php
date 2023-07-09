<?php
  require_once '../utils/Message.php';
  require_once '../persistence/UserStudentDAO.php';
  require_once '../persistence/database/Database.php';
	
	class UserStudentService
	{

		/**
		 * Constructor method for the class.
		 * It initializes a database connection using the UserStudentDAO class.
		 *
		 * @throws Exception if connection fails
		 */
		public function __construct() {
				try {
						$this->student = new UserStudentDAO();
				} catch (Exception $e) {
						throw new Exception($e->getMessage());
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
		
								$this->student->register(
										$idType, $identificationNumber, $firstName, $secondName, $surname,
										$secondSurname, $gender, $address, $email, $phone, $username,
										$password, $securityQuestion,	$securityAnswer, $attendantId, $courseId
								);
			
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/userStudentView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/userStudentView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/userStudentView.php'
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
		public function update(
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
							
							$this->student->update(
									$userId, $idType, $identificationNumber, $firstName,$secondName,
									$surname, $secondSurname,	$gender, $address, $email, $phone, $username,
									$password, $securityQuestion,	$securityAnswer, $attendantId, $courseId
							);
	
							Message::showSuccessMessage(
									"Registro Actualizado Exitosamente.",
									'../../views/userStudentView.php'
							);
					} else {
							Message::showWarningMessage(
									"Debes llenar todos los campos.",
									'../../views/userStudentView.php'
							);
					}
			} catch (Exception $e) {
					echo $e->getMessage();
					Message::showErrorMessage(
							"Ocurrió un error interno. Consulta al Administrador.",
							'../../views/userStudentView.php'
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
								$this->student->delete($userId);
								
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/userStudentView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/userStudentView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/userStudentView.php'
						);
				}
		}
	}
?>