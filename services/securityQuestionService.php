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
	require_once '../persistence/database/Database.php';
	require_once '../persistence/SecurityQuestionDAO.php';
	require_once '../utils/Message.php';

	class SecurityQuestionService
	{
		/**
		 * Constructor function for the class.
		 * Establishes a connection to the database using the Database class.
		 *
		 * @throws PDOException if unable to connect to the database.
		 */
		public function __construct() {
				try {
            $this->question = new addSecurityQuestionDAO();
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
						if (!empty($question)) {
                if (Message::isRegistered(Database::connect(), 'security_question', 'description', $question, false, null))
                {
                    Message::showErrorMessage(
                        "La pregunta de seguridad ingresada ya se encuentra registrado en la plataforma",
                        '../../views/questionView.php'
                    );
                    return;
                }
                
                $this->question->register($question, $state);
			
								Message::showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/questionView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/questionView.php'
								);
						}
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
		 * @param string $state The new state to set.
		 * @return string A success message.
		 */
		public function updateQuestionState(string $idSecurityQuestion, string $state)
		{
				try {
						if (!empty($idSecurityQuestion)) {
                $this->question->update($state, $idSecurityQuestion);
                
								Message::showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/questionView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/questionView.php'
								);
						}
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
						if (!empty($idSecurityQuestion)) {
                $this->question->delete($idSecurityQuestion);

								Message::showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/questionView.php'
								);
						} else {
								Message::showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/questionView.php'
								);
						}
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/questionView.php'
						);
				}
		}
	}
?>
</body>

</html>