<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Materia</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	class SubjectDAO
	{
		private $pdo;

		/**
		* Initializes a new instance of the class and connects it to the database.
		*
		* @throws PDOException if there is an error connecting to the database.
		*/
		public function __construct() {
				try {
						$this->pdo = Database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a subject with the given parameters
		 *
		 * @param string $subject The name of the subject
		 * @param string $state The state of the subject
		 * @param string $documentType The type of document of the user
		 * @param int $userId The ID of the user
		 *
		 * @return void
		 */
		public function registerSubject(string $subject, string $state, string $documentType, int $userId)
		{
				try {
						if (!empty($subject) && !empty($documentType) && !empty($userId)) {
								$query = "
										INSERT INTO `subject`
												(`n_subject`,
												`state`,
												`fk_id_user_teacher`,
												`fk_tdoc_user_teacher`)
										VALUES (UPPER(:subject),
												:state,
												:userId,
												:documentType)
								";
								$statement = $this->pdo->prepare($query);
								$statement->execute([
										'subject' => $subject,
										'state' => $state,
										'userId' => $userId,
										'documentType' => $documentType
								]);
								
								$this->showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/atributes/subjectView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/subjectView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/subjectView.php'
						);
				}
		}

		/**
		 * Updates subject information in the database.
		 *
		 * @param string $newSubject The new subject name.
		 * @param string $newState The new subject state.
		 * @param string $teacherDocumentType The teacher's document type.
		 * @param int $teacherId The teacher's ID in the database.
		 * @param string $currentSubject The current name of the subject to be updated.
		 *
		 * @return void
		 */
		public function updateSubject(
			string $newSubject, string $newState, string $teacherDocumentType,
			int $teacherId, string $currentSubject)
		{
				try {
						if (!empty($newSubject) && !empty($teacherDocumentType)
								&& !empty($teacherId) && !empty($currentSubject))
						{
								$sql = "
										UPDATE subject
										SET n_subject = UPPER(:newSubject),
												state = :newState,
												fk_id_user_teacher = :teacherId,
												fk_tdoc_user_teacher = :teacherDocumentType
										WHERE n_subject = :currentSubject
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->bindParam(':newSubject', $newSubject);
								$stmt->bindParam(':newState', $newState);
								$stmt->bindParam(':teacherId', $teacherId);
								$stmt->bindParam(':teacherDocumentType', $teacherDocumentType);
								$stmt->bindParam(':currentSubject', $currentSubject);
								$stmt->execute();
								
								$this->showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/atributes/subjectView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/subjectView.php'
								);
						}
				} catch (Exception $e) {
					echo $e->getMessage();
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/subjectView.php'
						);
				}
		}

		/**
		 * Deletes a subject from the database.
		 *
		 * @param string $subject The name of the subject to be deleted.
		 */
		public function deleteSubject(string $subject)
		{
				try {
						if (!empty($subject)) {
								$sql = "DELETE FROM subject WHERE n_subject = ?";
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([$subject]);
								
								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/atributes/subjectView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/subjectView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/subjectView.php'
						);
				}
		}

		/**
		 * Displays a success message using SweetAlert and redirects the user to a specified location.
		 *
		 * @param string $message The success message to display
		 * @param string $redirectURL The URL to redirect to after displaying the message
		 */
		private function showSuccessMessage(string $message, string $redirectURL): void
		{
				echo "
						<script>
								Swal.fire({
										position: 'top-end',
										icon: 'success',
										title: '$message',
										showConfirmButton: false,
										timer: 2000
								}).then(() => {
										window.location = '$redirectURL';
								});
						</script>
				";
		}

		/**
		 * Displays an error message using SweetAlert and redirects the user to a specified location.
		 *
		 * @param string $message The error message to display
		 * @param string $redirectURL The URL to redirect to after displaying the message
		 */
		private function showErrorMessage(string $message, string $redirectURL): void
		{
				echo "
						<script>
								Swal.fire({
										position: 'top-center',
										icon: 'error',
										title: '$message',
										showConfirmButton: false,
										timer: 2000
								}).then(() => {
										window.location = '$redirectURL';
								});
						</script>
				";
		}

		/**
		 * Displays an warning message using SweetAlert and redirects the user to a specified location.
		 *
		 * @param string $message The error message to display
		 * @param string $redirectURL The URL to redirect to after displaying the message
		 */
		private function showWarningMessage(string $message, string $redirectURL): void
		{
				echo "
						<script>
								Swal.fire({
										position: 'top-center',
										icon: 'warning',
										title: '$message',
										showConfirmButton: false,
										timer: 2000
								}).then(() => {
										window.location = '$redirectURL';
								});
						</script>
				";
		}
	}
?>
</body>

</html>