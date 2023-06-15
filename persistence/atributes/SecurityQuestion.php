<?php
	class SecurityQuestion
	{
		private $pdo;

		/**
		 * Constructor function for the class.
		 * Establishes a connection to the database using the Database class.
		 *
		 * @throws PDOException if unable to connect to the database.
		 */
		public function __construct() {
			try {
				$this->pdo = Database::connect();
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
		public function addSecurityQuestion(string $question, string $state): void
		{
			$sql = "INSERT INTO security_question (question, state)
								VALUES (UPPER(:question), :state)";

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([
					':question' => $question,
					':state' => $state,
			]);
				
			$successMessage = 'Security question added successfully.';
			$redirectTo = '../views/atributes/questionView.php';
				
			echo "<script>alert('$successMessage'); window.location='$redirectTo';</script>";
		}

		/**
		 * Updates the state of a security question in the database.
		 *
		 * @param string $question The question to update.
		 * @param string $state The new state to set.
		 * @return string A success message.
		 */
		public function updateQuestionState(string $question, string $state)
		{
			$query = 'UPDATE security_question SET state = ? WHERE question = ?';
			$stmt = $this->pdo->prepare($query);
			$stmt->execute([$state, $question]);
			
			echo "
				<script>
					alert('Record successfully deleted.');
					window.location='../views/atributes/questionView.php';
				</script>
			";
		}

		/**
		 * Deletes a record from the security_question table based on the provided question.
		 *
		 * @param string $question The question to match against the question column in the table.
		 */
		public function deleteQuestion(string $question): void
		{
			$sql = "DELETE FROM security_question WHERE question = ?";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$question]);
			
			echo "
				<script>
					alert('Record successfully deleted.');
					window.location='../views/atributes/questionView.php';
				</script>
			";
		}
	}
?>
