<?php
	require_once '../persistence/database/Database.php';
	require_once '../persistence/SecurityQuestionDAO.php';
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';

	class SecurityQuestionDAO
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
		 *
		 * @return void
		 */
		public function register(string $question): void
		{
			try {
				$sql = "
					INSERT INTO security_question (description, state)
					VALUES (UPPER(:description), 1)
				";

				$stmt = $this->pdo->prepare($sql);
				$stmt->execute([':description' => $question]);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
			}
		}

		/**
		 * Updates the state of a security question in the database.
		 *
		 * @param string $idSecurityQuestion The id of the security question to update.
		 * @param int $state The new state to set.
		 * @return string A success message.
		 */
		public function update(string $idSecurityQuestion, int $state)
		{
			try {
				$query = '
					UPDATE security_question
					SET state = ?
					WHERE id_security_question = ?
				';
				$stmt = $this->pdo->prepare($query);
				$stmt->execute([$state, $idSecurityQuestion]);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
			}
		}

		/**
		 * Deletes a record from the security_question table based on the provided ID.
		 *
		 * @param string $idSecurityQuestion The ID of the question to delete from the table.
		 * @throws Exception If an error occurs while executing the SQL statement.
		 */
		public function delete(string $idSecurityQuestion): void
		{
			try {
				$sql = "
					UPDATE security_question
					SET state = 3
					WHERE id_security_question = ?
				";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute([$idSecurityQuestion]);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
			}
		}

		/**
		 * Retrieves a security question by its ID.
		 *
		 * @param int $id The ID of the security question to retrieve.
		 * @throws Exception If there is an error retrieving the security question.
		 * @return array|null The security question as an associative array, or null if not found.
		 */
		public function getSecurityQuestionById(int $id)
		{
			try {
				$sql = "SELECT * FROM security_question WHERE id_security_question = :id";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute(['id' => $id]);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
			}
		}

		public function getSecurityQuestionListData($page)
		{
			try {
				// Obtener el número total de registros
				$sqlCount = "SELECT COUNT(*) AS total FROM security_question WHERE state != 3";
				$countQuery = $this->pdo->query($sqlCount);
				$totalRecords = $countQuery->fetchColumn();

				// Calcular el límite y el desplazamiento para la consulta actual
				$recordsPerPage = 5; // Número de registros por página
				$currentPage = $page; // Página actual
				$offset = ($currentPage - 1) * $recordsPerPage;

				// Consulta para obtener los registros de la página actual con límite y desplazamiento
				$sql = "SELECT * FROM security_question WHERE state != 3 LIMIT :offset, :limit";
				$query = $this->pdo->prepare($sql);
				$query->bindValue(':offset', $offset, PDO::PARAM_INT);
				$query->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
				$query->execute();

				// Verificar si existen registros
				$hasRecords = $query->rowCount() > 0;

				// Devolver los resultados como un arreglo
				return [
					'totalRecords' => $totalRecords,
					'recordsPerPage' => $recordsPerPage,
					'currentPage' => $currentPage,
					'offset' => $offset,
					'query' => $query,
					'hasRecords' => $hasRecords,
				];
			} catch (PDOException $e) {
				// Manejo de errores de la base de datos
				Message::showErrorMessage(INTERNAL_ERROR, SECURITY_QUESTION_URL);
				return null;
			}
		}
	}
?>