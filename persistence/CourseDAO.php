<?php
	require_once '../utils/Message.php';

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
		public function register(string $course, string $state): void
		{
				try {
						$sql = "
							INSERT INTO course (course, state)
							VALUES (UPPER(:course), :state)
						";
						$stmt = $this->pdo->prepare($sql);
						$stmt->execute([
								'course' => $course,
								'state' => $state,
						]);
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/courseView.php'
						);
				}
		}

		/**
		 * Updates a course record in the database.
		 *
		 * @param string $courseId - The id of the course to update.
 		 * @param string $course - The updated course code.
		 * @param string $state - The updated state of the course.
		 * @return void
		 */
		public function update(string $courseId, string $course, string $state)
		{
				try {
						$sql = "
								UPDATE course
								SET course = UPPER(:course),
										state = :state
								WHERE id_course = :id
						";
					
						$stmt = $this->pdo->prepare($sql);
						$stmt->execute([
								'course' => $course,
								'state' => $state,
								'id' => $courseId
						]);
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/courseView.php'
						);
				}
		}

		/**
		 * Deletes a course from the database
		 *
		 * @param string $courseId - The code of the course to be deleted
		 * @return void
		 */
		public function delete(string $courseId)
		{
				try {
						$sql = "
								UPDATE course
								SET state = 3
								WHERE id_course = '$courseId'
						";
						$this->pdo->query($sql);
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/courseView.php'
						);
				}
		}
	}
?>