<?php
  require_once '../utils/Message.php';
  require_once '../persistence/UserDAO.php';
	
	class UserAttendantDAO
	{
		private $pdo;

		/**
		 * Constructor for the class.
		 *
		 * @throws PDOException if unable to connect to database.
		 */
		public function __construct()
		{
				try {
						$this->pdo = database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
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
						$userId = UserDAO::createUser(
								$documentType, $identificationNumber, $firstName, $secondName, $surname,
								$secondSurname, $gender, $address, $email, $phone, $username, $password,
								$securityQuestion, $securityAnswer, $this->pdo
						);

						$this->createAttendant($userId, $relationId);
						$this->assignUserRole($userId);
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
						UserDAO::updateUser(
								$firstName,	$secondName, $surname, $secondSurname,
								$gender, $address, $email, $phone, $username,
								$password, $securityAnswer, $idType, $securityQuestion,
								$identificationNumber, $userId, $this->pdo
						);

						$this->updateAttendant($relationId,	$userId);
				} catch (Exception $e) {
						$this->showErrorMessage(
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
						$stmtRole = $this->pdo->prepare("
								DELETE FROM user_has_role
								WHERE user_id = :id_user
						");
						$stmtRole->execute(['id_user' => $userId]);
						
						$stmt = $this->pdo->prepare("
								UPDATE attendant
								SET state = 3
								WHERE user_id = :id_user
						");
						$stmt->execute(['id_user' => $userId]);
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/user/userAttendantView.php'
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
		private function updateAttendant(int $relationId, int $userId): void {
				$stmt = $this->pdo->prepare(
						"UPDATE attendant
						SET relationship_id = ?
						WHERE user_id = ?"
				);
				$stmt->execute([$relationId, $userId]);
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