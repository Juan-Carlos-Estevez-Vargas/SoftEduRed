<?php
	require_once '../utils/Message.php';

	class SubjectHasCourseDAO
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
		public function register($course, $subject)
		{
				try {
						$sql = "
								INSERT INTO subject_has_course (
										course_id,
										subject_id,
										state)
								VALUES (?, ?, 1)
						";
						$stmt = $this->pdo->prepare($sql);
						$stmt->execute([$course, $subject]);
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectHasCourseView.php'
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
		public function update(
			string $id, string $course,	string $subject, string $state
		)	{
				try {
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
				} catch (Exception $e) {
						Message::showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectHasCourseView.php'
						);
				}
		}

		/**
		 * Deletes a record from the subject_has_course table
		 *
		 *v@param string $id - the value to match with id_subject_has_course
		 */
		public function delete(string $id)
		{
				try {
						$sql = "
								DELETE FROM subject_has_course
								WHERE id_subject_has_course = ?
						";
			
						$stmt = $this->pdo->prepare($sql);
						$stmt->bindValue(1, $id);
						$stmt->execute();
				} catch (Exception $e) {
						$this->showErrorMessage(
								"Ocurrió un error interno. Consulta al Administrador.",
								'../../views/subjectHasCourseView.php'
						);
				}
		}

		public function exists($course, $subject): bool {
			try {
					$sql = "
							SELECT COUNT(*) AS total
							FROM subject_has_course
							WHERE subject_id = :subject AND course_id = :course;
					";
	
					$statement = $this->pdo->prepare($sql);
					$statement->bindParam(':subject', $subject);
					$statement->bindParam(':course', $course);
					$statement->execute();
	
					$result = $statement->fetch(PDO::FETCH_ASSOC);
					$total = $result['total'];
	
					return $total > 0;
			} catch (Exception $e) {
					Message::showErrorMessage(
							"Ocurrió un error interno. Consulta al Administrador.",
							'../../views/roleHasUserView.php'
					);
			}
	}
	}
?>