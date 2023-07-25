<?php
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';
	
	class GenderDAO
	{
		private $pdo;

		/**
		 * Class constructor.
		 *
		 * @throws PDOException If database connection fails.
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
		 * Registers a new gender in the database.
		 *
		 * @param string $gender The name of the gender to be registered.
		 * @param string $state The state where the gender is located.
		 */
		public function register(string $gender)
		{
			try {
				$sql = "
					INSERT INTO gender(description, state)
					VALUES(UPPER(:gender), 1)
				";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute(['gender' => $gender]);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, GENDER_URL);
			}
		}

		/**
		 * Update gender information in the database.
		 *
		 * @param string $idGender The id of the gender to be updated.
		 * @param string $gender The new gender description.
		 * @param string $state The new state of the gender in the database.
		 *
		 * @return void
		 */
		public function update(string $idGender, string $gender, string $state)
		{
			try {
				$sql = "
					UPDATE gender
					SET description = UPPER(?), state = ?
					WHERE id_gender = ?
				";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute([$gender, $state, $idGender]);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, GENDER_URL);
			}
		}
		
		/**
		 * Deletes a record from the gender table based on the given gender id.
		 *
		 * @param string $idGender The gender id to be deleted.
		 * @return void
		 */
		public function delete(string $idGender)
		{
			try {
				$sql = "
					UPDATE gender
					SET state = 3
					WHERE id_gender = ?
				";
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(1, $idGender);
				$stmt->execute();
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, GENDER_URL);
			}
		}

		/**
		 * Retrieves the gender record from the database based on the given gender ID.
		 *
		 * @param int $id The ID of the gender record to retrieve.
		 * @throws Exception If there is an error executing the SQL query.
		 * @return array|null The fetched gender record, or null if not found.
		 */
		public function getGenderById(int $id)
		{
			try {
				$sql = "SELECT * FROM gender WHERE id_gender = :id";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute(['id' => $id]);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, GENDER_URL);
			}
		}

		/**
		 * Retrieves gender list data for a given page.
		 *
		 * @param int $page The page number.
		 * @throws PDOException If there is an error executing the database query.
		 * @return array Returns an array containing the total number of records,
		 * the number of records per page, the current page number, the offset,
		 * the query results, and a boolean indicating if there are records or not.
		 */
		public function getGenderListData($page)
		{
			try {
				// Obtener el número total de registros
				$sqlCount = "SELECT COUNT(*) AS total FROM gender WHERE state != 3";
				$countQuery = $this->pdo->query($sqlCount);
				$totalRecords = $countQuery->fetchColumn();

				// Calcular el límite y el desplazamiento para la consulta actual
				$recordsPerPage = 5; // Número de registros por página
				$currentPage = $page; // Página actual
				$offset = ($currentPage - 1) * $recordsPerPage;

				// Consulta para obtener los registros de la página actual con límite y desplazamiento
				$sql = "SELECT * FROM gender WHERE state != 3 LIMIT :offset, :limit";
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
				Message::showErrorMessage(INTERNAL_ERROR, GENDER_URL);
				return null;
			}
		}
	}
?>