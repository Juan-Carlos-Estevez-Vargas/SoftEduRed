<?php
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';

	class UserDAO
	{
		private $pdo;

		/**
		 * Initializes a new instance of the class.
		 *
		 * Creates a new PDO connection object using database::conectar().
		 * Throws an exception with the error message if the connection fails.
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
     * Registers a new user in the system.
     *
     * @param string $idType The type of identification document.
     * @param int $identificationNumber The identification number.
     * @param string $firstName The first name of the user.
     * @param string $secondName The second name of the user.
     * @param string $surname The surname of the user.
     * @param string $secondSurname The second surname of the user.
     * @param string $gender The gender of the user.
     * @param string $address The address of the user.
     * @param string $email The email of the user.
     * @param string $phone The phone number of the user.
     * @param string $username The username of the user.
     * @param string $password The password of the user.
     * @param string $securityQuestion The security question of the user.
     * @param string $securityAnswer The security answer of the user.
     * @param string $url The URL of the page where the function is called.
     * @throws Exception When an error occurs during the registration process.
     * @return int The ID of the newly registered user.
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
      string $securityAnswer
    ): int {
      try {
				$sql = "
        INSERT INTO user (
          first_name,
          second_name,
          surname,
          second_surname,
          gender_id,
          address,
          email,
          phone,
          username,
          password,
          security_answer,
          document_type_id,
          security_question_id,
          identification_number,
          state
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, UPPER(?), ?, ?, ?, 1);
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
          $idType,
          $securityQuestion,
          $identificationNumber
        ]);
        return $pdo->lastInsertId();
			} catch (Exception $e) {
				// Show error message if an exception occurs.
        throw new Exception('Error Inserting user: ' . $e->getMessage());
			}
    }

		public function update(
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
      string $securityAnswer,
      string $idType,
      string $securityQuestion,
      int $identificationNumber,
      int $userId,
      string $url
    ): void
		{
			try {
				$sql = "
          UPDATE user
          SET
            first_name = :first_name,
            second_name = :second_name,
            surname = :surname,
            second_surname = :second_surname,
            gender_id = :gender,
            address = :address,
            email = :email,
            phone = :phone,
            username = :username,
            password = :password,
            security_answer = :security_answer,
            document_type_id = :document_type_id,
            security_question_id = :security_question_id,
            identification_number = :identification_number
          WHERE id_user = :user_id
				";
				// Prepare the SQL statement.
				$stmt = $this->pdo->prepare($sql);
				// Bind the parameters.
				$stmt->bindParam(':first_name', $firstName);
				$stmt->bindParam(':second_name', $secondName);
				$stmt->bindParam(':surname', $surname);
				$stmt->bindParam(':second_surname', $secondSurname);
				$stmt->bindParam(':gender', $gender);
				$stmt->bindParam(':address', $address);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':phone', $phone);
				$stmt->bindParam(':username', $username);
				$stmt->bindParam(':password', $password);
				$stmt->bindParam(':security_answer', $securityAnswer);
				$stmt->bindParam(':document_type_id', $idType);
				$stmt->bindParam(':security_question_id', $securityQuestion);
				$stmt->bindParam(':identification_number', $identificationNumber);
				$stmt->bindParam(':user_id', $userId);

				// Execute the statement.
				$stmt->execute();
			} catch (Exception $e) {
				// Show error message if an exception occurs.
        throw new Exception('Error Updating user: ' . $e->getMessage());
			}
		}

    /**
     * Gets all users from the database.
     *
     * @return array|null Array containing all user records, or null if no users found.
     * @throws Exception When an error occurs while fetching users.
     */
    public function getAllUsers(): ?array
    {
      try {
        $sql = "SELECT * FROM user";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        // Fetch all users as an associative array
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);

        // If no users found, return null
        if (empty($users)) {
            return null;
        }

        return $users;
      } catch (Exception $e) {
        // Show error message if an exception occurs.
        throw new Exception('Error fetching users: ' . $e->getMessage());
      }
    }
	}
?>