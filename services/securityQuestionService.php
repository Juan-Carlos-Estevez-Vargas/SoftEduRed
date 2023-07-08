<?php
	require_once '../persistence/database/Database.php';
	require_once '../persistence/SecurityQuestionDAO.php';
	require_once '../utils/Message.php';

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
		 * @param string $state The state for the security question.
		 *
		 * @return void
		 */
		public function register(string $question, string $state): void
		{
				try {
						// Check if the question is not empty
						if (!empty($question)) {
								// Check if the question is already registered in the database
								if (Message::isRegistered(Database::connect(), 'security_question', 'description', $question, false, null)) {
										// Show error message if the question is already registered
										Message::showErrorMessage(
												"La pregunta de seguridad ingresada ya se encuentra registrado en la plataforma",
												'../../views/questionView.php'
										);
										return;
								}
									
								// Register the question in the database
								$this->question->register($question, $state);
								
								// Show success message
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/questionView.php'
								);
						} else {
								// Show warning message if the question is empty
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/questionView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message for internal error
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/questionView.php'
						);
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
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/questionView.php'
								);
						} else {
								// Show warning message
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/questionView.php'
								);
						}
				} catch (Exception $e) {
						// Show error message
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/questionView.php'
						);
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
					Message::showSuccessMessage(
						"Registro Eliminado Exitosamente.",
						'../../views/questionView.php'
					);
				} else {
					// Show warning message if ID is empty
					Message::showWarningMessage(
						"Debes llenar todos los campos.",
						'../../views/questionView.php'
					);
				}
			} catch (Exception $e) {
				// Show error message if an exception occurs
				Message::showErrorMessage(
					"Ocurrió un error interno. Consulta al Administrador.",
					'../../views/questionView.php'
				);
			}
		}
	}
?>