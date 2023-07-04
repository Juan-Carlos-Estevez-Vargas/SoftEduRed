<?php
	require_once '../utils/Message.php';
  require_once '../persistence/UserDAO.php';
		
	class UserTeacherDAO
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
						$userId = UserDAO::createUser(
								$documentType, $identificationNumber, $firstName, $secondName, $surname,
								$secondSurname, $gender, $address, $email, $phone, $username, $password, $securityQuestion,
								$securityAnswer, $this->pdo
						);
						$userId = $this->pdo->lastInsertId();

						$this->createTeacher($userId, $salary, $documentType);
						$this->assignUserRole($userId);
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
						UserDAO::updateUser(
								$firstName,	$secondName, $surname, $secondSurname,
								$gender, $address, $email, $phone, $username,
								$password,	$securityAnswer, $idType, $securityQuestion,
								$identificationNumber, $userId, $this->pdo
						);
	
						$this->updateTeacher($salary, $idType, $userId);
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
						$stmtRole = $this->pdo->prepare("
								DELETE FROM user_has_role
								WHERE user_id = :id_user
						");
						$stmtRole->execute(['id_user' => $userId]);

						$stmt = $this->pdo->prepare("
								UPDATE teacher
								SET state = 3
								WHERE user_id = :id_user
						");
						$stmt->execute(['id_user' => $userId]);
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/userTeacherView.php'
						);
				}
		}

		/**
		 * Creates a new teacher record in the database.
		 *
		 * @param int $userId The ID of the user associated with the teacher.
		 * @param string $salary The salary of the teacher.
		 * @param int $documentType The ID of the document type associated with the teacher.
		 * @return void
		 */
		private function createTeacher(int $userId, string $salary, int $documentType): void {
				$stmt = $this->pdo->prepare("
						INSERT INTO teacher (user_id, salary, document_type_id)
						VALUES (?, ?, ?)
				");
				$stmt->execute([$userId, $salary, $documentType]);
		}

		/**
		 * Update the teacher's salary and document type based on user ID.
		 *
		 * @param string $salary The new salary.
		 * @param int $idType The new document type ID.
		 * @param int $userId The user ID.
		 *
		 * @return void
		 */
		private function updateTeacher(string $salary, int $idType, int $userId): void {
				$stmt = $this->pdo->prepare("
						UPDATE teacher
						SET salary = ?, document_type_id = ?
						WHERE user_id = ?
				");
				$stmt->execute([$salary, $idType, $userId]);
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
						VALUES (?, 3, 1)
				");
				$stmt->execute([$userId]);
		}
	}
?>