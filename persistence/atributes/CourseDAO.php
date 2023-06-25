<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Curso</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
</head>

<body>
  <?php
	class CourseDAO {
		private $pdo;

		/**
		 * Constructor of the class.
		 * Initializes the PDO object by connecting to the database.
		 *
		 * @throws PDOException if the connection to the database fails.
		 */
		public function __construct()
		{
				try {
						$this->pdo = Database::connect();
				} catch (PDOException $e) {
						throw new PDOException($e->getMessage());
				}
		}

		/**
		 * Registers a new course with a given code and state.
		 *
		 * @param string $course - The code of the course to register.
		 * @param string $state - The state of the course to register.
		 *
		 * @return void
		 */
		public function registerCourse(string $course, string $state): void
		{
				try {
					 	if (!empty($course)) {
								$sql = "
									INSERT INTO course (cod_course, state)
									VALUES (UPPER(:course), :state)
								";
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([
										'course' => $course,
										'state' => $state,
								]);
								
								$this->showSuccessMessage(
										"Registro Agregado Exitosamente.",
										'../../views/atributes/courseView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/courseView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/courseView.php'
						);
				}
		}

		/**
		 * Updates a course record in the database.
		 *
		 * @param string $newCourseCode - The updated course code.
		 * @param string $currentCourseCode - The current course code to update.
		 * @param string $newState - The updated state of the course.
		 * @return void
		 */
		public function updateCourseRecord(string $newCourseCode, string $currentCourseCode, string $newState)
		{
				try {
						if (!empty($newCourseCode) && !empty($currentCourseCode)) {
								$sql = "
										UPDATE course
										SET cod_course = UPPER(:newCourseCode),
												state = :newState
										WHERE cod_course = :currentCourseCode
								";
							
								$stmt = $this->pdo->prepare($sql);
								$stmt->execute([
										'newCourseCode' => $newCourseCode,
										'newState' => $newState,
										'currentCourseCode' => $currentCourseCode
								]);
								
								$this->showSuccessMessage(
										"Registro Actualizado Exitosamente.",
										'../../views/atributes/courseView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/courseView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/courseView.php'
						);
				}
		}

		/**
		 * Deletes a course from the database
		 *
		 * @param string $courseCode The code of the course to be deleted
		 * @return void
		 */
		public function deleteCourse(string $courseCode)
		{
				try {
						if (!empty($courseCode)) {
								$sql = "
										DELETE FROM course
										WHERE cod_course = '$courseCode'
								";
								$this->pdo->query($sql);
								
								$this->showSuccessMessage(
										"Registro Eliminado Exitosamente.",
										'../../views/atributes/courseView.php'
								);
						} else {
								$this->showWarningMessage(
										"Debes llenar todos los campos.",
										'../../views/atributes/courseView.php'
								);
						}
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/atributes/courseView.php'
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