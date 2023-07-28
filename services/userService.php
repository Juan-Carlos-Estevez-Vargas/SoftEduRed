<?php
	require_once '../persistence/database/Database.php';
	require_once '../persistence/UserDAO.php';
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';
  
	class UserService {

		/**
		 * Constructor of the class.
		 * Initializes the PDO object by connecting to the database.
		 *
		 * @throws PDOException if the connection to the database fails.
		 */
		public function __construct()
		{
			try {
				$this->user = new UserDAO();
			} catch (PDOException $e) {
				throw new PDOException($e->getMessage());
			}
		}

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
        ): void
		{
			try {
				if (!empty($idType) || !empty($identificationNumber) || !empty($firstName) || !empty($surname) || !empty($username) || !empty($password) || !empty($gender) || !empty($email) || !empty($securityQuestion) || !empty($securityAnswer)) {
					//if (Message::isRegistered(Database::connect(), 'course', 'course', $course, false, null))
					//{
					//	Message::showErrorMessage(COURSE_ALREADY_ADDED,	COURSE_URL);
					//	return;
					//}
					//$this->course->register($course);
					//Message::showSuccessMessage(ADDED_RECORD, COURSE_URL);
				} else {
					Message::showWarningMessage(EMPTY_FIELDS, COURSE_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, COURSE_URL);
			}
		}

        /**
         * Retrieves all users.
         *
         * @throws Exception if an error occurs while fetching users.
         * @return array|null An array containing all users, or null if no users found.
         */
        public function getAllUsers(): ?array
        {
            try {
                $users = $this->user->getAllUsers();
                if (empty($users)) {
                    return null;
                }
                return $this->user->getAllUsers();
            } catch (Exception $e) {
                // Show error message if an exception occurs.
                throw new Exception('Error fetching users: ' . $e->getMessage());
            }
        }

	}
?>