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
		 * @param string $teacherId The ID of teacher
		 *
		 * @return void
		 */
		public function registerSubject(string $subject, string $state, string $teacherId)
		{
				try {
						if (!empty($subject) && !empty($teacherId)) {
								$query = "
										INSERT INTO subject	(
												description,
												teacher_id,
												state)
										VALUES (
												UPPER(:description),
												:teacher,
												:state);
								";
								$statement = $this->pdo->prepare($query);
								$statement->execute([
										'description' => $subject,
										'teacher' => $teacherId,
										'state' => $state
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
		 * @param string $idSubject The ID of the subject to be updated.
		 * @param string $subject The new name of the subject.
		 * @param string $state The new state of the subject.
		 * @param int $teacherId The ID of the teacher assigned to the subject.
		 *
		 * @return void
		 */
		public function updateSubject(
			string $idSubject, string $subject, string $state, int $teacherId)
		{
				try {
						if (!empty($idSubject) && !empty($subject) && !empty($teacherId))
						{
								$sql = "
										UPDATE
												subject
										SET
												description = UPPER(:description),
												state = :state,
												teacher_id = :teacherId
										WHERE
												id_subject = :id
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->bindParam(':description', $subject);
								$stmt->bindParam(':state', $state);
								$stmt->bindParam(':teacherId', $teacherId);
								$stmt->bindParam(':id', $idSubject);
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
		 * @param string $subjectId The ID of the subject to be deleted.
 		 * @return void
		 */
		public function deleteSubject(string $subjectId): void
		{
				try {
						if (!empty($subjectId)) {
								$sql = "DELETE FROM subject WHERE id_subject = ?";
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([$subjectId]);
								
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