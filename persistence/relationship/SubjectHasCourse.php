<?php
	class SubjectCourse
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
		public function addSubjectCourse($course)
		{
			try {
				$stm1 = $this->pdo->prepare("SELECT * FROM subject");
				$stm1->execute();

				foreach ($stm1->fetchAll(PDO::FETCH_OBJ) as $row){
					$subject =  $row->n_subject;
					if (isset($_POST[$subject])) {
						$state="state_".$subject;
						$stateS=$_REQUEST[$state];

						$sql1 = "
							INSERT INTO subject_has_course (pk_fk_te_sub,pk_fk_course_stu, state_sub_course)
							VALUES ('$subject','$course','$stateS')
						";
						$this->pdo->query($sql1);
					}
				}

				print "
					<script>
						alert('Registro Agregado Exitosamente.');
						window.location='../views/relationship/subjectHasCourseView.php';
					</script>
				";
			} catch (Exception $e){
				print "
					<script>
						alert('Registro FALLIDO.');
						window.location='../views/relationship/subjectHasCourseView.php';
					</script>
				";
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
		public function updateSubjectCourse(
			string $newSubj, string $currSubj,
		 	string $newCourse, string $currCourse, string $newState
		)	{
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
			print "
				<script>
					alert('Record Successfully Updated.');
					window.location='../views/relationship/subjectHasCourseView.php';
				</script>
			";
		}

		/**
		 * Deletes a record from the subject_has_course table
		 *
		 * @param string $subject - the value to match with pk_fk_te_sub
		 * @param string $course - the value to match with pk_fk_course_stu
		 */
		public function deleteSubjectCourse(string $subject, string $course)
		{
			$sql = "
				DELETE FROM subject_has_course
				WHERE pk_fk_te_sub = ? AND pk_fk_course_stu = ?
			";

			$stmt = $this->pdo->prepare($sql);
			$stmt->bindValue(1, $subject);
			$stmt->bindValue(2, $course);
			$stmt->execute();
			
			echo "
				<script>
					alert('Registro Eliminado Exitosamente.');
					window.location='../views/relationship/subjectHasCourseView.php';
				</script>
			";
		}
	}
?>
