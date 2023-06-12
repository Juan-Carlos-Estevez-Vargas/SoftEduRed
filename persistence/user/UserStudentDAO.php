<?php
class UserStudentDAO
{

	/**
	 * Constructor method for the class.
	 * It initializes a database connection using the Database class.
	 *
	 * @throws Exception if connection fails
	 */
	public function __construct() {
		try {
			// Create a new database connection using the conectar method from the Database class.
			$this->pdo = Database::connect();
		} catch (Exception $e) {
			// If connection fails, throw an exception with error message.
			throw new Exception($e->getMessage());
		}
	}

	/**
	 * Registers a new user and student record in the database.
	 *
	 * @param string $idType The type of identification document.
	 * @param int $userId The identification number of the user.
	 * @param string $firstName The first name of the user.
	 * @param string $secondName The second name of the user.
	 * @param string $firstLastName The first last name of the user.
	 * @param string $secondLastName The second last name of the user.
	 * @param string $gender The gender of the user.
	 * @param string $address The address of the user.
	 * @param string $email The email of the user.
	 * @param string $phone The phone number of the user.
	 * @param string $username The username of the user.
	 * @param string $password The password of the user.
	 * @param string $securityAnswer The answer to the user's security question.
	 * @param string $securityQuestion The security question of the user.
	 * @param string $attendantIdType The type of identification document of the attendant.
	 * @param int $attendantId The identification number of the attendant.
	 * @param string $courseCode The code of the course the student is enrolled in.
	 * @return void
	 */
	public function registerUserAndStudent(
		string $idType, int $userId, string $firstName, string $secondName,	string $firstLastName,
		string $secondLastName, string $gender, string $address, string $email, string $phone,
		string $username, string $password, string $securityAnswer, string $securityQuestion,
		string $attendantIdType, int $attendantId, string $courseCode
	): void {
    // Insert user record into database
    $stmt = $this->pdo->prepare(
			"INSERT INTO user (pk_fk_cod_doc, id_user, first_name, second_name, surname, second_surname,
				`fk_gender`, adress, email, phone, user_name, pass, security_answer, `fk_s_question`)
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute(
			[$idType, $userId, $firstName, $secondName, $firstLastName,
				$secondLastName, $gender, $address, $email, $phone, $username,
				$password, $securityAnswer, $securityQuestion
			]);

    // Insert student record into database
    $stmt = $this->pdo->prepare(
			"INSERT INTO student (pk_fk_tdoc_user, pk_fk_user_id, fk_attendat_cod_doc, fk_attendant_id, fk_cod_course)
			VALUES (?, ?, ?, ?, ?)");

    $stmt->execute([$idType, $userId, $attendantIdType, $attendantId, $courseCode]);

    // Assign student role to user
    $stmt = $this->pdo->prepare(
			"INSERT INTO user_has_role (tdoc_role, pk_fk_id_user, pk_fk_role, state)
			VALUES (?, ?, 'STUDENT', 1)");

    $stmt->execute([$idType, $userId]);

    // Display success message and redirect to view page
    print "<script>
			alert('Registro Agregado Exitosamente.');
			window.location='../views/user/userStudentView.php';</script>";
	}

	/**
	 * Updates user and student information in the database
	 *
	 * @param string $documentType The document type of the user
	 * @param int $userId The user's ID
	 * @param string $firstName The user's first name
	 * @param string $secondName The user's second name
	 * @param string $firstLastName The user's first last name
	 * @param string $secondLastName The user's second last name
	 * @param string $gender The user's gender
	 * @param string $address The user's address
	 * @param string $email The user's email
	 * @param string $phone The user's phone number
	 * @param string $username The user's username
	 * @param string $pass The user's password
	 * @param string $securityAnswer The user's security answer
	 * @param string $securityQuestion The user's security question
	 * @param string $attendantDocument The document type of the attendant
	 * @param int $attendantId The ID of the attendant
	 * @param int $course The ID of the course
	 * @return void
	 */
	public function updateUserStudent(
    $documentType, $userId, $firstName, $secondName, $firstLastName, $secondLastName,
    $gender, $address, $email, $phone, $username, $pass, $securityAnswer,
    $securityQuestion, $attendantDocument, $attendantId, $course
	) {
    // Update user information query
    $sqlUpdateUser = "UPDATE user
			SET first_name = ?, second_name = ?, surname = ?, second_surname = ?, fk_gender = ?,
				adress = ?, email = ?, phone = ?, user_name = ?, pass = ?, security_answer = ?, fk_s_question = ?
			WHERE pk_fk_cod_doc = ? AND id_user = ?";
    
    // Update student information query
    $sqlUpdateStudent = "UPDATE student
			SET fk_attendat_cod_doc = ?, fk_attendant_id = ?, fk_cod_course = ?
			WHERE pk_fk_tdoc_user = ? AND pk_fk_user_id = ?";
    
    // Execute queries
    $this->pdo->prepare($sqlUpdateUser)->execute([
      $firstName, $secondName, $firstLastName, $secondLastName, $gender, $address,
      $email, $phone, $username, $pass, $securityAnswer, $securityQuestion,
      $documentType, $userId
    ]);

    $this->pdo->prepare($sqlUpdateStudent)->execute([
      $attendantDocument, $attendantId, $course, $documentType, $userId
    ]);
    
    // Redirect user to formu_view.php and display success message
    echo "<script>
			alert('Registro Actualizado Exitosamente.');
			window.location='../views/user/userStudentView.php';
		</script>";
	}

	/**
	 * Delete a user record based on their ID and document code.
	 *
	 * @param int $userId The user's ID.
	 * @param string $documentCode The document code.
	 * @return string A success message.
	 */
	public function deleteStudentUser($userId, $documentCode)
	{
		// Prepare the SQL statement to delete the user record.
		$stmt = $this->pdo->prepare(
			"DELETE FROM user	WHERE id_user = :id_user AND pk_fk_cod_doc = :doc_code"
		);
		
		// Execute the SQL statement with the given parameters.
		$stmt->execute([
			'id_user' => $userId,
			'doc_code' => $documentCode
		]);
		
		// Return a success message.
		return "Registro Eliminado Exitosamente.";
	}

}
