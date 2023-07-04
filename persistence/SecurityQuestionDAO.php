<?php
	require_once '../persistence/database/Database.php';
	require_once '../persistence/SecurityQuestionDAO.php';
	require_once '../utils/Message.php';

	class SecurityQuestionDAO
	{
		private $pdo;

		/**
		 * Constructor function for the class.
		 * Establishes a connection to the database using the Database class.
		 *
		 * @throws PDOException if unable to connect to the database.
		 */
		public function __construct() {
				try {
						$this->pdo = Database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
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
						$sql = "
								INSERT INTO security_question (description, state)
								VALUES (UPPER(:description), :state)
						";

							$stmt = $this->pdo->prepare($sql);
							$stmt->execute([
									':description' => $question,
									':state' => $state,
							]);
				} catch (Exception $e) {
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
		 * @param int $state The new state to set.
		 * @return string A success message.
		 */
		public function update(string $idSecurityQuestion, int $state)
		{
				try {
						$query = '
								UPDATE security_question
								SET state = ?
								WHERE id_security_question = ?
						';
						$stmt = $this->pdo->prepare($query);
						$stmt->execute([$state, $idSecurityQuestion]);
				} catch (Exception $e) {
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
						$sql = "
								UPDATE security_question
								SET state = 3
								WHERE id_security_question = ?
						";
						$stmt = $this->pdo->prepare($sql);
						$stmt->execute([$idSecurityQuestion]);
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/questionView.php'
						);
				}
		}
	}
?>