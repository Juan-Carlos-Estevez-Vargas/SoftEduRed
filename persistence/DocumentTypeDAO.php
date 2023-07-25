<?php
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';

	class DocumentTypeDAO
	{
		private $pdo;

		/**
		 * Class constructor
		 * Establishes a connection to the database using the database connector class.
		 *
		 * @throws Exception if connection to database fails
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
		 * Registers a new document type in the database
		 *
		 * @param string $documentType The code of the document type
		 * @param string $description The description of the document type
		 * @return void
		 */
		public function register(string $documentType, string $description): void
		{
			try {
				$sql = "
						INSERT INTO document_type (type, description, state)
						VALUES (UPPER(:documentType), UPPER(:description), 1)
				";
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(':documentType', $documentType);
				$stmt->bindParam(':description', $description);
				$stmt->execute();
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
			}
		}

		/**
		 * Updates a document type record in the database.
		 *
		 * @param string $idDocumentType The id of the document type to be updated.
		 * @param string $type The new code of the document type.
		 * @param string $description The new description of the document type.
		 * @param string $state The new state of the document type
		 * @return void
		 */
		public function update(string $idDocumentType, string $type, string $description, string $state): void
		{
			try {
				$query = "
					UPDATE document_type
					SET type = UPPER(:type),
						description = UPPER(:description),
						state = :state
					WHERE id_document_type = :id
				";
				
				$statement = $this->pdo->prepare($query);
				$statement->execute([
					':type' => $type,
					':description' => $description,
					':state' => $state,
					':id' => $idDocumentType
				]);
			} catch (Exception $e) {
				// If an error occurs, show an error message.
				Message::showErrorMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
			}
		}

		/**
		 * Deletes a record from the "document_type" table with the given document code.
		 *
		 * @param string $idDocumentType The document code to be deleted.
		 * @return void
		 */
		public function delete(string $idDocumentType): void
		{
			echo "llega aca?";
			try {
				$query = "
					UPDATE document_type
					SET	state = 3
					WHERE	id_document_type = :id
				";
				$statement = $this->pdo->prepare($query);
				$statement->execute([':id' => $idDocumentType]);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
			}
		}

		/**
		 * Retrieves a document type from the database using its ID.
		 *
		 * @param int $id The ID of the document type to retrieve.
		 * @throws Exception If there is an error retrieving the document type.
		 * @return array|null The document type data as an associative array, or null if not found.
		 */
		public function getDocumentTypeById(int $id)
		{
			try {
				$sql = "SELECT * FROM document_type	WHERE id_document_type = :id";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute(['id' => $id]);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
			}
		}

		/**
		 * Retrieves the list data for the document type based on the given page.
		 *
		 * @param int $page The page number to retrieve the data from.
		 * @throws PDOException if there is an error in the database.
		 * @return array Returns an array containing the total number of records, the number 
		 * of records per page, the current page number, the offset, the query result, and 
		 * a flag indicating if there are records or not.
		 */
		public function getDocumentTypeListData($page)
		{
			try {
				// Obtener el número total de registros
				$sqlCount = "SELECT COUNT(*) AS total FROM document_type WHERE state != 3";
				$countQuery = $this->pdo->query($sqlCount);
				$totalRecords = $countQuery->fetchColumn();

				// Calcular el límite y el desplazamiento para la consulta actual
				$recordsPerPage = 5; // Número de registros por página
				$currentPage = $page; // Página actual
				$offset = ($currentPage - 1) * $recordsPerPage;

				// Consulta para obtener los registros de la página actual con límite y desplazamiento
				$sql = "SELECT * FROM document_type WHERE state != 3 LIMIT :offset, :limit";
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
				Message::showErrorMessage(INTERNAL_ERROR, DOCUMENT_TYPE_URL);
				return null;
			}
		}
	}
?>