<?php
	require_once '../persistence/database/Database.php';
	require_once '../persistence/SecurityQuestionDAO.php';
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';

	class SecurityQuestionService
	{
		/**
		 * Constructor function for the class.
		 *
		 * This function establishes a connection to the database using the Database class.
		 * If unable to connect to the database, it throws a PDOException.
		 *
		 * @throws Exception if unable to connect to the database.
		 */
		public function __construct() {
			try {
				$this->question = new SecurityQuestionDAO();
			} catch (Exception $e) {
				throw new Exception($e->getMessage());
			}
		}

		/**
		 * Adds a new security question to the database.
		 *
		 * @param string $question The security question to add.
		 *
		 * @return void
		 */
		public function register(string $question): void
		{
			try {
				// Check if the question is not empty
				if (!empty($question)) {
					// Check if the question is already registered in the database
					if (Message::isRegistered(Database::connect(), 'security_question', 'description', $question, false, null)) {
						// Show error message if the question is already registered
						Message::showErrorMessage(SECURITY_QUESTION_ALREADY_ADDED, SECURITY_QUESTION_URL);
						return;
					}
						
					// Register the question in the database
					$this->question->register($question);
					
					// Show success message
					Message::showSuccessMessage(ADDED_RECORD, SECURITY_QUESTION_URL);
				} else {
					// Show warning message if the question is empty
					Message::showWarningMessage(EMPTY_FIELDS, SECURITY_QUESTION_URL);
				}
			} catch (Exception $e) {
				// Show error message for internal error
				Message::showErrorMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
			}
		}

		/**
		 * Updates the state of a security question in the database.
		 *
		 * @param string $idSecurityQuestion The id of the security question to update.
		 * @param string $state The new state to set.
		 * @return string A success message.
		 */
		public function update(string $idSecurityQuestion, string $state)
		{
			try {
				if (!empty($idSecurityQuestion)) {
					$this->question->update($idSecurityQuestion, $state);

					// Show success message
					Message::showSuccessMessage(UPDATED_RECORD, SECURITY_QUESTION_URL);
				} else {
					// Show warning message
					Message::showWarningMessage(EMPTY_FIELDS, SECURITY_QUESTION_URL);
				}
			} catch (Exception $e) {
				// Show error message
				Message::showErrorMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
			}
		}

		/**
		 * Deletes a record from the security_question table based on the provided ID.
		 *
		 * @param string $idSecurityQuestion The ID of the question to delete from the table.
		 * @throws Exception If an error occurs while executing the SQL statement.
		 */
		public function delete(string $idSecurityQuestion): void
		{
			try {
				// Check if the ID is not empty
				if (!empty($idSecurityQuestion)) {
					// Delete the question record
					$this->question->delete($idSecurityQuestion);

					// Show success message
					Message::showSuccessMessage(DELETED_RECORD, SECURITY_QUESTION_URL);
				} else {
					// Show warning message if ID is empty
					Message::showWarningMessage(EMPTY_FIELDS, SECURITY_QUESTION_URL);
				}
			} catch (Exception $e) {
				// Show error message if an exception occurs
				Message::showErrorMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
			}
		}

		/**
		 * Retrieves a security question by its ID.
		 *
		 * @param int $id The ID of the security question.
		 * @throws Exception If an error occurs while retrieving the security question.
		 * @return mixed The security question data if found, otherwise null.
		 */
		public function getSecurityQuestionById(int $id)
		{
			try {
				if (!empty($id)) {
					return $this->question->getSecurityQuestionById($id);
				} else {
					Message::showWarningMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
			}
		}

		/**
		 * Retrieves the security question list data based on the given page.
		 *
		 * @param int $page The page number to retrieve the data for.
		 * @throws Exception If an error occurs during the retrieval process.
		 * @return mixed The security question list data.
		 */
		public function getSecurityQuestionListData($page)
		{
			try {
				if (!empty($page)) {
					return $this->question->getSecurityQuestionListData($page);
				}
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
			}
		}
	}
?>