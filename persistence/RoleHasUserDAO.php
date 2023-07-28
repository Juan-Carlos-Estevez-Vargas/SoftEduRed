<?php
require_once '../utils/Message.php';
require_once '../utils/constants.php';

class RoleHasUserDAO
{
	private $pdo;

	/**
	 * Constructor method for the class.
	 *
	 * Establish a database connection using the database class.
	 *
	 * @throws PDOException If there is an error connecting to the database.
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
	 * Registers a user with the specified roles and states.
	 *
	 * @param int $userId The ID of the user being registered.
	 * @param int $roleId The ID of the role being assigned to the user.
	 * @throws Exception If the registration fails.
	 */
	public function register(int $userId, int $roleId): void
	{
		try {
			$sql = "
				INSERT INTO user_has_role (user_id, role_id, state)
				VALUES (:user, :role, 1);
			";

			$statement = $this->pdo->prepare($sql);
			$statement->bindParam(':user', $userId);
			$statement->bindParam(':role', $roleId);
			$statement->execute();
		} catch (Exception $e) {
			// Show error message if registration fails due to internal error.
			Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
		}
	}

	/**
	 * Updates a record in the user_has_role database table.
	 *
	 * @param string $id The id_user_has_role to update.
	 * @param string $state The new value for the state field.
	 *
	 * @return void
	 */
	public function update(string $id, string $state): void
	{
		try {
			$sql = "
				UPDATE user_has_role
				SET state = ?
				WHERE id_user_has_role = ?
			";

			$stmt = $this->pdo->prepare($sql);
			$stmt->execute([$state, $id]);
		} catch (Exception $e) {
			Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
		}
	}

	/**
	 * Deletes a user's role from the database.
	 *
	 * @param string $documentType The type of document of the user.
	 * @param int $userId The ID of the user.
	 * @param string $role The role to be deleted.
	 * @return void
	 */
	public function delete(string $idUserHasRole)
	{
		try {
			$sql = "
				DELETE FROM user_has_role
				WHERE id_user_has_Role = :id
			";

			$statement = $this->pdo->prepare($sql);
			$statement->bindParam(':id', $idUserHasRole);
			$statement->execute();
		} catch (Exception $e) {
			Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
		}
	}

	/**
	 * Checks if a user with a given ID and role ID exists in the database.
	 *
	 * @param int $idUser The ID of the user.
	 * @param int $roleId The ID of the role.
	 * @throws Exception If an error occurs while executing the query.
	 * @return bool Returns true if the user with the given ID and role ID exists, false otherwise.
	 */
	public function exists($idUser, $roleId): bool {
		try {
			$sql = "
				SELECT COUNT(*) as total FROM user_has_role
				WHERE user_id = :user AND role_id = :role
			";

			$statement = $this->pdo->prepare($sql);
			$statement->bindParam(':user', $idUser);
			$statement->bindParam(':role', $roleId);
			$statement->execute();

			$result = $statement->fetch(PDO::FETCH_ASSOC);
			$total = $result['total'];

			return $total > 0;
		} catch (Exception $e) {
			Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
		}
	}

	/**
	 * Retrieves a role_has_user record from the database based on the provided ID.
	 *
	 * @param int $id The ID of the role_has_user record to retrieve.
	 * @throws Exception If there is an error executing the database query.
	 * @return array|bool The role_has_user record as an associative array, or false if no record is found.
	 */
	public function getRoleHasUserById(int $id)
	{
		try {
			$sql = "SELECT * FROM user_has_role WHERE id_role_has_user = :id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(['id' => $id]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
		}
	}

	/**
	 * Retrieves the role_has_user list data for a given page.
	 *
	 * @param int $page The page number to retrieve.
	 * @throws PDOException If there is an error executing the database query.
	 * @return array|null An array containing the role_has_user list data, or null if there is an error.
	 */
	public function getRoleHasUserListData($page)
	{
		try {
			// Obtener el número total de registros
			$sqlCount = "SELECT COUNT(*) AS total FROM user_has_role WHERE state != 3";
			$countQuery = $this->pdo->query($sqlCount);
			$totalRecords = $countQuery->fetchColumn();

			// Calcular el límite y el desplazamiento para la consulta actual
			$recordsPerPage = 5; // Número de registros por página
			$currentPage = $page; // Página actual
			$offset = ($currentPage - 1) * $recordsPerPage;

			// Consulta para obtener los registros de la página actual con límite y desplazamiento
			$sql = "
				SELECT
					user.first_name,
					user.surname,
					user_has_role.user_id,
					user_has_role.role_id,
					user_has_role.id_user_has_role,
					role.description,
					user_has_role.state
				FROM user_has_role
				JOIN user ON user.id_user = user_has_role.user_id
				JOIN role ON role.id_role = user_has_role.role_id
				WHERE role.state = 1
				ORDER BY user_id, role_id ASC
				LIMIT :offset, :limit
			";
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
			Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
			return null;
		}
	}

	/**
	 * Retrieves the role that a user has based on the user ID and role ID.
	 *
	 * @param int $userId The ID of the user.
	 * @param int $roleId The ID of the role.
	 * @throws Exception When there is an error executing the SQL query.
	 * @return array The role information and user-role relationship.
	 */
	public function getRoleHasUserByUserAndRole(int $userId, int $roleId) {
		try {
			$sql = "
				SELECT
					user.id_user,
					user.first_name,
					user.surname,
					role.description,
					user_has_role.state,
					user_has_role.id_user_has_role
		  		FROM user_has_role
		  		JOIN user ON user.id_user = user_has_role.user_id
		  		JOIN role ON role.id_role = user_has_role.role_id
				WHERE user_id  = :userId &&	role_id = :roleId
			";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(['userId' => $userId, 'roleId' => $roleId]);

	 	    $result = $stmt->fetch(PDO::FETCH_ASSOC);
        	return $result;
		} catch (Exception $e) {
			Message::showErrorMessage(INTERNAL_ERROR, ROLE_HAS_USER_URL);
		}
	}
}
?>