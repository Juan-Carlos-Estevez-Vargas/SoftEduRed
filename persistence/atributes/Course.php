<?php
	class Course {
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
			$sql = "INSERT INTO course (cod_course, state) VALUES (UPPER(:course), :state)";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([
					'course' => $course,
					'state' => $state,
			]);

			echo "<script>
				alert('Registro Agregado Exitosamente.');
				window.location='../views/atributes/courseView.php';
			</script>";
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
			$sql = "UPDATE course
						SET cod_course = UPPER(:newCourseCode),
						state = :newState
						WHERE cod_course = :currentCourseCode";
						
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([
				'newCourseCode' => $newCourseCode,
				'newState' => $newState,
				'currentCourseCode' => $currentCourseCode
			]);

			echo "<script>
				alert('Registro Eliminado Exitosamente.');
				window.location='../views/atributes/courseView.php';
			</script>";
		}

		/**
		 * Deletes a course from the database
		 *
		 * @param string $courseCode The code of the course to be deleted
		 * @return void
		 */
		public function deleteCourse(string$courseCode)
		{
			$sql = "DELETE FROM course WHERE cod_course = '$courseCode'";
			$this->pdo->query($sql);
			echo "<script>
				alert('Registro Eliminado Exitosamente.');
				window.location='../views/atributes/courseView.php';
			</script>";
		}
	}
?>