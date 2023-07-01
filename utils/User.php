<?php
class User {
  
  /**
   * Create a new user.
   *
   * @param string $idType The type of identification for the user.
   * @param int $identificationNumber The identification number of the user.
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
   * @param PDO $pdo The PDO object for database connection.
   *
   * @return int The ID of the newly created user.
   */
  public static function createUser(
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
    PDO $pdo
  ): int {
    $stmt = $pdo->prepare("
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
    ");

    $stmt->execute([
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
  }

  /**
   * Update a user in the database.
   *
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
   * @param string $securityAnswer The security answer of the user.
   * @param string $idType The identification type of the user.
   * @param string $securityQuestion The security question of the user.
   * @param string $identificationNumber The identification number of the user.
   * @param int $userId The ID of the user to update.
   * @param PDO $pdo The PDO object for database connection.
   * @return void
   */
  public static function updateUser(
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
    $identificationNumber,
    $userId,
    PDO $pdo
  ) {
      $sqlUpdateUser = "
          UPDATE user
          SET
              first_name = ?,
              second_name = ?,
              surname = ?,
              second_surname = ?,
              gender_id = ?,
              address = ?,
              email = ?,
              phone = ?,
              username = ?,
              password = ?,
              security_answer = ?,
              document_type_id = ?,
              security_question_id = ?,
              identification_number = ?
          WHERE id_user = ?
      ";

      $pdo->prepare($sqlUpdateUser)->execute([
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
          $identificationNumber,
          $userId
      ]);
  }

  /**
   * Validates user fields.
   *
   * @param string $idType - The type of identification.
   * @param int $identificationNumber - The identification number.
   * @param string $firstName - The first name.
   * @param string $surname - The surname.
   * @param string $gender - The gender.
   * @param string $email - The email.
   * @param string $username - The username.
   * @param string $password - The password.
   * @param string $securityAnswer - The security answer.
   * @param string $securityQuestion - The security question.
   * @param string $attendantId - The attendant ID.
   * @param int $courseId - The course ID.
   * @return bool - Returns true if all fields are not empty, false otherwise.
   */
  public static function validateUserFields(
    string $idType,
    int $identificationNumber,
    string $firstName,
    string $surname,
    string $gender,
    string $email,
    string $username,
    string $password,
    string $securityAnswer,
    string $securityQuestion,
    string $attendantId,
    int $courseId
  ): bool {
    return !empty($idType)
        && !empty($identificationNumber)
        && !empty($firstName)
        && !empty($surname)
        && !empty($gender)
        && !empty($email)
        && !empty($username)
        && !empty($password)
        && !empty($securityAnswer)
        && !empty($securityQuestion)
        && !empty($attendantId)
        && !empty($courseId);
  }
}
?>