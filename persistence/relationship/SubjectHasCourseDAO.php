<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Materia por Curso</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	class SubjectCourseDAO
	{
		private $pdo;

		/**
		 * Initializes a new instance of the class with a database connection.
		 * @throws PDOException If there is any error with the database connection.
		 */
		public function __construct() {
				try {
						$this->pdo = Database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a course with its corresponding subjects and state.
		 *
		 * @param int $course The ID of the course to be registered.
		 * @param int $subject The ID of the subject to be registered.
		 * @param string $state The state of the subject in the course.
		 *
		 * @return void
		 */
		public function addSubjectHasCourse($course, $subject, $state)
		{
				try {
						if (!empty($course) && !empty($subject)) {
								$sql = "
										INSERT INTO subject_has_course (
												course_id,
												subject_id,
												state)
										VALUES (?, ?, ?)
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([$course, $subject, $state]);
								
								$this->showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/relationship/subjectHasCourseView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/subjectHasCourseView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/subjectHasCourseView.php'
						);
				}
		}

		/**
		 * Updates a record in the subject_has_course table.
		 *
		 * @param string $id The id of the record to be updated.
		 * @param string $course The new course id.
		 * @param string $subject The new subject id.
		 * @param string $state The new state.
		 * @return void
		 */
		public function updateSubjectHasCourse(
			string $id, string $course,	string $subject, string $state
		)	{
				try {
						if (!empty($id) && !empty($course) && !empty($subject))
						{
								$sql = "
										UPDATE
												subject_has_course
										SET
												course_id = ?,
												subject_id = ?,
												state = ?
										WHERE
												id_subject_has_course = ?
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([$course, $subject, $state, $id]);
							
								$this->showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/relationship/subjectHasCourseView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/subjectHasCourseView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/subjectHasCourseView.php'
						);
				}
		}

		/**
		 * Deletes a record from the subject_has_course table
		 *
		 *v@param string $id - the value to match with id_subject_has_course
		 */
		public function deleteSubjectHasCourse(string $id)
		{
				try {
						if (!empty($id)) {
								$sql = "
										DELETE FROM subject_has_course
										WHERE id_subject_has_course = ?
								";
					
								$stmt = $this->pdo->prepare($sql);
								$stmt->bindValue(1, $id);
								$stmt->execute();
								
								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/relationship/subjectHasCourseView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/relationship/subjectHasCourseView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/relationship/subjectHasCourseView.php'
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