<?php
	require_once '../utils/Message.php';
	require_once '../utils/constants.php';

	class RoleDAO
	{
		private $pdo;

		/**
		 * Initializes a new instance of the class.
		 *
		 * Creates a new PDO connection object using database::conectar().
		 * Throws an exception with the error message if the connection fails.
		 */
		public function __construct()
		{
			try {
				$this->pdo = database::connect();
			} catch (PDOException $e) {
				throw new PDOException($e->getMessage());
			}
		}

		/**
		 * Adds a new role to the database with the provided description and state
		 *
		 * @param string $description The description of the role
		 * @param string $state The state of the role
		 * @return void
		 */
		public function register(string $description): void
		{
			try {
				$sql = "
					INSERT INTO role (description, state)
					VALUES (UPPER(:description), 1)
				";
				$statement = $this->pdo->prepare($sql);
				$statement->execute(['description' => $description]);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_URL);
			}
		}

		/**
		 * Updates a record in the "role" table.
		 *
		 * @param string $idRole  The ID of the role to update.
		 * @param string $state   The new value for the "state" column.
		 *
		 * @return void
		 */
		public function update(string $idRole, string $state)
		{
			try {
				$sql = "
					UPDATE role
					SET state = :state
					WHERE id_role = :idRole
				";
				// Prepare the SQL statement.
				$stmt = $this->pdo->prepare($sql);
				// Bind the parameters.
				$stmt->bindParam(':state', $state);
				$stmt->bindParam(':idRole', $idRole);
				// Execute the statement.
				$stmt->execute();
			} catch (Exception $e) {
				// Show error message if an exception occurs.
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_URL);
			}
		}

		/**
		 * Deletes a record from the "role" table based on a given ID.
		 *
		 * @param string $idRole The ID of the role to be deleted
		 * @throws PDOException If there is an error executing the SQL statement
		 */
		public function delete(string $idRole)
		{
			try {
				$sql = "
					UPDATE role
					SET state = 3
					WHERE id_role = :role
				";
				$stmt = $this->pdo->prepare($sql);
				$stmt->bindParam(':role', $idRole);
				$stmt->execute();
			} catch (Exception $e) {
				// Show error message if there is an exception
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_URL);
			}
		}

		/**
		 * Retrieves a role from the database based on its ID.
		 *
		 * @param int $id The ID of the role to retrieve.
		 * @throws Exception If an error occurs while retrieving the role.
		 * @return array The role data as an associative array.
		 */
		public function getRoleById(int $id)
		{
			try {
				$sql = "SELECT * FROM role WHERE id_role = :id";
				$stmt = $this->pdo->prepare($sql);
				$stmt->execute(['id' => $id]);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			} catch (Exception $e) {
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_URL);
			}
		}

		/**
		 * Get the role list data for a specific page.
		 *
		 * @param int $page The page number.
		 * @throws PDOException Exception thrown if there is an error with the database.
		 * @return array Returns an array containing the total number of records, records per page,
		 * current page, offset, the query result, and a boolean indicating if there are records.
		 */
		public function getRoleListData($page)
		{
			try {
				// Obtener el número total de registros
				$sqlCount = "SELECT COUNT(*) AS total FROM role WHERE state != 3";
				$countQuery = $this->pdo->query($sqlCount);
				$totalRecords = $countQuery->fetchColumn();

				// Calcular el límite y el desplazamiento para la consulta actual
				$recordsPerPage = 5; // Número de registros por página
				$currentPage = $page; // Página actual
				$offset = ($currentPage - 1) * $recordsPerPage;

				// Consulta para obtener los registros de la página actual con límite y desplazamiento
				$sql = "SELECT * FROM role WHERE state != 3 LIMIT :offset, :limit";
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
				Message::showErrorMessage(INTERNAL_ERROR, ROLE_URL);
				return null;
			}
		}

		/**
		 * Retrieves all roles from the database.
		 *
		 * @throws PDOException if there is an error with the database connection.
		 * @return array|null An array of roles, or null if no roles are found.
		 */
		public function getAllRoles() {
			try {
				$sql = "SELECT * FROM role";
				$statement = $this->pdo->prepare($sql);
				$statement->execute();
		
				// Fetch all users as an associative array
				$roles = $statement->fetchAll(PDO::FETCH_ASSOC);
		
				// If no users found, return null
				if (empty($roles)) {
					return null;
				}
		
				return $roles;
			} catch (PDOException $e) {
				// Manejo de errores de la base de datos
				throw new PDOException($e->getMessage());
				return null;
			}
		}

		/**
		 * Gets roles that are not assigned to a specific user.
		 *
		 * @param int $userId The ID of the user to get unassigned roles for.
		 * @return array|null Array containing unassigned roles, or null if no unassigned roles found.
		 * @throws Exception When an error occurs while fetching unassigned roles.
		 */
		public function getUnassignedRoles(int $userId): ?array
		{
			try {
				$sql = '
					SELECT r.id_role, r.description
					FROM role r
					LEFT JOIN user_has_role uhr
						ON r.id_role = uhr.role_id
						AND uhr.user_id = :user_id
					WHERE uhr.user_id IS NULL
				';

				$statement = $this->pdo->prepare($sql);
				$statement->execute(['user_id' => $userId]);

				// Fetch unassigned roles as an associative array
				$unassignedRoles = $statement->fetchAll(PDO::FETCH_ASSOC);

				// If no unassigned roles found, return null
				if (empty($unassignedRoles)) {
					return null;
				}

				return $unassignedRoles;
			} catch (Exception $e) {
				// Show error message if an exception occurs.
				throw new Exception('Error fetching unassigned roles: ' . $e->getMessage());
			}
		}
	}
?>