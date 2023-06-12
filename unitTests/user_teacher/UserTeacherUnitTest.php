<?php

class UserTeacherUnitTest extends PHPUnit_Framework_TestCase
{

  /**
 * Tests the registrar function with different inputs
 *
 * Tests:
 * - Test with valid inputs
 * - Test with empty strings as inputs
 * - Test with null inputs
 * - Test with invalid email
 * - Test with invalid phone number
 *
 * @return void
 */
public function testRegistrar() {
  // Test with valid inputs
  $this->registrar('CC', '12345', 'John', '', 'Doe', '', 'Male', '123 Main St', 'johndoe@example.com', '1234567890', 'johndoe', 'password', 'Answer', 'Question');
  $this->assertDatabaseHas('user', ['id_user' => '12345']);

  // Test with empty strings as inputs
  $this->registrar('', '', '', '', '', '', '', '', '', '', '', '', '', '');
  $this->assertDatabaseMissing('user', ['id_user' => '']);

  // Test with null inputs
  $this->registrar(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
  $this->assertDatabaseMissing('user', ['id_user' => null]);

  // Test with invalid email
  $this->expectException(PDOException::class);
  $this->registrar('CC', '12345', 'John', '', 'Doe', '', 'Male', '123 Main St', 'invalidemail', '1234567890', 'johndoe', 'password', 'Answer', 'Question');

  // Test with invalid phone number
  $this->expectException(PDOException::class);
  $this->registrar('CC', '12345', 'John', '', 'Doe', '', 'Male', '123 Main St', 'johndoe@example.com', '123456', 'johndoe', 'password', 'Answer', 'Question');
}

  /**
 * Test registering a teacher with valid document number and user ID.
 */
public function testRegisterTeacherWithValidInputs(): void
{
    // Arrange
    $documentNumber = '123456';
    $userId = 5;
    
    // Act
    $this->registerTeacher($documentNumber, $userId);
    
    // Assert
    $this->assertDatabaseHas('teacher', [
        'user_pk_fk_cod_doc' => $documentNumber,
        'user_id_user' => $userId
    ]);
}

/**
 * Test registering a teacher with empty document number.
 */
public function testRegisterTeacherWithEmptyDocumentNumber(): void
{
    // Arrange
    $documentNumber = '';
    $userId = 5;
    
    // Act & Assert
    $this->expectException(PDOException::class);
    $this->registerTeacher($documentNumber, $userId);
}

/**
 * Test registering a teacher with zero user ID.
 */
public function testRegisterTeacherWithZeroUserId(): void
{
    // Arrange
    $documentNumber = '123456';
    $userId = 0;
    
    // Act & Assert
    $this->expectException(PDOException::class);
    $this->registerTeacher($documentNumber, $userId);
}

  public function testRegisterUserAsTeacherRole()
  {
    // Test valid registration
    $this->registerUserAsTeacherRole('PASSPORT', 123);
    $this->assertDatabaseHas('user_has_role', [
      'tdoc_role' => 'PASSPORT',
      'pk_fk_id_user' => 123,
      'pk_fk_role' => 'TEACHER',
      'state' => 1,
    ]);

    // Test invalid document type
    $this->expectException(PDOException::class);
    $this->registerUserAsTeacherRole('INVALID_TYPE', 456);

    // Test invalid user ID
    $this->expectException(PDOException::class);
    $this->registerUserAsTeacherRole('PASSPORT', 'not_an_int');
  }

  public function testUpdateUserInformation()
  {
    // Test case: Update user information successfully
    $result = $this->object->updateUserInformation(
        'passport', 1, 'John', 'M', 'Doe', 'S', 'Male', '123 Main St', 'john.doe@example.com',
        '123-456-7890', 'johndoe', 'password', 'answer', 'What is your favorite color?'
    );
    $this->assertEquals('Record updated successfully.', $result);

    // Test case: Invalid document type
    $result = $this->object->updateUserInformation(
        'invalid', 1, 'John', 'M', 'Doe', 'S', 'Male', '123 Main St', 'john.doe@example.com',
        '123-456-7890', 'johndoe', 'password', 'answer', 'What is your favorite color?'
    );
    $this->assertNotEquals('Record updated successfully.', $result);

    // Test case: Invalid user id
    $result = $this->object->updateUserInformation(
        'passport', 0, 'John', 'M', 'Doe', 'S', 'Male', '123 Main St', 'john.doe@example.com',
        '123-456-7890', 'johndoe', 'password', 'answer', 'What is your favorite color?'
    );
    $this->assertNotEquals('Record updated successfully.', $result);

    // Test case: Invalid email
    $result = $this->object->updateUserInformation(
        'passport', 1, 'John', 'M', 'Doe', 'S', 'Male', '123 Main St', 'invalid-email',
        '123-456-7890', 'johndoe', 'password', 'answer', 'What is your favorite color?'
    );
    $this->assertNotEquals('Record updated successfully.', $result);
  }

  public function testDeleteValidUser()
  {
      $this->obj->deleteUser(1, "passport");
      $this->assertNull($this->obj->getUser(1, "passport"));
  }
  
  public function testDeleteInvalidUser()
  {
      $this->expectException(PDOException::class);
      $this->obj->deleteUser("invalid_id", "passport");
  }
  
  public function testDeleteInvalidDocType()
  {
      $this->expectException(PDOException::class);
      $this->obj->deleteUser(1, "invalid_doc_type");
  }
}
?>