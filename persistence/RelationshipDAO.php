<?php
 	require_once '../utils/Message.php';
	require_once '../utils/constants.php';

	class RelationshipDAO
	{
		private $pdo;

		/**
		 * Initializes a new instance of the class by setting up a PDO connection to the database
		 *
		 * @throws PDOException if there is an error connecting to the database
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
		 * Registers a new relationship with the given description and state.
		 *
		 * @param string $description The description of the relationship to be registered.
		 * @param string $state The state of the relationship to be registered.
		 * @return void
		 */
		public function register(string $description): void
		{
			try {
				$query = "
					INSERT INTO relationship (description, state)
					VALUES (UPPER(:description), 1)
				";

				$statement = $this->pdo->prepare($query);
				$statement->bindParam(':description', $description);
				$statement->execute();
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
			}
		}

		/**
		 * Update a record in the 'relationship' table.
		 *
		 * @param string $idRelationship The id of the record to update.
		 * @param string $relationship The new value for 'description'.
		 * @param string $state The new value for 'state'.
		 *
		 * @throws Exception If there is an error updating the record.
		 *
		 * @return void
		 */
		public function update(string $idRelationship, string $state)
		{
			try {
				// Update the record in the database
				$sql = "
					UPDATE relationship
					SET state = :state
					WHERE id_relationship = :id
				";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute([
					'state' => $state,
					'id' => $idRelationship
				]);
			} catch (Exception $e) {
				// Show error message if there is an error updating the record
				Message::showErrorMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
			}
		}

		/**
		 * Deletes a record from the relationship table based on the description of the relationship.
		 *
		 * @param string $idRelationship The ID of the relationship to delete.
		 * @return void
		 */
		public function delete(string $idRelationship): void
		{
			try {
				$sql = "
					UPDATE relationship
					SET state = 3
					WHERE id_relationship = :id
				";
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(':id', $idRelationship, PDO::PARAM_STR);
				$stmt->execute();
			} catch (Exception $e) {
				// Show error message and redirect to relationship view
				Message::showErrorMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
			}
		}

		/**
		 * Retrieves a relationship by its ID.
		 *
		 * @param int $id The ID of the relationship.
		 * @throws Exception If there is an error retrieving the relationship.
		 * @return array|null The relationship information as an associative array, or null if not found.
		 */
		public function getRelationshipById(int $id)
		{
			try {
				$sql = "SELECT * FROM relationship WHERE id_relationship = :id";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute(['id' => $id]);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
			}
		}

		/**
		 * Retrieves a list of relationship data for a specific page.
		 *
		 * @param int $page The page number.
		 * @throws PDOException If there is an error with the database connection.
		 * @return array An array containing the total number of records, records per page, current page number,
		 *         offset, query results, and a boolean indicating if there are records.
		 */
		public function getRelationshipListData($page)
		{
			try {
				// Obtener el número total de registros
				$sqlCount = "SELECT COUNT(*) AS total FROM relationship WHERE state != 3";
				$countQuery = $this->pdo->query($sqlCount);
				$totalRecords = $countQuery->fetchColumn();

				// Calcular el límite y el desplazamiento para la consulta actual
				$recordsPerPage = 5; // Número de registros por página
				$currentPage = $page; // Página actual
				$offset = ($currentPage - 1) * $recordsPerPage;

				// Consulta para obtener los registros de la página actual con límite y desplazamiento
				$sql = "SELECT * FROM relationship WHERE state != 3 LIMIT :offset, :limit";
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
				Message::showErrorMessage(INTERNAL_ERROR, RELATIONSHIP_URL);
				return null;
			}
		}
	}
?>