<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pregunta de Seguridad</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	require_once '../../utils/Message.php';

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
		public function addSecurityQuestion(string $question, string $state): void
		{
				try {
						if (!empty($question)) {
								$sql = "
										INSERT INTO security_question (description, state)
										VALUES (UPPER(:description), :state)
								";

								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([
										':description' => $question,
										':state' => $state,
								]);
			
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/atributes/questionView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/questionView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/questionView.php'
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
		public function updateQuestionState(string $idSecurityQuestion, string $state)
		{
				try {
						if (!empty($idSecurityQuestion)) {
								$query = '
										UPDATE security_question
										SET state = ?
										WHERE id_security_question = ?
								';
								$stmt = $this->pdo->prepare($query);
								$stmt->execute([$state, $idSecurityQuestion]);

								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/atributes/questionView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/questionView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/questionView.php'
						);
				}
		}

		/**
		 * Deletes a record from the security_question table based on the provided ID.
		 *
		 * @param string $idSecurityQuestion The ID of the question to delete from the table.
		 * @throws Exception If an error occurs while executing the SQL statement.
		 */
		public function deleteQuestion(string $idSecurityQuestion): void
		{
				try {
						if (!empty($idSecurityQuestion)) {
								$sql = "
										UPDATE security_question
										SET state = 3
										WHERE id_security_question = ?
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([$idSecurityQuestion]);

								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/atributes/questionView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/questionView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/questionView.php'
						);
				}
		}
	}
?>
</body>

</html>