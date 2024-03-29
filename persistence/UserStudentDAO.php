<?php
  require_once '../utils/Message.php';
  require_once '../persistence/UserDAO.php';
	
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
						$userId = UserDAO::createUser(
								$idType, $identificationNumber, $firstName, $secondName, $surname,
								$secondSurname, $gender, $address, $email, $phone, $username, $password, $securityQuestion,
								$securityAnswer, $this->pdo
						);

						$this->createStudent($userId, $attendantId, $courseId);
						$this->assignUserRole($userId);
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
					UserDAO::updateUser(
							$firstName,	$secondName, $surname, $secondSurname,
							$gender, $address, $email, $phone, $username,
							$password,	$securityAnswer, $idType, $securityQuestion,
							$identificationNumber, $userId, $this->pdo
					);

					$this->updateStudent($attendantId, $courseId,	$userId);
			} catch (Exception $e) {
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
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/userStudentView.php'
						);
				}
		}
		
		/**
		 * Create a new student record.
		 *
		 * @param int    $userId      The ID of the user associated with the student.
		 * @param string $attendantId The attendant ID of the student.
		 * @param int    $courseId    The ID of the course associated with the student.
		 *
		 * @return void
		 */
		private function createStudent(int $userId, string $attendantId, int $courseId): void {
				$stmt = $this->pdo->prepare("
						INSERT INTO student (user_id, attendant_id, course_id, state)
						VALUES (?, ?, ?, 1)
				");
				$stmt->execute([$userId, $attendantId, $courseId]);
		}

		/**
		 * Update the student's attendant ID and course ID based on user ID.
		 *
		 * @param string $attendantId The new attendant ID.
		 * @param int $courseId The new course ID.
		 * @param int $userId The user ID.
		 *
		 * @return void
		 */
		private function updateStudent(string $attendantId, int $courseId, int $userId): void {
				$stmt = $this->pdo->prepare("
						UPDATE student
						SET attendant_id = ?, course_id = ?
						WHERE user_id = ?
				");
				$stmt->execute([$attendantId, $courseId, $userId]);
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
						VALUES (?, 2, 1)
				");
				$stmt->execute([$userId]);
		}
	}
?>