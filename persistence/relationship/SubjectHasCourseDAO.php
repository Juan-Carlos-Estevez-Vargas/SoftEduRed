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
		 *
		 * @return void
		 */
		public function addSubjectHasCourse($course)
		{
				try {
						if (!empty($course)) {
								$stm1 = $this->pdo->prepare("SELECT * FROM subject");
								$stm1->execute();

								foreach ($stm1->fetchAll(PDO::FETCH_OBJ) as $row){
										$subject =  $row->n_subject;
										if (isset($_POST[$subject])) {
												$state="state_".$subject;
												$stateS=$_REQUEST[$state];

												$sql1 = "
														INSERT INTO subject_has_course (
																pk_fk_te_sub,
																pk_fk_course_stu,
																state_sub_course)
														VALUES ('$subject', '$course', '$stateS')
												";
												$this->pdo->query($sql1);
										}
								}
								
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
		 * @param string $newSubj The new subject ID.
		 * @param string $currSubj The current subject ID.
		 * @param string $newCourse The new course ID.
		 * @param string $currCourse The current course ID.
		 * @param string $newState The new state value.
		 *
		 * @return void
		 */
		public function updateSubjectHasCourse(
			string $newSubj, string $currSubj,
		 	string $newCourse, string $currCourse, string $newState
		)	{
				try {
						if (!empty($newSubj) && !empty($currSubj) && !empty($newCourse) && !empty($currCourse))
						{
								$sql = "
										UPDATE
												subject_has_course
										SET
												pk_fk_te_sub = '$newSubj',
												pk_fk_course_stu = '$newCourse',
												state_sub_course = '$newState'
										WHERE
												pk_fk_te_sub = '$currSubj' &&
												pk_fk_course_stu = '$currCourse'
								";
								$this->pdo->query($sql);
							
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
		 * @param string $subject - the value to match with pk_fk_te_sub
		 * @param string $course - the value to match with pk_fk_course_stu
		 */
		public function deleteSubjectHasCourse(string $subject, string $course)
		{
				try {
						if (!empty($subject) && !empty($course)) {
								$sql = "
										DELETE FROM subject_has_course
										WHERE pk_fk_te_sub = ?
												AND pk_fk_course_stu = ?
								";
					
								$stmt = $this->pdo->prepare($sql);
								$stmt->bindValue(1, $subject);
								$stmt->bindValue(2, $course);
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