<?php
  require_once '../utils/Message.php';
  require_once '../persistence/UserDAO.php';
  require_once '../persistence/UserAttendantDAO.php';
	
	class UserAttendantService
	{
		/**
		 * Constructor for the class.
		 *
		 * @throws Exception if unable to create UserAttendantDAO object.
		 */
		public function __construct()
		{
				try {
						// Create an instance of UserAttendantDAO
						$this->attendant = new UserAttendantDAO();
				} catch (Exception $e) {
						// If an exception is thrown while creating UserAttendantDAO object,
						// re-throw the exception with the same message
						throw new Exception($e->getMessage());
				}
		}

		/**
		 * Registers a new attendant user, attendant, and assigns role to user.
		 *
		 * @param string $documentType The type of document.
		 * @param int $identificationNumber The user's identification number.
		 * @param string $firstName The user's first name.
		 * @param string $secondName The user's second name.
		 * @param string $surname The user's first last name.
		 * @param string $secondSurname The user's second last name.
		 * @param string $gender The user's gender.
		 * @param string $address The user's address.
		 * @param string $email The user's email.
		 * @param string $phone The user's phone number.
		 * @param string $username The user's username.
		 * @param string $password The user's password.
		 * @param string $securityQuestion The user's security question.
		 * @param string $securityAnswer The user's security answer.
		 * @param string $relationId The user's relationship with the attendant.
		 *
		 * @return void
		 */
		public function register(
			string $documentType, int $identificationNumber, string $firstName, string $secondName,
			string $surname, string $secondSurname, string $gender, string $address, string $email,
			string $phone, string $username, string $password, string $securityQuestion,
			string $securityAnswer,	string $relationId
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
												'../../views/userAttendantView.php'
										);
										return;
								}

								if (Message::isRegistered(Database::connect(), 'user', 'email', $email, false, null)) {
										Utils::showErrorMessage(
												"El correo electrónico ingresado ya se encuentra registrado en la plataforma.",
												'../../views/userAttendantView.php'
										);
										return;
								}

								if (!empty($phone) && Message::isRegistered(Database::connect(), 'user', 'phone', $phone, false, null)) {
										Utils::showErrorMessage(
												"El teléfono ingresado ya se encuentra registrado en la plataforma.",
												'../../views/userAttendantView.php'
										);
										return;
								}

								if (Message::isRegistered(Database::connect(), 'user', 'username', $username, false, null)) {
										Utils::showErrorMessage(
												"El usuario ingresado ya se encuentra registrado en la plataforma.",
												'../../views/userAttendantView.php'
										);
										return;
								}

                $this->attendant->register(
                    $documentType, $identificationNumber, $firstName, $secondName,
                    $surname, $secondSurname, $gender, $address, $email, $phone,
                    $username, $password, $securityQuestion, $securityAnswer,	$relationId
                );
								
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/userAttendantView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/userAttendantView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/userAttendantView.php'
						);
				}
		}

		/**
			 * Update the user and attendant data in the database.
			*
			* @param int $userId The user's id.
			* @param string $idType The user's identification document type.
			* @param int $identificationNumber The user's identification number.
			* @param string $firstName The user's first name.
			* @param string $secondName The user's second name.
			* @param string $surname The user's surname.
			* @param string $secondSurname The user's second surname.
			* @param string $gender The user's gender.
			* @param string $address The user's address.
			* @param string $email The user's email.
			* @param string $phone The user's phone number.
			* @param string $username The user's username.
			* @param string $password The user's password.
			* @param int $securityQuestion The user's security question id.
			* @param string $securityAnswer The user's security answer.
			* @param string $relationId The attendant's relationship id to the user.
		 */
		public function update(
			int $userId, string $idType, int $identificationNumber, string $firstName,
			string $secondName,	string $surname, string $secondSurname, string $gender,
			string $address, string $email,	string $phone, string $username, string $password,
			string $securityQuestion,	string $securityAnswer,	string $relationId
		) {
				try {
						if (!empty($idType) && !empty($identificationNumber) && !empty($firstName)
						&& !empty($surname)	&& !empty($gender) && !empty($email) && !empty($userId)
						&& !empty($username) && !empty($password) && !empty($securityAnswer)
						&& !empty($securityQuestion) && !empty($relationId))
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
								
								$this->attendant->update(
										$userId, $idType, $identificationNumber, $firstName, $secondName,
										$surname, $secondSurname, $gender, $address, $email, $phone,
										$username, $password, $securityQuestion, $securityAnswer,	$relationId
								);
								
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/userAttendantView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/userAttendantView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/userAttendantView.php'
						);
				}
		}

		/**
		 * Deletes an attendant user from the database.
		 *
		 * @param string $userId The user's ID.
		 * @return void
		 */
		public function delete(string $userId): void {
				try {
						if (!empty($userId)) {
								$this->attendant->delete($userId);
								
								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/userAttendantView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/userAttendantView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/userAttendantView.php'
						);
				}
		}

		/**
		 * Create an attendant record in the database.
		 *
		 * @param int $userId The ID of the user.
		 * @param string $relationId The ID of the relationship.
		 * @return void
		 */
		private function createAttendant(int $userId, string $relationId): void {
				$stmtAttendant = $this->pdo->prepare("
						INSERT INTO attendant (user_id, relationship_id, state)
						VALUES (?, ?, 1)
				");
				$stmtAttendant->execute([$userId, $relationId]);
		}

		/**
		 * Update the relationship ID of an attendant for a given user ID.
		 *
		 * @param string $attendantId The ID of the attendant.
		 * @param int $relationId The new relationship ID.
		 * @param int $userId The user ID.
		 * @return void
		 */
		private function updateAttendant(string $attendantId, int $relationId, int $userId): void {
				$stmt = $this->pdo->prepare(
						"UPDATE attendant
						SET relationship_id = ?
						WHERE user_id = ?"
				);
				$stmt->execute([$attendantId, $relationId, $userId]);
		}

		/**
		 * Assigns a user role to a user with the given ID.
		 *
		 * @param int $userId The ID of the user.
		 *
		 * @return void
		 */
		private function assignUserRole(int $userId): void {
				$stmt = $this->pdo->prepare("
						INSERT INTO user_has_role (user_id, role_id, state)
						VALUES (?, 5, 1)
				");
				$stmt->execute([$userId]);
		}
	}
?>